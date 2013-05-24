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
	$sql = "SELECT etat FROM tarifications WHERE ( id = $sessTarificationID) order by 1";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$formEtat = $data['etat'];

	$button .= "<br/>";
	$button .= "<br/>";
	$button .= "<input type='submit' class='button' value='Payer' onclick='javascript:tarificationPayer(this,$sessTarificationID);'/>";
	if ($formEtat =="start") {
		$button .= "<input type='submit'  class='button' value='Cl&ocirc;turer' onclick='javascript:openDialogConfirmCloture($sessTarificationID);' title='Permet la facturation aux m&eacute;decins et mutuelles'/>";
	} else {
		if ($formEtat =="close") {
		} else {
			if (strpos($formEtat, "prepay") === false) {
		$button .= "<input type='submit'  class='button' value='Cl&ocirc;turer' onclick='javascript:openDialogConfirmCloture($sessTarificationID);' title='Permet la facturation aux m&eacute;decins et mutuelles'/>";
			} 
		}
	}
	$button .= "<a href='../menu/menu.php'><input type='submit' class='button' value='Sortir' onclick='javascript:tarification_sortir()'/></a>";
							
	echo $button;

?>										