<?php
function topla($sayi1,$sayi2){
	$sonuc = $sayi1+$sayi2;
	echo $sonuc;
}
echo topla(5,5)."<br>";

function hosgeldiniz($isim ='Misafir'){
	echo "Hoşgediniz ".$isim."<br>";
}
hosgeldiniz();
hosgeldiniz('Musa');
hosgeldiniz(5);



function topla2($sayi1,$sayi2){
	$sonuc = $sayi1+$sayi2;
	return $sonuc;
}
$hesap = topla2(2,5);
echo $hesap;




// str_replace ile string ifadelerin yerini değiştiriz.
// expolde(',',$metin) = $a  böyle bir ifade metin içinideki , leri bölüyor.


?>