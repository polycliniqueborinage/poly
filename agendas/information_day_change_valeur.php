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
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	// Value from the js
	$jsInformation = $_GET['information'];
	$jsInformation = html_entity_decode($jsInformation);
	$jsInformation = $test->convert($jsInformation);
	
	// Value from the session
	$dateCurrent = isset($_SESSION['dateCurrent']) ? $_SESSION['dateCurrent'] : "";
	$medecinCurrent = isset($_SESSION['medecinCurrent']) ? $_SESSION['medecinCurrent'] : "";
	
	if ($dateCurrent!='' && $medecinCurrent!='') {
		$sql = "SELECT id, user_comment FROM `".$medecinCurrent."` where id = '".$dateCurrent."'";
		$result = requete_SQL ($sql);
		if (mysql_num_rows($result)==0){
			$sql = "INSERT INTO `".$medecinCurrent."` ( `id` , `user_comment` ) VALUES ('$dateCurrent', '$jsInformation' )";
		} else {
			$sql = "UPDATE `".$medecinCurrent."` SET user_comment = '$jsInformation' WHERE ( id  = '$dateCurrent' )";
		}
		$result = requete_SQL($sql);
	}
	
	deconnexion_DB();
	
$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>" 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>

