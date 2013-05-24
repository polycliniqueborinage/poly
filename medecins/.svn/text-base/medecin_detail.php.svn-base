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
	
	//$modifUrl ='../patients/modif_patient.php?id=';
	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$jsID = isset($_GET['id']) ? $_GET['id'] : '';
	
	//echo "test".$jsID;
	
	if ($jsID != '') {

	$sql = "SELECT 
		m.id as medecin_id,
		m.nom as medecin_nom, 
		m.prenom as medecin_prenom, 
		DATE_FORMAT(m.date_naissance, GET_FORMAT(DATE, 'EUR')) as medecin_date_naissance,
		m.rue as medecin_rue,
		m.code_postal as medecin_code_postal,
        m.commune as mdecin_commune,
		m.telephone_prive as medecin_telephone_prive, 
		m.telephone_travail as medecin_telephone_travail, 
		m.telephone_mobile as medecin_telephone_mobile, 
		m.fax as medecin_fax, 
		m.mail as medecin_mail, 
		m.type as medecin_type, 
		s.specialite as medecin_specialite, 
		m.inami as medecin_inami, 
		m.taux_acte as medecin_taux_acte, 
		m.taux_consultation as medecin_taux_consultation, 
		m.taux_prothese as medecin_taux_prothese,
		m.length_consult as medecin_length_consult, 
		m.protocole as medecin_protocole, 
		m.agenda as medecin_agenda,
		m.comment as medecin_comment,
		m.textcomment as medecin_textcomment,
		m.texthoraire as medecin_texthoraire
		FROM medecins m , specialites s WHERE s.id=m.specialite AND m.id ='$jsID'";
		
		// recherche
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);

			echo "<h1>".htmlentities($data['medecin_nom'])." ".htmlentities($data['medecin_prenom'])."</h1><br/>";
			echo "<table style='border:none'><tr><td style='border:none'>";
			echo "<b>Date naissance : </b>".$data['medecin_date_naissance']."<br/>";
			echo "<b>T&eacute;l&eacute;phone mobile : </b>".$data['medecin_telephone_mobile']."<br/>";
			echo "<b>T&eacute;l&eacute;phone travail : </b>".$data['medecin_telephone_travail']."<br/>";
			echo "<b>T&eacute;l&eacute;phone priv&eacute; : </b>".$data['medecin_telephone_prive']."<br/>";
			echo "<b>Fax : </b>".$data['medecin_fax']."<br/>";
			echo "<b>E-mail : </b>".$data['medecin_mail']."<br/>";
			echo "<b style='color:green'>Commentaire : ".htmlentities($data['medecin_comment'])."</b><br/>";
			echo "</td><td style='border:none'>";
			echo "<b>Taux acte : </b>".$data['medecin_taux_acte']."<br/>";
			echo "<b>Taux consultation : </b>".$data['medecin_taux_consultation']."<br/>";
			echo "<b>Taux proth&egrave;se : </b>".$data['medecin_taux_prothese']."<br/>";
			if ($data['medecin_agenda'] == 'checked') echo "<b>Ce m&eacute;decin poss&egrave;de un agenda<br/>";
			echo "<b>Dur&eacute;e consultation : </b>".$data['medecin_length_consult']."<br/>";
			echo "</td></tr></table>";
			echo "<h1>Information</h1><br/>";
			echo $data['medecin_textcomment']."<br/>";
			echo "<h1>Horaire</h1><br/>";
			echo $data['medecin_texthoraire']."<br/>";
			
		}

	}

	deconnexion_DB();

?>




 