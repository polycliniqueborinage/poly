<?php 

	// Demarre une session
	session_start();
	
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
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "delete_mutuelle.php";
	
	// Variables de l'url
	if (isset($_GET['code'])) {
		
		// from url
		$formCode = $_GET['code'];
		
		// ON possède l'inami du medecin
	
		$sql = requete_SQL ("DELETE FROM mutuelles WHERE code='$formCode'");
		
		$result = mysql_query($sql);
		
		// Valider l'ajout dans la DB
		$_SESSION['information']="Op&eacute;ration r&eacute;ussie - La mutuelle a &eacute;t&eacute; correctement supprim&eacute;e de la base de donn&eacute;e";
				
		header('Location: ../menu/menu.php');
						
		die();
	}
	
?>
