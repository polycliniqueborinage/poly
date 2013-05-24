<?
//
// VERIFICATION EN LIVE DU PSEUDO
//
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
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
		
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');

	$jsMutuelle = $_GET['mutuelle'];
	$jsMutuelle = html_entity_decode($jsMutuelle);
	$jsMutuelle = strtolower($test->convert($jsMutuelle));
	$jsMutuelle = trim($jsMutuelle);
	
	// protect empty content in editor's field
	if ($jsMutuelle=="") $jsMutuelle="%";
	
	$sql = "SELECT  * FROM mutuelles WHERE ((lower(code)) regexp '$jsMutuelle' OR (lower(nom)) regexp '$jsMutuelle') LIMIT 10";
	
	// VERIFICATION
	$result = mysql_query($sql);
	
		if(mysql_num_rows($result)!=0) {
	
		echo "<table border='0' cellpadding='2' cellspacing='1'>";
	
		echo "<th class='td'  colspan='3' align='center'>Actions";
		echo "</th>";
		echo "<th>";
		echo "Code";
		echo "</th>";
		echo "<th>";
		echo "Nom";
		echo "</th>";
		echo "<th>";
		echo "Contact";
		echo "</th>";
		
		while($data = mysql_fetch_assoc($result)) 	{
	
			// on affiche les informations de l'enregistrement en cours
			$formDetail = "".$data['code'];
			
			echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";
			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			echo "<a href='./modif_mutuelle.php?code=$formDetail'>";
			echo "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
			echo "</td>";
			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			echo "<a href='#' onClick='javascript:openDialogConfirmDelMutuelle($formDetail)' >";
			echo "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			echo "</td>";
			echo "<td width='25' style='cursor: pointer' onMouseDown=javascript:openMutuelleInfo($formDetail) valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
			echo "<img width='16' height='16' src='../images/icon_clipboard.gif' alt='Information' title='Information' border='0' /></a>";
			echo "</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['code']),ENT_QUOTES)."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['nom']),ENT_QUOTES)."</td>";
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>".htmlentities(stripcslashes($data['contact']),ENT_QUOTES)."</td>";
			echo "</tr>";
		
		}
	
		echo "</table>";
	
	} else {
		
		echo "";
			
	}

	deconnexion_DB();

?>