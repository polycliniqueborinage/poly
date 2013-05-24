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

	$id = $_GET['id'];
	$type = $_GET['type'];
	$champs = $_GET['champs'];
	$value = $_GET['value'];
	
	$info = '';
	$infoPatient = '';
	
	switch($type) {
		
		case 'del_patient':
			$sql = "DELETE FROM patients WHERE id='$id' Limit 1";
			$result = requete_SQL($sql);
			$sql = "UPDATE patients SET titulaire_id=id where titulaire_id='$id'";
			$result = requete_SQL($sql);
			$info = "Suppression d'un patient ($id)";
		break;
		case 'modif_patient':
			$sql = "UPDATE patients set $champs='$value' WHERE patient_id='$id' Limit 1";
			$result = requete_SQL($sql);
		break;
		case 'info_patient':
			$sql = "SELECT id as patient_id,
			nom as patient_nom, 
			prenom as patient_prenom, 
			DATE_FORMAT(date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date_naissance,
			sexe as patient_sexe,
			rue as patient_rue,
			code_postal as patient_code_postal,
	        commune as patient_commune,
			photo as patient_photo
			FROM patients WHERE id ='$id'";
			$result = requete_SQL($sql);
			$data = mysql_fetch_assoc($result);
	
			$payeurSQL = "SELECT sum(a_payer) as total_a_payer, sum(paye) as total_paye FROM tarifications WHERE ( patient_id  = '$id') AND a_payer < 0";
			$payeurResult = requete_SQL ($payeurSQL);
			$payeurData = mysql_fetch_assoc($payeurResult);
	
			$tarificationSQL = "SELECT count(*) as tarification_number FROM tarifications WHERE ( patient_id  = '$id')";
			$tarificationResult = requete_SQL ($tarificationSQL);
			$tarificationData = mysql_fetch_assoc($tarificationResult);
				
			$patientInfo .= "<b>Nom : </b>".htmlentities($data['patient_nom'])." ".htmlentities($data['patient_prenom'])."<br/>";
			$patientInfo .= "<b>Date naissance : </b>".$data['patient_date_naissance']."<br/>";
			$patientInfo .= "<b>Adresse : </b>".htmlentities($data['patient_rue'])." ".$data['patient_code_postal']." ".htmlentities($data['patient_commune'])."<br/>";
			$patientInfo .= "Le patient doit la somme de ".round((-1 * $payeurData['total_a_payer']) - $payeurData['total_paye'],2)." ! </b><br/>";
			$patientInfo .= "Le patient poss&egrave;de ".$tarificationData['tarification_number']." tarifications<br/>";
			
			if ($tarificationData['tarification_number'] > 0) {
				$patientInfo .= "<br><br><font color='red'> Il n'est pas conseill&eacute de supprimer ce patient - Contacter l'administrateur</font><br/>";
			}
			
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>", 	
        'info_patient' => $patientInfo 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>