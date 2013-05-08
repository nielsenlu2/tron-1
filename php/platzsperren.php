<!DOCTYPE html>
<?php

	include "includeup.php";
	
	
	//Wenn eingeloggt und Benutzerrecht weiter..
	if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") 
	{
		
		
		//Reservierung ID's mit POST vergleichen
		$plaetze = $sql->arrayCall("SELECT Platz_ID FROM tb_platz");
		
		$pid = true;
		
		foreach($plaetze as $p)
		{
			$id = $p["Platz_ID"];
			
			if(isset($_POST["$id"]))
			{
				$pid = $id;
			}
		}
		
		if(isset($_POST["bestaetigt"]))
			{
				$grund = 'NULL';
				if (isset($_POST['grund']))
				{
					$grund = $_POST['grund'];
				}
				
				$sql->change("UPDATE tb_platz SET Gesperrt = '1' WHERE Platz_ID = '$pid'");
				$sql->change("UPDATE tb_platz SET Kommentar = '$grund' WHERE Platz_ID = '$pid'");
				$daten["gesperrt"] = true;
				
				//Aufrufen der plaetze.php
				header('Location: plaetze.php');
			}
		
		$daten["pid"] = $pid;
		
		
		
		//auf Template verweisen
		$template = $twig->loadTemplate('platzsperren.twig');
		
	//sonst auf anmeldeseite
	}else{

		$template = $twig->loadTemplate('anmelde.twig');
		
	}
	
	
	include "includedown.php";

?>