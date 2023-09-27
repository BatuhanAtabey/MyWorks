from django import forms
from .models import Tournament


class TournamentForm(forms.ModelForm):
    class Meta:
        model = Tournament
        fields = ["tournament_title" ,"tournament_hastah","tournament_content","tournament_image","tournament_numberteam","tournament_numberinteam","tournament_price","tournament_1price","tournament_2price","tournament_3price"]

        
 
    
    

   
    def clean(self):
        cleaned_data = super().clean()
        tournament_numberteam = cleaned_data.get('tournament_numberteam')
        tournament_numberinteam = cleaned_data.get('tournament_numberinteam')
        tournament_price = cleaned_data.get('tournament_price')
        tournament_1price = cleaned_data.get('tournament_1price')
        tournament_2price = cleaned_data.get('tournament_2price')
        tournament_3price = cleaned_data.get('tournament_3price')
        # Diğer değişkenlerinizi burada kontrol edin
        
        if tournament_numberteam is not None and tournament_numberteam <= 0:
            self.add_error('tournament_numberteam', 'This value is not valid')
        if tournament_numberinteam is not None and tournament_numberinteam <= 0:
            self.add_error('tournament_numberinteam', 'This value is not valid')
        if tournament_price is not None and tournament_price <= 0:
            self.add_error('tournament_price', 'This value is not valid')
        if tournament_1price is not None and tournament_1price <= 0:
            self.add_error('tournament_1price', 'This value is not valid')  
        if tournament_2price is not None and tournament_2price <= 0:
            self.add_error('tournament_2price', 'This value is not valid')
        if tournament_3price is not None and tournament_3price <= 0:
            self.add_error('tournament_2price', 'This value is not valid')
        
        return cleaned_data