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
		
		case 'del_medecin':
			$sql = "DELETE FROM medecins WHERE id='$id' Limit 1";
			$result = requete_SQL($sql);
			$info = "Suppression d'un m&eacute;decin ($id)";
		break;
		case 'etiquette':
			$sql = "Update medecins set etiquette ='$value' WHERE id=$id Limit 1";
			$result = requete_SQL($sql);
			$info = $sql;
		break;
		case 'info_medecin':
			$sql = "SELECT * FROM medecins WHERE id ='$id'";
			$result = requete_SQL($sql);
			$data = mysql_fetch_assoc($result);
	
			$tarificationSQL = "SELECT count(*) as tarification_number FROM tarifications WHERE ( medecin_inami  = '".$data['inami']."')";
			$tarificationResult = requete_SQL ($tarificationSQL);
			$tarificationData = mysql_fetch_assoc($tarificationResult);
				
			$medecinInfo .= "<b>Nom : </b>".htmlentities($data['nom'])." ".htmlentities($data['prenom'])."<br/>";
			$medecinInfo .= "<b>Date naissance : </b>".$data['date_naissance']."<br/>";
			$medecinInfo .= "Le m&eacute;decin poss&egrave;de ".$tarificationData['tarification_number']." tarifications<br/>";
			
			if ($tarificationData['tarification_number'] > 0) {
				$medecinInfo .= "<br><br><font color='red'> Il n'est pas conseill&eacute de supprimer ce m&eacute;decin - Contacter l'administrateur</font><br/>";
			}
			
		break;
		default:
	}
	
	deconnexion_DB();		

$datas = array(
    'root' => array(
        'info' => "<div>".$info."</div>", 	
        'info_medecin' => $medecinInfo
	)
);
		
header("X-JSON: " . json_encode($datas));

?>