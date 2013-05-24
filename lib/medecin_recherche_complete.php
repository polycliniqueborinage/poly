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
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");

	$content = "";

	connexion_DB('poly');
	
	$jsMedecin = html_entity_decode($_GET['medecin']);
	$jsMedecin = strtolower($test->convert($jsMedecin));
	$jsMedecin = trim($jsMedecin);
		
	// protect empty content in editor's field
	if ($jsMedecin=="") $jsMedecin="%";
	
	$sql = "SELECT m.id as id, m.length_consult as length_consult, m.taux_consultation as taux_consultation, m.taux_acte as taux_acte, m.taux_prothese as taux_prothese, m.nom as nom, m.prenom as prenom, m.inami as inami, m.type as type, s.specialite as specialite, DATE_FORMAT(m.date_naissance, GET_FORMAT(DATE, 'EUR')) as date_naissance FROM medecins m, specialites s WHERE s.id=m.specialite AND ((lower(concat(nom, ' ' ,prenom))) regexp '$jsMedecin' OR (lower(concat(prenom, ' ' ,nom))) regexp '$jsMedecin') order by nom, prenom Limit 15";
	
	// VERIFICATION
	$result = requete_SQL($sql);
	
		if(mysql_num_rows($result)!=0) {
			
		$content .= "<table border='0' cellpadding='2' cellspacing='1'>";
		$content .=  "<th class='td'  colspan='3' align='center'>Actions";
		$content .=  "</th>";
		$content .=  "<th>";
		$content .=  "Nom";
		$content .=  "</th>";
		$content .=  "<th>";
		$content .=  "Pr&eacute;nom";
		$content .=  "</th>";
		$content .=  "<th>";
		$content .=  "Type";
		$content .=  "</th>";
		$content .=  "<th>";
		$content .=  "INAMI";
		$content .=  "</th>";
		$content .=  "<th>";
		$content .=  "Sp&eacute;cialit&eacute;";
		$content .=  "</th>";
    			
		while($data = mysql_fetch_assoc($result)) 	{

			$formID = $data['id'];
			$formDetail = "".$formID;
			
			// on affiche les informations de l'enregistrement en cours
			$content .=  "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );' >";
			$content .=  "<td width='25' align='center' valign=top' bgcolor='#D5D5D5'>";
			$content .=  "<a href='./modif_medecin.php?id=";
			$content .=  $data['id'];
			$content .=  "'>";
			$content .=  "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
			$content .=  "</td>";
			$content .=  "<td width='25' align='center' valign=top' bgcolor='#D5D5D5'>";
			$content .= "<a href='#' onClick='javascript:openDialogConfirmDelMedecin($formDetail)' >";
			$content .=  "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			$content .=  "</td>";
			$content .=	"<td width='25' style='cursor: pointer' onMouseDown=javascript:openMedecinInfo($formDetail) valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			$content .=  "<img width='16' height='16' src='../images/icon_clipboard.gif' alt='Information' title='Information' border='0' /></a>";
			$content .=  "</td>";
			$content .=  "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['nom']),ENT_QUOTES)."</td>";
			$content .=  "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['prenom']),ENT_QUOTES)."</td>";
			$content .=  "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".$data['type']."</td>";
			$content .=  "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".$data['inami']."</td>";
			$content .=  "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['specialite']),ENT_QUOTES)."</td>";
			$content .=  "</tr>";
			// DETAIL INFORMATION
			$content .=  "<tr id='$formDetail' style='display: none;'>";
			$content .=  "<td></td>";
			$content .=  "<td colspan='12'>";
			$content .=  "<img src='../images/indicator_verybig.gif'>";
			$content .=  "</td>";
			$content .=  "</tr>"; 
			
		}
	
		$content .=  "</table>";
	
	}
	
	deconnexion_DB();
	
	echo $content;

?>