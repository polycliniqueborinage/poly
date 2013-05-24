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
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/fonctions.php';
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	$dateCurrent = isset($_SESSION['dateCurrent']) ? $_SESSION['dateCurrent'] : "";
	$medecinCurrent = isset($_SESSION['medecinCurrent']) ? $_SESSION['medecinCurrent'] : "";
	
	$mode = $_GET['mode'];
	
	if ($mode=='portrait') {

		// Set maximum rows per page
		$max = 44;
		// Format
		$type = 'p';
		$patientSize = 130;
		$acteSize = 0;
		
	} else {

		$max = 32;		
		$type = 'l';
		$patientSize = 120;
		$acteSize = 100;
		
	}
	
	$dico = array('new' => 'N', 'std' => '', 'std urgt' => 'Urgt', 'std tent' => 'Dtx', 'new urgt' => 'New Urgt', 'new tent' => 'New Dtx');
	
	define('FPDF_FONTPATH','font/');

	require('fpdf_js.php');
	
	$tok = strtok($dateCurrent,"-");	
	$formDate_naissance_annee = $tok;
	$tok = strtok("-");
	$formDate_naissance_mois = $tok;
	$tok = strtok("-");
	$formDate_naissance_jour = $tok;
	$date = $formDate_naissance_jour.".".$formDate_naissance_mois.".".$formDate_naissance_annee;
	
class PDF_AutoPrint extends PDF_Javascript
{

	function AutoPrint($dialog=false)
	{
	    //Lance la bo�te d'impression ou imprime immediatement sur l'imprimante par d�faut
	    $param=($dialog ? 'true' : 'false');
	    $script="print($param);";
	    $this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
	    //Imprime sur une imprimante partag�e (requiert Acrobat 6 ou sup�rieur)
	    $script = "var pp = getPrintParams();";
	    if($dialog)
	        $script .= "pp.interactive = pp.constants.interactionLevel.full;";
	    else
	        $script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
	    $script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";	
	    $script .= "print(pp);";
	    $this->IncludeJS($script);
	}

}

	//Create new pdf file
	$pdf=new PDF_AutoPrint($type,'mm','A4');

	//Open file
	$pdf->Open();

	//Disable automatic page break
	$pdf->SetAutoPageBreak(false);

	//set initial y axis position per page
	$y_axis_initial = 15;

	//set initial x axis position per page
	$x_axis_initial = 15;

	//Hauteur de la cellule
	$row_height=6;

	if ($medecinCurrent!='all') {
		$sql = "SELECT * FROM medecins where agenda = 'checked' and inami='".$medecinCurrent."'";
	} else {
		$sql = "SELECT * FROM medecins where agenda = 'checked'";
	}
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)>0) {
	
		while($data = mysql_fetch_assoc($result)) {
			
			$medecinNomPrenom =  $data['nom']." ".$data['prenom'];
			$medecinTelephoneTravail =  $data['telephone_travail'];
			if ($medecinTelephoneTravail!='') $medecinTelephoneTravail.= " (travail) ";
			$medecinTelephoneMobile =  $data['telephone_mobile'];
			if ($medecinTelephoneMobile!='') $medecinTelephoneMobile.= " (gsm) ";
			$medecinTelephonePrive =  $data['telephone_prive'];
			if ($medecinTelephonePrive!='') $medecinTelephonePrive.= " (priv�) ";
			$medecinComment =  $data['comment'];
			$medecinInami =  $data['inami'];

			$sqlComment = "SELECT id, comment FROM `".$medecinInami."` where id = '".$dateCurrent."'";
			
			$sqlGlobalMorning = "select * FROM `".$medecinInami."` WHERE 
		date = '".$dateCurrent."' and midday like 'morning%' order by position asc, length"; 
			
			$sqlGlobalAfternoon = "select * FROM `".$medecinInami."` WHERE 
		date = '".$dateCurrent."' and midday like 'afternoon%' order by position asc, length";
			
			$resultComment = mysql_query($sqlComment);
			$resultGlobalMorning = mysql_query($sqlGlobalMorning);
			$resultGlobalAfternoon = mysql_query($sqlGlobalAfternoon);
			
			if((mysql_num_rows($resultGlobalMorning) + mysql_num_rows($resultGlobalAfternoon)) >0) {
		
				$dataComment = mysql_fetch_assoc($resultComment);
				
				//initialize counter
				$i = 9;
				
				//Add first page
				$pdf->AddPage();
		
				$y_axis = $y_axis_initial;
				$x_axis = $x_axis_initial;
			
				// Titre
				$pdf->SetFont('Arial','B',16);
				$pdf->SetY($y_axis);
				$pdf->SetX($x_axis);
				$pdf->Cell(18,10,"Planning pour ".$medecinNomPrenom." (".$date.")");
				$y_axis = $y_axis + 10;
	
				$pdf->SetFont('Arial','',12);
				$pdf->SetY($y_axis);
				$pdf->SetX($x_axis);
				$pdf->Cell(12,10,"T�l�phone m�decin : ".$medecinTelephoneTravail.$medecinTelephoneMobile.$medecinTelephonePrive);
				$y_axis = $y_axis + 5;

				$pdf->SetFont('Arial','',12);
				$pdf->SetY($y_axis);
				$pdf->SetX($x_axis);
				$pdf->Cell(12,10,"Commentaire : ".$medecinComment);
				$y_axis = $y_axis + 5;
				
				$pdf->SetY($y_axis);
				$pdf->SetX($x_axis);
				$pdf->Cell(12,10,"Commentaire sur le jour : ".$dataComment['comment']);
				$y_axis = $y_axis + 9;
				
				
				$pdf->SetFillColor(232,232,232);
				$pdf->SetY($y_axis);
				$pdf->SetX($x_axis);
	
				$pdf->Cell(14,6,'Debut',1,0,'L',1);
				$pdf->Cell(14,6,'Fin',1,0,'L',1);
				$pdf->Cell(8,6,'D.',1,0,'L',1);
				$pdf->Cell($patientSize,6,'Patient',1,0,'L',1);
				if ($acteSize!=0)
				$pdf->Cell($acteSize,6,'Acte',1,0,'L',1);
				$pdf->Cell(10,6,'New',1,0,'L',1);
				$pdf->Cell(10,6,'Qui',1,0,'L',1);
				
				// Morning
				while($data = mysql_fetch_assoc($resultGlobalMorning)) 	{
	
					if ($i == $max) {
			
						$pdf->AddPage();
						$y_axis = $y_axis_initial;
						$x_axis = $x_axis_initial;
						//initialize counter
						$i = 0;
						$pdf->SetY($y_axis);
						$pdf->SetX($x_axis);
	
						$pdf->SetFillColor(232,232,232);
						$pdf->Cell(14,6,'Debut',1,0,'L',1);
						$pdf->Cell(14,6,'Fin',1,0,'L',1);
						$pdf->Cell(8,6,'D.',1,0,'L',1);
						$pdf->Cell($patientSize,6,'Patient',1,0,'L',1);
						if ($acteSize!=0)
						$pdf->Cell($acteSize,6,'Acte',1,0,'L',1);
						$pdf->Cell(10,6,'New',1,0,'L',1);
						$pdf->Cell(10,6,'Qui',1,0,'L',1);
						
					}
	
					$y_axis = $y_axis + $row_height;
					$pdf->SetY($y_axis);
					$pdf->SetX($x_axis);
	
					$midday = $data['midday'];
					$start = $data['start'];	
					$end = $data['end'];
					$length = round(($data['length']/18)*5,0);
					$id = $data['patient_id'];
					$userComment = $data['user_comment'];
					$acteComment = $data['acte_comment'];
					$new = $data['new'];
					$caisse = substr($data['caisse'],0,3);
										
					$pdf->SetFillColor(256,256,256);
					$pdf->Cell(14,6,$start,1,0,'L',1);
					$pdf->Cell(14,6,$end,1,0,'L',1);
					$pdf->Cell(8,6,$length,1,0,'L',1);
					$pdf->Cell($patientSize,6,$userComment,1,0,'L',1);
					if ($acteSize!=0)
					$pdf->Cell($acteSize,6,$acteComment,1,0,'L',1);
					$pdf->Cell(10,6,$dico[$new],1,0,'L',1);
					$pdf->Cell(10,6,$caisse,1,0,'L',1);
					
				    $i = $i + 1;
	
				}
				
				
				// afternoon
				while($data = mysql_fetch_assoc($resultGlobalAfternoon)) 	{
	
					if ($i == $max) {
			
						$pdf->AddPage();
						$y_axis = $y_axis_initial;
						$x_axis = $x_axis_initial;
						//initialize counter
						$i = 0;
						$pdf->SetY($y_axis);
						$pdf->SetX($x_axis);
	
						$pdf->SetFillColor(232,232,232);
						$pdf->Cell(14,6,'Debut',1,0,'L',1);
						$pdf->Cell(14,6,'Fin',1,0,'L',1);
						$pdf->Cell(8,6,'D.',1,0,'L',1);
						$pdf->Cell($patientSize,6,'Patient',1,0,'L',1);
						if ($acteSize!=0)
						$pdf->Cell($acteSize,6,'Acte',1,0,'L',1);
						$pdf->Cell(10,6,'New',1,0,'L',1);
						$pdf->Cell(10,6,'Qui',1,0,'L',1);
						
					}
	
					$y_axis = $y_axis + $row_height;
					$pdf->SetY($y_axis);
					$pdf->SetX($x_axis);
	
					// pour chaque medecin
					$midday = $data['midday'];
					$start = $data['start'];	
					$end = $data['end'];
					$length = round(($data['length']/18)*5,0);
					$id = $data['patient_id'];
					$patientComment = $data['user_comment'];
					$acteComment = $data['acte_comment'];
					$new = $data['new'];
					$caisse = substr($data['caisse'],0,3);
					
					$pdf->SetFillColor(256,256,256);
					$pdf->Cell(14,6,$start,1,0,'L',1);
					$pdf->Cell(14,6,$end,1,0,'L',1);
					$pdf->Cell(8,6,$length,1,0,'L',1);
					$pdf->Cell($patientSize,6,$patientComment,1,0,'L',1);
					if ($acteSize!=0)
					$pdf->Cell($acteSize,6,$acteComment,1,0,'L',1);
					$pdf->Cell(10,6,$dico[$new],1,0,'L',1);
					$pdf->Cell(10,6,$caisse,1,0,'L',1);
					$i = $i + 1;
	
				}
				
			}
			
		}
		
		$pdf->AutoPrint(true);

		//Create file
		$pdf->Output();
	
	}	

?>