

<form action="" method="post">
<table border='1' align ="center">
<tr> <td colspan="3"> Dgs Puan Hesaplama</td></tr>
<tr> <td> </td> <td> Doğru</td> <td> Yanlış</td> </tr>
<tr>	<td>Sayisal Testi: </td> <td><input type="textbox" name="sayisal1"/></td> <td><input type="textbox" name="sayisal2"/></td> </tr>
<tr>    <td>Sözel Testi: </td> <td><input type="textbox" name="sozel1"/> </td> <td><input type="textbox" name="sozel2"/>  </td> </tr>
<tr>	<td>Önlisans başarı Puanı (Zorunlu Alan):</td> <td><input type="textbox" name="onlisans"/> </td>  </tr>
<tr>	<td>Alanınız:</td> <td><input type="radio" name="alan" value="1"/>Sayisal</td> <td><input type="radio" name="alan" value="2"/>Sözel </td> <td><input type="radio" name="alan" value="3"/> Eşit Ağırlık</td> </tr>
<tr>	<td>2018 Öncesinde DGS ile bir programa yerleştirildiniz mi? </td> <td><input type="radio" name="dgsolay" value="1"/>Evet </td> <td><input type="radio" name="dgsolay" value="0"/>Hayir</td>  </tr>
<tr>    <td> </td> <td><input type="submit" name="hesap" value="hesapla">  </td>   <td>	<input type="submit" name="temizle" value="temizle">  </td>  </tr>
</table>	


</form>


<?php

if(isset($_POST['hesap'])){
	// 1 Doğru 2 Yanlış
$sayisal1 = $_POST['sayisal1'];
$sayisal2 = $_POST['sayisal2'];
$sozel1 = $_POST['sozel1'];
$sozel2 = $_POST['sozel2'];
// Önlisan Puani
$onlisans = $_POST['onlisans'];

// bölümü
$alan = $_POST['alan'];
$dgsolay = $_POST['dgsolay'];
// Dgs Durumu



$dgspuan =0;
$sayisalnet =0;
$sozelnet =0;
$esitagirliknet=0;

$sayisalnet = (($sayisal1) - ($sayisal2*4));


$sozelnet = (($sozel1) - ($sozel2*4));








if($alan =1 ){
	
	$dgssay = (($sayisalnet*3)+($sozelnet*0.6) + ($onlisans*0.6)) ;
	
	if($dgsolay =1){
		$totalpuan = (($dgssay * 0.45 ) +146);
		echo "Puanınız $totalpuan";
		
	}

		if($dgsolay=0){
		$totalpuan = (($dgssay * 0.65) +146));
		echo "Puanınız $totalpuan";
		
	}
	
}

if($alan = 2){
	
	$dgssozel = (($sayisalnet*0.6)+($sozelnet*3) + ($onlisans*0.6));
	
		if($dgsolay=1){
		$totalpuan = (($dgssozel * 0.45)+75);
		echo "Puanınız $totalpuan";
		
	}

		if($dgsolay=0){
		$totalpuan = (($dgssozel * 0.65)+76);
		echo "Puanınız $totalpuan";
		
	}
	
}


if($alan =3){
	
	$dgsesitagirlik = (($sayisalnet*1.8)+($sozelnet*1.8) + ($onlisans*0.6));
	
		if($dgsolay=1){
		$totalpuan = (($dgsesitagirlik * 0.45)+176);
		echo "Puanınız $totalpuan";
		
	}

		if($dgsolay=0){
		$totalpuan = (($dgsesitagirlik * 0.65)+176);
		echo "Puanınız $totalpuan";
		
	}
	
}









	
}



?>