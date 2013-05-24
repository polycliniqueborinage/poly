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
	include_once 'fonctions.php';
	
	//$test = new testTools("info");
	
	//$nom_fichier = "modif_patient.php";
		
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	$jsTable = isset($_GET['table']) ? $_GET['table'] : '';
	
	if ($jsTable != '') {

		$sql = "DESCRIBE ".$jsTable;
		
	} else {

		if ($jsTable=="") $jsPatient="%";
		$sql = "DESCRIBE ".$jsTable;
	}
	$result = mysql_query($sql);
		if(mysql_num_rows($result)!=0) {
	
			while($data = mysql_fetch_assoc($result)) 	{

				echo htmlentities($data['Field']);
				echo "#";
			}
	} else {
		
		echo "";
			
	}

	deconnexion_DB();
	
?>