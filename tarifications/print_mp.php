<?php 

	// Demarre une session
	session_start();
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	
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

	//DEBUT DELCARATION DES CLASSES
	require('../classes/class.mylog.php');
	require('../classes/class.fpdf.php');
	require('../classes/class.patient.php');
	require('../classes/class.prevention.php');
	//FIN DELCARATION DES CLASSES
	
	// recupere les valeurs en session patient
	$sessionPatientId = $_SESSION['mpPatientID'];  
	

	//include("./include/class.fpdf.php");
	$mylog 		= (object) new mylog();
	$pdf 		= (object) new pdfhtml('P', 'pt', 'A4');
	$prevention = (object) new prevention();
	$patient 	= (object) new patient();
	
	connexion_DB('poly');
	
	$motifs = $prevention->getMotifsAContacter($sessionPatientId);
	
	for($i=0; $i<count($motifs); $i++) {
		
		$preventioni = $prevention->getMotif($motifs[$i]["id_motif"]);
	
		$patienti = $patient->get($sessionPatientId);
		
		//echo $motifs[$i]["id_motif"];
		// change status
		$prevention->changeContactStatus($sessionPatientId,$motifs[$i]["id_motif"],"contacte");
	
		$pdf->AddPage();
	
		$pdf->SetFont('Arial', 'B', '10');
	
		$pdf->Image('../classes/entete_poly.png', 0, 0, 595, 170);
	
		//espace
		$pdf->Cell(0, 100, '', '', 2);
	
		if ($patienti["gender"] == 'M') $gender = "Monsieur";
		else 							$gender = "Madame";
	
		$pdf->Cell(0,  50, '', '', 2);
			
		//descriptif du patient - alignement gauche
		$pdf->Cell(500, 10, $gender." ".$patienti['familyname']." ".$patienti['firstname'], 'R', 2, 'R');
		$pdf->Cell(500, 10, $patienti['address1'], 'R', 2, 'R');
		$pdf->Cell(500, 10, $patienti['zip1']." ".$patienti['city1'], 'R', 2, 'R');
	
		//espace
		$pdf->Cell(0, 30, '', '', 2);
	
	
		// get date
		setlocale(LC_TIME, fr_FR);
		$today = ucfirst(strftime('%A, %d %B %Y',strtotime(date("m/d/Y"))));
		$pdf->Cell(500, 70, $today, '', 2, 'L');
	
		//texte principale de la lettre - alignement gauche
		$pdf->Cell(0, 30, '', '', 2);
		$pdf->Cell(0, 20, $gender." ".$patienti['familyname'].',', '', 2, 'L');
		$pdf->Cell(0, 40, '', '', 2);
	
		$mainText = $preventioni['main_text'];
	
		$pdf->WriteHTML($mainText);
	
	}
	ob_end_clean();
	$pdf->output();
?>