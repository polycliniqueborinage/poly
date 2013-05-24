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
	$sessCaisse = $_SESSION['login'];
	$date = date("Y-m-d");
	
	$content = "";
	
	if ($paiementType == 'banksys') {
		$code = '580003'; 
	} else {
		$code = '570000'; 
	}
	
		
	$sql = "SELECT t.paye as tarification_paye, t.patient_id, t.medecin_inami, p.nom as patient_nom, p.prenom as patient_prenom, m.nom as medecin_nom, m.prenom as medecin_prenom from tarifications t, medecins m, patients p WHERE (p.id = t.patient_id) AND (m.inami = t.medecin_inami) AND ( t.id  = '$id')";
	$result = requete_SQL ($sql);
		
	if((mysql_num_rows($result)==1) && ($valeur!=0) ) {
		
		$data = mysql_fetch_assoc($result);
		
		$valeurPaye = round($data['tarification_paye'] + $valeur,2);

		$description = "Tarification de ".$data['patient_nom']." ".$data['patient_prenom']." pour ".$data['medecin_nom']." ".substr($data['medecin_prenom'],0,1).".";
		$description = $test->convert($description);
		
		$sql = "UPDATE tarifications SET paye = '$valeurPaye' WHERE ( id  = '$id' )";
		$result = requete_SQL ($sql);
		
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
		
		$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
				VALUES ( '$sessCaisse', '$date' , '$code','$description', '$valeur', '$paiementType', now() )";
		$result = requete_SQL ($sql);
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." recoit un paiement de $valeur euro ($paiementType)</b><br/><br/>";

		
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