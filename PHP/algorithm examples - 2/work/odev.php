<?php
// Öðrenciler
// 0 Öðrenci no , 1 öðrenci ismi ,  2  okul id  , 3  dönem id  , 4  bölüm id;
$ogrenci[1] = array (1,'Batuhan Atabey',3,4,3);
$ogrenci[2] = array (2,'Murat Temel',3,3,1);
$ogrenci[3] = array (1,'Kemal Turan',1,2,2);
$ogrenci[4] = array (1,'Mustafa Demir',2,4,4);

//Okullar
$okul[1] = array(1,'Istanbul Universitesi');
$okul[2] = array(2,'Ankara Universitesi');
$okul[3] = array(3,'Aydin Universitesi');
$okul[4] = array(4,'Manisa Universitesi');


//Dönem
$donem[1] = array(1,'Yaz');
$donem[2] = array(2,'Kis');
$donem[3] = array(3,'Sonbahar');
$donem[4] = array(4,'Ilkbahar');

//Bölüm
$bolum[1] = array(1,'Iktisat Fakultesi');
$bolum[2] = array(2,'Tip Fakultesi');
$bolum[3] = array(3,'Guzel Sanatlar Fakultesi');
$bolum[4] = array(4,'Matematik Fakultesi');

// Öðrencileri tek tek secicek for 
for($i=1;$i<=4;$i++){

echo $ogrenci[$i][1]." Isimli ogrenci ";

// Sorgulari yaparken düzenli olmasý için boþ bir string tanýmlayýp o deðerin doðru gelmesini saðlayip döngüye aldým.
//Okul Sorgulamasi
$okuladi = "";
if($okuladi == ""){ 
				if($ogrenci[$i][2]==1){

					echo $okul[1][1]." Okulundan ";
				}
				else if($ogrenci[$i][2]==2){

					echo $okul[2][1]." Okulundan ";
				}
				else if($ogrenci[$i][2]==3){

					echo $okul[3][1]." Okulundan ";
				}
				else{

					echo $okul[4][1]." Okulundan ";
				}
}

//Donem Sorgulamasi
$donemadi = "";
if($donemadi == ""){ 
				if($ogrenci[$i][3]==1){

					echo $donem[1][1]." Doneminde  ";
				}
				else if($ogrenci[$i][3]==2){

					echo $donem[2][1]." Doneminde  ";
				}
				else if($ogrenci[$i][3]==3){

					echo $donem[3][1]." Doneminde  ";
				}
				else{

					echo $donem[4][1]." Doneminde ";
				}
}

//Bölüm Sorgulamasi
$bolumadi = "";
if($bolumadi == ""){ 
				if($ogrenci[$i][4]==1){

					echo $bolum[1][1]." Bolumunden mevzun olmustur <br><br>";
				}
				else if($ogrenci[$i][4]==2){

					echo $bolum[2][1]." Bolumunden mevzun olmustur <br><br>";
				}
				else if($ogrenci[$i][4]==3){

					echo $bolum[3][1]." Bolumunden mevzun olmustur <br><br>";
				}
				else{

					echo $bolum[4][1]." Bolumunden mevzun olmustur <br><br>";
				}
}





}



?>
