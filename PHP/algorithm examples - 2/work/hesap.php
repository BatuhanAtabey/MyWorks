<?php
$s1=$_POST['s2'];
$s2=$_POST['s2'];
$islem=$_POST['hesapla'];
$toplam=0;
if ($islem==1){
	$toplam=$s1+$s2;
	echo "sonuc:".$toplam;

	
}
else if ($islem==2){
	$toplam=$s1-$s2;
	echo "sonuc:".$toplam;

	
}
else if ($islem==3){
	$toplam=$s1/$s2;
	echo "sonuc:".$toplam;

	
}
if($islem==4){
	$toplam=$s1*$s2;
	echo "sonuc:".$toplam;

	
}


?>