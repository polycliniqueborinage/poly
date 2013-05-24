<?php

	// Demarre une session
	session_start();

	require_once "../../artichow/BarPlot.class.php";
	include_once '../../lib/fonctions.php';
	
	date_default_timezone_set('UTC');
	
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

	// compare
	$compare = isset($_SESSION['stat_compare']) ? $_SESSION['stat_compare'] : "-1";
	$compare = isset($_GET['stat_compare']) ? $_GET['stat_compare'] : $compare;
	
	// nombre de resultat
	$statistique_number = isset($_SESSION['stat_statistique_number']) ? $_SESSION['stat_statistique_number'] : 1;
	$statistique_number = isset($_GET['stat_statistique_number']) ? $_GET['stat_statistique_number'] : $statistique_number;
	
	$jour = date("d");
	$mois = date("m");
	$annee = date("Y");
	$dataCurrent = date("Y-m-d", mktime(0, 0, 0, $mois - 1, $jour, $annee));
	
	$dateMin1 = isset($_SESSION['stat_date_min']) ? $_SESSION['stat_date_min'] : $dataCurrent;
	$dateMin1 = isset($_GET['stat_date_min']) ? $_GET['stat_date_min'] : $dateMin1;
	
	// date de fin
	$dateMax1 = isset($_SESSION['stat_date_max']) ? $_SESSION['stat_date_max'] : date("Y-m-d");
	$dateMax1 = isset($_GET['stat_date_max']) ? $_GET['stat_date_max'] : $dateMax1;
	
	$datetools = new dateTools($dateMin1,$dateMax1);
	$labels = array();
	$labels = $datetools->compare($compare);
	
	$dateMin2 = date ("Y-m-d", $labels[0]);
	$dateMax2 = date ("Y-m-d", $labels[1]);
		
	// mise en session
	$_SESSION['stat_statistique'] = $statistique;
	$_SESSION['stat_statistique_number'] = $statistique_number;
	$_SESSION['stat_groupe'] = $groupe;
	$_SESSION['stat_date_min'] = $dateMin1;
	$_SESSION['stat_date_max'] = $dateMax1;
	$_SESSION['stat_compare'] = $compare;
	
	$datetools1 = new dateTools($dateMin1,$dateMax1);
	$datetools2 = new dateTools($dateMin2,$dateMax2);
	
	connexion_DB('poly');
	
	$sqlglobal1= "SELECT $groupe2 as id, $groupe1 AS label, $statistique AS total
	FROM tarifications ta, tarifications_detail td, medecins me, patients pa, specialites sp
	WHERE ta.etat =  'close'
	AND ta.medecin_inami = me.inami
	AND ta.patient_id = pa.id
	AND td.tarification_id = ta.id
	AND sp.id = me.specialite
	AND ta.cloture >= '$dateMin1' and ta.cloture <= '$dateMax1' 
	GROUP BY $groupe2
	order by total desc
	LIMIT $statistique_number";
	
	$values2 = array();
	$labels2 = array();
	
	$result1 = requete_SQL ($sqlglobal1);
	
	if(mysql_num_rows($result1)!=0) { 
		
		$id1 = array();
		$values1 = array();
		$labels1 = array();
		$i = 0;

		while($data = mysql_fetch_assoc($result1)) 	{
									
			$id= $data['id'] ;
			$values1[$i] = round($data['total'],2);
			$labels1[$i] = $data['label'];
			
			
			// compare
			$sqlglobal2= "SELECT $groupe1 AS label, $statistique AS total
			FROM tarifications ta, tarifications_detail td, medecins me, patients pa, specialites sp
			WHERE ta.etat =  'close'
			AND ta.medecin_inami = me.inami
			AND ta.patient_id = pa.id
			AND td.tarification_id = ta.id
			AND sp.id = me.specialite
			AND ta.cloture >= '$dateMin2' and ta.cloture <= '$dateMax2' 
			AND $groupe2 = $id 
			GROUP BY $groupe2 ";
			
			$result2 = requete_SQL ($sqlglobal2);
	
			if(mysql_num_rows($result2)!=0) {
				$data2 = mysql_fetch_assoc($result2);
				$values2[$i] = round($data2['total'],2);
				$labels2[$i] = $data2['label'];
			} else {
				$values2[$i] = 0;
				$labels2[$i] = 'none';
			}

			$i++;
			
		}
		
	} else {
		$values1 = array(0);
		$labels1 = array("none");
		$values2 = array(0);
		$labels2 = array("none");
	}
	 
	deconnexion_DB();
	
	$graph = new Graph(800, 400);
	//$graph->setAntiAliasing(TRUE);
	$graph->title->set($dicoStatistique[$statistique]." ".$dicoGroupe[$groupe]." ( ".$datetools1->get2DATES()." % ".$datetools2->get2DATES().")");
	//$graph->title->set($values2[0]);
	
	$group = new PlotGroup;
	$group->setPadding(NULL, NULL, 35, NULL);
	$group->setSpace(5, 5, NULL, NULL);

	$group->grid->hide(TRUE);
	
	$plot = new BarPlot($values1, 1, 1, 5);
	$plot->setBarColor(new LightBlue(25));
	$group->add($plot);

	
	$plot = new BarPlot($values2, 1, 1, 0);
	$plot->setBarColor(new LightRed(25));
	
	//$plot->setLegend($labels1);
	
	
	$group->add($plot);

	$graph->add($group);
	$graph->draw();


?>