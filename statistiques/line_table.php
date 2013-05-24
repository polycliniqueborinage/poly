<?php

	// Demarre une session
	session_start();

	include_once '../lib/fonctions.php';
	
	$dicoStatistique = array('COUNT(ta.id)' => 'Pourcentage de tarifications', 'COUNT(td.id)' => 'Pourcentage de prestations','SUM(td.cout_mutuelle)' => 'Pourcentage sur le gain','SUM(td.cout_medecin)' => 'Pourcentage sur le gain du medecin','SUM(td.cout_poly)' => 'Pourcentage sur le gain de la polyclinique' );
	$dicoGroupe = array('groupe1' => 'par medecin', 'groupe2' => 'par patient','groupe3' => 'par specialite' );
		
	
	// groupe
	$groupe = isset($_SESSION['stat_groupe']) ? $_SESSION['stat_groupe'] : "groupe1";
	$groupe = isset($_GET['stat_groupe']) ? $_GET['stat_groupe'] : $groupe;

	switch($groupe) {
			
		case "groupe1" :
			$groupe1 = "concat(me.nom, ' ', me.prenom)";
			$groupe2 = "me.inami";
		break;
		case "groupe2" :
			$groupe1 = "concat(pa.nom, ' ', pa.prenom)";
			$groupe2 = "pa.id";
		break;
		case "groupe3" :
			$groupe1 = "sp.specialite";
			$groupe2 = "sp.id";
		break;
	}
	
	// statistique
	$statistique = isset($_SESSION['stat_statistique']) ? $_SESSION['stat_statistique'] : "COUNT(ta.id)";
	$statistique = isset($_GET['stat_statistique']) ? $_GET['stat_statistique'] : $statistique;
	
	// nombre de resultat
	$statistique_number = isset($_SESSION['stat_statistique_number']) ? $_SESSION['stat_statistique_number'] : 10;
	$statistique_number = isset($_GET['stat_statistique_number']) ? $_GET['stat_statistique_number'] : $statistique_number;
	
	$jour = date("d");
	$mois = date("m");
	$annee = date("Y");
	$dataCurrent = date("Y-m-d", mktime(0, 0, 0, $mois - 1, $jour, $annee));
	
	$dateMin = isset($_SESSION['stat_date_min']) ? $_SESSION['stat_date_min'] : $dataCurrent;
	$dateMin = isset($_GET['stat_date_min']) ? $_GET['stat_date_min'] : $dateMin;
	
	// date de fin
	$dateMax = isset($_SESSION['stat_date_max']) ? $_SESSION['stat_date_max'] : date("Y-m-d");
	$dateMax = isset($_GET['stat_date_max']) ? $_GET['stat_date_max'] : $dateMax;
	
	
	$datetools = new dateTools($dateMin,$dateMax);
	$labels = array();
	$labels = $datetools->distributDATE($statistique_number);
	$value = array();
	
	$temp = "";
	
	connexion_DB('poly');
	
	for($i = 0 ; $i < $statistique_number ; $i++) 	{
		
		$start = $labels[$i];
		$end = $labels[$i+1];
		$daystart = date ("Y-m-d", $start);
		$dayend = date ("Y-m-d", $end);
		
		$sqlglobal= "SELECT $statistique AS total
		FROM tarifications ta, tarifications_detail td, medecins me, patients pa, specialites sp
		WHERE ta.etat =  'close'
		AND ta.medecin_inami = me.inami
		AND ta.patient_id = pa.id
		AND td.tarification_id = ta.id
		AND sp.id = me.specialite
		AND ta.cloture >= '$daystart' and ta.cloture < '$dayend'";

		$result = requete_SQL ($sqlglobal);
		
		$data = mysql_fetch_assoc($result);
		
		$value[$i] = $data['total'];
		
	
		$temp .= $data['total']."<br/>";			
		
	}
	
	deconnexion_DB();
	
	echo $temp;
	
	
	echo "david";	
	

?>