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
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	$dico = array('nom' => 'nom', 'prenom' => 'pr&eacute;nom', 'role' => 'r&ocirc;le', 'application' => 'application', 'inami' => 'code Inami', 'droit' => 'mode d\'acc&egrave;s sur l\'agenda');
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	$id = $_GET['id'];
	$type = $_GET['type'];
	$value = html_entity_decode($_GET['value']);
	
	$content = "";
	
	switch($type) {
		
		case 'del_user':
			$sql = "DELETE FROM users WHERE ( login = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "<b>Suppression de ".$id."</b><br/><br/>";
		break;
		case 'login':
			$sql = "UPDATE users SET login = '$value' WHERE ( login = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "<b>Modification du login avec ".stripcslashes(htmlentities($value))." pour l'ancien $id</b><br/><br/>";
		break;
		case 'password':
			$sql = "UPDATE users SET password = md5('$value') WHERE ( login = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "<b>Modification du password pour $id</b><br/><br/>";
		break;
		case 'prenom':
		case 'nom':
			$value = ucfirst(strtolower($test->convert($value)));
			$sql = "UPDATE users SET $type = '$value' WHERE ( login = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "<b>Modification du champs ".$dico[$type]." avec ".stripcslashes(htmlentities($value))." pour $id</b><br/><br/>";
		break;
		default:
			$sql = "UPDATE users SET $type = '$value' WHERE ( login = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "<b>Modification du champs ".$dico[$type]." avec la valeur '$value' pour $id</b><br/><br/>";
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>