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
	$title = $_GET['title'];
	
	$content = "";
	
	switch($type) {
		
		case 'change_title':
			$sql = "Update notices SET titre = '$title' WHERE ( id = '$id') LIMIT 1";
			//$content .= $sql;
			$result = requete_SQL($sql);
			$content .= "Modification du titre avec ".$title."<br/><br/>";
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>