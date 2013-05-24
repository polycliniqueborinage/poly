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

	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	$id = $_GET['id'];
	$type = $_GET['type'];
	$champs = $_GET['champs'];
	$valeur = $_GET['valeur'];
	
	$dico = array('prix_vp' => 'prix maison pour le VIPO', 'prix_tp' => 'prix maison pour le tiers payant','prix_tr' => 'prix maison pour le travailleur', 'b_tiers_payant' => 'le remboursement pour le le tiers payant (b_tiers_payant)','a_vipo' => 'le remboursement pour le vipo (a_vipo)', 'hono_travailleur' => 'l\' honoraire pour le travailleur','kdb' => 'le kdb', 'bc' => 'le bc');
	$content = "";
	
	switch($type) {
		
		case 'change_cecodi':
			$sql = "UPDATE cecodis2 SET $champs = '$valeur' WHERE id  = '$id'";
			$result = requete_SQL($sql);
			//$content .= $sql;
			$content .= "Modification du ".$dico[$champs]." avec ".$valeur."<br/><br/>";
		break;
		
		case 'del_cecodi':
			$sql = "DELETE FROM cecodis2 WHERE ( id = '$id') LIMIT 1";
			$result = requete_SQL($sql);
			$content .= "Suppresion de la presation INAMI<br/><br/>";
		break;
		default:
	
	}

	deconnexion_DB();		

$datas = array(
    'root' => array(
        'content' => "<div>".$content."</div>"	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>
