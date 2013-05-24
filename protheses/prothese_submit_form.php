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
	
	$dico = array('cout_totale' => 'un devis', 'cout_prothese' => 'un cout de prothesiste', 'paiement' => 'un acompte', 'child0' => 'Adulte', 'child1' => 'Enfant', 'tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	$content = "";
    $dataAPayer ="";
    $dataPaye = ""; 
    $dataRestePayer = ""; 
		
	$sessTarificationID = $_SESSION['prothese_id'];
	$sessTarificationPatientType = $_SESSION['tarification_type'];
	$sessTarificationPatientChildren = $_SESSION['tarification_children'];
	$sessTarificationPatientSexe = $_SESSION['tarification_sex'];
	$sessTarificationPatientAge = $_SESSION['tarification_age'];
	$sessMedecinTauxProthese = $_SESSION['taux_prothese'];
	$sessMedecinTauxConsul = $_SESSION['taux_consultation'];
	$sessMedecinTauxActe = $_SESSION['taux_acte'];
	$sessCaisse = $_SESSION['login'];
	
	$formCecodi = isset($_GET['cecodi_input']) ? $_GET['cecodi_input'] : '';
	$formDevis = isset($_GET['devis_input']) ? $_GET['devis_input'] : '';
	$formProthesiste = isset($_GET['prothesiste_input']) ? $_GET['prothesiste_input'] : '';
	$formDelCecodi = isset($_GET['del_cecodi']) ? $_GET['del_cecodi'] : '';
	$formDelEntrie = isset($_GET['del_entrie']) ? $_GET['del_entrie'] : '';
	
	$today = date("Y-m-d");
			
	// Si ajout protesiste
	if (strlen($formProthesiste) != '') {
		$sql = "INSERT into protheses_detail (prothese_id,date,type,montant) VALUES ( '$sessTarificationID', '$today', 'cout_prothese', '$formProthesiste')";
		$result = requete_SQL ($sql);
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute un cout proth&egrave;siste de $formProthesiste euro</b><br/><br/>";
	}
	
	// Si ajout devis
	if (strlen($formDevis) != '') {
		
		if (strpos($formDevis, ".") === false && strlen($formDevis) == 6 ) {
			
			$sql = "SELECT cecodi, propriete, description, kdb, bc, hono_travailleur, a_vipo, b_tiers_payant, classe, children, prix_vp, prix_tp, prix_tr, age FROM cecodis2 WHERE ( cecodi = '$formDevis') AND ( age like '%|$sessTarificationPatientAge|%' ) order by id Desc";
			
			// VERIFICATION
			$result = requete_SQL ($sql);
		
			if(mysql_num_rows($result)!=0) {
				
				$data = mysql_fetch_assoc($result);
			
				// variables from DB
				$test = new testTools("info");
				$dataCecodi = $data['cecodi'];
				$dataPropriete = $data['propriete'];
				$dataDescription = $data['description'];
				$dataDescription = $test->convert($dataDescription);
				$dataKdb = $data['kdb'];
				$dataBc = $data['bc'];
				$dataHono = $data['hono_travailleur'];
				$dataA= $data['a_vipo'];
				$dataB = $data['b_tiers_payant'];
					
				// Calcul Honoraire mutuelle
				$dataMutuelle = calcul_mutuelle($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
				//$content .= "Devis ".$dataMutuelle."<br/>";
				
				// Remboursement mutuelle
				$rembMutuelle = round($dataMutuelle,2);

				$sql = "INSERT into protheses_detail (prothese_id,date,type,montant) VALUES ( '$sessTarificationID', '$today', 'cout_totale', '$rembMutuelle')";
				$result = requete_SQL ($sql);
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute un devis de $rembMutuelle ($formDevis)</b><br/>";
				
			} else {
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." essaie un devis avec un code inexistant ($formDevis)</b><br/><br/>";
			}	
			
			
		} else {
			$sql = "INSERT into protheses_detail (prothese_id,date,type,montant) VALUES ( '$sessTarificationID', '$today', 'cout_totale', '$formDevis')";
			$result = requete_SQL ($sql);
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute un devis de $formDevis euro</b><br/><br/>";
		}
	}
	
	// Si prestation INAMI
	if (strlen($formCecodi) == 6) {

		$sql = "SELECT cecodi, propriete, description, kdb, bc, hono_travailleur, a_vipo, b_tiers_payant, classe, children, prix_vp, prix_tp, prix_tr, age FROM cecodis2 WHERE ( cecodi = '$formCecodi') AND ( age like '%|$sessTarificationPatientAge|%' ) order by id Desc";
		
		// VERIFICATION
		$result = requete_SQL ($sql);
	
		if(mysql_num_rows($result)!=0) {
			
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute une prestation ($formCecodi)</b><br/>";
			
			$data = mysql_fetch_assoc($result);
		
			// variables from DB
			$test = new testTools("info");
			$dataCecodi = $data['cecodi'];
			$dataPropriete = $data['propriete'];
			$dataDescription = $data['description'];
			$dataDescription = $test->convert($dataDescription);
			$dataKdb = $data['kdb'];
			$dataBc = $data['bc'];
			$dataHono = $data['hono_travailleur'];
			$dataA= $data['a_vipo'];
			$dataB = $data['b_tiers_payant'];
			$dataPrixVP = $data['prix_vp'];
			$dataPrixTP = $data['prix_tp'];
			$dataPrixTR = $data['prix_tr'];
			
			/*
			$content .= "Propri&eacute;t&eacute; :".$dataPropriete."<br/>";
			if ($dataPropriete =='acte') {
				$content .= "Kdb :".$dataKdb."<br/>";
				$content .= "BC :".$dataBc."<br/>";
				$content .= "Pourcentage m&eacute;decin : ".$sessMedecinTauxActe."<br/>";
			} else {
				$content .= "Honoraire : ".$dataHono."<br/>";
				$content .= "Intervention b&eacute;n&eacute;ficiaires avec r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataA."<br/>";
				$content .= "Intervention b&eacute;n&eacute;ficiaires sans r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataB."<br/>";
				$content .= "Pourcentage m&eacute;decin : ".$sessMedecinTauxConsul."<br/>";
			}
			*/
				
			// Calcul Honoraire officielle
			$dataCout = calcul_cout($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
			$content .= "Honoraire officielle : ".$dataCout."<br/>";
			
			// Calcul Honoraire caisse
			$dataCaise = calcul_caisse($sessTarificationPatientType,$dataCout,$dataPrixVP,$dataPrixTP,$dataPrixTR);
			$content .= "Honoraire caisse : ".$dataCaise."<br/>";
			
			// Calcul Honoraire mutuelle
			$dataMutuelle = calcul_mutuelle($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
			$content .= "Remboursement mutuelle : ".round(($dataMutuelle-$dataCout),2)."<br/>";
			
			// Calcul Honoraire medecin
			$dataCoutMedecin = calcul_cout_medecin($dataPropriete,$dataKdb,$dataHono,$sessMedecinTauxActe,$sessMedecinTauxConsul);
			$content .= "Revenu m&eacute;decin : ".$dataCoutMedecin."<br/>";
			
			// Calcul Honoraire poly
			$dataCoutPoly = calcul_cout_poly($dataPropriete,$formPatientType,$dataKdb,$dataHono,$dataCout,$dataCoutMedecin);
			$content .= "Revenu polyclinique : ".$dataCoutPoly."<br/><br/>";
			
			// Ajout dans la DB
			$q = requete_SQL ("INSERT INTO tarifications_detail ( tarification_id , cecodi , propriete, description, kdb , bc , hono_travailleur , a_vipo , b_tiers_payant, cout, cout_medecin, cout_poly, cout_mutuelle, caisse)
				VALUES ('$sessTarificationID', '$dataCecodi', '$dataPropriete', '$dataDescription', '$dataKdb', '$dataBc', '$dataHono', '$dataA' , '$dataB', '$dataCout', '$dataCoutMedecin', '$dataCoutPoly', '$dataMutuelle', '$dataCaise')");
			
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute un remboursement mutuelle de ".($dataMutuelle - $dataCout)." euro</b><br/><br/>";
				
		}
		else {
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." essaie un code inexistant ($formCecodi)</b><br/><br/>";
		}			
	}

	
	// Si suppr prestation INAMI
	if ($formDelCecodi != '') {
		$sql = "Select cecodi, cout, cout_mutuelle FROM tarifications_detail WHERE ( id = $formDelCecodi) LIMIT 1";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		if ($data['cecodi']=='0') {$temp = "Acte interne";} else {$temp = $data['cecodi'];}
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." supprime une prestation (".$temp." - ".($data['cout_mutuelle']-$data['cout'])." euro)</b><br/><br/>";
		$sql = "DELETE FROM tarifications_detail WHERE ( id = '$formDelCecodi') LIMIT 1";
		$result = requete_SQL ($sql);
	}
	
	
	// Si suppr montant
	if ($formDelEntrie != '') {
		$sql = "SELECT id, prothese_id, date, type, montant FROM protheses_detail WHERE id = $formDelEntrie";
		$result = requete_SQL ($sql);
		if(mysql_num_rows($result)!=0) {
			$data = mysql_fetch_assoc($result);
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." supprime ".$dico[$data['type']]." pour un montant de ".$data[montant]." euro</b><br/><br/><br/>";
			$sql = "DELETE FROM protheses_detail WHERE ( id = '$formDelEntrie') LIMIT 1";
			$result = requete_SQL ($sql);
		}
	}
	
	
	// MISE A JOUR LOG DANS DB
	$sql = "UPDATE tarifications set log = concat('$content',log) WHERE id = $sessTarificationID";
	$result = requete_SQL ($sql);
	
	
$datas = array(
    'root' => array(
        'content' => $content, 
        'solde' => $solde, 
        'a_payer' => $dataAPayer, 
        'deja_paye' => $dataPaye, 
        'reste_paye' => $dataRestePayer 
	)
);
		
header("X-JSON: " . json_encode($datas));

?>		