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
	
	$notice = ""; 
        
	connexion_DB('poly');
	
	//notices
	$sql = "SELECT id, titre, textarea FROM notices ORDER BY 2";
	
	$result = requete_SQL ($sql);
											
	if(mysql_num_rows($result)!=0) {
		
		while($data = mysql_fetch_assoc($result)) 	{
													
			$dataID = $data['id'];
			$dataTitre = $data['titre'];
												
			$notice .= "<tr>";
			$notice .= "<th id='$dataID'>".htmlentities($dataTitre)."</th>";
			$notice .= "<td>";
			$notice .= "&nbsp;&nbsp;<img width='16' height='16' src='../images/modif_small.gif' alt='Modification' title='Modification' border='0' onClick='changeNotice($dataID)'/>";
			$notice .= "&nbsp;&nbsp;<a href='#' onClick='openDialogConfirmDelNotice($dataID)' >";
			$notice .= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' />";
			$notice .= "</a>";
			$notice .= "</td>";
			$notice .= "</tr>";
		
		}
	
	}
	
	$notice .= "<tr>";
	$notice .= "<input type='hidden' id='id' name='id' value='<?=$formID?>'/>";
	$notice .= "<th colspan='2' id='globalText'>";
	$notice .= "<textarea id='TextArea1' name='TextArea1' rows='10' cols='160' style='width:100%;display:none'>";
	$notice .= "</textarea>";
	$notice .= "</th>";
	$notice .= "</tr>";
			
	$notice .= "<tr>";
	$notice .= "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>";
	$notice .= "<td class='formInput'>";
	$notice .= "<input type='submit' value='Valider' class='button' onclick='javascript:submitHandler(\"editors_here\");'>";
	$notice .= "</td>";
	$notice .= "</tr>";
	
	deconnexion_DB();
	
	
$datas = array(
    'root' => array(
        'notice' => $notice
	)
);
		
header("X-JSON: " . json_encode($datas));

?>										