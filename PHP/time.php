<?php  include ("sql.php"); $text = " ";$baglanti = sqlbaglan($text); $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $key = "2ad04f.aq111froqp0z6431f..c13f.";					
if(isset($_GET['code'])){ $gelencod = $_GET['code']; if($gelencod != $key ) { echo 'KOD YANLIS '; die; } }else { echo 'X'; die; }		


			// turnuva
	 		$turnuvabilgileri= $baglanti->query("SELECT * FROM turnuvatime WHERE turnuva_durumu = 1");
			while ($cikti = $turnuvabilgileri->fetch(PDO::FETCH_ASSOC)) { 
	
			$turnuvaismi = $cikti["turnuva_ismi"];
			$fark = $cikti["turnuva_kalansaniye"];

			$yenisaniye = $fark - 60 ;
			if($yenisaniye<=0){ // BAŞLATMA İŞLEMLERİ 
			 
			 //NEXT TOURNAMENT 
		    $turnuvavarmi = 0 ;
			$turnuvabilgileri= $baglanti->query("SELECT * FROM turnuvalar WHERE turnuva_ismi ='$turnuvaismi' AND turnuva_durumu=1");
			while ($cikti = $turnuvabilgileri->fetch(PDO::FETCH_ASSOC)) {  
			
				$t_katilimsayisi = $cikti["turnuva_katilimsayisi"];
				$t_durumu = $cikti["turnuva_durumu"];
				$t_ismi = $cikti["turnuva_ismi"];
				$t_takimkisisayisi = $cikti["turnuva_takimkisisayisi"];
				$t_id = $cikti["turnuva_id"];
				$t_girisucreti = $cikti["turnuva_girisparasi"];
				$t_sahibi = $cikti["turnuva_sahibi"];
				$t_roundtime = $cikti["turnuva_roundtime"];
				$turnuvavarmi = 1;
	
			
			}
			if($turnuvavarmi == 1){ 
			// katilim sayisi 0 sa direk bitir.
			if($t_katilimsayisi == 0) {
					$turnuvadurumunudegis = $baglanti->query("UPDATE turnuvatime SET turnuva_durumu = '3' WHERE turnuva_ismi='$t_ismi'");
						$turnuvadurumunudegis2 = $baglanti->query("UPDATE turnuvalar SET turnuva_durumu = '3' WHERE turnuva_ismi='$t_ismi'");								
			}
			// 2 den az katilim varsa iptal et ve paralarını iade et turnuvayı bitir.
			else if($t_katilimsayisi ==1 ) { 
			
			$iadeturnuvatakimbilgileri= $baglanti->query("SELECT * FROM turnuvadakitakimlar WHERE tk_turnuvaismi ='$turnuvaismi'");
			while ($cikti2 = $iadeturnuvatakimbilgileri->fetch(PDO::FETCH_ASSOC)) {   
			
			$iadeteamname = $cikti2["tk_teamname"];
			
			$iadeturnuvaoyuncubilgileri = $baglanti->query("SELECT * FROM teamplayers WHERE tp_teamname ='$iadeteamname'");
			while ($cikti3 = $iadeturnuvaoyuncubilgileri->fetch(PDO::FETCH_ASSOC)) { 
			$iadeusername = $cikti3["tp_playerusername"];
			
			$iadeturnuvaoyuncubilgileri2 = $baglanti->query("SELECT * FROM users WHERE user_username ='$iadeusername'");
			while ($cikti4 = $iadeturnuvaoyuncubilgileri2->fetch(PDO::FETCH_ASSOC)) {  
			$iadekullaniciparasi = $cikti4["user_money"];
			
			$yeniparasi = $iadekullaniciparasi+ $t_girisucreti;
			
			$bakiyeyiyenile = $baglanti->query("UPDATE users SET user_money = '$yeniparasi' WHERE user_username='$iadeusername'");
			
			}
			
			}
							$teamturnuvadansil = $baglanti->query("UPDATE teams SET team_oyundami = '0' WHERE team_adi='$iadeteamname'");
							$turnuvadansil = "DELETE FROM turnuvadakitakimlar WHERE tk_turnuvaid = '$t_id' AND tk_turnuvaismi='$t_ismi' AND tk_teamname ='$iadeteamname'";
							$baglanti->exec($turnuvadansil);
						$turnuvadurumunudegis = $baglanti->query("UPDATE turnuvatime SET turnuva_durumu = '3' WHERE turnuva_ismi='$t_ismi'");
						$turnuvadurumunudegis2 = $baglanti->query("UPDATE turnuvalar SET turnuva_durumu = '3' WHERE turnuva_ismi='$t_ismi'");
			}
			
			
			
			
			
				
			}else if($t_katilimsayisi>= 2) {  
				$tmacdakitakimlar52= $baglanti->query("SELECT * FROM users WHERE user_username='$t_sahibi'");
			while ($cikti2 = $tmacdakitakimlar52->fetch(PDO::FETCH_ASSOC)) { 
			$atamaciid = $cikti2["user_id"]; 
			}
				
				
				//BAŞLAT
		 $takimsayisi = 0;
				 $takimsayisi2 = 0;
				 				 $turnuvadakitakimlar = array(

 
);			

			$tmacdakitakimlar= $baglanti->query("SELECT * FROM turnuvadakitakimlar WHERE tk_turnuvaid='$t_id'");
			while ($cikti = $tmacdakitakimlar->fetch(PDO::FETCH_ASSOC)) {
				
				$takiminismi = $cikti["tk_teamname"];
				
				// system mesaj ekleme
				
					$takimdakioyuncular= $baglanti->query("SELECT * FROM teamplayers WHERE tp_teamname='$takiminismi'");
			while ($cikti2 = $takimdakioyuncular->fetch(PDO::FETCH_ASSOC)) {
				$systemmesage_oyuncuismi = $cikti2["tp_playerusername"];
				
				$mesaj = 'The tournament named '.$systemmesage_oyuncuismi.' has started, please login.';
			
		$mesajekle = "INSERT INTO log_systemmessage (sm_username,sm_message)
		VALUES ('$systemmesage_oyuncuismi','$mesaj')";
		$baglanti->exec($mesajekle);
				
				
			}
				
				
				
				
				
			$takimsayisi2 = $takimsayisi + 1;
				 $turnuvadakitakimlar += array(
					
					$takimsayisi2 => $takiminismi,
						);
						
						$takimsayisi++;
			}
	 

include ("functions.php");
if($takimsayisi%2 !=0 ) { 

$btm = rand(1,$takimsayisi); 

$buygecentakim = $turnuvadakitakimlar[$btm];

		$buyekle = "INSERT INTO turnuvamaclari (tm_birincitakimisim,tm_birincitakimcode,tm_ikincitakimisim,	tm_ikinicitakimcode,tm_kazanan,tm_atamacid,tm_turnuvaid,tm_matchdurumu)
		VALUES ('$buygecentakim','1','BUY','1','1','$atamaciid','$t_id','3')";
		$baglanti->exec($buyekle);




unset($turnuvadakitakimlar[$btm]);  


}

	
	
	
	$kisisayisi = 0 ;

	foreach($turnuvadakitakimlar as $takim){
		
		$kisisayisi++;
		
		if($kisisayisi == 1){
			
			$birincitakim = $takim;
		}
		if($kisisayisi == 2){
			
			$ikincitakim = $takim;

		
		$birincitakimcodeee = rand(1,99999999);
		
		$birincitakimcodee = sha1(md5($birincitakimcodeee));
		$birincitakimcode = mb_substr($birincitakimcodee,0,10);
		
		$ikincitakimcodeee = rand(1,99999999);
	
		$ikincitakimcodee = sha1(md5($ikincitakimcodeee));
		$ikincitakimcode = mb_substr($ikincitakimcodee,0,10);
		
		
		
		
		$maclariekle = "INSERT INTO turnuvamaclari (tm_birincitakimisim,tm_birincitakimcode,tm_ikincitakimisim,	tm_ikinicitakimcode,tm_atamacid,tm_turnuvaid)
		VALUES ('$birincitakim','$birincitakimcode','$ikincitakim','$ikincitakimcode','$atamaciid','$t_id')";
		$baglanti->exec($maclariekle);
		
	$kisisayisi = 0 ;
	
		}
		
		
	}
	
	
	// turnuvaoylama
	
		$tmacdakitakimlar= $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$t_id'");
			while ($cikti = $tmacdakitakimlar->fetch(PDO::FETCH_ASSOC)) {
				$macidsi = $cikti["tm_id"];
			$kazananvarmi = $cikti["tm_kazanan"];
			
			if($kazananvarmi == 0 ) {
		$tmoylamaekle = "INSERT INTO turnuvamaclarioylama (tmo_macid)
		VALUES ('$macidsi')";
		$baglanti->exec($tmoylamaekle);
		
		// turnuvatakimoyuncularihazir team_adi match_id oyuncu_adi hazirmi       matchid -> teamadi->oyuncuadi hazirmi 0 
			
			$birincitakimismi = $cikti["tm_birincitakimisim"];
			$ikincitakimismi = $cikti["tm_ikincitakimisim"];
			
				$takimdakioyuncular= $baglanti->query("SELECT * FROM teamplayers WHERE tp_teamname='$birincitakimismi' OR tp_teamname='$ikincitakimismi'");
			while ($cikti4 = $takimdakioyuncular->fetch(PDO::FETCH_ASSOC)) {
				$takimdakioyuncuismi = $cikti4["tp_playerusername"];
				$takimdaoyuncutakimismi = $cikti4["tp_teamname"];
				
				$oyuncularihazirekle = "INSERT INTO turnuvatakimoyuncularihazir (team_adi,match_id,oyuncu_adi)
		VALUES ('$takimdaoyuncutakimismi','$macidsi','$takimdakioyuncuismi')";
		$baglanti->exec($oyuncularihazirekle);
		
		
		//turnuvatakimoyuncularihaziristastik
		
		
					$oyuncularihaziristastikekle = "INSERT INTO turnuvatakimoyuncularihaziristastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi,takim_hazirkisisayisi)
		VALUES ('$t_id','$macidsi','$takimdaoyuncutakimismi','$t_takimkisisayisi','0')";
		$baglanti->exec($oyuncularihaziristastikekle);
		
		// turnuvabitimioylama
			$turnuvabittimioylamaekle = "INSERT INTO turnuvabitimioylama (turnuva_id,match_id,takim_ismi,user_username)
		VALUES ('$t_id','$macidsi','$takimdaoyuncutakimismi','$takimdakioyuncuismi')";
		$baglanti->exec($turnuvabittimioylamaekle);
		
		//turnuvabittimistastik
		
		$turnuvabittimiistastikekle = "INSERT INTO turnuvabitimiistastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi,takim_bitimidiyensayisi)
		VALUES ('$t_id','$macidsi','$takimdaoyuncutakimismi','$t_takimkisisayisi','0')";
		$baglanti->exec($turnuvabittimiistastikekle);
		
		//turnuvayendimioylama
			
			$turnuvayendimioylamaekle = "INSERT INTO turnuvayendimioylama (turnuva_id,match_id,takim_ismi,user_username)
		VALUES ('$t_id','$macidsi','$takimdaoyuncutakimismi','$takimdakioyuncuismi')";
		$baglanti->exec($turnuvayendimioylamaekle);
		
			}
			
			
			
				
			}

				
			
			}
	
	$turnuvabilgileriniyenile = $baglanti->query("UPDATE turnuvalar SET turnuva_durumu='2' ,turnuva_hangirounda='1' WHERE turnuva_id='$t_id'");

			
			$durumupdate = $baglanti->query("UPDATE turnuvatime SET turnuva_durumu='2' WHERE turnuva_ismi='$t_ismi'");
		
				$roundtimeekle = "INSERT INTO turnuvaroundtime (turnuva_ismi,turnuva_roundtime) VALUES ('$t_ismi','$t_roundtime')";
			$baglanti->exec($roundtimeekle); 
				//*BAŞLAT
			}
			
			} 
			
			}else if($yenisaniye>0) { $sy = $baglanti->query("UPDATE turnuvatime SET turnuva_kalansaniye='$yenisaniye' WHERE turnuva_ismi='$turnuvaismi'");}
			}


// *turnuva

//turnuva finish

function tournamentfinish($tid,$tbirinci,$tikinci,$tucuncu) {
	
	echo '<br>';
	echo $tid.' '.$tbirinci.' '.$tikinci.' '.$tucuncu;
}


// *** turnuva finish*

// mac eşleştirme
function maceslestir($kazanantakimlar,$atamaciid,$turnuvaid,$turnuvaround,$turnuvatakimkisisayisi){
	$text = " ";$baglanti = sqlbaglan($text); $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$kazanansayisi = count($kazanantakimlar);
			
			if($kazanansayisi%2 ==0 ) { 
			
			}
			else {  $buyismi = "BUY"; 
				$kazanansayisi++;   $kazanantakimlar += array ( $kazanansayisi => $buyismi );    
			} 
			$takimsayi = 0;
			foreach ($kazanantakimlar as $nextteamname) {
			
			$takimsayi++;
			if($takimsayi == 1) { $birincitakimismi = $nextteamname ; }
			else if($takimsayi == 2) { $takimsayi =0 ;   $ikincitakimismi = $nextteamname; 
		$birincitakimcodeee = rand(1,99999999);
		$birincitakimcodee = sha1(md5($birincitakimcodeee));
		$takimcode1 = mb_substr($birincitakimcodee,0,10);
		
		$ikincitakimcodeee = rand(1,99999999);
		$ikincitakimcodee = sha1(md5($ikincitakimcodeee));
		$takimcode2 = mb_substr($ikincitakimcodee,0,10);
			
	
	
		
	
		$maclariekleee = "INSERT INTO turnuvamaclari (tm_birincitakimisim,tm_birincitakimcode,tm_ikincitakimisim,tm_ikinicitakimcode,tm_atamacid,tm_turnuvaid,tm_round) VALUES ('$birincitakimismi','$takimcode1','$ikincitakimismi','$takimcode2','$atamaciid','$turnuvaid','$turnuvaround')";
		$baglanti->exec($maclariekleee);  
			}	
			
			}
			
				$macbilgileri = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_atamacid='$atamaciid' AND tm_turnuvaid='$turnuvaid' AND tm_round='$turnuvaround'");
			while ($cikti = $macbilgileri->fetch(PDO::FETCH_ASSOC)) { 
			$nextmatchid = $cikti["tm_id"];
			$nextmatchbirincitakimismi = $cikti["tm_birincitakimisim"];
			$nextmatchikincitakimismi = $cikti["tm_ikincitakimisim"];
			
		$oylama = "INSERT INTO turnuvamaclarioylama (tmo_macid) VALUES ('$nextmatchid')";
		$baglanti->exec($oylama);
		$oylama2 = "INSERT INTO turnuvabitimiistastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi) VALUES ('$turnuvaid','$nextmatchid','$nextmatchbirincitakimismi','$turnuvatakimkisisayisi')";
		$baglanti->exec($oylama2);
		$oylama3 = "INSERT INTO turnuvabitimiistastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi) VALUES ('$turnuvaid','$nextmatchid','$nextmatchikincitakimismi','$turnuvatakimkisisayisi')";
		$baglanti->exec($oylama3);
		$oylama4 = "INSERT INTO turnuvatakimoyuncularihaziristastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi) VALUES ('$turnuvaid','$nextmatchid','$nextmatchbirincitakimismi','$turnuvatakimkisisayisi')";
		$baglanti->exec($oylama4);
		$oylama5 = "INSERT INTO turnuvatakimoyuncularihaziristastik (turnuva_id,match_id,takim_ismi,turnuva_takimkisisayisi) VALUES ('$turnuvaid','$nextmatchid','$nextmatchikincitakimismi','$turnuvatakimkisisayisi')";
		$baglanti->exec($oylama5);
		
		// playerlar  turnuvabitimioylama  turnuvatakimoyuncularihazir turnuvayendimioylama
			$macbilgileri44 = $baglanti->query("SELECT * FROM teamplayers WHERE tp_teamname='$nextmatchbirincitakimismi'");
			while ($cikti3 = $macbilgileri44->fetch(PDO::FETCH_ASSOC)) { 
			$nextplayername = $cikti3["tp_playerusername"];
			
			$oylama6 = "INSERT INTO turnuvabitimioylama (turnuva_id,match_id,takim_ismi,user_username) VALUES ('$turnuvaid','$nextmatchid','$nextmatchbirincitakimismi','$nextplayername')";
		$baglanti->exec($oylama6);
		$oylama7 = "INSERT INTO turnuvatakimoyuncularihazir (team_adi,match_id,oyuncu_adi) VALUES ('$nextmatchbirincitakimismi','$nextmatchid','$nextplayername')";
		$baglanti->exec($oylama7);
		$oylama8 = "INSERT INTO turnuvayendimioylama (turnuva_id,match_id,takim_ismi,user_username) VALUES ('$turnuvaid','$nextmatchid','$nextmatchbirincitakimismi','$nextplayername')";
		$baglanti->exec($oylama8);
			}
			$macbilgileri45 = $baglanti->query("SELECT * FROM teamplayers WHERE tp_teamname='$nextmatchikincitakimismi'");
			while ($cikti4 = $macbilgileri45->fetch(PDO::FETCH_ASSOC)) { 
			$nextplayername = $cikti4["tp_playerusername"];
			
			$oylama6 = "INSERT INTO turnuvabitimioylama (turnuva_id,match_id,takim_ismi,user_username) VALUES ('$turnuvaid','$nextmatchid','$nextmatchikincitakimismi','$nextplayername')";
		$baglanti->exec($oylama6);
		$oylama7 = "INSERT INTO turnuvatakimoyuncularihazir (team_adi,match_id,oyuncu_adi) VALUES ('$nextmatchikincitakimismi','$nextmatchid','$nextplayername')";
		$baglanti->exec($oylama7);
		$oylama8 = "INSERT INTO turnuvayendimioylama (turnuva_id,match_id,takim_ismi,user_username) VALUES ('$turnuvaid','$nextmatchid','$nextmatchikincitakimismi','$nextplayername')";
		$baglanti->exec($oylama8);
			}

			}




		
}



//** maç eşleştirme

// round 

			$roundtimebilgileri = $baglanti->query("SELECT * FROM turnuvaroundtime");
			while ($cikti = $roundtimebilgileri->fetch(PDO::FETCH_ASSOC)) { 
			$rt_turnuvaismi = $cikti["turnuva_ismi"];    
			$rt_roundtime = $cikti["turnuva_roundtime"];
			$yenirt = 0;
			$yenirt = $rt_roundtime - 1;
			if($yenirt ==0) {
			// next round tournament bilgileri  $nm
				
			$rtturnuvamentinfo= $baglanti->query("SELECT * FROM turnuvalar WHERE turnuva_ismi='$rt_turnuvaismi' AND turnuva_durumu=2");
			while ($cikti2 = $rtturnuvamentinfo->fetch(PDO::FETCH_ASSOC)) { 
			$rt_tid = $cikti2["turnuva_id"];
			$rt_tismi = $cikti2["turnuva_ismi"];
			$rt_tteamsayisi = $cikti2["turnuva_takimkisisayisi"];
			$rt_thangiround = $cikti2["turnuva_hangirounda"];
			$rt_tbirinciparasi = $cikti2["turnuva_birinciparasi"];
			$rt_tikinciparasi  = $cikti2["turnuva_ikinciparasi"];
			$rt_tucuncuparasi  = $cikti2["turnuva_ucuncuparasi"];
			$rt_ikincilikmacieslesmi = $cikti2["turnuva_ikincilikmaci"];
			$rt_turnuvaroundsuresi = $cikti2["turnuva_roundtime"];
			$rt_tbirincibelirlendi = $cikti2["turnuva_birincibelirlendi"];
			$rt_tikincibelirlendi = $cikti2["turnuva_ikincibelirlendi"];
			$rt_tucuncubelirlendi = $cikti2["turnuva_ucuncubelirlendi"];
				// o roundaki maclar
				 $kazanantakimlar = array();
				 $kaybedentakimlar = array();
				 $kazanantakimsayisi = 0 ; $kaybedentakimsayisi = 0; $macvarsa = 0;
				$rtturnuvamentmatches= $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$rt_tid' AND tm_round = '$rt_thangiround'");
			while ($cikti3 = $rtturnuvamentmatches->fetch(PDO::FETCH_ASSOC)){
				
				$nm_id = $cikti3["tm_id"];
				$nm_birincitakim  = $cikti3["tm_birincitakimisim"];
				$nm_birinctakimcode = $cikti3["tm_birincitakimcode"];
				$nm_ikincitakim = $cikti3["tm_ikincitakimisim"];
				$nm_ikincitakimcode = $cikti3["tm_ikinicitakimcode"];
				$nm_kazanan = $cikti3["tm_kazanan"];
				$nm_atmacidi = $cikti3["tm_atamacid"];
				$nm_matchdurumu  = $cikti3["tm_matchdurumu"];
				$nm_hangirounda = $cikti3["tm_round"];
				
				$macvarsa++;
				
				/* 
				Kazanan varmi ? 
		yoksa kazanan belirle ve kazananlar dizisine at 
		varsa kazananı kazanan dizisine at  ;
				
				*/
				// hazir diyenleri kontrol et herkes hazir demişse onu kazanan yap
				if($macvarsa !=0 ) {
				if($nm_matchdurumu == 0) {
					$birincitakimfullhazir = 0 ;
					$ikincitakimfullhazir = 0;
					
					$birincihazirbilgilerisorgu = $baglanti->query("SELECT * FROM turnuvatakimoyuncularihaziristastik WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_birincitakim'");
					while ($cikti4 = $birincihazirbilgilerisorgu->fetch(PDO::FETCH_ASSOC)){
					$fullhazirsayisi = $cikti4["turnuva_takimkisisayisi"];
					$birincitakimhazirsayisi =  $cikti4["takim_hazirkisisayisi"];
					}
					if($fullhazirsayisi == $birincitakimhazirsayisi) {
						
						$birincitakimfullhazir = 1;
					}else { $birincitakimfullhazir = 0; }
					
					if($birincitakimfullhazir == 0) {
						// birinci takim full hazir demişse ikinciye bak eğer demişse zaten kazanan o eğer ikinci takımda hazir dememişse ikiside elendi
						
					$ikincihazirbilgilerisorgu = $baglanti->query("SELECT * FROM turnuvatakimoyuncularihaziristastik WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_ikincitakim'");
					while ($cikti5= $ikincihazirbilgilerisorgu->fetch(PDO::FETCH_ASSOC)){ 
					$fullhazirsayisi = $cikti5["turnuva_takimkisisayisi"];
					$ikincitakimhazirsayisi = $cikti5["takim_hazirkisisayisi"];
					
					}
					if($fullhazirsayisi == $ikincitakimhazirsayisi) {$ikincitakimfullhazir = 1;}else { $ikincitakimfullhazir = 0 ;}	
					
					if($ikincitakimfullhazir == 0 && $birincitakimfullhazir ==0 ) {
						
					
					}
					if($ikincitakimfullhazir == 1 && $birincitakimfullhazir ==0 ) {
						
				
						$kazanantakimsayisi++; $kazanantakimlar += array (  $kazanantakimsayisi => $nm_ikincitakim ); 
						$kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_birincitakim) ;
						
					}
					}else {  
					$kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim );
					$kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_ikincitakim ) ;
					} 
		
					
					
				}
				if($nm_matchdurumu == 1) {
					$birincitakimfullbittidedi =0 ;
					$ikincitakimfullbittidedi = 0;
					$birincitakimbittisorgu = $baglanti->query("SELECT * FROM turnuvabitimiistastik WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_birincitakim'");
					while ($cikti5= $birincitakimbittisorgu->fetch(PDO::FETCH_ASSOC)){  
					$fullbitisayisi = $cikti5["turnuva_takimkisisayisi"];
					$birbittisayisi = $cikti5["takim_bitimidiyensayisi"];
					
					
					}
					if($fullbitisayisi == $birbittisayisi) {$birincitakimfullbittidedi = 1; }
					else {
						$ikincitakimbittisorgu = $baglanti->query("SELECT * FROM turnuvabitimiistastik WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_ikincitakim'");
					while ($cikti6= $ikincitakimbittisorgu->fetch(PDO::FETCH_ASSOC)){ 
					$fullbitisayisi = $cikti6["turnuva_takimkisisayisi"];
					$ikibittisayisi = $cikti6["takim_bitimidiyensayisi"];
					}
					if($fullbitisayisi == $ikibittisayisi) {  $ikincitakimfullbittidedi = 1; }
						
					}
					
					if($birincitakimfullbittidedi == 1 && $ikincitakimfullbittidedi == 0 ) {
						$kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim );
						$kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_ikincitakim) ;
						
					}
					else if($birincitakimfullbittidedi == 0 && $ikincitakimfullbittidedi == 1) {
							$kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_ikincitakim );
						$kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_birincitakim) ;
					}
					
					
				}
				if($nm_matchdurumu == 2) {
					
					// 3 tane takım kararı 1 yendim 2 yenildim 3null
					$birincitakimkarari =0 ; $birincitakimyendimsayisi = 0; $birincitakimyenildimsayisi = 0; $birincitakimnullsayisi = 0 ;
					$ikincitakimkarari = 0 ; $ikincitakimyendimsayisi = 0; $ikincitakimyenildimsayisi = 0 ; $ikincitakimnullsayisi = 0 ;
					$birincitakimkararisorgu = $baglanti->query("SELECT * FROM turnuvayendimioylama WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_birincitakim'");
					while ($cikti7= $birincitakimkararisorgu->fetch(PDO::FETCH_ASSOC)){
						$nextplayerbitimioyu = $cikti7["yendimi"];
						if($nextplayerbitimioyu == 0) { $birincitakimnullsayisi++; }
						else if($nextplayerbitimioyu == 1) { $birincitakimyendimsayisi++;}
						else { $birincitakimyenildimsayisi++; }
					}
					$nextplayerbitimioyu =0;
					$ikincitakimkararisorgu = $baglanti->query("SELECT * FROM turnuvayendimioylama WHERE turnuva_id='$rt_tid' AND match_id='$nm_id' AND takim_ismi='$nm_ikincitakim'");
					while ($cikti8= $ikincitakimkararisorgu->fetch(PDO::FETCH_ASSOC)){
						$nextplayerbitimioyu = $cikti8["yendimi"];
						if($nextplayerbitimioyu == 0) { $ikincitakimnullsayisi++; }
						else if($nextplayerbitimioyu == 1) { $ikincitakimyendimsayisi++;}
						else { $ikincitakimyenildimsayisi++; }
					}
					
					if($birincitakimnullsayisi >= $birincitakimyendimsayisi && $birincitakimnullsayisi >= $birincitakimyenildimsayisi) {  $birincitakimkarari = 3;}
					else if($birincitakimyendimsayisi > $birincitakimnullsayisi && $birincitakimyendimsayisi > $birincitakimyenildimsayisi ) { $birincitakimkarari = 1; }
					else if($birincitakimyenildimsayisi > $birincitakimnullsayisi && $birincitakimyenildimsayisi > $birincitakimyendimsayisi) { $birincitakimkarari =2; }
					
					if($ikincitakimnullsayisi >= $ikincitakimyendimsayisi && $ikincitakimnullsayisi >= $ikincitakimyenildimsayisi) {  $ikincitakimkarari = 3;}
					else if($ikincitakimyendimsayisi > $ikincitakimnullsayisi && $ikincitakimyendimsayisi > $ikincitakimyenildimsayisi ) { $ikincitakimkarari = 1; }
					else if($ikincitakimyenildimsayisi > $ikincitakimnullsayisi && $ikincitakimyenildimsayisi > $ikincitakimyendimsayisi) { $ikincitakimkarari =2; }
					
					if($birincitakimkarari != $ikincitakimkarari) {
						
						if($birincitakimkarari == 1 && $ikincitakimkarari == 2) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_ikincitakimtakim) ;}
						else if($birincitakimkarari == 1 && $ikincitakimkarari == 3) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_ikincitakim) ;}
						else if($birincitakimkarari == 2 && $ikincitakimkarari == 1) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_ikincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_birincitakim) ;}
						else if($birincitakimkarari == 2 && $ikincitakimkarari == 3) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_ikincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_birincitakim) ; }
						else if($birincitakimkarari == 3 && $ikincitakimkarari == 1 ) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_ikincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_birincitakim) ;}
						else if($birincitakimkarari == 3 && $ikincitakimkarari == 2 ) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimlar => $nm_ikincitakimtakim) ; }
					}
					
				}
				if($nm_matchdurumu == 3) {
					
					if($nm_kazanan ==1) {
						$kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_birincitakim );
						$kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimsayisi => $nm_ikincitakim) ; }
					else if($nm_kazanan ==2) { $kazanantakimsayisi++;   $kazanantakimlar += array ( $kazanantakimsayisi => $nm_ikincitakim ); $kaybedentakimsayisi++; $kaybedentakimlar += array ( $kaybedentakimsayisi => $nm_birincitakim) ;}
			
					
				}
			}
				
			}
			
			 // KAZANAN TAKIMLARLA İŞLEMLER BURADA YAPILICAK 
		 	print_r($kazanantakimlar);  echo '<br>';
		
			$winner_1 = "NULL"; $winner_2= "NULL" ; $winner_3 = "NULL";
		
			if($kazanantakimsayisi == 0 ) {   
			
				
				tournamentfinish($rt_tid,$winner_1,$winner_2,$winner_3);
				
			
			
			/*
			$yenikazanantakimlar = array();
			$yenikazanantakimsayisi = 0 ;
			$eskiround = $rt_thangiround - 1;
			if($eskiround >0) {
				$yenilenmaclar = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid = '$rt_tid' AND tm_round=$eskiround'");
				while($cikti2 = $yenilenmaclar->fetch(PDO::FETCH_ASSOC)){
				$birincitakimismi = $cikti2["tm_birincitakimisim"];
				
					
				}
				
				
			}
			else { $winner_1 = "NULL" ; $winner_2 = "NULL"; $winner_3="NULL";
				 tournamentfinish($rt_tid,$winner_1,$winner_2,$winner_3); 
			
			}
			*/
			
			
			}
			// Speacial durum 1 kazanan var hepsi elenmiş oy vermediği için veya başka sebepden.
			else if($kazanantakimsayisi == 1) {
				
			
			
					$kazananmaci = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$rt_tid' AND tm_round='$rt_thangiround' AND ( tm_birincitakimisim='$kazanantakimlar[1]' OR tm_ikincitakimisim ='$kazanantakimlar[1]' )");
					while ($cikti7= $kazananmaci->fetch(PDO::FETCH_ASSOC)){ 
					$nextteamname1 = $cikti7["tm_birincitakimisim"];
					$nextteamname2 = $cikti7["tm_ikincitakimisim"];
					}
					
					if($nextteamname1 == $kazanantakimlar[1] ) {
						
					$winner_1 = $nextteamname1 ;  $winner_2 = $nextteamname2;   tournamentfinish($rt_tid,$winner_1,$winner_2,$winner_3); 
					}else { $winner_1 = $nextteamname2; $winner_2 =$nextteamname1;    tournamentfinish($rt_tid,$winner_1,$winner_2,$winner_3);  }
			
				
			}
			
			else if($kazanantakimsayisi == 2) {
				
				// ikincilik maci yok  yenilenleri aralarında eşleştir 
				if($rt_ikincilikmacieslesmi ==0 ) {
				
				
				$birincikazanantakim  = $kazanantakimlar[1];
				$ikincikazanantakim = $kazanantakimlar[2];
				$kazananmaci2 = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$rt_tid' AND tm_round='$rt_thangiround' AND ( tm_birincitakimisim='$kazanantakimlar[1]' OR tm_ikincitakimisim ='$kazanantakimlar[1]' )");
				while ($cikti7= $kazananmaci2->fetch(PDO::FETCH_ASSOC)){ 
				$nextteamname1 = $cikti7["tm_birincitakimisim"];
				$nextteamname2 = $cikti7["tm_ikincitakimisim"];
				} 
				if($nextteamname1 == $birincikazanantakim) { $birincikaybedentakim = $nextteamname2;} 
				else { $birincikaybedentakim= $nextteamname1; }
				
				$kazananmaci3 = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$rt_tid' AND tm_round='$rt_thangiround' AND ( tm_birincitakimisim='$kazanantakimlar[2]' OR tm_ikincitakimisim ='$kazanantakimlar[2]' )");
				while ($cikti7= $kazananmaci3->fetch(PDO::FETCH_ASSOC)){ 
				$nextteamname3 = $cikti7["tm_birincitakimisim"];
				$nextteamname4 = $cikti7["tm_ikincitakimisim"];
				} 
				if($nextteamname3 == $ikincikazanantakim) { $ikincikaybedentakim = $nextteamname4;} 
				else { $ikincikaybedentakim= $nextteamname3; }
				
				// kaybedenlerde biri buysa diğeri direk 3.  
		
			 
				 
				 $kaybedentakimlardabuyvarmi = 0 ;
				 $ucuncubelirlendi = 0 ;
				 
				
				 $kazanantakimsayisi++; $kazanantakimlar += array (  $kazanantakimsayisi => $birincikaybedentakim );  		
				 
				 $kazanantakimsayisi++; $kazanantakimlar += array (  $kazanantakimsayisi => $ikincikaybedentakim );
				 
			  $yeniround = $rt_thangiround + 1;			  
			maceslestir($kazanantakimlar,$nm_atmacidi,$rt_tid,$yeniround,$rt_tteamsayisi);
		
				 // UPDATE ikinclikmaci 1 , round++ ,roundtime 0la
				 $kazananmacidsorgu = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_turnuvaid='$rt_tid' AND tm_round='$yeniround' AND ( tm_birincitakimisim='$birincikaybedentakim' OR tm_ikincitakimisim ='$birincikaybedentakim' )");
				while ($cikti9= $kazananmacidsorgu->fetch(PDO::FETCH_ASSOC)){
					$ikincilikmaciid = $cikti9["tm_id"];
					}
				$turnuvabilgileriyenile = $baglanti->query("UPDATE turnuvalar SET turnuva_hangirounda='$yeniround' ,turnuva_ikincilikmaci='$ikincilikmaciid' WHERE turnuva_id ='$rt_tid' AND turnuva_ismi='$rt_turnuvaismi' ");
				$rountimeyenile = $baglanti->query("UPDATE turnuvaroundtime SET turnuva_roundtime ='$rt_turnuvaroundsuresi' WHERE  turnuva_ismi='$rt_tismi' ");
				
				
				
				
				
				
				}
				
				else { 
				 $ucunculuksorgu = $baglanti->query("SELECT * FROM turnuvamaclari WHERE tm_id='$rt_ikincilikmacieslesmi'");
				while ($cikti9= $ucunculuksorgu ->fetch(PDO::FETCH_ASSOC)){ 
				$is_teamname1 = $cikti9["tm_birincitakimisim"];
				$is_teamname2= $cikti9["tm_ikincitakimisim"];
				}
				$kacincidabuldu = 0 ;
				foreach($kazanantakimlar as $takim){
					$kacincidabuldu++;
				if($takim == $is_teamname1) { $winner_3= $is_teamname1;  $burdabuldu = $kacincidabuldu; }
				else if($takim == $is_teamname2) { $winner_3= $is_teamname2; $burdabuldu = $kacincidabuldu; }
			
				
				}
				unset($kazanantakimlar[$burdabuldu]);
				print_r($kazanantakimlar);
				
				// 2kim 
				$ikinciliksorgu = $baglanti->query("SELECT * FROM turnuvamaclari WHERE (tm_birincitakimisim='$kazanantakimlar[1]' OR tm_ikincitakimisim='$kazanantakimlar[1]') AND tm_turnuvaid='$rt_tid' AND tm_round='$rt_thangiround'");
				while ($cikti10= $ikinciliksorgu->fetch(PDO::FETCH_ASSOC)){  
				$ikis_team1 = $cikti10["tm_birincitakimisim"];
				$ikis_team2 = $cikti10["tm_ikincitakimisim"];
				
				}
				
				
				if($ikis_team1 == $kazanantakimlar[1]){ $winner_1 = $kazanantakimlar[1];  $winner_2 = $ikis_team2; }
				else { $winner_1 = $kazanantakimlar[1];  $winner_2=$ikis_team1; }
					tournamentfinish($rt_tid,$winner_1,$winner_2,$winner_3);
				
				
			
					
				}
			}else if($kazanantakimsayisi > 2) { 
			$yeniround = $rt_thangiround + 1;	
			
			maceslestir($kazanantakimlar,$nm_atmacidi,$rt_tid,$yeniround,$rt_tteamsayisi);
			$turnuvabilgileriyenile = $baglanti->query("UPDATE turnuvalar SET turnuva_hangirounda='$yeniround' WHERE turnuva_id ='$rt_tid' AND turnuva_ismi='$rt_turnuvaismi' ");
			$rountimeyenile = $baglanti->query("UPDATE turnuvaroundtime SET turnuva_roundtime ='$rt_turnuvaroundsuresi' WHERE  turnuva_ismi='$rt_tismi' ");
			//BURDA KALDIK  maclari eşleştir turnuva durumu artır round süresi yenile
			}
			
			}		
				//* next tournament
			}
			else { // roundtime düşür ve kaydet
				$rtupdate = $baglanti->query("UPDATE turnuvaroundtime SET turnuva_roundtime='$yenirt' WHERE turnuva_ismi='$rt_turnuvaismi'");
			}
			

			}

// *round
?>
