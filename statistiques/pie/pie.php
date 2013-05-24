<?php

	// Demarre une session
	session_start();

	require_once "../../artichow/Pie.class.php";
	include_once '../../lib/fonctions.php';
	
	date_default_timezone_set('UTC');
	
	// val inside legent
	$maxLegendSize = 20;
	
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
		case "groupe4" :
			$groupe1 = "td.cecodi";
			$groupe2 = "td.cecodi";
		break;
		case "groupe5" :
			$groupe1 = "concat(pa.ct1, '-', pa.ct2)";
			$groupe2 = "concat(pa.ct1, '-', pa.ct2)";
		break;
		case "groupe6" :
			$groupe1 = "ta.type";
			$groupe2 = "ta.type";
		break;
		case "groupe7" :
			$groupe1 = "ta.mutuelle_code";
			$groupe2 = "ta.mutuelle_code";
		break;
		case "groupe8" :
			$groupe1 = "ta.age";
			$groupe2 = "ta.age";
		break;
		case "groupe9" :
			$groupe1 = "ta.sex";
			$groupe2 = "ta.sex";
		break;
	}
	
	// statistique
	$statistique = isset($_SESSION['stat_statistique']) ? $_SESSION['stat_statistique'] : "statistique1";
	$statistique = isset($_GET['stat_statistique']) ? $_GET['stat_statistique'] : $statistique;
	
	switch($statistique) {
			
		case "statistique1" :
			$statistique1 = "COUNT(ta.id)";
			$statistique2 = "";
			$statistique3 = ""; 
		break;
		case "statistique2" :
			$statistique1 = "COUNT(td.id)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique3" :
			$statistique1 = "SUM(td.cout_mutuelle)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique4" :
			$statistique1 = "SUM(td.cout_medecin)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique5" :
			$statistique1 = "SUM(td.cout_poly)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique6" :
			$statistique1 = "SUM(td.cout_mutuelle-td.cout_medecin)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique7" :
			$statistique1 = "SUM(td.cout_mutuelle-td.cout)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
		case "statistique8" :
			$statistique1 = "SUM(td.caisse)";
			$statistique2 = "tarifications_detail td,";
			$statistique3 = "AND td.tarification_id = ta.id"; 
		break;
	}
		
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
	
	$datetools1 = new dateTools($dateMin,$dateMin);
	$datetools2 = new dateTools($dateMax,$dateMax);
	
	$dateMin = $datetools1->changeDATE(+0);
	$dateMax = $datetools2->changeDATE(+1);
	
	if ($groupe=='groupe4' && $statistique=='statistique1') {

		$graph = new Graph(800, 500);
		$graph->setAntiAliasing(TRUE);
	
		$graph->title->set("Combinaison impossible !");

		$graph->draw();

	} else {
		
		$sqlglobal= "SELECT $groupe1 AS label, $statistique1 AS total
		FROM tarifications ta, $statistique2 medecins me, patients pa, specialites sp
		WHERE ta.etat =  'close'
		AND ta.medecin_inami = me.inami
		AND ta.patient_id = pa.id
		$statistique3
		AND sp.id = me.specialite
		AND ta.cloture >= '$dateMin' and ta.cloture < '$dateMax' 
		GROUP BY $groupe2
		order by total desc
		LIMIT $statistique_number";
		
		connexion_DB('poly');
		
		$result = requete_SQL ($sqlglobal);
		$nbr = mysql_num_rows($result);
		
		$values = array();
		$labels = array();
		$i = 0;
		
		while($data = mysql_fetch_assoc($result)) 	{
			$values[$i] = $data['total'];
			$labels[$i] = $data['label'];
			$i++;
		}
	
		deconnexion_DB();
		
		$graph = new Graph(800, 500);
		$graph->setAntiAliasing(TRUE);
		
		//$graph->title->set($dicoStatistique[$statistique]." ".$dicoGroupe[$groupe]." ( ".$datetools1->transformDATE2()." au ".$datetools2->transformDATE2().")");
		//$graph->title->set($_SESSION['stat_statistique_number']);

		$plot = new Pie($values, PIE_EARTH);
		$plot->setCenter(0.4, 0.55);
		$plot->setSize(0.7, 0.6);
		$plot->set3D(20);
		
		$plot->setLegend($labels);
	
		$plot->legend->setPosition(1.35);
	
		$graph->add($plot);
		$graph->draw();
		
	}
	
	
	
	

?>