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
	
	connexion_DB('poly');

	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	$jsPseudo = isset($_GET['pseudo']) ? $_GET['pseudo'] : '';
	
	$modifUrl ='../actes/modif_acte.php?id=';
	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	$number="";
	$content="";
	$title="";
		
	$sql = "SELECT * FROM actes ";
	
	if ($jsID != '') {

		$sql .=" WHERE id ='$jsID'";

	} else {
		
		// verification if the value $champscomplet contain and ID
		$jsPseudo = html_entity_decode($jsPseudo);
		$jsPseudo = strtolower($test->convert($jsPseudo));
		$jsPseudo = trim($jsPseudo);
		
		// protect empty conten in editor's field
		if ($jsPseudo=="") $jsPseudo="%";
		
		$sql .= " WHERE ((lower(concat(code, ' ' ,description))) regexp '$jsPseudo' OR (lower(concat(description, ' ' ,code))) regexp '$jsPseudo') order by description LIMIT 7";
		
	}
	
	// recherche
	$result = requete_SQL($sql);
	
	if(mysql_num_rows($result)>1) {

		$number = "2";
		$style='bleu';
		$title = "";
		$content .= "<ul class='border-green border-greenred'>";

		while($data = mysql_fetch_assoc($result)) 	{
		
			switch($style) {
			case 'green':
				$style='bleu';
				break;
			case 'bleu':
				$style='green';
			break;
			default:
			}
			
			$content .=  "<li onclick=\"acte_recherche_list('".$data['id']."')\"  class='$style'><a href=\"#\" title=\"".htmlentities($data['description'])."\">";
			$content .= ucfirst(htmlentities($data['code']));
			$content .= " - ".htmlentities(substr($data['description'],0,30));
			$content .= "</a></li>";
		
		}
		
		$content .= "</ul>";
		
	} else {
		
		if(mysql_num_rows($result)==1) {

			// exaclty one result
			$number = "1";
			
			$data = mysql_fetch_assoc($result);
			
			$title = ucfirst(htmlentities($data['description']));
			
			$content .= "<div class='border-green color".$data['patient_rating_somme_info']."'>";
			$content .= "<h1>";
			$content .= "&nbsp;<a href='".$modifUrl.$data['id']."' alt='Modification compl&egrave;te' title='Modification compl&egrave;te'><img src=\"../images/modif_small.gif\" /></a>";
			$content .= ucfirst(htmlentities($data['code']))."</h1>";
			$content .= "<b>Description : </b>".ucfirst(htmlentities($data['description']))."<br/>";
			$content .= "<b>Codes Inami : </b>".ucfirst(htmlentities($data['cecodis']))."<br/>";
			$content .= "<b>Co&ucirc;t Travailleur : </b>".$data['cout_tr']."<br/>";
			$content .= "<b>Co&ucirc;t Tiers Payant : </b>".$data['cout_tp']."<br/>";
			$content .= "<b>Co&ucirc;t Vipo : </b>".$data['cout_vp']."<br/>";
			$content .= "<b>Dur&eacute;e : </b>".$data['length']."<br/>";
			$content .= "</div>";
			

		} else {
			// no result at all!
			$number = "0";
			$title = "";
			$content .= "<div class='border-green'>";
			$content .= "Aucun acte interne trouv&eacute; !";
			$content .= "</div>";
		}
			
	}
	
	
	deconnexion_DB();

$datas = array(
    'root' => array(
        'content' => $content, 
        'title' => $title,
        'number' => $number
)
);
		
header("X-JSON: " . json_encode($datas));

?>