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

	// recupere le nombre d'etiquettes
	$nombreEtiquette = $_GET['nombreEtiquette'];

	// recupere la liste des medecins
	$medecinsList = $_GET['mutuellesList'];

	define('FPDF_FONTPATH','font/');

	require('../factures/fpdf_js.php');

class RPDF extends PDF_Javascript {
function AutoPrint($dialog=false)
{
    //Lance la bo�te d'impression ou imprime immediatement sur l'imprimante par d�faut
    $param=($dialog ? 'true' : 'false');
    $script="print($param);";
    $this->IncludeJS($script);
}
function TextWithDirection($x,$y,$txt,$direction='R')
{
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

function TextWithRotation($x,$y,$txt,$txt_angle,$font_angle=0)
{
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

	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	// Cr�ation du pdf
	$pdf=new RPDF();
	$pdf->Open();
	$pdf->SetFont('Arial','',15);
	$pdf->SetFontSize(16);
	
	$medecinsList = substr($medecinsList,1)."|";
	$tok = strtok($medecinsList,"||");

	// Pour chaque m�decin
	while ($tok !== false && $tok!='') {
		
		$sql = "select * from mutuelles where code='$tok'";

		$result = requete_SQL ($sql);

		if(mysql_num_rows($result)!=0) {

			$data = mysql_fetch_assoc($result);
			$code = $data['code'];
			$nom = $data['nom'];
			$rue = $data['rue'];
			$codePostal = $data['code_postal'];
			$ville = $data['commune'];
			$contact = $data['contact'];
			// autres valeurs
			$compteur = 0;
			
			// Pour autant d'�tiquette qu'il faut
			while ($compteur < $nombreEtiquette) {

				$compteur ++;
				$pdf->AddPage();
				$pdf->SetFontSize(16);
				$pdf->TextWithDirection(96,187,$code." ".$nom,'U');
				$pdf->SetFontSize(11);
				$pdf->TextWithDirection(101,187,$rue,'U');
				$pdf->TextWithDirection(106,187,$codePostal." ".$ville,'U');
				//$pdf->TextWithDirection(111,187,$specialite." ".$inami,'U');
			
			}
					
		} else {
		
		}

		$tok = strtok("||");
	}

	// Fonction de deconnexion � la base de donn�es
	deconnexion_DB();

	$pdf->AutoPrint(false);
	$pdf->Output();

?>