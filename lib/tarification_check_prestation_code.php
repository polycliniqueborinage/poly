<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
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

	// Fonction de connexion a la base de donnees
	connexion_DB('poly');
	
	$cecodi = "";
    $description = "";
    $class  = "cecodi";
    
	$sessTarificationID = $_SESSION['tarification_id'];
	$sessTarificationPatientType = $_SESSION['tarification_type'];
	$sessTarificationPatientChildren = $_SESSION['tarification_children'];
	$sessTarificationPatientSexe = $_SESSION['tarification_sex'];
	$sessTarificationPatientAge = $_SESSION['tarification_age'];
	$sessMedecinTauxConsul = $_SESSION['taux_consultation'];
	$sessMedecinTauxActe = $_SESSION['taux_acte'];

	$formCecodi = isset($_GET['cecodi_input']) ? $_GET['cecodi_input'] : '';

	$sql = "SELECT * FROM cecodis2 WHERE ( cecodi like '$formCecodi%') AND ( age like '%|$sessTarificationPatientAge|%' ) order by cecodi, id Desc limit 5";
		
	// VERIFICATION
	$result = requete_SQL ($sql);
	
	if(mysql_num_rows($result)==1) {
			
		$data = mysql_fetch_assoc($result);
		
		// variables from DB
		$dataCecodi = $data['cecodi'];
		$dataPropriete = $data['propriete'];
		$dataDescription = $data['description'];
		$dataKdb = $data['kdb'];
		$dataBc = $data['bc'];
		$dataHono = $data['hono_travailleur'];
		$dataA= $data['a_vipo'];
		$dataB = $data['b_tiers_payant'];
		$dataPrixVP = $data['prix_vp'];
		$dataPrixTP = $data['prix_tp'];
		$dataPrixTR = $data['prix_tr'];
		$dataCondition = $data['cond'];
		$dataTpfortr = $data['tpfortr'];
		
		$cecodi .= $dataCecodi;
		
		$content .= "Propri&eacute;t&eacute; :".$dataPropriete."<br/>";
		if ($dataPropriete =='acte') {
			$content .= "Kdb :".$dataKdb."<br/>";
			$content .= "BC :".$dataBc."<br/>";
		} else {
			$content .= "Honoraire : ".$dataHono."<br/>";
			$content .= "Intervention b&eacute;n&eacute;ficiaires avec r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataA."<br/>";
			$content .= "Intervention b&eacute;n&eacute;ficiaires sans r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataB."<br/>";
		}
		$content .= "Description : ".htmlentities($dataDescription)."<br/>";
		$content .= "Condition : ".htmlentities($dataCondition)."<br/>";
		if ($dataTpfortr == 'checked') {			
			$content .= "<b>Accorder le tiers payant pour le travailleur</b><br/>";
 		}
		
		if (trim($dataCondition!='')) $class .= " condition";
		
	} else {

		while($data = mysql_fetch_assoc($result)) 	{
			
			$dataCecodi = $data['cecodi'];
			$dataDescription = $data['description'];
			$dataTpfortr = $data['tpfortr'];
			if ($dataTpfortr == 'checked') {	
				$dataTpfortr = " - <font color = 'red'>tp pour tr</font>";
 			} else {
 				$dataTpfortr = "";
 			}

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
		
			$content .= "<b><a href='#' onClick='javascript:tarificationCheckCecodiList($dataCecodi);return false;' >".$dataCecodi."</a></b> - ".htmlentities($dataDescription)." - <font color = 'red'>Age = ".$age."</font>".$dataTpfortr."<br/>";
		
		}
		
	}
	

$datas = array(
    'root' => array(
        'cecodi_desc' => $content, 
        'cecodi_input' => $cecodi,
        'class' => $class
)
);
		
header("X-JSON: " . json_encode($datas));

?>		