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
	
	unset ($_SESSION['information']);
					
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';

	$id = $_GET['id'];
	$sessCaisse = $_SESSION['login'];
	
	$content = "";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	if ($id !='') {
		
		$sql = "UPDATE tarifications SET etat = 'close', caisse = '$sessCaisse', cloture=now() WHERE ( id  = '$id' )";
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." cloture la tarification</b><br/><br/>";
		$result = requete_SQL($sql);
		
				
		// MISE A JOUR LOG DANS DB
		$sql = "UPDATE tarifications set log = concat('$content',log) WHERE id = $id";
		$result = requete_SQL ($sql);

	}
	
	deconnexion_DB();
	
$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>