<?php 

	// Demarre une session
	session_start();

	// Validation du Login
	// SECURISE
	if(isset($_SESSION['application'])) {
		if ($_SESSION['application']=="|poly|") {
			// login ok
		}else {
			// redirection
			header('Location: ../../login/index.php');
			die();
		}
	} else {
		// redirection
		header('Location: ../../login/index.php');
		die();
	}
	// SECURITE
	
	// Inclus le fichier contenant les fonctions personalisÈes
	include_once '../lib/fonctions.php';

	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	$dico = array('tp' => 'Tiers payant', 'tr' => 'Travailleur', 'vp' => 'Vipo', 'child0' => 'Adulte', 'child1' => 'Enfant', 'tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	// Fonction de connexion ‡ la base de donnÈes
	connexion_DB('poly');
	
	$patient = isset($_GET['patient']) ? $_GET['patient'] : '';
	$patient = strtolower($test->convert($patient));
	
	$medecin = isset($_GET['medecin']) ? $_GET['medecin'] : '';
	$medecin = strtolower($test->convert($medecin));
	
	$start_date = $_GET['start_date'];
	$tok = strtok($start_date,"/");
	$start_date_day = $tok;
	$tok = strtok("/");
	$start_date_month = $tok;
	$tok = strtok("/");
	$start_date_year = $tok;
	
	$end_date = $_GET['end_date'];
	$tok = strtok($end_date,"/");
	$end_date_day = $tok;
	$tok = strtok("/");
	$end_date_month = $tok;
	$tok = strtok("/");
	$end_date_year = $tok;
	
	$etat = stripslashes($_GET['etat']);
	
	$tarification = $_GET['tarification'];
	
	$prestation = $_GET['prestation'];

	$limit = 15;
	
	
	if ($prestation!='') {
		
		$sql = "SELECT p.nom as patient_nom, p.prenom as patient_prenom, p.niss as patient_niss, DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date, m.nom as medecin_nom, m.prenom as medecin_prenom, m.inami as medecin_inami, t.id as tarification_id, DATE_FORMAT(t.cloture, GET_FORMAT(DATE, 'EUR')) as tarification_cloture, DATE_FORMAT(t.date, GET_FORMAT(DATE, 'EUR')) as tarification_date, t.caisse as tarification_caisse, t.paye as tarification_paye, t.a_payer as tarification_a_payer, t.mutuelle_code tarification_mutuelle_code, t.type as tarification_type, t.etat as tarification_etat, t.children as tarification_children, t.utilisation as tarification_utilisation FROM tarifications t, patients p, medecins m, tarifications_detail td 
		WHERE (m.inami = t.medecin_inami) AND (t.patient_id = p.id) AND (td.tarification_id = t.id)
		AND td.id = '$prestation' AND t.etat='close'";
		
	} else {
		
		$sql = "SELECT p.nom as patient_nom, p.prenom as patient_prenom, p.niss as patient_niss, DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date, m.nom as medecin_nom, m.prenom as medecin_prenom, m.inami as medecin_inami, t.id as tarification_id, DATE_FORMAT(t.cloture, GET_FORMAT(DATE, 'EUR')) as tarification_cloture, DATE_FORMAT(t.date, GET_FORMAT(DATE, 'EUR')) as tarification_date, t.caisse as tarification_caisse, t.paye as tarification_paye, t.a_payer as tarification_a_payer, t.mutuelle_code tarification_mutuelle_code, t.type as tarification_type, t.etat as tarification_etat, t.children as tarification_children, t.utilisation as tarification_utilisation FROM tarifications t, patients p, medecins m 
		WHERE (m.inami = t.medecin_inami) AND (t.patient_id = p.id)  AND t.etat='close'";
		
		if ($tarification!='') {

			$sql .= " AND t.id = '$tarification'";
		
		} else {
			$sql .= " ".$etat;
			if ($patient != '') $sql .= " AND (lower(concat(p.nom, ' ' ,p.prenom)) regexp '$patient' OR lower(concat(p.prenom, ' ' ,p.nom)) regexp '$patient')";
			if ($medecin != '') $sql .= " AND (lower(concat(m.nom, ' ' ,m.prenom)) regexp '$medecin' OR lower(concat(m.nom, ' ' ,m.prenom)) regexp '$medecin')";
			if (checkdate($start_date_month,$start_date_day,$start_date_year)) $sql .= " AND  t.date >='$start_date_year-$start_date_month-$start_date_day'";
			if (checkdate($end_date_month,$end_date_day,$end_date_year)) $sql .= " AND  t.date <='$end_date_year-$end_date_month-$end_date_day'";
		}
	}
	
	$sql .= " order by t.date desc limit ".$limit;
	
	// VERIFICATION
	$result = requete_SQL ($sql);
	
	if(mysql_num_rows($result)>0) {
	
		echo "<table border='0' cellpadding='2' cellspacing='1'>";
		
		echo "<th>";
		echo "Etat";
		echo "</th>";
		
		echo "<th>";
		echo "Action";
		echo "</th>";
		
		echo "<th>";
		echo "ID";
		echo "</th>";
		echo "<th>";
		echo "Utilisation";
		echo "</th>";
		echo "<th>";
		echo "Date de tarification";
		echo "</th>";
		echo "<th>";
		echo "Patient";
		echo "</th>";
		echo "<th>";
		echo "Type";
		echo "</th>";
		echo "<th>";
		echo "M&eacute;decin";
		echo "</th>";
		echo "<th>";
		echo "Solde &agrave; payer";
		echo "</th>";
		echo "<th>";
		echo "Cloture";
		echo "</th>";
		
		while($data = mysql_fetch_assoc($result)) 	{
		
			// on affiche les informations de l'enregistrement en cours
			$id = $data['tarification_id'];
			$etat =  $data['tarification_etat'];
			$cloture = $data['tarification_cloture'];
			$solde =  $data['tarification_a_payer'] - $data['tarification_paye'];
			$type = $data['tarification_type'];
			
			$info = "";
			$style = "";
			$urlModif = "";
			
			switch($etat) {
				case 'close':
					if ($solde>0) {
						// cloture pas payé						
						$info ='Clotur&eacute; mais non pay&eacute;';
						$style ='../images/tarif_close.gif';
						$etat = 'close';
					} else {
						if ($solde==0) {
							// cloture et payé						
							$info ='Clotur&eacute; et pay&eacute;';
							$style='../images/tarif_close_paye.gif';
							$etat = 'closepaye';
						} else {
							// cloture et erreur patientp
							$info='Clotur&eacute; avec une erreur du patient';
							$style='../images/tarif_close_paye.gif';
							$etat = 'closeerrpatient';
						}
					}
				break;
				case 'start':
					$info='Aucunes prestations encod&eacute;es';
					$style='../images/tarif_start.gif';
				break;
				default:
					$info='Tarification en attente';
					$style='../images/tarif_wait.gif';
			}

			switch($utilisation) {
				case 'tarification':
					$urlModif='../tarifications/modif_tarification.php?id=';
				break;
				case 'prothese':
					$urlModif='../protheses/modif_prothese.php?id=';
				break;
				default:
					$urlModif='../tarifications/modif_retarification.php?id=';
			}
			
			echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";

			// boule
			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			echo "<img width='16' height='16' src='$style' alt='$info' title='$info' border='0' /></a>";
			echo "</td>";
			
			// information
			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5' onMouseDown='openTarificationInfo($id)'>";
			echo "<a href='#'><img width='16' height='16' src='../images/icon_clipboard.gif' alt='Information' title='Information' border='0' /></a>";
			echo "</td>";
			
			
		
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>$id</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".ucfirst($data['tarification_utilisation'])."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".$data['tarification_date']."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".htmlentities(stripcslashes($data['patient_nom']),ENT_QUOTES)." ".htmlentities(stripcslashes($data['patient_prenom']),ENT_QUOTES)."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>$dico[$type]</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".htmlentities(stripcslashes($data['medecin_nom']),ENT_QUOTES)." ".htmlentities(stripcslashes($data['medecin_prenom']),ENT_QUOTES)."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".$solde."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap' onclick='javascript:tarificationRechercheCompleteList($id,\"$utilisation\")'>".$cloture."</td>";
			
			echo "</tr>";

		}
	
		echo "</table>";

	}
	
	if(mysql_num_rows($result)==1) {
		
		$sql = "SELECT id, tarification_id, cecodi, propriete, description, kdb, bc, hono_travailleur, a_vipo, b_tiers_payant, cout, cout_poly, cout_medecin, cout_mutuelle, caisse FROM tarifications_detail WHERE ( tarification_id = $id) order by 1";
			
		$result = requete_SQL ($sql);

		if(mysql_num_rows($result)!=0) {
			
			echo "<table border='0' cellpadding='2' cellspacing='1'>";
				
			if ($_SESSION['role'] == 'Administrateur') {
					echo "<th colspan='2' align='center'>";
					echo "ID";
					echo "</th>";
			} else {
					echo "<th colspan='1' align='center'>";
					echo "ID";
					echo "</th>";
			}
			echo "<th>";
			echo "Cecodi";
			echo "</th>";
			echo "<th>";
			echo "kdb";
			echo "</th>";
			echo "<th>";
			echo "bc";
			echo "</th>";
			echo "<th>";
			echo "hono";
			echo "</th>";
			echo "<th>";
			echo "tp";
			echo "</th>";
			echo "<th>";
			echo "vipo";
			echo "</th>";
			echo "<th>";
			echo "cout";
			echo "</th>";
			echo "<th>";
			echo "caisse";
			echo "</th>";
			echo "<th alt='Remboursement de la mutuelle'>";
			echo "Rem. Mut.";
			echo "</th>";
			echo "<th>";
			echo "Medecin";
			echo "</th>";
			echo "<th>";
			echo "Poly";
			echo "</th>";
			
			while($data = mysql_fetch_assoc($result)) 	{
			
				$id = $data['id'];
				
				echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";
					
				if ($_SESSION['role'] == 'Administrateur') {

					echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
					echo "<a href='#' onClick='";
					echo "openDialogConfirmDelPrestation(\"$utilisation\",$id)";
					echo ";return false;'>";
					echo "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
					echo "</td>";
	
				}

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['id'];
				echo "</td>";
			
				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['cecodi'];
				echo "</td>";
				
				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['kdb'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['bc'];
				echo "</td>";
	
				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['hono_travailleur'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['b_tiers_payant'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['a_vipo'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['cout'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['caisse'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo round ($data['cout_mutuelle'] - $data['cout'],2);
				echo "</td>";
					
				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['cout_medecin'];
				echo "</td>";

				echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				echo $data['cout_poly'];
				echo "</td>";
					
			}

		echo "</table>";

		}
	}

	deconnexion_DB();

?>