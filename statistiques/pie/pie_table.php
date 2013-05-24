<?php

	// Demarre une session
	session_start();

	include_once '../../lib/fonctions.php';
	
	//dico
	$dicoStatistique = array('statistique1' => 'Pourcentage de consultations', 'statistique2' => 'Pourcentage de codes Inami','statistique3' => 'Pourcentage sur les rentrees total','statistique4' => 'Pourcentage sur les rentrees du medecin','statistique5' => 'Pourcentage sur les rentrees de la polyclinique sans TM','statistique6' => 'Pourcentage sur les rentrees de la polyclinique avec TM', 'statistique7' => 'Pourcentage sur le remboursement des mutuelles', 'statistique8' => 'Pourcentage sur les rentrees en caisse (hors remboursement mutuelle)' );
	$dicoGroupe = array('groupe1' => 'par medecin', 'groupe2' => 'par patient','groupe3' => 'par specialite','groupe4' => 'par code Inami','groupe5' => 'par assurabilite (CT1-CT2)','groupe6' => 'par assurabilite (Type)','groupe7' => 'par mutuelle','groupe8' => 'par age' ,'groupe9' => 'par sexe'  );
	
	// groupe
	$statGroupe = isset($_SESSION['stat_groupe']) ? $_SESSION['stat_groupe'] : "groupe1";
	$statGroupe = isset($_GET['stat_groupe']) ? $_GET['stat_groupe'] : $statGroupe;
	
	switch($statGroupe) {
			
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
			$groupe1 = "concat(ta.age,' ans')";
			$groupe2 = "ta.age";
		break;
		case "groupe9" :
			$groupe1 = "ta.sex";
			$groupe2 = "ta.sex";
		break;
	}
	
	// statistique
	$statStatistique = isset($_SESSION['stat_statistique']) ? $_SESSION['stat_statistique'] : "statistique1";
	$statStatistique = isset($_GET['stat_statistique']) ? $_GET['stat_statistique'] : $statStatistique;
	
	switch($statStatistique) {
			
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
	$statStatistiqueNumber = isset($_SESSION['stat_statistique_number']) ? $_SESSION['stat_statistique_number'] : 10;
	$statStatistiqueNumber = isset($_GET['stat_statistique_number']) ? $_GET['stat_statistique_number'] : $statStatistiqueNumber;
	
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
	
	//test combi 
	if ($statGroupe=='groupe4' && $statStatistique=='statistique1') {
		echo "<h1>Combinaison impossible !</h1>";
	} else {
		
		$sum = 0;
	
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
		LIMIT $statStatistiqueNumber";
		
		//echo $sqlglobal;
		
		$sqlglobalResume= "SELECT $statistique1 AS total
		FROM tarifications ta, $statistique2 medecins me, patients pa, specialites sp
		WHERE ta.etat =  'close'
		AND ta.medecin_inami = me.inami
		AND ta.patient_id = pa.id
		$statistique3
		AND sp.id = me.specialite
		AND ta.cloture >= '$dateMin' and ta.cloture < '$dateMax'";
		
		//echo $sqlglobalResume;
		
		// mise en session
		$_SESSION['statistique_title1'] = $dicoStatistique[$statStatistique];
		$_SESSION['statistique_title2'] = $dicoGroupe[$statGroupe];
		$_SESSION['statistique_title3'] = "pour la periode du ".$datetools1->transformDATE2()." au ".$datetools2->transformDATE2();
		$_SESSION['statistique_sqlglobal'] = $sqlglobal; 
		$_SESSION['statistique_sqlglobalResume'] = $sqlglobalResume; 
		
		connexion_DB('poly');
	
		$result = requete_SQL ($sqlglobal);
		$resultResume = requete_SQL ($sqlglobalResume);
		$i = 1;
		
		$data = mysql_fetch_assoc($resultResume);
		$sumFull = round($data['total'],2);
		
		echo "<table border='0' cellpadding='2' cellspacing='1'>";
		
		while($data = mysql_fetch_assoc($result)) 	{
										
			echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";
								
			echo "<td valign='top' width='20px' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo $i;
			echo "</td>";
			
			echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo htmlentities($data['label']);
			echo "</td>";
	
			echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo round($data['total'],2);
			$sum = $sum + round($data['total'],2);
			echo "</td>";

			echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo round((100*$data['total']/$sumFull),2)." % (sur 100%)";
			echo "</td>";
			
			echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo round((100*$sum/$sumFull),2)." % (sur 100%)";
			echo "</td>";
			
			echo "</tr>";
			
			$i++;
			
		}
		
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td align='center'>Total</td>";
		echo "<td align='center'>".$sum." (".round((100*$sum/$sumFull),2)." %)</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td align='center' >Grand total sans limitation</td>";
		echo "<td align='center'>$sumFull  (100 %)</td>";
		echo "</tr>";

		echo "</table>";
	
	}
	
	deconnexion_DB();
	
?>