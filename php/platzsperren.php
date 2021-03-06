<!DOCTYPE html>
<?php

	include "includeup.php";
	
	
	
	//Wenn eingeloggt und Benutzerrecht weiter..
	if (isset($_SESSION["login"]) && $_SESSION["login"] == "ok") 
	{
		if ($platzrecht) {
		
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
					
					$von = $_POST["datumAnfang"];
					$bis = $_POST["datumEnde"];
					$grund = 'NULL';
					if (isset($_POST['grund']))
					{
						$grund = $_POST['grund'];
					}
					
					if($grund != NULL)
					{
						if(isset($_POST["allessperren"]))
						{
													
							foreach($plaetze as $id)
							{
								$pid = $id['Platz_ID'];
								$sql->change("UPDATE tb_platz SET Gesperrt = '1', GesperrtVon = '$von', GesperrtBis = ' $bis', Kommentar = '$grund' WHERE Platz_ID = '$pid'");
							}
						}
						else {
						
							$sql->change("UPDATE tb_platz SET Gesperrt = '1', GesperrtVon = '$von', GesperrtBis = ' $bis', Kommentar = '$grund' WHERE Platz_ID = '$pid'");
							
						}
						$daten["gesperrt"] = true;
						
						//Aufrufen der plaetze.php
						header('Location: plaetze.php');
					}
					
					
				}
			
			$daten["pid"] = $pid;
			
			if(isset($_POST["allessperren"]))
			{
				$template = $twig->loadTemplate('allessperren.twig');
			}
			else {
				//auf Template verweisen
				$template = $twig->loadTemplate('platzsperren.twig');
			}
		
		//sonst auf home.php
		}else{
			header('Location: home.php');
		}	
			
	//sonst auf anmeldeseite
	}else{

		$template = $twig->loadTemplate('anmelde.twig');
		
	}
	
	
	include "includedown.php";

?>