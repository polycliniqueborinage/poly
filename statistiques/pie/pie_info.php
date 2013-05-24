<?php

	// Demarre une session
	session_start();

	include_once '../../lib/fonctions.php';
	
	$dicoStatistique = array('statistique1' => 'Pourcentage de consultations', 'statistique2' => 'Pourcentage de codes Inami','statistique3' => 'Pourcentage sur les rentr&eacute;es total','statistique4' => 'Pourcentage sur les rentr&eacute;es du m&eacute;decin','statistique5' => 'Pourcentage sur les rentr&eacute;es de la polyclinique sans ticket mod&eacute;rateur','statistique6' => 'Pourcentage sur les rentr&eacute;es de la polyclinique avec ticket mod&eacute;rateur', 'statistique7' => 'Pourcentage sur le remboursement des mutuelles', 'statistique8' => 'Pourcentage sur les rentr&eacute;es en caisse (hors remboursement mutuelle)' );
	$dicoGroupe = array('groupe1' => 'par m&eacute;decin', 'groupe2' => 'par patient','groupe3' => 'par specialit&eacute;','groupe4' => 'par code Inami','groupe5' => 'par assurabilit&eacute; (CT1-CT2)','groupe6' => 'par assurabilit&eacute; (Type)','groupe7' => 'par mutuelle','groupe8' => 'par age','groupe9' => 'par sexe' );
			
	// groupe
	$statGroupe = isset($_SESSION['stat_groupe']) ? $_SESSION['stat_groupe'] : "groupe1";
	$statGroupe = isset($_GET['stat_groupe']) ? $_GET['stat_groupe'] : $statGroupe;
	
	//echo "get".$_GET['stat_groupe']."<br/>";
	//echo "sess".$_SESSION['stat_groupe']."<br/>";
	//echo "$statGroupe".$statGroupe."<br/>";
	
	// statistique
	$statStatistique = isset($_SESSION['stat_statistique']) ? $_SESSION['stat_statistique'] : "statistique1";
	$statStatistique = isset($_GET['stat_statistique']) ? $_GET['stat_statistique'] : $statStatistique;

	//echo "get".$_GET['stat_statistique']."<br/>";
	//echo "sess".$_SESSION['stat_statistique']."<br/>";
	//echo "statStatistique".$statStatistique."<br/>";
	
	// nombre de resultat
	$statStatistiqueNumber = isset($_SESSION['stat_statistique_number']) ? $_SESSION['stat_statistique_number'] : 10;
	$statStatistiqueNumber = isset($_GET['stat_statistique_number']) ? $_GET['stat_statistique_number'] : $statStatistiqueNumber;
	
	//echo "get".$_GET['stat_statistique_number']."<br/>";
	//echo "sess".$_SESSION['stat_statistique_number']."<br/>";
	//echo "statStatistiqueNumber".$statStatistiqueNumber."<br/>";
	
	$jour = date("d");
	$mois = date("m");
	$annee = date("Y");
	$dataCurrent = date("Y-m-d", mktime(0, 0, 0, $mois - 1, $jour, $annee));
	
	$dateMin = isset($_SESSION['stat_date_min']) ? $_SESSION['stat_date_min'] : $dataCurrent;
	$dateMin = isset($_GET['stat_date_min']) ? $_GET['stat_date_min'] : $dateMin;
	
	// date de fin
	$dateMax = isset($_SESSION['stat_date_max']) ? $_SESSION['stat_date_max'] : date("Y-m-d");
	$dateMax = isset($_GET['stat_date_max']) ? $_GET['stat_date_max'] : $dateMax;
	
	// mise en session
	$_SESSION['stat_statistique'] = $statStatistique;
	$_SESSION['stat_statistique_number'] = $statStatistiqueNumber;
	$_SESSION['stat_groupe'] = $statGroupe;
	$_SESSION['stat_date_min'] = $dateMin;
	$_SESSION['stat_date_max'] = $dateMax;
	
	
	$datetools1 = new dateTools($dateMin,$dateMin);
	$datetools2 = new dateTools($dateMax,$dateMax);
	
	$title = $dicoStatistique[$statStatistique]." ".$dicoGroupe[$statGroupe]." ( ".$datetools1->transformDATE2()." au ".$datetools2->transformDATE2().") -  $statStatistiqueNumber r&eacute;sultat(s)";
	
	echo "<h1>$title</h1><br/><br/><br/>";
?>