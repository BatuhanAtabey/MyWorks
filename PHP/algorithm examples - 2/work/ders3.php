<form action ="" method="post" >

<select name="sayi"> 
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
<br>
<br>
<input type="submit" name="hesapla" value="Çarpım Tablosu">
</form>








<?php

if(isset($_POST['hesapla'])){
	$sayi=$_POST['sayi'];

 for ($i=1;$i<=9;$i++)
    {
        echo $sayi." x ".$i." = ".($sayi*$i)."<br>";       
    }
}





?>