<?php 

	// Demarre une session
	session_start();

	// Validation du Login
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
	
	$id = $_GET['id'];
	$valeur = $_GET['valeur'];
	$paiementType = $_GET['paiement_type'];
	$compte = $_GET['compte'];
	
	$sessCaisse = $_SESSION['login'];
	$date = date("Y-m-d");
	
	$content = "";

	/*$content .= $id;
	$content .= $valeur;
	$content .= $paiementType;
	$content .= $compte;
	*/
		
	if ($paiementType == 'banksys') {
		$code = '580003'; 
	} else {
		$code = '570000'; 
	}
	
	// Ouverture de la caisse
	$sql = "SELECT * FROM caisses_transaction where date = '$date'  AND caisse='$sessCaisse' AND code = '5000'";
	$result = requete_SQL ($sql);
		
	if (mysql_num_rows($result)==0) {
		$sql = "SELECT sum(montant) as montant FROM caisses_transaction where caisse='$sessCaisse' AND mode='espece' AND date = (select max(date) from caisses_transaction where date!='$date' and code ='5000' and caisse='$sessCaisse')";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$montant = round($data['montant'],2);
		$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
			VALUES ( '$sessCaisse', '$date' , '5000','Ouverture de la caisse', '$montant', 'espece', now() )";
		$result = requete_SQL ($sql);
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A').", ouverture de la caisse de ".$sessCaisse." </b><br/><br/>";
	}	
	// FIN Ouverture de la caisse

	
	// INSERT INTO PROTHESE DETAIL
	$sql = "INSERT into protheses_detail (prothese_id,date,type,montant,compte) VALUES ( '$id', '$date', 'paiement', '$valeur','$compte')";
	$result = requete_SQL ($sql);
	
	$sessionPatientNom = isset($_SESSION['impression_patient_last_name']) ? $_SESSION['impression_patient_last_name'] : '';  
	$sessionPatientPrenom = isset($_SESSION['impression_patient_first_prenom']) ? $_SESSION['impression_patient_first_prenom'] : '';  
	$sessionMedecinNom = isset($_SESSION['impression_medecin_last_name']) ? $_SESSION['impression_medecin_last_name'] : '';  
	$sessionMedecinPrenom = isset($_SESSION['impression_medecin_first_prenom']) ? $_SESSION['impression_medecin_first_prenom'] : '';  
	
	$description = "Prothese de ".$sessionPatientNom." ".$sessionPatientPrenom." pour ".$sessionMedecinNom." ".substr($sessionMedecinPrenom,0,1).".";
	
	$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
				VALUES ( '$sessCaisse', '$date' , '$code','$description', '$valeur', '$paiementType', now() )";
	$result = requete_SQL ($sql);
	$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." recoit un paiement de $valeur euro ($paiementType)</b><br/><br/>";

		
	// MISE A JOUR LOG DANS DB
	$sql = "UPDATE tarifications set log = concat('$content',log) WHERE id = $id";
	$result = requete_SQL ($sql);
		
	deconnexion_DB();
	
$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>