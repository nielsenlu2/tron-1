<!DOCTYPE html>
<?php
	
	include "includeup.php";
	
	$date = $_SESSION["datum"];
	$time = $_POST["zeit"];
	$platz = $_POST["pid"];
	$pnr = $_POST["pnr"];
	
	//Wenn eingeloggt, weiter..
	if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") { 
		
		if (isset($_POST["reserviert"])) {
			
			$bis = $_POST["resbis"];
			$von = $_POST["resvon"];
			$pid = $_POST["pid"];
			

			if (isset($_POST["resfuer"]))
			{
				$fuer = $_POST["resfuer"];
			} else {
				$fuer = $mitglied->mitglied_ID;
			}
			
			
			
			
			$sql->change("INSERT INTO tb_reservierung(fk_Mitglied_ID, fk_Platz_ID, Datum, ReservierungVon, ReservierungBis) VALUES ('$fuer', '$pid', '$date', '$von', '$bis')");
		}
		
	
		if(isset($_POST["geklickt"])) {
			
		
			$zeit = $sql->call("SELECT * FROM tb_zeiten");
			
			$reservierung = $sql->arrayCall("SELECT * FROM tb_reservierung WHERE Datum = '$date'");
			
			$mitglied = $sql->arrayCall("SELECT * FROM tb_mitglied");
			
			
			
			
			
			
			
			
			$daten["zeit"]=$zeit;
			$daten["time"]=$time;
			$daten["datum"]=$date;
			$daten["reservierungen"]=$reservierung;
			$daten["mitglieder"]=$mitglied;
			$daten["platz"]=$platz;
			$daten["pnr"]=$pnr;
			
			
			
		
		}else{
			header('Location: home.php');
		}
		
		
		
		
		
		
		
		
		
		
		
		//auf Template verweisen
		$template = $twig->loadTemplate('resformular.twig');
		
	//sonst auf anmeldeseite
	}else{

		$template = $twig->loadTemplate('anmelde.twig');
		
	}
	
	
	include "includedown.php";
?>