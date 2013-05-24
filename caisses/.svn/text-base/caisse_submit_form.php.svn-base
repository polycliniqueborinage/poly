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

	include_once '../lib/fonctions.php';
	include_once '../lib/calcul_honoraire.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';

	// Fonction de connexion a la base de donnees
	connexion_DB('poly');
	
	$content = '';
	
	$sessCaisseDate = (isset($_SESSION['caisse_date']) && $_SESSION['caisse_date']!='') ? $_SESSION['caisse_date'] : date("Y-m-d");
	$sessCaisseLogin = (isset($_SESSION['caisse_login']) && $_SESSION['caisse_login']!='') ? $_SESSION['caisse_login'] : $_SESSION['login'];
	$sessRole = $_SESSION['role'];
	$sessLogin = $_SESSION['login'];
	
	$dateJour = date("Y-m-d");
	
	$caisse = isset($_GET['caisse_input']) ? $_GET['caisse_input'] : '';
	$date = isset($_GET['date']) ? $_GET['date'] : '';
	$delCaisse = isset($_GET['del_caisse']) ? $_GET['del_caisse'] : '';

	$transactionID = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
	$transactionValeur = isset($_GET['transaction_valeur']) ? $_GET['transaction_valeur'] : '';
	$comment = isset($_GET['comment']) ? $_GET['comment'] : '';
	$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
	$compte = isset($_GET['compte']) ? $_GET['compte'] : '';
	
	// SUPPRESSION ENTREE
	if ($delCaisse != '') {
		
		$sql = "Select * FROM caisses_transaction WHERE ( id = $delCaisse) LIMIT 1";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$sql = "DELETE FROM caisses_transaction WHERE ( id = '$delCaisse') LIMIT 1";
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessLogin." supprime une entr&eacute;e en caisse pour un montant de ".$data['montant']." euro</b><br/><br/>";
		$result = requete_SQL ($sql);
	} else {
		// CHANGEMENT DE CAISSE
		if ($caisse != '' && $caisse != $sessCaisseLogin) {
			$_SESSION['caisse_login'] = $caisse;
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessLogin." change de caisse ($caisse)</b><br/><br/>";
		} else {
			// CHANGEMENT DE DATE
			if ($date.length > 7  && $date != $sessCaisseDate) {
					$_SESSION['caisse_date'] = $date;
					$datetools = new dateTools($date,$date);
					$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessLogin." change de jour pour le ".$datetools->transformDATE()."</b><br/><br/>";
			} else {
				// AJOUT ENTREE
				if ( $transactionID != '' && $transactionValeur!='' && $mode!='') {
					
					// Ouverture de la caisse
					$sql = "SELECT * FROM caisses_transaction where date = '$sessCaisseDate' AND caisse='$sessCaisseLogin' AND code = '5000'";
					$result = requete_SQL ($sql);
					if (mysql_num_rows($result)==0) {
						$sql = "SELECT sum(montant) as montant FROM caisses_transaction where caisse='$sessCaisseLogin' AND mode='espece' AND date = (select max(date) from caisses_transaction where date!='$sessCaisseDate' and code ='5000' and caisse='$sessCaisseLogin')";
						$result = requete_SQL ($sql);
						$data = mysql_fetch_assoc($result);
						$montant = round($data['montant'],2);
						$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
						VALUES ( '$sessCaisseLogin', '$sessCaisseDate' , '5000','Ouverture de la caisse', '$montant', 'espece', now() )";
						$result = requete_SQL ($sql);
						$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A').", ouverture de la caisse de ".$sessCaisseLogin." </b><br/><br/>";
					}	
					// FIN Ouverture de la caisse
					
					// init
					if ($transactionID == 0) {
						$sql = "DELETE FROM caisses_transaction WHERE caisse = '$sessCaisseLogin' and date = '$sessCaisseDate' and code = '5000' Limit 1";
						$result = requete_SQL ($sql);
						$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure )
						VALUES ( '$sessCaisseLogin', '$sessCaisseDate' , '5000','Initialisation de la caisse', '$transactionValeur', 'espece', now() )";
						//$content .= $sql;
						$result = requete_SQL ($sql);
						$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A').", initialise la caisse de ".$sessCaisseLogin." avec un montant de $transactionValeur euro</b><br/><br/>";
					} else {
						// add transaction
						$sql = "SELECT id, code, type, description FROM caisse_code WHERE id='$transactionID'";
						$result = requete_SQL ($sql);
						$data = mysql_fetch_assoc($result);
						$type = $data['type'];
						$code = $data['code'];
						$description = htmlentities($data['description'])." ".$comment;
						$valeur = $type * $transactionValeur;
						$sql = "INSERT INTO caisses_transaction ( caisse, date, code, description, montant, mode, heure, compte )
								VALUES ( '$sessCaisseLogin', '$sessCaisseDate', '$code','$description', '$valeur', '$mode', now(), '$compte' )";
						$result = requete_SQL ($sql);
						$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessLogin." ajoute une entr&eacute;e dans la caisse de $sessCaisseLogin</b><br/>";
						$content .= "Montant : $valeur<br/>";
						$content .= "Commentaire : $comment<br/>";
						$content .= "Compte : $compte<br/>";
						$content .= "Description : $description<br/>";
						$content .= "Code : $code<br/><br/>";
					}
					
				}
			}
			
		}
		
	}
	

$datas = array(
    'root' => array(
        'content' => $content
	)
);
		
header("X-JSON: " . json_encode($datas));

?>	