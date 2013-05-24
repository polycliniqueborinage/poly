<?
//
// VERIFICATION EN LIVE DU PSEUDO
//

	// Demarre une session
	session_start();
	
	// Validation du Login
	if(isset($_SESSION['nom'])) {
	}
	else {
		// redirection
		header('Location: ../index.php');
		die();
	}
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	

	$id = $_GET['id'];
	$sessCaisse = $_SESSION['login'];
	
	$formDate = date("Y-m-d");
	
	$content = "";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	if ($id !='') {
		
		$sql = "UPDATE tarifications SET etat = 'close', caisse = '$sessCaisse', cloture=now() WHERE ( id  = '$id' )";
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." cloture la tarification pour cette proth&egrave;se</b><br/><br/>";
		$result = requete_SQL($sql);
		
		$sql = "SELECT sum(montant) as somme FROM protheses_detail WHERE (prothese_id = '$id' AND type = 'cout_totale')";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$CoutTotale = round($data['somme'],2);
		
		$sql = "SELECT sum(cout) as cout_total, sum(cout_mutuelle) as cout_mutuelle_total FROM tarifications_detail WHERE (tarification_id = '$id')";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$CoutMutuelle = round(($data['cout_mutuelle_total']-$data['cout_total']),2);
		
		$sql = "SELECT sum(montant) as somme FROM protheses_detail WHERE (prothese_id = '$id' AND type = 'cout_prothese')";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$CoutProthese .= -1 * (round($data['somme'],2));
		
		$sessMedecinTauxProthese = $_SESSION['taux_prothese'];
														 
		$CoutTotaleSansMutuelle = $CoutTotale - $CoutMutuelle;
		
		$GainMedecin = round($CoutTotaleSansMutuelle * $sessMedecinTauxProthese / 100,2);
		$GainPoly = round ($CoutTotaleSansMutuelle - $GainMedecin,2);
		
		$CoutProtheseMedecin = round($CoutProthese * $sessMedecinTauxProthese / 100,2);
		$CoutProthesePoly = round ($CoutProthese - $CoutProtheseMedecin,2);
		
		$content .= " <b>Devis</b> =".$CoutTotale."<br/>";
		$content .= " <b>Intervention de la mutuelle =</b>".$CoutMutuelle."<br/>";
		$content .= " <b>Gain hors mutuelle =</b>".$CoutTotaleSansMutuelle."<br/>";
		$content .= " <b>Gain medecin =</b>".$GainMedecin."<br/>";
		$content .= " <b>Gain poly =</b>".$GainPoly."<br/>";
		$content .= " <b>Cout prothese medecin =</b>".$CoutProtheseMedecin."<br/>";
		$content .= " <b>Cout prothese poly =</b>".$CoutProthesePoly."<br/><br/>";
		
		$sql = "INSERT INTO tarifications_detail ( tarification_id , cecodi , propriete, description, kdb , bc , hono_travailleur , a_vipo , b_tiers_payant, cout, cout_medecin, cout_poly, cout_mutuelle, caisse) VALUES ('$id', '', 'prothese', 'Gain sur le TM de la prothese', '', '', '', '' , '', '$CoutTotaleSansMutuelle', '$GainMedecin', '$GainPoly', '$CoutTotaleSansMutuelle', '0')";
		$result = requete_SQL ($sql);
				
		$sql = "INSERT INTO tarifications_detail ( tarification_id , cecodi , propriete, description, kdb , bc , hono_travailleur , a_vipo , b_tiers_payant, cout, cout_medecin, cout_poly, cout_mutuelle, caisse) VALUES ('$id', '', 'prothese', 'Cout du prothésiste', '', '', '', '' , '', '$CoutProthese', '$CoutProtheseMedecin', '$CoutProthesePoly', '$CoutProthese', '0')";
		$result = requete_SQL ($sql);
		
		// MISE A JOUR LOG DANS DB
		$sql = "UPDATE tarifications set log = concat('$content',log) WHERE id = $id";
		$result = requete_SQL ($sql);

	}
	
	deconnexion_DB();
	
	//unset($_SESSION['prothese_id']);
	unset($_SESSION['information']);
		

$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>