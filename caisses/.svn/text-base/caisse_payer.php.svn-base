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
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	if (isset($_GET['id'])) {
		$formID = $_GET['id'];
	}

	if (isset($_GET['montant'])) {
		$formMontant = $_GET['montant'];
	}

	if (isset($_GET['motif'])) {
		$formMotif = $_GET['motif'];
	} else {
		$formMotif = "";
	}

	if (isset($_GET['mode'])) {
		$formMode = $_GET['mode'];
	}
	
	if (isset($_SESSION['caisse_nom'])) {
		$formCaisse = $_SESSION['caisse_login'];
	} else {
		$formCaisse = $_SESSION['login'];
	}
	
	$sql = "SELECT id, code, type, description FROM caisse_code WHERE id='$formID'";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	
	$formCode = $data['code'];
	$formType = $data['type'];
	$formDescription = $formMotif." ".$data['description'];
	$formDate = date("Y-m-d");
	
	// Ouverture de la caisse
	$sql = "SELECT * FROM caisses_transaction where date = '$formDate' AND caisse='$formCaisse' AND code = '5000'";

	$result = requete_SQL ($sql);
	
	if (mysql_num_rows($result)==0) {
		$sql = "SELECT sum(montant) as montant FROM caisses_transaction where caisse='$formCaisse' AND mode='espece' AND date = (select max(date) from caisses_transaction where date!='$formDate' and code ='5000' and caisse='$formCaisse')";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$montant = round($data['montant'],2);
		$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
			VALUES ( '$formCaisse', '$formDate' , '5000','Ouverture de la caisse', '$montant', 'espece', now() )";
		$result = requete_SQL ($sql);
	}	
	// FIN Ouverture de la caisse

	// insert dans la DB
	$formValeur = $formType * $formMontant;

	$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
				VALUES ( '$formCaisse', '$formDate', '$formCode','$formDescription', '$formValeur', '$formMode', now() )";

	$result = requete_SQL ($sql);
													
?>
							