# Generated by Django 4.1.4 on 2023-01-15 06:41

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('tournament', '0002_alter_tournament_tournament_status'),
    ]

    operations = [
        migrations.AddField(
            model_name='tournament',
            name='tournament_numberintournament',
            field=models.IntegerField(default=0, verbose_name='Team in tournament number '),
        ),
    ]
