# Generated by Django 4.1.4 on 2023-05-27 03:51

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('tournament', '0006_alter_tournament_tournament_image_tournamentadmin_and_more'),
    ]

    operations = [
        migrations.RenameField(
            model_name='tournamentadmin',
            old_name='admin_admin',
            new_name='admin_status',
        ),
    ]
