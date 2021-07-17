<form action="" method="POST">
Öğrenci Ad:<input type="text" name ="ad"><br>
Sayi1 :<input type="text" name ="sayi1"><br>
Sayi2 :<input type="text" name ="sayi2"><br>
<select name="secim"> 
<option value="1">Hoşgediniz Ad</option>
<option value="2">İki Sayiyi Topla</option>
<option value="3">İki Sayiyi Carp</option>
</select>
<input type="submit" name="hesapla" value="hesapla">
</form>
<?php
function hosgeldiniz($isim ='Misafir'){
	echo "Hoşgediniz ".$isim."<br>";
}
function topla($sayi1,$sayi2){
	$sonuc = $sayi1+$sayi2;
	echo $sonuc;
}
function carp($sayi1,$sayi2){
	$sonuc = $sayi1*$sayi2;
	echo $sonuc;
}




if(isset($_POST['hesapla'])){
	$ad=$_POST['ad'];
	$sayi1=$_POST['sayi1'];
	$sayi2=$_POST['sayi2'];
	$secim=$_POST['secim'];
	
	if($secim==1){
		echo hosgeldiniz($ad);
	}
	else if($secim==2){
		echo topla($sayi1,$sayi2);
	}
	else if($secim==3){
		echo carp($sayi1,$sayi2);
	}

}



?>