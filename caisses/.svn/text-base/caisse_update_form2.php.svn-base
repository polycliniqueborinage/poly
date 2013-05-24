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

	$sessCaisseDate = $_SESSION['caisse_date'];
	$sessCaisseLogin = $_SESSION['caisse_login'];
	$sessLogin = $_SESSION['login'];
	$sessRole = $_SESSION['role'];
	
	$cecodi = "";
    $caisse = ""; 
    $date = ""; 
    $montantOuverture = ""; 
    $montantFermeture = "";
    $banksysFermeture = ""; 
        
	connexion_DB('poly');
	
	// caisse
	$sql = "select nom, prenom, role, login FROM users WHERE login = '$sessCaisseLogin'";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$caisse .=  $data['nom']." ".$data['prenom']." - ".$data['role']." (".$data['login'].") ";
	$caisse .="<div id='patientImageLeft' class='openBox'><a href='#'></a></div>";
	
	
	// date
	$datetools = new dateTools($sessCaisseDate,$sessCaisseDate);
	$date .= $datetools->transformDATE();
	$date .="<div id='medecinImageLeft' class='openBox'><a href='#'></a></div>";
	
	$sql = "SELECT montant FROM caisses_transaction WHERE date ='$sessCaisseDate' AND caisse='$sessCaisseLogin' AND mode='espece' AND code='5000'";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)>0) {
		$data = mysql_fetch_assoc($result);
		$montantOuverture = "Caisse ouverture  = ".round($data['montant'],2);
	} else {
		$montantOuverture = " PAS OUVERTE ";
	}
	

	$sql = "SELECT SUM(montant) as montant FROM caisses_transaction WHERE ( date = '$sessCaisseDate' AND mode = 'espece' AND caisse='$sessCaisseLogin')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$montantFermeture = "Caisse fermeture  = ".round($data['montant'],2);
	

	$sql = "SELECT SUM(montant) as montant FROM caisses_transaction WHERE ( date = '$sessCaisseDate' AND mode = 'banksys' AND caisse='$sessCaisseLogin')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$banksysFermeture = "Bansys fermeture  = ".round($data['montant'],2);

	
$datas = array(
    'root' => array(
        'montant_ouverture' => $montantOuverture,
        'montant_fermeture' => $montantFermeture,
        'banksys_fermeture' => $banksysFermeture,
		'caisse' => $caisse,
		'date' => $date,
	)
);
		
header("X-JSON: " . json_encode($datas));

?>										