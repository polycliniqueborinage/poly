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
	
	$modifUrl ='../patients/modif_patient.php?id=';
	$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	
	//echo "test".$jsID;
	
	if ($jsID != '') {

	$sql = "SELECT 
		id as patient_id,
		nom as patient_nom, 
		prenom as patient_prenom, 
		DATE_FORMAT(date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date_naissance,
		sexe as patient_sexe,
		rue as patient_rue,
		code_postal as patient_code_postal,
        commune as patient_commune,
		nationnalite as patient_nationnalite, 
		telephone as patient_telephone, 
		gsm as patient_gsm, 
		mail as patient_mail, 
		mutuelle_code as patient_mutuelle_code, 
		mutuelle_matricule as patient_mutuelle_matricule, 
		sis as patient_sis, 
		ct1 as patient_ct1, 
		ct2 as patient_ct2, 
		tiers_payant as patient_tiers_payant, 
		niss as patient_niss, 
		titulaire_id as patient_titulaire_id, 
		prescripteur as patient_prescripteur,
		tiers_payant_info as patient_tiers_payant_info, 
		vipo_info as patient_vipo_info, 
		mutuelle_info as patient_mutuelle_info, 
		interdit_info as patient_interdit_info, 
		(rating_rendez_vous_info + rating_frequentation_info + rating_preference_info) as patient_rating_somme_info,
		rating_rendez_vous_info as patient_rating_rendez_vous_info, 
		rating_frequentation_info  as patient_rating_frequentation_info, 
		rating_preference_info as patient_rating_preference_info, 
		commentaire as patient_commentaire,
		photo as patient_photo,
		textcomment as patient_textcomment
		FROM patients WHERE id ='$jsID'";
	
		// recherche
		$result = mysql_query($sql);

		
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);

			$PayeurPatientID = $data['patient_id'];
			$PayeurSQL = "SELECT sum(a_payer) as total_a_payer, sum(paye) as total_paye FROM tarifications WHERE ( patient_id  = '$PayeurPatientID') AND a_payer < 0";
			$PayeurResult = requete_SQL ($PayeurSQL);
			$PayeurData = mysql_fetch_assoc($PayeurResult);
			
			echo "<h1>".htmlentities($data['patient_nom'])." ".htmlentities($data['patient_prenom'])."</h1><br/>";
			echo "<table style='border:none'><tr><td style='border:none'>";
			echo "<b>Date naissance : </b>".$data['patient_date_naissance']."<br/>";
			echo "<b>NISS (registre national) : </b>".$data['patient_niss']."<br/>";
			echo "<b>Sexe : </b>".$data['patient_sexe']."<br/>";
			echo "<b>Adresse : </b>".htmlentities($data['patient_rue'])." ".$data['patient_code_postal']." ".htmlentities($data['patient_commune'])."<br/>";
			echo "<b>T&eacute;l&eacute;phone fixe : </b>".$data['patient_telephone']."<br/>";
			echo "<b>GSM : </b>".$data['patient_gsm']."<br/>";
			echo "<b>E-mail : </b>".$data['patient_mail']."<br/>";
			echo "<b>Nationnalit&eacute; : </b>".htmlentities($data['patient_nationnalite'])."<br/><br/>";
			echo "<b style='color:green'>Commentaire : ".htmlentities($data['patient_commentaire'])."</b><br/>";
			echo "<b style='color:green'>Rendez-vous : ".$data['patient_rating_rendez_vous_info']." / 5</b><br/>";
			echo "<b style='color:green'>Fr&eacute;quentation : ".$data['patient_rating_frequentation_info']." / 5</b><br/>";
			echo "<b style='color:green'>Pr&eacute;f&eacute;rence : ".$data['patient_rating_preference_info']." / 5</b><br/><br/>";
			echo "</td><td style='border:none'>";
			echo "<b>Code Mutuelle : </b>".$data['patient_mutuelle_code']."<br/>";
			echo "<b>CT1/CT2 : </b>".$data['patient_ct1']."/".$data['patient_ct2']."<br/>";
			echo "<b>R&eacute;duction T.P. : </b>".$dico['tiers_payant'.$data['patient_tiers_payant']]."<br/>";
			echo "<b>Matricule patient : </b>".$data['patient_mutuelle_matricule']."<br/>";
			echo "<b>SIS : </b>".$data['patient_sis']."<br/>";
			echo "<b>Prescripteur : </b>".htmlentities($data['patient_prescripteur'])."<br/><br/>";
			if($PayeurData['total_a_payer'] < 0) { echo "<b style='color:red'>Le patient doit la somme de ".round((-1 * $PayeurData['total_a_payer']) - $PayeurData['total_paye'],2)." ! </b><br/>"; }
			if($data['patient_tiers_payant_info'] == 'checked') { echo "<b style='color:red'>Refus r&eacute;duction tiers payant</b><br/>"; }
			if($data['patient_vipo_info'] == 'checked') { echo "<b style='color:red'>Refus r&eacute;duction VIPO</b><br/>"; }
			if($data['patient_mutuelle_info'] == 'checked') { echo "<b style='color:red'>Refus prise en charge aux mutuelles</b><br/>"; }
			if($data['patient_interdit_info'] == 'checked') { echo "<b style='color:red'>INTERDIT D'ETABLISSEMENT</b><br/>"; }
			echo "</td></tr></table>";
			echo "<br/>";
			echo $data['patient_textcomment'];

		}

	}

	deconnexion_DB();

?>




 