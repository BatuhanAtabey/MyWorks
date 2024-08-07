# Generated by Django 4.1.4 on 2023-05-25 01:35

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('tournament', '0004_alter_tournament_options_tournament_tournament_round_and_more'),
    ]

    operations = [
        migrations.AddField(
            model_name='tournament',
            name='tournament_1price',
            field=models.IntegerField(default=0, verbose_name='Tournament 1st prize'),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='tournament',
            name='tournament_2price',
            field=models.IntegerField(default=0, verbose_name='Tournament 2nd prize'),
            preserve_default=False,
        ),
        migrations.AddField(
            model_name='tournament',
            name='tournament_3price',
            field=models.IntegerField(default=0, verbose_name='Tournament 3rd prize'),
            preserve_default=False,
        ),
    ]
