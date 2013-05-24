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
	
	// Link to the webapp INAMI
	$url = "https://www.riziv.fgov.be/webapp/nomen/Honoraria.aspx?lg=F&id=";
	
	$sessTarificationID = $_SESSION['prothese_id'];
	
	$cecodi = "";
	$montant = ""; 
    $montantDetail = ""; 
    $devis = ""; 
    $devisDetail = ""; 
    $prothesiste = ""; 
    $prothesisteDetail = ""; 
    $acompte = ""; 
    $acompteDetail = ""; 
    $remboursement = ""; 
    $remboursementDetail = ""; 
    $dataAPayer ="";
    $dataPaye = ""; 
    $dataRestePayer = ""; 
    $button = ""; 
    
	connexion_DB('poly');
	
	// Affichage de la liste des cecodis
	$sql = "SELECT td.id as id, td.tarification_id as tarification_id, td.cecodi as cecodi, td.propriete as propriete, td.description as description, td.kdb as kdb, td.bc as bc, td.hono_travailleur as hono_travailleur, td.a_vipo as a_vipo, td.b_tiers_payant as b_tiers_payant, td.cout as cout,  td.caisse as caisse, t.etat as etat FROM tarifications_detail td, tarifications t WHERE ( td.tarification_id = t.id) AND ( td.tarification_id = $sessTarificationID) order by 1";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)!=0) {
		
		$cecodi .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		$cecodi .= "<th class='td'  colspan='1' align='center'>";
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
			$cecodi .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			if (strpos($data['etat'], "close")===false) {
				$cecodi .= "<a href='#' onClick=\"javascript:submitForm(".$data['id'].",'');return false;\" >";
				$cecodi .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			}
			$cecodi .= "</td>";
			$cecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$cecodi .= "<a target='_blank' href='".$url.$data['cecodi']."' title='".strtoupper($data['propriete'])." ".htmlentities($data['description'])."'>".$data['cecodi']."</a>";
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

	
	// Affichage des devis  submitForm('','')
	$sql = "SELECT id, prothese_id, date, type, montant FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'cout_totale') order by 3";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)!=0) {
		$devisDetail .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		while($data = mysql_fetch_assoc($result)){
			$datetools = new dateTools($data['date'],$data['date']);
			
			$devisDetail .= "<tr>";
			if ($_SESSION['role'] == 'Administrateur') {
				$devisDetail .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				$devisDetail .= "<a href='#' onClick=\"javascript:submitForm('',".$data['id'].");return false;\" >";
				$devisDetail .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
				$devisDetail .= "</td>";
			}
			$devisDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$devisDetail .= $datetools->transformDATE()."</td>";
			$devisDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$devisDetail .= $data['montant']."</td>";
			$devisDetail .= "</tr>";
		}
		$devisDetail .= "</table>";
	}
	
	$sql = "SELECT sum(montant) as somme FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'cout_totale')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$devisValue = round($data['somme'],2);
	$devis .= "Devis : ".round($data['somme'],2);
	$devis .= "<div id='devisImageLeft' class='openBox'><a href='#'></a></div>";	
	

	// Affichage des prothesistes
	$sql = "SELECT id, prothese_id, date, type, montant FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'cout_prothese') order by 3";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)!=0) {
		$prothesisteDetail .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		while($data = mysql_fetch_assoc($result)){
			$prothesisteDetail .= "<tr>";
			if ($_SESSION['role'] == 'Administrateur') {
				$prothesisteDetail .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				$prothesisteDetail .= "<a href='#' onClick=\"javascript:submitForm('',".$data['id'].");return false;\" >";
				$prothesisteDetail .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
				$prothesisteDetail .= "</td>";
			}
			$prothesisteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$prothesisteDetail .= $data['date']."</td>";
			$prothesisteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$prothesisteDetail .= $data['montant']."</td>";
			$prothesisteDetail .= "</tr>";
		}
		$prothesisteDetail .= "</table>";
	}
	
	$sql = "SELECT sum(montant) as somme FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'cout_prothese')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$prothesisteValue = round($data['somme'],2);
	$prothesiste .= "Cout proth&egrave;siste : ".round($data['somme'],2);
	$prothesiste .= "<div id='protheseImageLeft' class='openBox'><a href='#'></a></div>";	
	

	// Affichage des acomptes
	$sql = "SELECT id, prothese_id, date, type, montant, compte FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'paiement') order by 3";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)!=0) {
		$acompteDetail .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		while($data = mysql_fetch_assoc($result)){
			$acompteDetail .= "<tr>";
			if ($_SESSION['role'] == 'Administrateur') {
				$acompteDetail .= "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
				$acompteDetail .= "<a href='#' onClick=\"javascript:submitForm('',".$data['id'].");return false;\" >";
				$acompteDetail .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
				$acompteDetail .= "</td>";
			}
			$acompteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$acompteDetail .= $data['date']."</td>";
			$acompteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$acompteDetail .= $data['montant']."</td>";
			$acompteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$acompteDetail .= $data['type']."</td>";
			$acompteDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$acompteDetail .= $data['compte']."</td>";
			$acompteDetail .= "</tr>";
		}
		$acompteDetail .= "</table>";
	}
	
	$sql = "SELECT sum(montant) as somme FROM protheses_detail WHERE (prothese_id = '$sessTarificationID' AND type = 'paiement')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$acompteValue = round($data['somme'],2);
	$acompte .= "Acompte : ".round($data['somme'],2);
	$acompte .= "<div id='acompteImageLeft' class='openBox'><a href='#'></a></div>";	
	
	
	// Affichage des remboursement
	$sql = "SELECT cout, cout_mutuelle FROM tarifications_detail WHERE (tarification_id = '$sessTarificationID')";
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)!=0) {
		$remboursementDetail .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
		while($data = mysql_fetch_assoc($result)){
			$remboursementDetail .= "<tr>";
			$remboursementDetail .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
			$remboursementDetail .= $data['cout_mutuelle']-$data['cout']."</td>";
			$remboursementDetail .= "</tr>";
		}
		$acompteDetail .= "</table>";
	}
	
	$sql = "SELECT sum(cout) as cout_total, sum(cout_mutuelle) as cout_mutuelle_total FROM tarifications_detail WHERE (tarification_id = '$sessTarificationID')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$remboursementValue = round(($data['cout_mutuelle_total']-$data['cout_total']),2);
	$remboursement .= "Remboursement mutuelle : ".round(($data['cout_mutuelle_total']-$data['cout_total']),2);
	$remboursement .= "<div id='remboursementImageLeft' class='openBox'><a href='#'></a></div>";	

	
	$dataAPayer = round($devisValue - $remboursementValue,2);
    $dataPaye = $acompteValue; 
    $dataRestePayer = round($dataAPayer - $dataPaye,2);
	
	// Affichage des boutons
	$sql = "SELECT etat FROM tarifications WHERE ( id = $sessTarificationID) order by 1";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$formEtat = $data['etat'];
	$button .= "<br/>";
	$button .= "<br/>";
	$button .= "<input type='submit' class='button' value='Payer' onclick='javascript:prothesePayer(this,$sessTarificationID);'/>";
	if ($formEtat !="close" && $dataRestePayer <= 0 && $prothesisteValue >0) {
		$button .= "<input type='submit'  class='button' value='Cl&ocirc;turer' onclick='javascript:openDialogConfirmCloture($sessTarificationID);' title='Permet la facturation aux m&eacute;decins et mutuelles'/>";
	}
	$button .= "<a href='../menu/menu.php'><input type='submit' class='button' value='Sortir'/></a>";
	
	
	deconnexion_DB();
	
	
	
$datas = array(
    'root' => array(
        'cecodi' => $cecodi, 
        'montant' => $montant, 
        'montant_detail' => $montantDetail, 
        'devis' => $devis, 
        'devis_detail' => $devisDetail, 
        'prothesiste' => $prothesiste, 
        'prothesiste_detail' => $prothesisteDetail, 
        'acompte' => $acompte, 
        'acompte_detail' => $acompteDetail,
        'remboursement' => $remboursement, 
        'remboursement_detail' => $remboursementDetail,
        'a_payer' => $dataAPayer." euro", 
        'deja_paye' => $dataPaye." euro", 
        'reste_paye' => $dataRestePayer, 
		'button' => $button 
	)
);
		
header("X-JSON: " . json_encode($datas));

?>						