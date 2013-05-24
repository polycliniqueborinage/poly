<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
	// SECURISE
	if(isset($_SESSION['application'])) {
		if ($_SESSION['application']=="|poly|" && $_SESSION['role']=="Administrateur") {
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

	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$jsType = $_GET['type'];
	$jsID = $_GET['id'];
	$jsChamps = $_GET['champs'];
	$jsValeur = $_GET['valeur'];
	$jsValeur = html_entity_decode($jsValeur);
	
	$jsType = $test->convert($jsType);
	$jsID = $test->convert($jsID);
	$jsChamps = $test->convert($jsChamps);
	$jsValeur = $test->convert($jsValeur);
	
	$content = "";
	
	switch($jsType) {
		
		case 'del_code':
			$sql = "DELETE FROM caisse_code WHERE id = '$jsID'";
			$result = requete_SQL($sql);
			$content .= "Suppression du code de tarification ($jsID) <br/><br/>";
		break;
		case 'modif_code':
			
			/*if ($jsChamps == 'code') {
				// modification du code
				$sql = "SELECT * from caisse_code where code = $jsValeur and type = (select type from caisse_code where id = $jsID )";
				$result = requete_SQL($sql);
				$nbrResult = mysql_num_rows($result);
				
			} else {
				if ($jsChamps == 'type') {
					// modification du type
					$sql = "SELECT * from caisse_code where code = (select code from caisse_code where id = $jsID ) and type = $jsValeur";
					$result = requete_SQL($sql);
					$nbrResult = mysql_num_rows($result);
				
				} else {
					$nbrResult = 0;
				}
			}

			$content .="$nbrResult</b><br/><br/>";
			*/
			if ($jsValeur!='') {
				$sql = "UPDATE caisse_code SET $jsChamps = '$jsValeur' WHERE id = $jsID";
				$result = requete_SQL($sql);
				$content .="Modification du champs $jsChamps avec ".stripcslashes(htmlentities($jsValeur))."</b><br/><br/>";
			} else {
				$content .="Pas de valeur vide autoris&eacute;e</b><br/><br/>";
			}
			
		break;
		default:
	}
	
	deconnexion_DB();

	
$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>