<?php 

function texteSplit($texte){
	$curseur = 0;
	$res = "";
	for($i=0; $i<strlen($texte); $i++){
		$curseur++;
		$res = $res.$texte[$i];
		
		if($curseur == 100){
			$i++;
			while($texte[$i] != ' '){
				$res .= $texte[$i];
				$i++;
			}
			$res .= '\\n';
			$curseur = 0;
		}		
	}	
	return($res);
}

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
	
	//vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/fonctions.php';
	include_once '../lib/gestionErreurs.php';
	define('FPDF_FONTPATH','font/');
	require('../factures/fpdf_js.php');
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "imprimer_lettre.php";
	
	$formNbLettres = isset($_GET['nb']) ? $_GET['nb'] : '';
	
	$pdf = new FPDF('P', 'pt', 'A4');
	for($i = 0; $i < $formNbLettres; $i++){
		$id_patient = isset($_GET["patient".$i]) ? $_GET["patient".$i] : '';
		$id_motif   = isset($_GET["motif".$i])   ? $_GET["motif".$i]   : '';
		
		$requete_patient = "SELECT * FROM patients            WHERE id       = ".$id_patient;
		$requete_motif   = "SELECT * FROM medecine_preventive WHERE motif_ID = ".$id_motif;
		
		$res_patient = requete_SQL($requete_patient);
		$res_motif   = requete_SQL($requete_motif);
		
		$patient = mysql_fetch_assoc($res_patient);
		$motif   = mysql_fetch_assoc($res_motif);
	
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->Image('../images/entete_lettre.png', 0, 0, 595, 170);
		
		//espace
		$pdf->Cell(0, 100, '', '', 2);
		
		if($patient['sexe'] == 'M')
			$prefixe = 'Monsieur';
		else
			$prefixe = 'Madame';	
		$pdf->Cell(0,  50, '', '', 2);
		
		//descriptif du patient - alignement gauche
		$pdf->Cell(500, 10, $prefixe." ".$patient['prenom']." ".$patient['nom'], 'R', 2, 'R');
		$pdf->Cell(500, 10, $patient['rue'], 'R', 2, 'R');
		$pdf->Cell(500, 10, $patient['code_postal']." ".$patient['commune'], 'R', 2, 'R');
		
		//espace
		$pdf->Cell(0, 30, '', '', 2);
		
		
		$jour = date("d");
		$mois_chiffre = date("m");
		switch($mois_chiffre){
			case '01':
			$mois = "janvier";
			break;
			
			case '02':
			$mois = "f�vrier";
			break;
			
			case '03':
			$mois = "mars";
			break;
			
			case '04':
			$mois = "avril";
			break;
			
			case '05':
			$mois = "mai";
			break;
			
			case '06':
			$mois = "juin";
			break;
			
			case '07':
			$mois = "juillet";
			break;
			
			case '08':
			$mois = "ao�t";
			break;
			
			case '09':
			$mois = "septembre";
			break;
			
			case '10':
			$mois = "octobre";
			break;
			
			case '11':
			$mois = "novembre";
			break;
			
			case '12':
			$mois = "d�cembre";
			break;
		}
		
		$annee = date("Y");
		
		//date - alignement droite
		$dateDuJour = "Le ".$jour." ".$mois." ".$annee;
		$pdf->Cell(500, 70, $dateDuJour, '', 2, 'L');
		
		//texte principale de la lettre - alignement gauche
		$pdf->Cell(0, 30, '', '', 2);
		$pdf->Cell(0, 20, $prefixe." ".$patient['nom'].',', '', 2, 'L');
		$pdf->Cell(0, 40, '', '', 2);
		$pdf->MultiCell(500, 10, str_replace('&#039;', '\'', $motif['texte_principal']), '', 2, 'L');
		
		//signature - alignement gauche
		$pdf->Cell(0, 50, '', '', 2);
		$pdf->Cell(100, 10, $motif['signature'], '', 2, 'L');
		
	} 
	$pdf->output();

	deconnexion_DB();
	die();

?>

<html>
<body onload="this.close();">
</html>
