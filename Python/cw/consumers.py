# chat/consumers.py
import json
from django.contrib.auth.models import User
from channels.generic.websocket import AsyncWebsocketConsumer
from .models import RoomMessage , Room , AreYouReady , AreYouWin ,match_MatchDetails
from django.contrib.auth.decorators import login_required
from channels.db import database_sync_to_async
from asgiref.sync import sync_to_async
from tournament.models import TournamentMatches
from match.views import matchStarter

class ChatConsumer(AsyncWebsocketConsumer):
    async def connect(self):
        self.room_name = self.scope["url_route"]["kwargs"]["room_name"]
        self.room_group_name = "chat_%s" % self.room_name

        # Join room group
        await self.channel_layer.group_add(self.room_group_name, self.channel_name)

        await self.accept()

    async def disconnect(self, close_code):
        # Leave room group
        self.channel_layer.group_discard("my_group", self.channel_name)
        print("WebSocket bağlantısı kapatıldı.")
        await self.channel_layer.group_discard(self.room_group_name, self.channel_name)

    # İştemciden mesaj geldiğinde
    async def receive(self, text_data):
        text_data_json = json.loads(text_data)
        message = text_data_json["message"]
        user = self.scope["user"]
        what_is_it = text_data_json["what_is_it"]
        print("***********************")
        print(user)
        print(message)
        print(self.room_name)
        
        print("***********************")
        if what_is_it == "text":
            new_message = RoomMessage(user=user, room_id=self.room_name, content=message , what_is_it= what_is_it)
            await sync_to_async(new_message.save)()
            
            
           
            # Send message to room group
            await self.channel_layer.group_send(
                self.room_group_name, {
                    "type": "chat_message",               
                    "message": message,
                    "user": user.username,
                    "message_createddate": new_message.get_short_date(),
                    "what_is_it" : new_message.what_is_it,
                    }
            )

        elif what_is_it == "ready":
           
           # Ready mesaji gönderme
            await self.channel_layer.group_send(
                    self.room_group_name, {
                        "type": "ready_message",               
                        "message": message,
                        "user": user.username,
                        "what_is_it" : what_is_it,
                        }
                )
            
            @database_sync_to_async
            def get_id(username,matchid):
              for user in  User.objects.filter(username=username):

                readyPlayer = AreYouReady.objects.filter(match_id=matchid , user=user).first()

                readyPlayer.vote = True
                
                readyPlayer.save()

                matchReadyPlayer = AreYouReady.objects.filter(match_id=matchid)
                everyBodyReady = True

                for player in matchReadyPlayer:
                       
                    if player.vote == False:  # Ready Değilse 1kişi 
                        everyBodyReady = False
                        break
                    elif everyBodyReady == True:
                        newUser = AreYouWin()
                        newUser.match_id = player.match_id
                        newUser.user = player.user
                        newUser.team_name = player.team_name
                        newUser.save()

                
                if everyBodyReady == True:
                    tournamentMatch  = TournamentMatches.objects.filter(id= matchid).first()
                    tournamentMatch.tm_status = 1
                    tournamentMatch.save()
                    return everyBodyReady

            
          

            everybodyTrue = await get_id(user,message)
              
            if everybodyTrue== True:
                what_is_it= "matchstart"
                #Start mesajı gönderme
                await self.channel_layer.group_send(
                        self.room_group_name, {
                        "type": "match_start",               
                        "message": "matchstart",
                        "user": user.username,
                        "what_is_it" : what_is_it,
                        }
                        
                        )
        elif what_is_it == "winmatch" or what_is_it =="lostmatch":

            @database_sync_to_async
            def matchDone(matchid): #Every vote coming here and look everybody vote if have result match finish
                # Win-Lost  or Lost-Win   - kazanan belirlenir burada yapılıcak
                # Lost-Lost   - admin tarafından
                # Win-Win  - admin tarafından
                matchData = AreYouWin.objects.filter(match_id = matchid)
                matchFinishOkey = False  
              
                
                

                everyBodyUseVote = False
                for match in matchData:
                    if match.use_vote == False:
                        everyBodyUseVote = False
                       
                        print(everyBodyUseVote)
                        break

                    else:
                        everyBodyUseVote = True
                        
                    
                
                if everyBodyUseVote == True: #Herkes oy kullandıysa
                    team1_name = matchData[0].team_name
                    
                    
                    team1_vote = True
                    team2_vote = True
                
                    for match in matchData:
                        
                        if team1_name != match.team_name: # team2
                            team2_name = match.team_name
                            print (team2_name ," Player " , match.user, " Vote " , match.vote, "  Team Vote --- >" , team2_vote)

                            if team2_vote == True :
                                if match.vote == False:
                                    team2_vote = False
                            


                        else : #team1
                           
                            print (team1_name ," Player " , match.user, " Vote " , match.vote , "  Team Vote --- >" , team1_vote)
                            if team1_vote == True :
                                if match.vote == False:
                                    team1_vote = False

                    matchFinish = TournamentMatches.objects.filter(id = matchid).first()     

                        
                    if team1_vote == True and team2_vote == False:
                        matchFinish.tm_status = 2
                        matchFinish.save()
                        newMatchDetails = match_MatchDetails()
                        newMatchDetails.match_id = matchFinish
                        newMatchDetails.winner_team = team1_name
                        newMatchDetails.loser_team = team2_name
                        newMatchDetails.save()
                        matchFinishOkey = True
                    elif team1_vote == False and team2_vote == True:
                        matchFinish.tm_status = 2
                        matchFinish.save()
                        newMatchDetails = match_MatchDetails()
                        newMatchDetails.match_id = matchFinish
                        newMatchDetails.winner_team = team2_name
                        newMatchDetails.loser_team = team1_name
                        newMatchDetails.save()
                        matchFinishOkey = True


                        
                        
                    print("************************")
                    print(team1_name , "  ---- >  " ,team1_vote)
                    print(team2_name, "   ----->  " , team2_vote)
                    print("************************")


                return matchFinishOkey
                    
                    
                

                

            if  what_is_it == "winmatch":
                await self.channel_layer.group_send(
                        self.room_group_name, {
                            "type": "winmatch",               
                            "message": message,
                            "user": user.username,
                            "what_is_it" : what_is_it,
                            }
                )
                @database_sync_to_async
                def do_WinVote(username,matchid):

                    whoSay = AreYouWin.objects.filter(match_id= matchid , user=user).first()
                    whoSay.vote = True
                    whoSay.use_vote= True
                    whoSay.save()
                   
               


                await do_WinVote(user,message)
                matchWhat = await matchDone(message)
                
                print("match what " , matchWhat)
                if matchWhat == True:
                    #Finish mesajı gönderme
                    what_is_it= "matchfinish"
                    await self.channel_layer.group_send(
                        self.room_group_name, {
                        "type": "match_finish",               
                        "message": "matchfinish",
                        "user": user.username,
                        "what_is_it" : what_is_it,
                        }
                        
                        )

                
            elif what_is_it == "lostmatch":
                await self.channel_layer.group_send(
                        self.room_group_name, {
                            "type": "lostmatch",               
                            "message": message,
                            "user": user.username,
                            "what_is_it" : what_is_it,
                            }
                )

                @database_sync_to_async
                def do_LostVote(username,matchid):

                    whoSay = AreYouWin.objects.filter(match_id= matchid , user=user).first()
                    whoSay.vote = False
                    whoSay.use_vote= True
                    whoSay.save()

            


                await do_LostVote(user,message)
                matchWhat = await matchDone(message)
                print("match what " , matchWhat)
                if matchWhat == True:
                    #Finish mesajı gönderme
                    what_is_it= "matchfinish"
                    await self.channel_layer.group_send(
                        self.room_group_name, {
                        "type": "match_finish",               
                        "message": "matchfinish",
                        "user": user.username,
                        "what_is_it" : what_is_it,
                        }
                        
                        )
        
              
        
    # Django tarafından istemciye mesaj gönderildiğinde
    async def chat_message(self, event):
        message = event["message"]
        user= event["user"]
        message_createddate=  event["message_createddate"]
        what_is_it=  event["what_is_it"]
        
        # Send message to WebSocket
        await self.send(text_data=json.dumps(
            {"message": message ,
             "user":user,
             "message_createddate": message_createddate,
             "what_is_it" : what_is_it,
            })
            
            
            )
    async def ready_message(self,event):
        message = event["message"]
        user= event["user"]
        what_is_it=  event["what_is_it"]
        await self.send(text_data=json.dumps(
            {"message": message ,
             "user":user,
             "what_is_it" : what_is_it,
            })
            
            
            )    
    async def match_start(self,event):
        message = event["message"]
        user = event["user"]
        what_is_it = event["what_is_it"]
        await self.send(text_data=json.dumps(
            {
                "message" : message,
                "user" : user,
                "what_is_it" :what_is_it,
           })
        )
    async def winmatch(self,event):
        message = event["message"]
        user = event["user"]
        what_is_it = event["what_is_it"]
        await self.send(text_data=json.dumps(
            {
                "message" : message,
                "user" : user,
                "what_is_it" :what_is_it,
           })
        ) 
    async def lostmatch(self,event):
        message = event["message"]
        user = event["user"]
        what_is_it = event["what_is_it"]
        await self.send(text_data=json.dumps(
            {
                "message" : message,
                "user" : user,
                "what_is_it" :what_is_it,
           })
        )   
    async def match_finish(self,event):
        message = event["message"]
        user = event["user"]
        what_is_it = event["what_is_it"]
        
        await self.send(text_data=json.dumps(
            {
                "message" : message,
                "user" : user,
                "what_is_it" :what_is_it,
           })
        )