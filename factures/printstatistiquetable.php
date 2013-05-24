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
	
	include_once '../lib/fonctions.php';
	
	// get session
	$title1 = $_SESSION['statistique_title1'];
	$title2 = $_SESSION['statistique_title2'];
	$title3 = $_SESSION['statistique_title3'];
	$sqlglobal = $_SESSION['statistique_sqlglobal'];
	$sqlglobalResume = $_SESSION['statistique_sqlglobalResume']; 
	
	define('FPDF_FONTPATH','font/');

	require('fpdf_js.php');
	
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
	$pdf=new PDF_AutoPrint('p','mm','A4');

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

	//initialize counter
	$i = 9;
	
	// max
	$max = 40;
	
	//sum
	$sum = 0;
				
	//Add first page
	$pdf->AddPage();
		
	$y_axis = $y_axis_initial;
	$x_axis = $x_axis_initial;
			
	// Titre
	$pdf->SetFont('Arial','B',16);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	$pdf->Cell(18,10,$title1);
	$y_axis = $y_axis + 8;
	// Titre
	$pdf->SetFont('Arial','B',16);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	$pdf->Cell(18,10,$title2);
	$y_axis = $y_axis + 8;
	// Titre
	$pdf->SetFont('Arial','B',16);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	$pdf->Cell(18,10,$title3);
	$y_axis = $y_axis + 10;
	
	$pdf->SetFont('Arial','',12);
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	
	$pdf->Cell(20,6,'ID',1,0,'L',1);
	$pdf->Cell(60,6,'LABEL',1,0,'L',1);
	$pdf->Cell(30,6,'VALEUR',1,0,'L',1);
	$pdf->Cell(30,6,'%',1,0,'L',1);
	$pdf->Cell(30,6,'% cumul',1,0,'L',1);
	
	connexion_DB('poly');
	
	$result = requete_SQL ($sqlglobal);
	$resultResume = requete_SQL ($sqlglobalResume);
	$y = 1;
	
	//resume
	$data = mysql_fetch_assoc($resultResume);
	$sumFull = round($data['total'],2);
	
	while($data = mysql_fetch_assoc($result)) 	{
	
		if ($i == $max) {
			
			$pdf->AddPage();
			$y_axis = $y_axis_initial;
			$x_axis = $x_axis_initial;
			
			//initialize counter
			$i = 0;
			$pdf->SetY($y_axis);
			$pdf->SetX($x_axis);
	
			$pdf->SetFillColor(232,232,232);
			$pdf->Cell(20,6,'ID',1,0,'L',1);
			$pdf->Cell(60,6,'LABEL',1,0,'L',1);
			$pdf->Cell(30,6,'VALEUR',1,0,'L',1);
			$pdf->Cell(30,6,'%',1,0,'L',1);
			$pdf->Cell(30,6,'% cumul',1,0,'L',1);
			
		}
	
		$y_axis = $y_axis + $row_height;
		$pdf->SetY($y_axis);
		$pdf->SetX($x_axis);

		$sum = $sum + round($data['total'],2);
		
		$pdf->SetFillColor(256,256,256);
		$pdf->Cell(20,6,$y,1,0,'L',1);
		$pdf->Cell(60,6,$data['label'],1,0,'L',1);
		$pdf->Cell(30,6,round($data['total'],2),1,0,'L',1);
		$pdf->Cell(30,6,round((100*$data['total']/$sumFull),2),1,0,'L',1);
		$pdf->Cell(30,6,round((100*$sum/$sumFull),2),1,0,'L',1);
		
		
			
		$i ++;
		$y ++;
	
	}
	
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	
	$pdf->SetFillColor(256,256,256);
	$pdf->Cell(20,6,"",1,0,'L',1);
	$pdf->Cell(100,6,"Total",1,0,'L',1);
	$pdf->Cell(50,6,$sum." (".round((100*$sum/$sumFull),2)." %)",1,0,'L',1);
		
	$y_axis = $y_axis + $row_height;
	$pdf->SetY($y_axis);
	$pdf->SetX($x_axis);
	
	$pdf->SetFillColor(256,256,256);
	$pdf->Cell(20,6,"",1,0,'L',1);
	$pdf->Cell(100,6,"Grand total sans limitation",1,0,'L',1);
	$pdf->Cell(50,6,$sumFull."  (100 %)",1,0,'L',1);
	

	deconnexion_DB();
	
	$pdf->AutoPrint(true);

	$pdf->Output();
	
	
	
	
	/*
	
		
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
			
			echo "</tr>";
			
			$i++;
			
		}
		
		echo "<tr>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "<td>&nbsp;</td>";
		echo "</tr>";

		$data = mysql_fetch_assoc($resultResume);
		$sumFull = round($data['total'],2);
		
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
	
	
* 	*/
	
?>