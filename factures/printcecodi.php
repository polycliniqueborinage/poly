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

	$mode = $_GET['mode'];
	
	if ($mode=='portrait') {
		// Set maximum rows per page
		$max = 42;
		// Format
		$type = 'p';
		//$patientSize = 130;
		//$acteSize = 0;
	} else {
		$max = 30;		
		$type = 'l';
		//$patientSize = 120;
		//$acteSize = 100;
	}
	
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	define('FPDF_FONTPATH','font/');
	require('fpdf_js.php');
	require('formmail.php');

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
	$x_axis_initial = 7;

	//Hauteur de la cellule
	$row_height=6;

	//Add first page
	$pdf->AddPage();
	
	//initialize counter
	$i = 4;

	$y_axis = $y_axis_initial;
	$x_axis = $x_axis_initial;
	
	// Titre
	$pdf->SetFont('Arial','B',16);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	$pdf->Cell(18,10,"Listing des codes INAMI");
	
	$y_axis = $y_axis + 18;
	
	//print column titles for the actual page
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);

	// print header
	$pdf->Cell(20,6,'INAMI',1,0,'L',1);
	$pdf->Cell(15,6,'Type',1,0,'L',1);
	$pdf->Cell(25,6,'Age',1,0,'L',1);
	if ($type == 'p') {
		$pdf->Cell(15,6,'kdb',1,0,'L',1);
		$pdf->Cell(15,6,'bc',1,0,'L',1);
		$pdf->Cell(15,6,'hona',1,0,'L',1);
		$pdf->Cell(15,6,'a_vip',1,0,'L',1);
		$pdf->Cell(15,6,'b_tp',1,0,'L',1);
		$pdf->Cell(15,6,'VIPO',1,0,'L',1);
		$pdf->Cell(15,6,'TIERS',1,0,'L',1);
		$pdf->Cell(15,6,'TRAV',1,0,'L',1);
	}	else {
		$pdf->Cell(150,6,'Description',1,0,'L',1);
		$pdf->Cell(15,6,'kdb',1,0,'L',1);
		$pdf->Cell(15,6,'bc',1,0,'L',1);
		$pdf->Cell(15,6,'hona',1,0,'L',1);
		$pdf->Cell(15,6,'a_vip',1,0,'L',1);
		$pdf->Cell(15,6,'b_tp',1,0,'L',1);
	}					

	$sqlglobal = "SELECT * from cecodis2 ORDER BY cecodi";

	$result = mysql_query($sqlglobal);

	while($data = mysql_fetch_assoc($result)) 	{
		
		if ($i == $max) {
		
			// saut de page
			$pdf->AddPage();
			$y_axis = $y_axis_initial;
			$x_axis = $x_axis_initial;
			//initialize counter
			$i = 0;
			$pdf->SetY($y_axis);
			$pdf->SetX($x_axis);

			$pdf->SetFillColor(232,232,232);
			$pdf->Cell(20,6,'INAMI',1,0,'L',1);
			$pdf->Cell(15,6,'Type',1,0,'L',1);
			$pdf->Cell(25,6,'Age',1,0,'L',1);
			if ($type == 'p') {
				$pdf->Cell(15,6,'kdb',1,0,'L',1);
				$pdf->Cell(15,6,'bc',1,0,'L',1);
				$pdf->Cell(15,6,'hona',1,0,'L',1);
				$pdf->Cell(15,6,'a_vip',1,0,'L',1);
				$pdf->Cell(15,6,'b_tp',1,0,'L',1);
				$pdf->Cell(15,6,'VIPO',1,0,'L',1);
				$pdf->Cell(15,6,'TIERS',1,0,'L',1);
				$pdf->Cell(15,6,'TRAV',1,0,'L',1);
			}	else {
				$pdf->Cell(150,6,'Description',1,0,'L',1);
				$pdf->Cell(15,6,'kdb',1,0,'L',1);
				$pdf->Cell(15,6,'bc',1,0,'L',1);
				$pdf->Cell(15,6,'hona',1,0,'L',1);
				$pdf->Cell(15,6,'a_vip',1,0,'L',1);
				$pdf->Cell(15,6,'b_tp',1,0,'L',1);
			}
		}
		
		$y_axis = $y_axis + $row_height;
		$pdf->SetY($y_axis);
		$pdf->SetX($x_axis);

	    $cecodi = $data['cecodi'];
	    $propriete = substr($data['propriete'],0,6);
	    $children = $data['children'];
	    $age = substr($data['age'], 1, (strlen($data['age'])-2));
		$tok = strtok($age,"||");
		$temp = "";
		$currentAge = "";
		$oldAge = "";
		while ($tok !== false) {
			$currentAge = $tok;
			if ($currentAge != ($oldAge+1)) {
				$temp .= "-".$oldAge.";".$currentAge;
			}
			$tok = strtok("||");
			$oldAge = $currentAge;
		}
		$temp.= "-".$currentAge.";"; 
		$temp =  substr($temp, 2);
		$age = $temp;
		$kdb = $data['kdb'];
	    $bc = $data['bc'];
	    $hono_travailleur  = $data['hono_travailleur'];
	    $a_vipo = $data['a_vipo'];
	    $b_tiers_payant = $data['b_tiers_payant'];
		$prix_vp = $data['prix_vp'];
		$prix_tp = $data['prix_tp'];
		$prix_tr = $data['prix_tr'];
		$description = $data['description'];
		
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(20,6,$cecodi,1,0,'L',1);
		$pdf->Cell(15,6,$propriete,1,0,'L',1);
		$pdf->Cell(25,6,$age,1,0,'L',1);
		if ($type == 'p') {
			$pdf->Cell(15,6,$kdb,1,0,'L',1);
			$pdf->Cell(15,6,$bc,1,0,'L',1);
			$pdf->Cell(15,6,$hono_travailleur,1,0,'L',1);
			$pdf->Cell(15,6,$a_vipo,1,0,'L',1);
			$pdf->Cell(15,6,$b_tiers_payant,1,0,'L',1);
			$pdf->Cell(15,6,$prix_vp,1,0,'L',1);
			$pdf->Cell(15,6,$prix_tp,1,0,'L',1);
			$pdf->Cell(15,6,$prix_tr,1,0,'L',1);
		}	else {
			$pdf->Cell(150,6,$description,1,0,'L',1);
			$pdf->Cell(15,6,$kdb,1,0,'L',1);
			$pdf->Cell(15,6,$bc,1,0,'L',1);
			$pdf->Cell(15,6,$hono_travailleur,1,0,'L',1);
			$pdf->Cell(15,6,$a_vipo,1,0,'L',1);
			$pdf->Cell(15,6,$b_tiers_payant,1,0,'L',1);
		}
		
	    $i = $i + 1;

	}

	$pdf->AutoPrint(true);

	//Create file
	$pdf->Output();
?>