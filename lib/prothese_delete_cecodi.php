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
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	// On fait la requ�te
	$champscomplet = $_GET['id'];
	
	// suppression du record
	$sql = "DELETE FROM tarifications_detail WHERE ( id = '$champscomplet')";
	
	$result = requete_SQL ($sql);

	deconnexion_DB();
	
	header('Location: ../protheses/modif_prothese.php');

	
?>























