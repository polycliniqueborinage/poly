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

	switch($type) {
		
		case 'del_acte':
			$sql = "DELETE FROM actes WHERE ( id = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$info = "Suppression d'un acte ($id)";
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>" 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>