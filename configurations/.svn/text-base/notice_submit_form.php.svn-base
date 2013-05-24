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
	
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion a la base de donnees
	connexion_DB('poly');

	$newTitre = $_GET['new_titre'];
	
	$newTitre = html_entity_decode($newTitre);
	$newTitre = strtolower($test->convert($newTitre));
	$newTitre = trim($newTitre);
		
	$delNotice = $_GET['del_notice'];
	
	$content = "";
	
	if ($newTitre != '') {
		$sql = "INSERT INTO notices (titre) VALUES ('$newTitre')";
		$result = requete_SQL($sql);
		$content .= "<b>Ajout de la notice ".htmlentities(stripcslashes($newTitre))."</b><br><br>";
	}

	if ($delNotice != '') {
		$sql = "DELETE FROM notices WHERE id = '$delNotice'";
		$result = requete_SQL($sql);
		$content .= "<b>Suppression de la notice $delNotice</b><br><br>";
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'content' => $content 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>		















