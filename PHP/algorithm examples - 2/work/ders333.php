<form action="" method="POST">
Öğrenci numarası:<input type="text" name ="ogrencino"><br>
<input type="submit" name="getir" value="Yılsonu Notunu Getir"><br>

</from>






<?php
$ahmet=array(1,"Gelişim",50,100,0);
$mehmet=array(2,"Gelişim",50,100,0);
$veli=array(3,"Gelişim",50,100,0);

$ortahmet=($ahmet[2]*0.4)+($ahmet[3]*0.6);
$ortmehmet=($mehmet[2]*0.4)+($mehmet[3]*0.6);
$ortveli=($veli[2]*0.4)+($veli[3]*0.6);

if(isset($_POST['getir'])){
	$no=$_POST['ogrencino'];
	if($no==1){
		echo $ahmet[1]."üniversitesi  ".$ahmet[0]."No'lu öğrencisi Yıl sonu Notu:".$ortahmet;
	}
	else if ($no==2){
		echo $mehmet[1]."üniversitesi " .$mehmet[0]."No'lu öğrencisi Yıl sonu Notu:".$ortmehmet;
	}
	else if ($no==3){
		echo $veli[1]."üniversitesi ".$veli[0]."No'lu öğrencisi Yıl sonu Notu:".$ortveli;
	}
	







/* print_r($dizi) => diziyi yazdırır.
 $dizi=arry("bir"=>"x",iki=>"y","üç"=>"3") bu şekildeki dizileri yazdırmak için ; foreach ($dizi as $anahtar =>$deger) */

}


?>



