from django.shortcuts import render
from django.shortcuts import render ,HttpResponse, redirect,get_object_or_404,reverse
# Create your views here.
from django.contrib.auth.decorators import login_required
from django.contrib import messages
from django.contrib.auth.models import User
from user.models import UserDetails
from tournament.models import TournamentMatches
from team.models import Team
from team.models import TeamPlayers
from .models import Room , RoomUser ,RoomMessage ,AreYouReady, AreYouWin , match_MatchDetails

@login_required(login_url='/user/login/')
def matchDetails(request,id):


   matchdetails = get_object_or_404(TournamentMatches , id = id)

   room = Room.objects.get(room_match=id)
   team1Players = TeamPlayers.objects.filter(tp_teamname = matchdetails.tm_team1)
   team2Players = TeamPlayers.objects.filter(tp_teamname = matchdetails.tm_team2)

    # Are you have team this match? 
   areYouHaveTeamHere = 0
   loginUserTeamName = ""
   for player in team1Players:

        if player.tp_username == str(request.user):
        
          areYouHaveTeamHere=1
          loginUserTeamName = player.tp_teamname

   for player in team2Players:
       if player.tp_username == str(request.user):
          areYouHaveTeamHere = 1
          loginUserTeamName = player.tp_teamname


   if areYouHaveTeamHere == 1:
        # Are you here this room ? 
        areYouinRoom = 0 
        roomusers = RoomUser.objects.filter(room_id = room.id ,ru_username = request.user)

        for user in roomusers:
          if user.ru_username == request.user:
             areYouinRoom = 1

        if areYouinRoom == 0:

    
            newPlayers = RoomUser()
            newPlayers.room_id = room
            newPlayers.ru_username = request.user
            newPlayers.save()

            #Are you ready add 
            #Already in added ? 
            areyouReadyPlayers = AreYouReady.objects.filter(match_id = matchdetails.id ,user=request.user ).first()
            areyouReadyPlayers.areyouin = True
            areyouReadyPlayers.save()
     
      

        
   else:
       return redirect("index")

    #Messages send html

   messages = RoomMessage.objects.filter(room = room)

     
   
   team1Datas = Team.objects.filter(id = matchdetails.tm_team1 ).first()
   team2Datas = Team.objects.filter(id = matchdetails.tm_team2 ).first()
   teamdata = []
   teamdata.append({
      
       "team1_image": team1Datas.team_image,
       "team1_name": team1Datas.team_name,
       "team1_id" : team1Datas.id,


       "team2_image": team2Datas.team_image,
       "team2_name": team2Datas.team_name,
       "team2_id" : team1Datas.id,
   })

   #  playerid   - playerusername(team1playersda var) - player resim -
   # - teamid - teamname - nickname - voteid - vote  
   # if matchdetails.tm_status == 0  : # Tournament Ready Station
   readyPlayer1Data = AreYouReady.objects.filter(match_id = matchdetails.id  ,team_name = team1Datas.team_name)
   readyPlayers2Data = AreYouReady.objects.filter(match_id = matchdetails.id  ,team_name = team2Datas.team_name)
 
   winPlayer1Data = AreYouWin.objects.filter(match_id = matchdetails.id  , team_name = team1Datas.team_name )
   winPlayer2Data = AreYouWin.objects.filter(match_id = matchdetails.id  , team_name = team2Datas.team_name )

   if matchdetails.tm_status == 2: 
       matchFinishData  = match_MatchDetails.objects.filter(match_id = matchdetails.id).first()
   else:
       matchFinishData = None
       
   Data = {
      "matchdetails" : matchdetails,
      "room" :room,
      "messages2" : messages,
      "teamdata" : teamdata,
      "team1Players" : team1Players,
      "team2Players" : team2Players,
      "readyPlayer1Data" : readyPlayer1Data,
      "readyPlayer2Data" : readyPlayers2Data,
      "winPlayer1Data" : winPlayer1Data,
      "winPlayer2Data" : winPlayer2Data,
      "matchFinishData" : matchFinishData,

      
    }
   # print(teamdata)
   # print("******************")
   # print(Data)
   # print("*******************")
   # print(readyPlayers2Data)

   return render(request,"matchdetails.html",Data)

@login_required(login_url='/user/login/')
def matchStarter(matchid,winTeam,lostTeam):
    print("hello")