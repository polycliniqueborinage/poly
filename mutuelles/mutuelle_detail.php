<?
	// Demarre une session
	session_start();
	
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

	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	//$modifUrl ='../patients/modif_patient.php?id=';
	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	
	//echo "test".$jsID;
	
	if ($jsID != '') {

	$sql = "SELECT * FROM mutuelles WHERE code ='$jsID'";
		
		// recherche
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);

			echo "<td style='border:none'></td>";
			echo "<td colspan='8'>";
			echo "<h1>".htmlentities($data['code'])." ".htmlentities($data['nom'])."</h1><br/>";
			echo "<table style='border:none'><tr><td style='border:none'>";
			echo "<b>Adresse : </b>".htmlentities($data['rue'])." ".$data['code_postal']." ".htmlentities($data['commune'])."<br/>";
			echo "<b>Contact : ".htmlentities($data['contact'])."</b><br/>";
			echo "<b>T&eacute;l&eacute;phone : </b>".$data['telephone']."<br/>";
			echo "<b>Fax : </b>".$data['fax']."<br/>";
			echo "<b>E-mail : </b>".$data['mail']."<br/>";
			echo "</td></tr></table>";
			echo "<br/>";
			echo "<td style='border:none'></td>";

		}

	}

	deconnexion_DB();

?>




 