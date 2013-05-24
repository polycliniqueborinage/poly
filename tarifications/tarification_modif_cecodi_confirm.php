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
	include_once '../lib/calcul_honoraire.php';

	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");

	// Fonction de connexion à la base de données
	connexion_DB('poly');

	$id = $_GET['id'];
	$cecodi = $_GET['cecodi'];

	$sessTarificationID = $_SESSION['tarification_id'];
	$sessTarificationPatientType = $_SESSION['tarification_type'];
	$sessTarificationPatientChildren = $_SESSION['tarification_children'];
	$sessTarificationPatientSexe = $_SESSION['tarification_sex'];
	$sessTarificationPatientAge = $_SESSION['tarification_age'];
	$sessMedecinTauxConsul = $_SESSION['taux_consultation'];
	$sessMedecinTauxActe = $_SESSION['taux_acte'];
	$sessCaisse = $_SESSION['login'];
		
	$sql = "SELECT * FROM cecodis2 WHERE ( cecodi = '$cecodi') AND ( age like '%|$sessTarificationPatientAge|%' ) order by id Desc";
	
	$result = requete_SQL ($sql);

	$data = mysql_fetch_assoc($result);
	
	$dataCecodi = $data['cecodi'];
	$dataPropriete = $data['propriete'];
				
	$dataDescription = $data['description'];
	$dataDescription = $test->convert($dataDescription);
  			
	// Prix
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
	$dataTpfortr = $data['tpfortr'];
	
	$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." remplace un acte interne par un cecodi ($cecodi)</b><br/>";
	
	// Accorder le tp pour le tr dans le cadre d'une consultation
 	if ($dataTpfortr == 'checked' && $sessTarificationPatientType =='tr') {			
			$content .= "<b>Accorder le tiers payant pour le travailleur</b><br/>";
			$sessTarificationPatientType = 'tp';
 	}
	
	// Calcul Honoraire officielle
	$dataCout = calcul_cout($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
	$content .= "Honoraire officielle : ".$dataCout."<br/>";
			
	// Calcul Honoraire mutuelle
	$dataMutuelle = calcul_mutuelle($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
	$content .= "Remboursement mutuelle : ".round(($dataMutuelle-$dataCout),2)."<br/>";
			
	// Calcul Honoraire medecin
	$dataCoutMedecin = calcul_cout_medecin($dataPropriete,$dataKdb,$dataHono,$sessMedecinTauxActe,$sessMedecinTauxConsul);
	$content .= "Revenu m&eacute;decin : ".$dataCoutMedecin."<br/>";
			
	// Calcul Honoraire poly
	$dataCoutPoly = calcul_cout_poly($dataPropriete,$formPatientType,$dataKdb,$dataHono,$dataCout,$dataCoutMedecin);
	$content .= "Revenu polyclinique : ".$dataCoutPoly."<br/><br/>";
				
	// modification du record 
	$sql = "Update tarifications_detail set propriete='$dataPropriete' ,cecodi='$cecodi', kdb='$dataKdb', bc='$dataBc', hono_travailleur='$dataHono', a_vipo='$dataA', b_tiers_payant='$dataB', cout='$dataCout', cout_medecin='$dataCoutMedecin', cout_poly='$dataCoutPoly', cout_mutuelle='$dataMutuelle' WHERE ( id = '$id')";
	$result = requete_SQL ($sql);
		
	deconnexion_DB();
	
$datas = array(
    'root' => array(
        'content' => $content	
	)
);
		
header("X-JSON: " . json_encode($datas));

?>