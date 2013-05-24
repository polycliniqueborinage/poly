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
	
	$action = isset($_GET['action']) ? $_GET['action'] : '';
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	
	$mode = "";
	$class = "";
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	switch($action) {
		
		case 'change_transaction':
			$sql = "SELECT id, code, type, description FROM caisse_code WHERE id='$id'";
			$result = requete_SQL ($sql);
			$data = mysql_fetch_assoc($result);
			$type = $data['type'];
			$mode .= "<OPTION value=''>Votre choix ...</OPTION>";
			$mode .= "<OPTION value='espece'>Paiement en esp&egrave;ce</OPTION>";
			if ($id == 0) {
				$class .= "cecodi condition";
			} else {
				if ($type == -1) {
					$class .= "cecodi out";
				} else {
					$mode .= "<OPTION value='banksys'>Paiement par bancontact</OPTION>";
					$mode .= "<OPTION value='virement'>Paiement par virement bancaire</OPTION>";
					$class .= "cecodi in";
				}
			}
			
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'mode' => $mode, 	
        'class' => $class, 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>