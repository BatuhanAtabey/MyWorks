

<form action="" method="post">
  kullanıcı adı: <input type="text" name="kad"><br>
  şifre: <input type="password" name="sifre"><br>
  <input type="submit" name="giris" value="giriş yap">
</form>

<?php
$kad="admin";
$sifre=1234;
 if (isset($_POST['giris'])){
	 $kad=$_POST['kad'];
	 $sifre=$_POST['sifre'];
	 if ($kad=="admin" && $sifre==1234){
		 
		 echo "hoşgeldiniz.";
		 header("Location:index.php");
	 }
	  else {
		 
		 echo "Kullanıcı adı hatalı.";
	 }
	 
 }

?>

