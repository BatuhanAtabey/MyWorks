<?php
for($i=0;$i<=10000;$i++){
	$random = rand(1,4);
	
	if($random == 1){
	$dna[1][$i] = 'A';
	}
	else if($random == 2){
	$dna[1][$i] = 'G';
	}
	else if($random == 3){
	$dna[1][$i] = 'C';
	}
	else if($random == 4){
	$dna[1][$i] = 'T';
	}
	
	
}


for($i=0;$i<=10000;$i++){
	$random = rand(1,4);
	
	if($random == 1){
	$dna[2][$i] = 'A';
	}
	else if($random == 2){
	$dna[2][$i] = 'G';
	}
	else if($random == 3){
	$dna[2][$i] = 'C';
	}
	else if($random == 4){
	$dna[2][$i] = 'T';
	}
	
	
}
$adet =0;
for($a=0;$a<=10000;$a++){

$at = 0;
if($at==0){	
		if($dna[1][$a] == 'A' && $dna[2][$a] == 'T'){
	
			echo $dna[1][$a]."--->".$dna[2][$a]."<br>";
			$adet++;
			}
		if($dna[1][$a] == 'T' && $dna[2][$a] == 'A'){
	
		echo $dna[1][$a]."--->".$dna[2][$a]."<br>";
		$adet++;
			}


		}	
		
$gc =0;
if($gc==0){	
		if($dna[1][$a] == 'G' && $dna[2][$a] == 'C'){
	
			echo $dna[1][$a]."--->".$dna[2][$a]."<br>";
			$adet++;
			}
		if($dna[1][$a] == 'C' && $dna[2][$a] == 'G'){
	
		echo $dna[1][$a]."--->".$dna[2][$a]."<br>";
		$adet++;
			}


		}			
		
			

}


echo $adet;



?>
