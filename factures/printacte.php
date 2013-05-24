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
			
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	define('FPDF_FONTPATH','font/');
	require('fpdf_js.php');
	require('formmail.php');

	class PDF_AutoPrint extends PDF_Javascript
	{
		function AutoPrint($dialog=false)
		{
    	//Lance la boîte d'impression ou imprime immediatement sur l'imprimante par défaut
    	$param=($dialog ? 'true' : 'false');
    	$script="print($param);";
    	$this->IncludeJS($script);
		}

		function AutoPrintToPrinter($server, $printer, $dialog=false)
		{
   		//Imprime sur une imprimante partagée (requiert Acrobat 6 ou supérieur)
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
	$pdf=new PDF_AutoPrint('P','mm','A4');

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

	//Set maximum rows per page
	$max = 42;

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
	$pdf->Cell(18,10,"Listing des actes internes");
	
	$y_axis = $y_axis + 18;
	
	//print column titles for the actual page
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','',12);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);

	// print header								
	$pdf->Cell(20,6,'Code',1,0,'L',1);
	$pdf->Cell(80,6,'Description',1,0,'L',1);
	$pdf->Cell(11,6,'TR',1,0,'L',1);
	$pdf->Cell(11,6,'TP',1,0,'L',1);
	$pdf->Cell(11,6,'VP',1,0,'L',1);
	$pdf->Cell(20,6,'Duree',1,0,'L',1);
	$pdf->Cell(20,6,'',1,0,'L',1);
	$pdf->Cell(20,6,'',1,0,'L',1);
	
	$sqlglobal = "SELECT * from actes ORDER BY description";

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
			$pdf->Cell(20,6,'Code',1,0,'L',1);
			$pdf->Cell(80,6,'Description',1,0,'L',1);
			$pdf->Cell(11,6,'TR',1,0,'L',1);
			$pdf->Cell(11,6,'TP',1,0,'L',1);
			$pdf->Cell(11,6,'VP',1,0,'L',1);
			$pdf->Cell(20,6,'Duree',1,0,'L',1);
			$pdf->Cell(20,6,'',1,0,'L',1);
			$pdf->Cell(20,6,'',1,0,'L',1);
			
		}
		
		$y_axis = $y_axis + $row_height;
		$pdf->SetY($y_axis);
		$pdf->SetX($x_axis);

	    $code  = $data['code'];
	    $description  = $data['description'];
	    $cout_tr = $data['cout_tr'];
	    $cout_tp = $data['cout_tp'];
	    $cout_vp = $data['cout_vp'];
	    $length = $data['length'];
	    
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(20,6,$code,1,0,'L',1);
		$pdf->Cell(80,6,$description,1,0,'L',1);
		$pdf->Cell(11,6,$cout_tr,1,0,'L',1);
		$pdf->Cell(11,6,$cout_tp,1,0,'L',1);
		$pdf->Cell(11,6,$cout_vp,1,0,'L',1);
		$pdf->Cell(20,6,$length,1,0,'L',1);
		$pdf->Cell(20,6,'',1,0,'L',1);
		$pdf->Cell(20,6,'',1,0,'L',1);
		
	    $i = $i + 1;

	}

	$pdf->AutoPrint(true);

	//Create file
	$pdf->Output();
?>