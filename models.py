from django.db import models
from ckeditor.fields import RichTextField
# Create your models here.


class Tournament(models.Model):
    tournament_author = models.ForeignKey("auth.User",on_delete=models.CASCADE,verbose_name="Turnuva sahibi")
    tournament_title = models.CharField(max_length=50, verbose_name= " Tournament Name")
    tournament_hastah = models.CharField(max_length=50 , verbose_name=" Game Name")
    tournament_content = RichTextField(verbose_name="Tournament Views") 
    tournament_createddate = models.DateTimeField(auto_now_add=True , verbose_name= " Tournament Created Time")
    tournament_image = models.FileField(default="defaulttournament235.jpg",blank=True,null=True , verbose_name= "Tournament Image")
    tournament_numberteam = models.IntegerField(verbose_name="Number of teams participating in the tournament")
    tournament_numberinteam = models.IntegerField(verbose_name="Teams participating in the tournament")
    tournament_numberintournament = models.IntegerField(default=0 ,verbose_name= "Team in tournament number ")
    tournament_price = models.IntegerField(verbose_name="Tournament entry fee")
    tournament_status = models.IntegerField(default= 0 , verbose_name="Tournament Status")
    tournament_round = models.IntegerField(default=0 , verbose_name="Tournamanet Round")
    tournament_1price  = models.IntegerField(verbose_name="Tournament 1st prize")
    tournament_2price  = models.IntegerField(verbose_name="Tournament 2nd prize")
    tournament_3price  = models.IntegerField(verbose_name="Tournament 3rd prize")

class TournamentTeams(models.Model):
    tt_tournamentname = models.ForeignKey(Tournament, on_delete=models.CASCADE, verbose_name="Tournament name")
    tt_teamname = models.CharField(max_length=50,verbose_name="Tournament Team Name")
    tt_createddate = models.DateTimeField(auto_now_add= True , verbose_name="This team join date in Tournament")
    

# numberteam - turnuvaya giricek MAX takım sayısı
# numberinteam - turnuvaya giricek takımdaki oyuncu sayisi
# numberintournament - turnuvaya katılan takım sayısı
# Tournament Status 
# 0  -> Turnuva oluşturuldu - başlatılmadı 
# 1 -> Turnuva başladı  -
# 2 -> Turnuva bitti - 


    

    def __str__(self) -> str:
        return str(self.tt_teamname)

    class Meta:

        ordering = ['-tt_createddate']    


class TournamentAdmin(models.Model):
    admin_tournamentname = models.ForeignKey(Tournament, on_delete=models.CASCADE, verbose_name="Tournament name")
    admin_gm = models.ForeignKey("auth.User",on_delete=models.CASCADE,verbose_name="Tournament Admin")
    admin_status = models.IntegerField(verbose_name=" Staff Name") 
    admin_createddate = models.DateTimeField(auto_now_add= True , verbose_name="This team join date in Tournament")

    def __str__(self) -> str:
        return self.admin_tournamentname

    class Meta:

        ordering = ['admin_createddate']    


#### Admin Level
# 1 - Team Kick
# 2 - Team Kick - Tournament Start - Win Lost
# 3 - Admin Add - Team Kick - Tournament Start
# 4 - Admin Delete - Owner


class AdminRequest(models.Model):
    adminrequest_tournamentname = models.ForeignKey(Tournament, on_delete=models.CASCADE, verbose_name="Tournament name")
    adminrequest_gm = models.ForeignKey("auth.User",on_delete=models.CASCADE,verbose_name="Tournament Admin")
    adminrequest_admin = models.CharField(max_length=50 , verbose_name=" Staff Name") 
    adminrequest_status  = models.IntegerField(verbose_name="Admin Status")
    adminrequest_createddate = models.DateTimeField(auto_now_add= True , verbose_name="This team join date in Tournament")
   
    class Meta:

        ordering = ['adminrequest_createddate']   


class TournamentMatches(models.Model):
    tm_tournamentname = models.ForeignKey(Tournament, on_delete=models.CASCADE, verbose_name="Tournament name")
    tm_team1 = models.CharField(max_length=50 , verbose_name=" Team1") 
    tm_team2 = models.CharField(max_length=50 , verbose_name=" Team2") 
    tm_createddate = models.DateTimeField(auto_now_add= True , verbose_name="Created Time")
    tm_status = models.IntegerField(default = 0 ,verbose_name="Match Status") # 1 - Everybody Ready |  2 - Match Finish | 3- 1,2,3 st match | 4 - 1,2 st match 
    tm_round = models.IntegerField(default = 1 ,verbose_name="Tournament Round")
    
    class Meta:

        ordering = ['tm_tournamentname']  

class TournamentComments(models.Model):
    tc_tournament = models.ForeignKey(Tournament, on_delete=models.CASCADE, verbose_name="Tournament name")
    tc_author = models.ForeignKey("auth.User",on_delete=models.CASCADE,verbose_name="Comment user")
    tc_message = models.CharField(max_length=50 , verbose_name="Message Text") 
    tc_createddate = models.DateTimeField(auto_now_add= True , verbose_name="Created Time")