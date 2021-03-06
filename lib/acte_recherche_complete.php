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
	// Inclus le fichier contenant les fonctions personalis�es
	include_once 'fonctions.php';

	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');
	
	$jsActe = html_entity_decode($_GET['acte']);
	$jsActe = strtolower($test->convert($jsActe));
	$jsActe = trim($jsActe);
	
	$modifUrl ='../actes/modif_acte.php?id=';
	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	$content="";
	
	$sql = "SELECT * FROM actes";
	$sql .= " WHERE ((lower(concat(code, ' ' ,description))) regexp '$jsActe' OR (lower(concat(description, ' ' ,code))) regexp '$jsActe') order by description LIMIT 7";
	
	// VERIFICATION
	$result = requete_SQL($sql);
	
		if(mysql_num_rows($result)!=0) {
	
			$content .=  "<table border='0' cellpadding='2' cellspacing='1'>";
		
			$content .=  "<th class='td'  colspan='2' align='center'>";
			$content .=  "</th>";
			$content .= "<th>";
			$content .= "Code";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Decription";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Codes Inami associ&eacute;s";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Co&ucirc;t Travailleur";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Co&ucirc;t Tiers Payant";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Co&ucirc;t Vipo";
			$content .= "</th>";
			$content .= "<th>";
			$content .= "Dur&eacute;e";
			$content .= "</th>";
			
			while($data = mysql_fetch_assoc($result)) 	{

				$content .= "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );' >";
				$content .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				$content .= "<a href='../actes/modif_acte.php?id=";
				$content .= $data['id'];
				$content .= "'>";
				$content .= "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
				$content .= "</td>";

				$content .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				$content .= "<a href='#' onClick='openDialogConfirmDelActe(".$data['id'].")' >";
				$content .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
				$content .= "</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['code']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['description']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['cecodis']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['cout_tr']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['cout_tp']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['cout_vp']),ENT_QUOTES)."</td>";
				$content .= "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['length']),ENT_QUOTES)."</td>";
				$content .= "</tr>";
		
			}
	
			$content .= "</table>";

		} else {
		
			$content .= "Aucun acte interne trouv&eacute; !";
						
		}
	
	deconnexion_DB();

$datas = array(
    'root' => array(
        'content' => $content 
	)
);
		
header("X-JSON: " . json_encode($datas));

?>