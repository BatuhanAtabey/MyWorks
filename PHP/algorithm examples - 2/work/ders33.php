<form action ="" method="post" >

<input type="radio" name="sayi" value="10">10
<input type="radio" name="sayi" value="9">9
<input type="radio" name="sayi" value="8">8
<input type="radio" name="sayi" value="8">7
<br>
<input type="submit" name="faktoriyel" value="Faktöriyel hesapla">





</form>

<?php

if(isset($_POST['faktoriyel'])){
	$sayi=$_POST['sayi'];
	echo $sayi."! =";
	$toplam=1;
	for($i=$sayi;$i>=1;$i--){
	echo $i.",";
	$toplam*=$i;
	}
	echo " = ".$toplam;
}




?>