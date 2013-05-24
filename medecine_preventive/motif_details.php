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
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/fonctions.php';

	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');
	
	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	
	//echo "test".$jsID;
	
	if ($jsID != '') {

	$sql = "SELECT * FROM medecine_preventive WHERE motif_ID = '".$jsID."'";
			
		// recherche
		$result = requete_SQL ($sql);

		
		if($data = mysql_fetch_assoc($result)) {
		
			
			
			echo "<h1>".htmlentities($data['description'])."</h1><br/>";
			echo "<table style='border:none'><tr><td style='border:none'>";
			echo "<b>P&eacute;riode de pr&eacute;vention : </b>".$data['periode_nb']." ".$data['periode_base']."<br/><br/>";
			echo "<b>Contenu de la lettre : </b><br/>".$data['texte_principal']."<br/><br/>";
			echo "<b>Signature : </b>".$data['signature']."<br/><br/>";
			echo "<b>R&eacute;currence : </b>".htmlentities($data['recurrence'])."<br/><br/>";
			echo "<b>Requ&ecirc;te : </b>".htmlentities($data['requete'])."<br/><br/>";
			echo "</td></tr></table>";
			echo "<br/><br/><br/><br/>";

		}

	}
	
	echo "<h1>".htmlentities($data['description'])."</h1><br/>";
	
	
//utilisation de 0000-00-00 pour la date du jour
$date_jour = date("Y-m-d");
//$request_bis = $data['requete'];
$request_bis = str_replace('\\', '', $data['requete']);
for($i=0; $i<strlen($request_bis); $i++){
			if($request_bis[$i] == 0 && $request_bis[$i+4] == '-' && $request_bis[$i+7] == '-'){
				$annee_en_cours = date("Y");
				$annee_calculee = substr($request_bis, $i, 4);
				
				$mois_en_cours = date("m");
				$mois_calculee = substr($request_bis, $i+5, 2);
				
				$jour_en_cours = date("d");
				$jour_calculee = substr($request_bis, $i+8, 2);
				
				$annee     = $annee_en_cours - $annee_calculee;
				$mois      = $mois_en_cours  - $mois_calculee;
				$jour      = $jour_en_cours  - $jour_calculee;
				
				if(strlen($mois) == 1){
					$mois = '0'.$mois; 
				}
				
				if(strlen($jour) == 1){
					$jour = '0'.$jour; 
				}
				
				$request_bis = substr_replace($request_bis, $annee, $i,   4);
				$request_bis = substr_replace($request_bis, $mois,  $i+5, 2);
				$request_bis = substr_replace($request_bis, $jour,  $i+8, 2);
				
			}
		}
//$requete_bis = str_replace('0000-00-00', $date_jour, $request);
$result = requete_SQL ($request_bis);

if(mysql_num_rows($result)!=0) {
	
	echo "<table border='0' cellpadding='2' cellspacing='1'>";
	
		echo"<tr>";
		echo"<th>Id</th>";
		echo"<th>Nom</th>";
		echo"<th>Pr&eacute;nom</th>";
		echo"<th>Rue</th>";
		echo"<th>Code postal</th>";
		echo"<th>Commune</th>";
		echo"<th>T&eacute;l&eacute;phone</th>";
		echo"<th>GSM</th>";
		echo"</tr>";
	
	$cursor = 0;	
	while(($patient = mysql_fetch_row($result)) && ($cursor < 20)){
			$cursor++;
			$req_infoPatient = "select id, nom, prenom, rue, code_postal, commune, telephone, gsm from patients WHERE id = '".$patient[0]."'";
			$res_infoPatient = requete_SQL ($req_infoPatient);
	
		
		while($row = mysql_fetch_row($res_infoPatient)){
			echo"<tr>";
				for($j=0; $j<mysql_num_fields($res_infoPatient); $j++)
					echo"<td>".$row[$j]."</td>";
			echo"</tr>";
		}
	}	
		
	echo "</table>";
}


	deconnexion_DB();

?>
