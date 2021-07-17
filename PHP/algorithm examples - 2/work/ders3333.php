




<?php


/* 
1-) $yemek['acılı']=array("kebap","lahmacun","çigkofte")
 $yemek[tatlı]=array("pasta","kek","suffle")


2-)$yemek=arry(arry("kebap","lahmacun","çigkofte"),array("pasta","kek","suffle"))

1.yöntemle yazılırsa çağırma işlemi ; echo $yemek['tatlı'][1] =kek'lı ekrana yazar
2.yöntemle yazılırsa çağırma işlemi ;echo $yemek[1][2] =suffle'lı ekrana yazar

*/

$ogrenci[0]=array('ahmet',1,1,1);
$ogrenci[1]=array('Mehmet',55,60,2);
$ogrenci[2]=array('Veli',3,72,2);

$ders[0]=array(1,"Matematik");
$ders[1]=array(55,"Fizik");
$ders[2]=array(3,"Kimya");

$ogretmen[0]=array(1,"İlknur");
$ogretmen[1]=array(60,"Levent");
$ogretmen[2]=array(72,"Mahmut");

$donem[0]=array(1,"Bahar Güz");
$donem[1]=array(2,"Sonbahar");
$donem[2]=array(2,"Sonbahar");

for($i=0;$i<=3;$i++){
	
	for($k=0;$k<=3;k++){
		
		echo $ogrenci[i][k]."adlı ogrenci";
		
	}
}



















?>