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
	
	$content="";
	$title="";
	
	$modifUrl ='../medecins/modif_medecin.php?id=';

	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	$jsPseudo = isset($_GET['pseudo']) ? $_GET['pseudo'] : '';
	
	// Fonction de connexion � la base de donn�es
	connexion_DB('poly');
	
	if ($jsID != '') {

		$sql = "SELECT nom , prenom, DATE_FORMAT(date_naissance, GET_FORMAT(DATE, 'EUR')) as date_naissance, rue, code_postal, inami, commune, id, telephone_travail, telephone_prive, telephone_mobile, fax, mail ,comment FROM medecins WHERE id ='$jsID' Limit 7";

	} else {

		$jsPseudo = html_entity_decode($jsPseudo);
		$jsPseudo = strtolower($test->convert($jsPseudo));
		$jsPseudo = trim($jsPseudo);
		
		// protect empty conten in editor's field
		if ($jsPseudo=="") $jsPseudo="%";

		$sql = "SELECT  nom , prenom, DATE_FORMAT(date_naissance, GET_FORMAT(DATE, 'EUR')) as date_naissance, rue, code_postal, inami, commune, id, telephone_travail, telephone_prive, telephone_mobile, fax, mail, comment FROM medecins WHERE ((lower(concat(nom, ' ' ,prenom))) regexp '$jsPseudo' OR (lower(concat(prenom, ' ' ,nom))) regexp '$jsPseudo') Limit 7";
	}

	// recherche
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)>1) {

		$style='bleu';
		$content .= "<ul class='border-red border-greenred'>";
		
		while($data = mysql_fetch_assoc($result)) 	{
		
			switch($style) {
			case 'red':
				$style='bleu';
				break;
			case 'bleu':
				$style='red';
			break;
			default:
			}
				
			$content .= "<li onclick=\"medecin_recherche_list('".$data['id']."')\" class='$style'><a href=\"#\" title=\"".htmlentities($data['rue'])." ".$data['code_postal']." ".$data['commune']."\">";
			$content .= htmlentities($data['nom'])." ".htmlentities($data['prenom']);
			$content .= "</a></li>";
		
		}
		$content .= "</ul>";
		
	} else {
		
		if(mysql_num_rows($result)==1) {
			
			$data = mysql_fetch_assoc($result);
			
			$title .= htmlentities($data['nom'])." ".htmlentities($data['prenom']);
			
			$content .= "<div class='border-red'>";
			$content .= "<h1><a href='".$modifUrl.$data['id']."'><img src=\"../images/16x16/user_edit.png\" /></a> ".htmlentities($data['nom'])." ".htmlentities($data['prenom'])."</h1><br/>";
			$content .= "<b>INAMI : </b>".$data['inami']."<br/>";
			$content .= "<b>T&eacute;l travail : </b>".$data['telephone_travail']."<br/>";
			$content .= "<b>T&eacute;l priv&eacute; : </b>".$data['telephone_prive']."<br/>";
			$content .= "<b>T&eacute;l mobile : </b>".$data['telephone_mobile']."<br/>";
			$content .= "<b>Num&eacute;ro de fax : </b>".$data['fax']."<br/>";
			$content .= "<b>Adresse Email : </b>".$data['mail']."<br/>";
			$content .= "<b>Adresse : </b>".htmlentities($data['rue'])." ".$data['code_postal']." ".htmlentities($data['commune'])."<br/>";
			$content .= "<b>Commentaire : </b>".htmlentities($data['comment'])."<br/>";
			$content .= "</div>";
			
		} else {
			
			$title .= "";
			$content .= "<div class='border-green'>Aucun m&eacute;decin trouv&eacute; !</div>";
			
		}
			
	}

	deconnexion_DB();

$datas = array(
    'root' => array(
        'content' => $content, 
        'title' => $title
	)
);
		
header("X-JSON: " . json_encode($datas));

?>