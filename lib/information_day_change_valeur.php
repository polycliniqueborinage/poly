<?
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
	include_once 'fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	// Value from the js
	$jsInformation = $_GET['information'];
	$jsInformation = $test->convert($jsInformation);

	// Value from the session
	$dateCurrent = isset($_SESSION['dateCurrent']) ? $_SESSION['dateCurrent'] : "";
	$medecinCurrent = isset($_SESSION['medecinCurrent']) ? $_SESSION['medecinCurrent'] : "";
	
	if ($dateCurrent!='' && $medecinCurrent!='') {
		$sql = "SELECT id, comment FROM `".$medecinCurrent."` where id = '".$dateCurrent."'";
		$result = mysql_query($sql);
		if (mysql_num_rows($result)==0){
			$sql = "INSERT INTO `".$medecinCurrent."` ( `id` , `comment` ) VALUES ('$dateCurrent', '$jsInformation' )";
		} else {
			$sql = "UPDATE `".$medecinCurrent."` SET comment = '$jsInformation' WHERE ( id  = '$dateCurrent' )";
		}
		$result = requete_SQL($sql);
	}
	
	deconnexion_DB();
?>


