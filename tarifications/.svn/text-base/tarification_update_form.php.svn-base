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
	
	$sessTarificationID = $_SESSION['tarification_id'];
	// Link to the webapp INAMI
	$url = "https://www.riziv.fgov.be/webapp/nomen/Honoraria.aspx?lg=F&id=";
		
	$cecodi = ""; 
    $button = ""; 
	
	connexion_DB('poly');
	
	// Affichage de la liste
	$sql = "SELECT td.id as id, td.tarification_id as tarification_id, td.cecodi as cecodi, td.propriete as propriete, td.description as description, td.kdb as kdb, td.bc as bc, td.hono_travailleur as hono_travailleur, td.a_vipo as a_vipo, td.b_tiers_payant as b_tiers_payant, td.cout as cout,  td.caisse as caisse, t.etat as etat FROM tarifications_detail td, tarifications t WHERE ( td.tarification_id = t.id) AND ( td.tarification_id = $sessTarificationID) order by 1";
	$result = requete_SQL ($sql);
	
	if(mysql_num_rows($result)!=0) {
										
		$cecodi .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		$cecodi .= "<th class='td'  colspan='2' align='center'>";
		$cecodi .= "</th>";
		$cecodi .= "<th>CECODI</th>";
		$cecodi .= "<th>KDB</th>";
		$cecodi .= "<th>BC</th>";
		$cecodi .= "<th>HONO</th>";
		$cecodi .= "<th>VIPO</th>";
		$cecodi .= "<th>TIERS</th>";
		$cecodi .= "<th>Co&ucirc;t</th>";
		$cecodi .= "<th>Caisse</th>";
		
		while($data = mysql_fetch_assoc($result)) 	{
		
			// on affiche les informations de l'enregistrement en cours
			$cecodi .= "<tr>";

			// MODIFICAION
			$cecodi .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			if ($data['propriete'] == 'prepay') {
				$cecodi .= "<a href='#' onClick='javascript:tarificationCecodiChange(this,".$data['id'].");return false;'>";
				$cecodi .= "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
			}
												
			/*if ($data['propriete'] == 'interne') {
				$cecodi .= "<a href='#' onClick='javascript:tarificationModifInterne(".$data['id'].");return false;'>";
				$cecodi .= "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
			}*/
			$cecodi .= "</td>";

			// SUPPRESSION
			$cecodi .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			if (strpos($data['etat'], "close")===false) {
				$cecodi .= "<a href='#' onClick='javascript:submitForm(".$data['id'].");return false;' >";
				$cecodi .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			}
			$cecodi .= "</td>";

			// CECODI
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			if ($data['cecodi'] != '0') {
				$cecodi .= "<a target='_blank' href='".$url.$data['cecodi']."' title='".strtoupper($data['propriete'])." ".htmlentities($data['description'])."'>".$data['cecodi']."</a>";
			} else {
				$cecodi .= "<a href='#' title='".strtoupper($data['propriete'])." ".htmlentities($data['description'])."'>".htmlentities($data['description'])."</a>";
			}
			$cecodi .= "</td>";
		
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['kdb']."</td>";
	
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['bc']."</td>";

			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['hono_travailleur']."</td>";
	
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['a_vipo']."</td>";
		
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['b_tiers_payant']."</td>";
		
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['cout']."</td>";
		
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= $data['caisse']."</td>";
			
			$cecodi .= "</tr>";
			
		}
	
		$cecodi .= "</table>";

	} 
		
	echo $cecodi;
	
?>										