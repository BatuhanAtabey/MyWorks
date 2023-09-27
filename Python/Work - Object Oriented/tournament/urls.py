from django.contrib import admin
from django.urls import path
from . import views
from django.conf import settings
from django.conf.urls.static import static

app_name = "tournament"

urlpatterns = [
    path('tournaments/', views.Tournaments,name ="Tournaments"),
    path('tournament/<int:id>', views.tournamentDetails,name ="tournament"),
    path('newtournament/', views.newTournament, name = "newTournament"),
    path('mytournament/', views.myTournament, name = "myTournament"),
    path('myMatches/', views.myMatches, name = "myMatches"),
    path('delete/<int:id>',views.deleteTournament, name="deleteTournament"),
    path('update/<int:id>',views.updateTournament, name="updateTournament"),
    path('addcomment/<int:id>',views.addComment, name="addcomment"),
    path('joinTournament/<int:id>',views.joinTournament, name="joinTournament"),
    path('tournamentPanel/<int:id>',views.tournamentPanel, name ="tournamentPanel"),
    path('tournamentAdmin/<int:id>',views.tournamentAdmin, name ="tournamentAdmin"),
    path('yesAdminRequest/<int:id>',views.yesAdminRequest, name="yesAdminRequest"),
    path('noAdminRequest/<int:id>',views.noAdminRequest, name="noAdminRequest"),
    path('kickAdminRequest/<int:id>',views.kickAdminRequest, name="noAdminRequest"),
    path('deleteAdminRequest/<int:id>',views.deleteAdminRequest, name="deleteAdminRequest"),
    path('kickTournament/<int:id>',views.tournamentKick, name ="kickTournament"),
    path('tournamentStart/<int:id>',views.tournamentStart, name ="tournamentStart"),
    path('tournamentMatches/<int:id>',views.tournamentMatches, name ="tournamentMatches"),
    path('winMatch/<str:teamname>/<int:matchid>',views.winMatch, name ="winMatch"),
    path('tournamentNextRound/<int:id>',views.nextRound, name ="tournamentNextRound"),
    path('tournamentFinish/<int:id>',views.tournamentFinish, name ="tournamentFinish"),
]
