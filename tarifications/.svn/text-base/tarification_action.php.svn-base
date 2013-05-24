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
	
	// Validation du Login
	if(isset($_SESSION['nom'])) {
	}
	else {
	// redirection
	header('Location: ../index.php');
	die();
	}
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	$id = $_GET['id'];
	$type = $_GET['type'];
	$sessCaisse = $_SESSION['login'];

	switch($type) {
		
		case 'decloture_tarification':
			$sql = "UPDATE tarifications SET etat = 'consultation', caisse = '$sessCaisse', cloture='' WHERE ( id  = '$id' )";
			$result = requete_SQL($sql);
			$info = "D&eacute;cloture d'une tarification";
		break;
		case 'del_tarification':
			$sql = "DELETE FROM tarifications WHERE ( id = '$id')";
			$result = requete_SQL($sql);
			$sql = "DELETE FROM tarifications_detail WHERE ( tarification_id = '$id')";
			$result = requete_SQL($sql);
			$info = "Suppression d'une tarification ($id)";
		break;
		case 'del_prestation':
			$sql = "DELETE FROM tarifications_detail WHERE ( id = '$id')";
			$result = requete_SQL($sql);
			$info = "Suppression d'une prestation ($id)";
		break;
		case 'cloture_erreur_medecin':
			$sql = "SELECT a_payer, paye, id FROM tarifications WHERE id='$id'";
			$result = requete_SQL ($sql);
			if(mysql_num_rows($result)==1) {
				$data = mysql_fetch_assoc($result);
				$formAPayer = $data['a_payer'];
				$formPayer = $data['paye'];
				$formRestePayer = $formAPayer - $formPayer;
				$sql = "INSERT INTO erreurs (tarification_id, type, a_payer) VALUES ('$id', 'erreur_medecin', '$formRestePayer')";
				$result = requete_SQL ($sql);
				$sql = "UPDATE `tarifications` SET `a_payer` = 0 WHERE id = '$id'";
				$result = requete_SQL ($sql);
				$info = "Cloture par une erreur du medecin";
			}
		break;
		case 'cloture_erreur_patient':
				// suppression du record
			$sql = "UPDATE `tarifications` SET `a_payer` = -1*`a_payer` WHERE ( id = '$id')";
			$result = requete_SQL ($sql);
			$info = "Cloture par une erreur du patient";
		break;
		case 'decloture_erreur_patient':
			// suppression du record
			$sql = "UPDATE `tarifications` SET `a_payer` = -1*`a_payer` WHERE ( id = '$id')";
			$result = requete_SQL ($sql);
			$info = "Decloture une erreur du patient";
		break;
		case 'cloture_cadeau_poly':
			$sql = "SELECT a_payer, paye, id FROM tarifications WHERE id='$id'";
			$result = requete_SQL ($sql);
			if(mysql_num_rows($result)==1) {
				$data = mysql_fetch_assoc($result);
				$formAPayer = $data['a_payer'];
				$formPayer = $data['paye'];
				$formRestePayer = $formAPayer - $formPayer;
				$sql = "INSERT INTO erreurs (tarification_id, type, a_payer) VALUES ('$id', 'erreur_poly', '$formRestePayer')";
				$result = requete_SQL ($sql);
				$sql = "UPDATE `tarifications` SET `a_payer` = 0 WHERE id = '$id'";
				$result = requete_SQL ($sql);
				$info = "Cloture par un cadeau de la poly";
			}
		break;
		case 'cloture_erreur_caisse':
			$sql = "SELECT a_payer, paye, id FROM tarifications WHERE id='$id'";
			$result = requete_SQL ($sql);
			if(mysql_num_rows($result)==1) {
				$data = mysql_fetch_assoc($result);
				$formAPayer = $data['a_payer'];
				$formPayer = $data['paye'];
				$formRestePayer = $formAPayer - $formPayer;
				$sql = "INSERT INTO erreurs (tarification_id, type, a_payer) VALUES ('$id', 'erreur_caisse', '$formRestePayer')";
				$result = requete_SQL ($sql);
				$sql = "UPDATE `tarifications` SET `a_payer` = 0 WHERE id = '$id'";
				$result = requete_SQL ($sql);
				$info = "Cloture par une erreur de caisse";
			}
		break;
		default:
	}
	
	
			
	// suppression du record
	//$result = requete_SQL($sql);
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>" 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>