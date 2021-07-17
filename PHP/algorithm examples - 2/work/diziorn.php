<form action="" method="post">
	Öğrenci No <input type="textbox" name="girilenno"/> <br>


	<input type="submit" name="hesap" value="hesap"> 
</form>

<?php
$ogrenci[1] = array("Ahmet",525,"Fatih Üniversitesi",52,52);
$ogrenci[2] = array("Mehmet",213,"Akdeniz Üniversitesi",50,70);
$ogrenci[3] = array("Veli",1231,"Fatih Üniversitesi",60,80);


	for($i=1; $i <=3;$i++){
		$yilsonunotu = ( (($ogrenci[$i][3])*0.4) + (($ogrenci[$i][4])*0.6)  );
		$ogrenci[$i][5] = $yilsonunotu;
		
	echo $ogrenci[$i][0]."  İsimli Öğrenci ".$ogrenci[$i][1]." Numaralı  ".$ogrenci[$i][2]." Okulundaki Öğrencinin yil sonu notu ".$ogrenci[$i][5]."<br>";
	}


	if(isset($_POST['hesap'])){
		$girilenno= $_POST['girilenno'];
		
		for($i=1; $i<=3;$i++){
				if($girilenno == $ogrenci[$i][1]){
					
				echo "Girdiginiz öğrencinin yil sonu notu : ".$ogrenci[$i][5];
				}
				
		
		}
	}
?>

