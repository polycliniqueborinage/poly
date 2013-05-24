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
	$champs = $_GET['champs'];
	$value = $_GET['value'];
	
	$info = '';
	$infoPatient = '';
	
	switch($type) {
		
		case 'del_mutuelle':
			$sql = "DELETE FROM mutuelles WHERE code='$id' Limit 1";
			$result = requete_SQL($sql);
			$info = "Suppression d'une mutuelle ($id)";
		break;
		case 'info_mutuelle':
			$sql = "SELECT * FROM mutuelles WHERE code ='$id'";
			$result = requete_SQL($sql);
			$data = mysql_fetch_assoc($result);
	
			$tarificationSQL = "SELECT count(*) as tarification_number FROM tarifications WHERE ( mutuelle_code  = '$id')";
			$tarificationResult = requete_SQL ($tarificationSQL);
			$tarificationData = mysql_fetch_assoc($tarificationResult);
				
			$mutuelleInfo .= "<b>Code : </b>".htmlentities($data['code'])."<br/>";
			$mutuelleInfo .= "<b>Nom : </b>".htmlentities($data['nom'])."<br/>";
			$mutuelleInfo .= "La mutuelle poss&egrave;de ".$tarificationData['tarification_number']." tarifications<br/>";
			
			if ($tarificationData['tarification_number'] > 0) {
				$mutuelleInfo .= "<br><br><font color='red'> Il n'est pas conseill&eacute de supprimer cette mutuelle - Contacter l'administrateur</font><br/>";
			}
			
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>", 	
        'info_mutuelle' => $mutuelleInfo 	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>