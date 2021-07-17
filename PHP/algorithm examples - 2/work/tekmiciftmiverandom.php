
<form action="" method="post">
	Sayi1 : <input type="textbox" name="sayi1"/> <br>
	Sayi2 : <input type="textbox" name="sayi2"/> <br>


	<br>
	<input type="submit" name="hesap" value="hesapla"> 
	<input type="submit" name="randomhesapla" value="randomhesapla"> 
</form>

<?php
$sonuc = 0;
if(isset($_POST['hesap'])){
$sayi1 = $_POST['sayi1'];
$sayi2 = $_POST['sayi2'];

for($a=$sayi1;$a <=$sayi2;$a++){
	if($a%2==0){
		echo "Çift =".$a."<br>";
	}
	else{
		echo "Tek =".$a."<br>";
	}
	
}

}

// Girilen 2 Sayi arasında random sayi üreticegiz ve bu sayi 50 olduğu zaman kaçıncı tahminde 50yi buldugumuzu söylicek.
if(isset($_POST['randomhesapla'])){
	$sayi1 = $_POST['sayi1'];
	$sayi2 = $_POST['sayi2'];
	$b = rand($sayi1,$sayi2);
	if($sayi2 >50){
		$tahmin =0;
		do {
			$sayi = rand($sayi1,$sayi2);
			$tahmin++;
		}while($sayi!=50);
		
		echo "Kaçıncı tahminde buldun: $tahmin";
	}

	
}



?>