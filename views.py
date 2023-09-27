from django.shortcuts import render ,HttpResponse, redirect,get_object_or_404,reverse
from .models import Tournament , TournamentTeams , TournamentAdmin,AdminRequest,TournamentMatches,TournamentComments
from team.models import Team , TeamPlayers
from user.models import UserDetails
from match.models import Room ,AreYouReady , match_MatchDetails
from .forms import TournamentForm
from django.contrib import messages
from django.contrib.auth.decorators import login_required
from django.core.paginator import Paginator, EmptyPage, PageNotAnInteger
from django.shortcuts import render
import random ,uuid
from django.db.models import Q
from django.contrib.auth.models import User
from django.http import Http404
# Create your views here.


def Tournaments(request):
    tournaments = Tournament.objects.all()
    paginator = Paginator(tournaments, 10)
    page = request.GET.get('page')
    try:
        tournaments = paginator.page(page)
    except PageNotAnInteger:
        # If page is not an integer, deliver first page.
        tournaments = paginator.page(1)
    except EmptyPage:
        # If page is out of range (e.g. 9999), deliver last page of results.
        tournaments = paginator.page(paginator.num_pages)

    return render(request,"tournaments.html",{"tournaments" : tournaments})


@login_required(login_url='/user/login/')
def newTournament(request):
    form = TournamentForm(request.POST or None, request.FILES or None)


    if form.is_valid():

        tournament = form.save(commit=False)
        tournament.tournament_author  = request.user
        tournament.save()
        
        latest_tournament = Tournament.objects.filter(tournament_author=request.user).latest('id')
        newAdmin = TournamentAdmin(admin_tournamentname=latest_tournament , admin_gm = request.user ,admin_status= 4)
        newAdmin.save()
        

        messages.success(request , "Your tournament has been successfully created")
        return redirect("index")


    return render(request ,"newtournament.html",{"form" : form })


@login_required(login_url='/user/login/')
def myTournament(request):
    
    tournament = Tournament.objects.filter(tournament_author = request.user)

    tournamentData = {
        "tournaments": tournament
    }
    print(tournamentData)
    return render(request,"mytournaments.html",tournamentData)

@login_required(login_url='/user/login/')
def updateTournament(request,id):
    tournament = get_object_or_404(Tournament,id=id)
    form = TournamentForm(request.POST or None , request.FILES or None,instance=tournament)
    
    if tournament.tournament_author != request.user :
        return redirect("index")

    elif tournament.tournament_status != 0:
        messages.success(request,"Your tournament already start")
        return redirect("/tournament/mytournament")

    elif tournament.tournament_numberintournament > 0 :
        messages.warning(request,"Your tournament have a team ")
    else: 
      if form.is_valid():
        tournament = form.save(commit=False)
        tournament.tournament_author  = request.user
        tournament.save()
       
        messages.success(request,"Your tournament information has been successfuly updated")
        return redirect("/tournament/mytournament")
    
    
    
    return render(request,"updatetournament.html",{"form" : form })


@login_required(login_url='/user/login/')
def deleteTournament(request,id):
    tournament = get_object_or_404(Tournament,id =id)
    if tournament.tournament_author != request.user:
        return redirect("index")

    elif tournament.tournament_status !=0:
        messages.warning(request,"You cant delete your tournament because started.")
        return redirect("/tournament/mytournament")
    elif tournament.tournament_numberintournament > 0 :
        messages.warning(request , " Tournament have a team.")
        return redirect("/tournament/mytournament")
    else:
        tournament.delete()
        messages.success(request,"Succesfuly delete your tournament. ")
        return redirect("/tournament/mytournament")

@login_required(login_url='/user/login/')
def tournamentDetails(request,id):
    tournament = get_object_or_404(Tournament ,id=id)
    tournamentTeams = TournamentTeams.objects.filter(tt_tournamentname = tournament )
    tournamentAdmins = TournamentAdmin.objects.filter(admin_tournamentname = tournament)
    tournamentMatches = TournamentMatches.objects.filter(tm_tournamentname = tournament)
    tournamentComments = TournamentComments.objects.filter(tc_tournament = tournament)
    
    teams = []
    for team in tournamentTeams:
        teams += Team.objects.filter(id=team.tt_teamname)

    CommentData = []
    for player in tournamentComments:
        profile = UserDetails.objects.filter(userDetail_username =player.tc_author).first()
        CommentData.append({

            "comment_picture" : profile.userDetail_image,
            "comment_author" : profile.userDetail_username,
            "comment_comment" : player.tc_message,
            "comment_date" : player.tc_createddate

        })

    
    print(CommentData)
    Data = {
        "tournament" : tournament,
        "teams" : teams,
        "tournamentAdmins" : tournamentAdmins,
        "tournamentMatches" : tournamentMatches,
        "tournamentComments" : CommentData,
        
        
        
        }
    return render(request,"tournament.html",Data)

@login_required(login_url='/user/login/') 
def addComment(request,id):
    tournament = get_object_or_404(Tournament,id=id)

    if request.method == "POST":
        comment = request.POST.get("comment")

        newComment = TournamentComments(tc_author=request.user,tc_message=comment)
        newComment.tc_tournament = tournament
        newComment.save()
        messages.success(request,"Your message has been sent")


    return redirect(request.META.get('HTTP_REFERER'))

@login_required(login_url='/user/login/')
def joinTournament(request,id):

    tournament = get_object_or_404(Tournament,id=id)    
    team = Team.objects.filter(team_author = request.user)
    if tournament.tournament_status !=0 : 
        messages.warning(request,"Tournament already started ")
        return redirect(request.META.get('HTTP_REFERER'))

    if team : 
        team = get_object_or_404(Team,team_author = request.user)
        
        #Turnuvaya katılan takım sayısı fullse
        if tournament.tournament_numberintournament >= tournament.tournament_numberteam:
            messages.warning(request, " Tournament full ")
            return render(request,"tournament.html",{"tournament" : tournament})
        #Takım zaten turnuvadaysa
        if team.team_status != 0 : 
            messages.warning(request,"Your team already in a tournament")
            return render(request,"tournament.html",{"tournament" : tournament})


        if tournament.tournament_numberinteam == team.team_numberin :
           
                
            
                # Turnavaya giriş işlemleri
                teamplayers = TeamPlayers.objects.filter(tp_teamname = team)
                nothavemoney = 0 
                mesaj = "Not have money this players : "
                for p_name in teamplayers:
                    p_details =  get_object_or_404(UserDetails,userDetail_username = p_name)
                    if tournament.tournament_price >= p_details.userDetail_money :
                        nothavemoney = 1
                        mesaj  += f"{p_name} | "
                
                if nothavemoney == 1:
                    messages.warning(request,mesaj)

                    # Para cekip hesaplardan parayı siliyoruz.
                elif nothavemoney == 0 :
                    for p_name in teamplayers:
                        p_details = get_object_or_404(UserDetails,userDetail_username = p_name)
                        newmoney  = 0 
                        newmoney =  p_details.userDetail_money  - tournament.tournament_price
                        p_details.userDetail_money = newmoney
                        p_details.save()

                      
                        print(newmoney)

                    tournament.tournament_numberintournament += 1
                    tournament.save()
                    team.team_status = 1
                    team.save()

                    tournamentTeamJoin = TournamentTeams(tt_tournamentname = tournament , tt_teamname = team.id)
                    tournamentTeamJoin.save()
                    messages.success(request,"Your team join the tournament , Fight for Victory !") 
                    return render(request,"tournament.html",{"tournament" : tournament})
                        
        else:
           mesaj = f"Your need team players TOTAL :  {tournament.tournament_numberinteam}"
           messages.warning(request,mesaj)
           
        return render(request,"tournament.html",{"tournament" : tournament})
    else:
        
        messages.warning(request," You dont have any team or not you are captain your team") 
        return render(request,"tournament.html",{"tournament" : tournament})
    
@login_required(login_url='/user/login/')   
def tournamentPanel(request,id):
    tournament = get_object_or_404(Tournament,id=id)

    if tournament.tournament_author != request.user:
        return redirect("index")
    
    tournamentTeams = TournamentTeams.objects.filter(tt_tournamentname = tournament)

    Data = {
        "tournament" : tournament,
        "tournamentTeams" : tournamentTeams
    }

    print(tournament)
    return render(request, "tournamentpanel.html" , Data)

@login_required(login_url='/user/login/')   
def tournamentAdmin(request,id):
    tournament = get_object_or_404(Tournament ,id=id)
    tournamentAdmin  = TournamentAdmin.objects.filter(admin_tournamentname = tournament)
    tournamentAdminRequest = AdminRequest.objects.filter(adminrequest_tournamentname = tournament)
    Data = {
        "tournament" : tournament,
        "tournamentAdmin" : tournamentAdmin,
        "tournamentAdminRequest" : tournamentAdminRequest
            }

    if request.POST.get("adminname") and request.POST.get("adminstatus"):
        inviteAdminUsername = request.POST.get("adminname")
    
    
        inviteAdminStatus = request.POST.get("adminstatus")

        try:
                inviteAdminStatus = int(inviteAdminStatus) # adminstatus değerini tamsayıya dönüştürmeye çalış
        except ValueError:
                messages.warning(request,"The admin status value must be a number.") 
                return render(request, "admin.html" , Data)

            # Diğer işlemleri gerçekleştir ve yanıtı döndür

        # Zaten bu turnuvada adminse.
        user = User.objects.get(username=inviteAdminUsername)
        areyouadmin = TournamentAdmin.objects.filter(admin_tournamentname = tournament , admin_gm= user)
        if areyouadmin:
                messages.warning(request,"This user already admin in tournament") 
                return render(request, "admin.html" , Data)
       


        if(4 >= inviteAdminStatus>0) :

            ##INVITE GONDERME 
            inviteUser = UserDetails.objects.filter(userDetail_username = inviteAdminUsername)

            
        
            if inviteUser:
                
                invite = AdminRequest.objects.filter(adminrequest_tournamentname = tournament.id ,adminrequest_admin = inviteAdminUsername)

                if invite:
                    messages.warning(request,"You have already invite !")
                else:
                    newInvite = AdminRequest(adminrequest_tournamentname= tournament , adminrequest_gm = request.user , adminrequest_admin = inviteAdminUsername ,  adminrequest_status = inviteAdminStatus)
                    newInvite.save()
                    messages.success(request,"You sent the invitation")
            else :
                messages.warning(request,"There is no user by this name")
            
            
        else:

            messages.warning(request," Admin status must be between 0 and 4") 
            return render(request, "admin.html" , Data)
        
        print(tournamentAdminRequest)

    return render(request, "admin.html" , Data)

@login_required(login_url='/user/login/')   
def yesAdminRequest(request,id):
    invite = get_object_or_404(AdminRequest,id=id , adminrequest_admin = request.user)
    adminJoin = TournamentAdmin(admin_tournamentname = invite.adminrequest_tournamentname ,
    admin_gm = request.user,
    admin_status =  invite.adminrequest_status)
    
    adminJoin.save()
    invite.delete()
    messages.success(request,"You success your invitation.")
    return render(request,"index.html")  

@login_required(login_url='/user/login/')   
def noAdminRequest(request,id):
    invite = get_object_or_404(AdminRequest,id=id)

    if invite.adminrequest_admin == str(request.user):
        invite.delete()
        messages.warning(request,"You deleted your invitation.")
        return render(request,"index.html")  
    else:
        return render(request,"index.html") 
    
@login_required(login_url='/user/login/')   
def kickAdminRequest(request,id):
    invite = get_object_or_404(TournamentAdmin,id=id)

    admin = get_object_or_404(TournamentAdmin,admin_gm=request.user , admin_tournamentname = invite.admin_tournamentname)
    if admin.admin_status == 4:
        invite.delete()
        messages.success(request,"You deleted your admin.")
    else:
        messages.warning(request,"You cant delete invitation.")

    return redirect(request.META.get('HTTP_REFERER'))

@login_required(login_url='/user/login/')   
def deleteAdminRequest(request,id):
    invite = get_object_or_404(AdminRequest,id=id)
    if invite.adminrequest_gm == request.user:
        invite.delete()
        messages.success(request,"You deleted your invitation.")
    else:
        messages.warning(request,"You cant delete invitation.")

    return redirect(request.META.get('HTTP_REFERER'))

@login_required(login_url='/user/login/')   
def tournamentKick(request,id):
  
    pass

@login_required(login_url='/user/login/')   
def tournamentStart(request,id):
    tournament = get_object_or_404(Tournament,id =id)
    tournamentAdmin = get_object_or_404(TournamentAdmin,admin_tournamentname =tournament.id , admin_gm = request.user )
    tournamentTeams = list(TournamentTeams.objects.filter(tt_tournamentname=tournament))
    tournamentTeams_count = TournamentTeams.objects.filter(tt_tournamentname = tournament).count()
    print (tournament)
    if tournamentAdmin.admin_status <= 1:
        messages.warning(request,"You cant start tournament !")
        return redirect(request.META.get('HTTP_REFERER'))

    if tournament.tournament_status != 0 :
        messages.warning(request,"Your tournament already started ")
        return redirect(request.META.get('HTTP_REFERER'))
    matches = []
    #BYE TEAM
    if tournamentTeams_count % 2 != 0: 
        buyTeam = random.choice(tournamentTeams)
        tournamentTeams.remove(buyTeam)
        buymatch = TournamentMatches(tm_tournamentname = tournament ,tm_team1=buyTeam, tm_team2="BUY" , tm_status =2)
        matches.append(buymatch)
       

   
    for i in range(0, len(tournamentTeams), 2):
        team1 = tournamentTeams[i]
        team2 = tournamentTeams[i+1]
        match = TournamentMatches(tm_tournamentname = tournament ,tm_team1=team1, tm_team2=team2)
        matches.append(match)

    

    TournamentMatches.objects.bulk_create(matches)

    tournamentMatchAdded = TournamentMatches.objects.filter(tm_tournamentname=tournament)
    for match in tournamentMatchAdded:
       
        roomid = str(uuid.uuid4())
        newRoom = Room(id=roomid,room_match=match.id)
        newRoom.save()
        if match.tm_status !=2 :
            team1Players = TeamPlayers.objects.filter(tp_teamname = match.tm_team1)
            team2Players = TeamPlayers.objects.filter(tp_teamname = match.tm_team2)
            for player in team1Players:

                newAreYouReady = AreYouReady()
                newAreYouReady.match_id = match
                newUser = User.objects.filter(username = player.tp_username).first()
                newAreYouReady.user = newUser
                newAreYouReady.team_name = player.tp_teamname
                newAreYouReady.save()
            
            for player in team2Players:
                newAreYouReady = AreYouReady()
                newAreYouReady.match_id = match
                newUser = User.objects.filter(username = player.tp_username).first()
                newAreYouReady.user = newUser
                newAreYouReady.team_name =  player.tp_teamname
                newAreYouReady.save()
        else:
            buywinner = Team.objects.filter(id= match.tm_team1).first()
            newWinner = match_MatchDetails(match_id= match ,winner_team = buywinner.team_name,loser_team="BUY" )
            newWinner.save()
    
    tournament.tournament_status = 1 
    tournament.tournament_round = 1
    tournament.save()

    return redirect(request.META.get('HTTP_REFERER'))



@login_required(login_url='/user/login/')
def myMatches(request):
    team_players = TeamPlayers.objects.filter(tp_username=request.user)
    matching_matches = TournamentMatches.objects.filter(Q(tm_team1__in=team_players.values('tp_teamname')) | Q(tm_team2__in=team_players.values('tp_teamname')))
    print(matching_matches)

   



    tournamentData = {
        "matching_matches": matching_matches
    }
    
    
    return render(request,"mymatches.html",tournamentData)

@login_required(login_url='/user/login/')
def tournamentMatches(request ,id):
    tournament = Tournament.objects.filter(id=id).first()
    matches = TournamentMatches.objects.filter(tm_tournamentname=tournament)
    tournamentAdmins = TournamentAdmin.objects.filter(admin_tournamentname = tournament)

    areYouAdmin = False
    for admin in tournamentAdmins:
        if admin.admin_gm == request.user and admin.admin_status >= 3:
            areYouAdmin = True
    
    if areYouAdmin == False :
         messages.warning(request,"Your admin level not enough")
         return redirect(request.META.get('HTTP_REFERER'))
    else:

        matchData = []

        for match in matches:
            if match.tm_team1 != "BUY": 

                team1= Team.objects.filter(id = match.tm_team1).first()
            else: 
                 matchData.append({
                "match_id" : match.id,
                "team1_id " : 0,
                "team1_name" : "BUY",

                "team2_id" : match.tm_team2,
                "team2_name" : team2.team_name,
                "match_round" : match.tm_round,
                "match_status" : match.tm_status,

                 })
            if match.tm_team2 != "BUY":
                team2 = Team.objects.filter(id = match.tm_team2).first()
            else: 
                matchData.append({
                "match_id" : match.id,
                "team1_id " : match.tm_team1,
                "team1_name" : team1.team_name,

                "team2_id" : 0,
                "team2_name" : "BUY",
                "match_round" : match.tm_round,
                "match_status" : match.tm_status,

                 })

            matchData.append({
                "match_id" : match.id,
                "team1_id " : match.tm_team1,
                "team1_name" : team1.team_name,

                "team2_id" : match.tm_team2,
                "team2_name" : team2.team_name,
                "match_round" : match.tm_round,
                "match_status" : match.tm_status,

            })




        data = {
            "matches": matchData,
            "tournament" : tournament,
        }
        
    

        return render(request,"tournamentmatches.html",data)
    
@login_required(login_url='/user/login/')
def winMatch(request ,teamname,matchid):
    
    match = TournamentMatches.objects.filter(id=matchid).first()
    tournamentid = match.tm_tournamentname
    print("--------------" )
    
    tournamentadmin = TournamentAdmin.objects.filter(admin_tournamentname = match.tm_tournamentname)

    areYouAdmin = False

    for admin in tournamentadmin:
        if admin.admin_gm == request.user:
            if admin.admin_status >= 3:
                areYouAdmin = True

            else:
                messages.warning(request,"Your admin level not enough")
                return redirect(request.META.get('HTTP_REFERER'))
    if areYouAdmin == False:
        raise Http404("You are not admin ")
    else: 
        team1 = Team.objects.filter(id = match.tm_team1).first()
        team2 = Team.objects.filter(id = match.tm_team2).first()
        if team1.team_name == teamname:
            winnerTeam = team1.team_name
            lostTeam = team2.team_name
        else :
            winnerTeam = team2.team_name
            lostTeam = team1.team_name



        winnerAddMatch = match_MatchDetails()
        winnerAddMatch.match_id = match
        winnerAddMatch.winner_team  = winnerTeam
        winnerAddMatch.loser_team = lostTeam
        winnerAddMatch.save()
        match.tm_status = 2
        match.save()
        return redirect(request.META.get('HTTP_REFERER'))
   
    return redirect(request.META.get('HTTP_REFERER'))


@login_required(login_url='/user/login/')
def nextRound(request ,id):
    tournament =  Tournament.objects.filter(id=id).first()
   
    if tournament:
        t_Admin = TournamentAdmin.objects.filter(admin_tournamentname = tournament , admin_gm = request.user).first()
        if t_Admin:
            
            if t_Admin.admin_status  >= 3 :
                matches = TournamentMatches.objects.filter(tm_tournamentname = tournament , tm_round = tournament.tournament_round)
                if matches.count() > 2:
                    matchData= []
                    notFinishMatch = False
                    for match in matches:
                        if match.tm_status != 2:
                            notFinishMatch = True
                        else : 
                            if match.tm_team2 != "BUY":

                                team1Data  = Team.objects.filter(id= match.tm_team1).first()
                                team2Data = Team.objects.filter(id = match.tm_team2).first()
                                matchData.append({
                                    
                                    "match_id" : match.id,
                                    "team1_id" :  match.tm_team1,
                                    "team1_name" :  team1Data.team_name,
                                    
                                    "team2_id" : match.tm_team2,
                                    "team2_name" : team2Data.team_name,
                                    })
                            else : 
                                team1Data  = Team.objects.filter(id= match.tm_team1).first()
                                
                                matchData.append({
                                    
                                    "match_id" : match.id,
                                    "team1_id" :  match.tm_team1,
                                    "team1_name" :  team1Data.team_name,
                                    
                                    "team2_id" : "BUY",
                                    "team2_name" : "BUY",
                                    })


                    if notFinishMatch == False :
                        winner = []
                    
                        for match in matchData:
                           
                            matchDetails = match_MatchDetails.objects.filter(match_id = match["match_id"]).first()

                            if matchDetails.winner_team == match["team1_name"]:
                                winner.append({
                                  "team_id" : match["team1_id"],
                                  "team_name": match["team1_name"],      

                                })
                                
                            else : 
                                winner.append({

                                    "team_id" : match["team2_id"],
                                    "team_name" : match["team2_name"],
                                })
                                
                        matches =  []
                        if (len(winner)) % 2 != 0 :
                            buyTeam = random.choice(winner)
                            winner.remove(buyTeam)
                            buyMatch = TournamentMatches(tm_tournamentname=tournament , tm_team1 = buyTeam["team_id"] , tm_team2= "BUY" , tm_status = 2,  tm_round = tournament.tournament_round+1)
                            matches.append(buyMatch)
                            
                        
                        for i in range(0 ,len(winner) ,2 ) :
                            team1 = winner[i]["team_id"]
                            team2 = winner[i+1]["team_id"]
                            match = TournamentMatches(tm_tournamentname =tournament , tm_team1 = team1 , tm_team2 = team2, tm_round = tournament.tournament_round+1)
                            matches.append(match)
                        
                        TournamentMatches.objects.bulk_create(matches)
                        tournament.tournament_round += 1
                        tournament.save()

                        tournamentMatchAdded = TournamentMatches.objects.filter(tm_tournamentname=tournament ,tm_round = tournament.tournament_round)
                        for match in tournamentMatchAdded:
                        
                            roomid = str(uuid.uuid4())
                            newRoom = Room(id=roomid,room_match=match.id)
                            newRoom.save()
                            
                            if match.tm_status != 2 : 
                                print("GIRDI !!!!!!!!!!!!!!!!!!!!!!!!!")
                                team1Players = TeamPlayers.objects.filter(tp_teamname = match.tm_team1)
                                team2Players = TeamPlayers.objects.filter(tp_teamname = match.tm_team2)
                                for player in team1Players:

                                    newAreYouReady = AreYouReady()
                                    newAreYouReady.match_id = match
                                    newUser = User.objects.filter(username = player.tp_username).first()
                                    newAreYouReady.user = newUser
                                    newAreYouReady.team_name = player.tp_teamname
                                    newAreYouReady.save()
                                    print(newAreYouReady)
                                
                                for player in team2Players:
                                    newAreYouReady = AreYouReady()
                                    newAreYouReady.match_id = match
                                    newUser = User.objects.filter(username = player.tp_username).first()
                                    newAreYouReady.user = newUser
                                    newAreYouReady.team_name =  player.tp_teamname
                                    newAreYouReady.save()
                                    print(newAreYouReady)
                            else :
                                buywinner = Team.objects.filter(id= match.tm_team1).first()
                                newWinner = match_MatchDetails(match_id= match ,winner_team = buywinner.team_name,loser_team="BUY" )
                                newWinner.save()
                          
                             

                        return redirect(request.META.get('HTTP_REFERER'))
                    else: 
                        messages.warning(request,"You cannot go to the next round because some matches in the tournament are not finished, please finish the matches.")
                        return redirect(request.META.get('HTTP_REFERER'))
                else :
                    messages.warning(request,"You have 2 match you can finish tournament !")
                    return redirect(request.META.get('HTTP_REFERER'))


            else:
                messages.warning(request,"Your admin level not enough")
                return redirect(request.META.get('HTTP_REFERER'))

        else:
           
           # get_object_or_404()
           return redirect(request.META.get('HTTP_REFERER'))

    else :
        return redirect(request.META.get('HTTP_REFERER'))
     
   
@login_required(login_url='/user/login/')
def tournamentFinish(request ,id):
    tournament =  Tournament.objects.filter(id=id).first()

    if tournament:
        t_Admin = TournamentAdmin.objects.filter(admin_tournamentname = tournament , admin_gm = request.user).first()

        if t_Admin:
            if t_Admin.admin_status  >= 3 :
                matches = TournamentMatches.objects.filter(tm_tournamentname = tournament , tm_round = tournament.tournament_round)
                if matches.count() <= 2 : # match status -- > 1 - Everybody Ready |  2 - Match Finish | 3- 1,2,3 st match | 4 - 1,2 st match 
                    pass
                else:
                    messages.warning(request,"You must first go next round!")
                    return redirect(request.META.get('HTTP_REFERER'))
            else: 
                messages.warning(request,"Your admin level not enough")
                return redirect(request.META.get('HTTP_REFERER'))
        else: 
            return redirect(request.META.get('HTTP_REFERER'))

    else :
        return redirect(request.META.get('HTTP_REFERER'))
    


    return redirect(request.META.get('HTTP_REFERER'))



