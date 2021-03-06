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

	// recupere le nombre d'etiquettes
	$nombre = $_GET['nombre'];
	
	// recupere les valeurs en session patient
	$sessionPatientNom = isset($_SESSION['impression_patient_last_name']) ? $_SESSION['impression_patient_last_name'] : '';  
	$sessionPatientPrenom = isset($_SESSION['impression_patient_first_prenom']) ? $_SESSION['impression_patient_first_prenom'] : '';  
	$sessionPatientAdresse = isset($_SESSION['impression_patient_addresse']) ? $_SESSION['impression_patient_addresse'] : '';  
	$sessionDateNaissance = isset($_SESSION['impression_patient_birthday']) ? $_SESSION['impression_patient_birthday'] : ''; 
	$tok = strtok($sessionDateNaissance,"-");
	$sessionDateAnnee = $tok;
	$tok = strtok("-");
	$sessionDateMois = $tok;
	$tok = strtok("-");
	$sessionDateJour = $tok;
	$sessionDateNaissance = $sessionDateJour.$sessionDateMois.$sessionDateAnnee; 
	$sessionSIS = isset($_SESSION['impression_patient_sis']) ? $_SESSION['impression_patient_sis'] : '';  
	$sessionMutuelleCode = isset($_SESSION['impression_tarification_mutuelle_code']) ? $_SESSION['impression_tarification_mutuelle_code'] : '';  
	$sessionMutuelleMatricule = isset($_SESSION['impression_tarification_patient_mutuelle_matricule']) ? $_SESSION['impression_tarification_patient_mutuelle_matricule'] : '';  
	$sessionCT1 = isset($_SESSION['impression_tarification_ct1']) ? $_SESSION['impression_tarification_ct1'] : '';  
	$sessionCT2 = isset($_SESSION['impression_tarification_ct2']) ? $_SESSION['impression_tarification_ct2'] : '';  
	$sessionType = isset($_SESSION['impression_tarification_patient_type']) ? $_SESSION['impression_tarification_patient_type'] : '';
	if($sessionType=="vp") $sessionType="!!".$sessionType.'!!';
	$sessionTiersPayant = isset($_SESSION['impression_tarification_patient_tiers_payant']) ? $_SESSION['impression_tarification_patient_tiers_payant'] : '';  
	$sessionSex = isset($_SESSION['impression_tarification_patient_sex']) ? $_SESSION['impression_tarification_patient_sex'] : '';  
	$sessionAge = isset($_SESSION['impression_tarification_patient_age']) ? $_SESSION['impression_tarification_patient_age'] : '';  
	
	// recupere les valeurs en session medecin
	$sessionMedecinNom = isset($_SESSION['impression_medecin_last_name']) ? $_SESSION['impression_medecin_last_name'] : '';  
	$sessionMedecinPrenom = isset($_SESSION['impression_medecin_first_prenom']) ? $_SESSION['impression_medecin_first_prenom'] : '';  
	$sessionInami = isset($_SESSION['impression_medecin_inami']) ? $_SESSION['impression_medecin_inami'] : '';  
	
	define('FPDF_FONTPATH','font/');

	require('../factures/fpdf_js.php');


	class RPDF extends PDF_Javascript {
	function AutoPrint($dialog=false)	{
	    //Lance la bo�te d'impression ou imprime immediatement sur l'imprimante par d�faut
	    $param=($dialog ? 'true' : 'false');
	    $script="print($param);";
	    $this->IncludeJS($script);
	}
	function TextWithDirection($x,$y,$txt,$direction='R'){
	    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
	    if ($direction=='R')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='L')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='U')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    elseif ($direction=='D')
	        $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$txt);
	    else
	        $s=sprintf('BT %.2f %.2f Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$txt);
	    if ($this->ColorFlag)
	        $s='q '.$this->TextColor.' '.$s.' Q';
	    $this->_out($s);
	}

	function TextWithRotation($x,$y,$txt,$txt_angle,$font_angle=0){
	    $txt=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
	
	    $font_angle+=90+$txt_angle;
	    $txt_angle*=M_PI/180;
	    $font_angle*=M_PI/180;
	
	    $txt_dx=cos($txt_angle);
	    $txt_dy=sin($txt_angle);
	    $font_dx=cos($font_angle);
	    $font_dy=sin($font_angle);

	    $s=sprintf('BT %.2f %.2f %.2f %.2f %.2f %.2f Tm (%s) Tj ET',
             $txt_dx,$txt_dy,$font_dx,$font_dy,
             $x*$this->k,($this->h-$y)*$this->k,$txt);
	    if ($this->ColorFlag)
	        $s='q '.$this->TextColor.' '.$s.' Q';
	    $this->_out($s);
	}
	}



	$compteur = 0;

	$pdf=new RPDF();

	$pdf->Open();

	$pdf->SetFont('Arial','',15);
	$pdf->SetFontSize(16);

	while ($compteur < $nombre) {
	
		$compteur ++;
		$pdf->AddPage();
		$pdf->TextWithDirection(96,187,$sessionPatientNom." ".$sessionPatientPrenom." - ".strtoupper($sessionType)." ",'U');
		$pdf->SetFontSize(11);
		$pdf->TextWithDirection(101,187,$sessionDateNaissance."   ".$sessionCT1." ".$sessionCT2."   ".$sessionSex." ".$sessionAge,'U');
		$pdf->TextWithDirection(106,187,$sessionMutuelleMatricule." - MUT : ".$sessionMutuelleCode,'U');
		$pdf->SetFontSize(8);
		$pdf->TextWithDirection(110,187,substr($sessionPatientAdresse,0,40),'U');
		$pdf->SetFontSize(16);
		$pdf->TextWithDirection(116,187,$sessionInami." ".$sessionMedecinNom." ".substr($sessionMedecinPrenom,0,1),'U');
		
	}
	
	$pdf->AutoPrint(false);
	$pdf->Output();

?>
