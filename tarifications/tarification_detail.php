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

	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	$url = "https://www.riziv.fgov.be/webapp/nomen/Honoraria.aspx?lg=F&id=";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$urlID = isset($_GET['id']) ? $_GET['id'] : '';
	
	//echo $urlID;
	
		// Recherche des infos sur cette tarification
	$sql = "SELECT id, date, caisse, medecin_inami, patient_id, mutuelle_code, patient_matricule, titulaire_matricule, type, ct1, ct2, tiers_payant, children, age, sex, etat, a_payer, paye, log FROM tarifications WHERE id='$urlID' and utilisation = 'tarification'";
	
	$result = requete_SQL ($sql);
	
	//on trouve une tarification
	if(mysql_num_rows($result)==1) {
	
		$data = mysql_fetch_assoc($result);
			
		$dataTarificationID = $data['id']; 
		$dataTarificationDate = $data['date'];
		$dataTarificationCaisse = $data['caisse'];
		$dataTarificationEtat = $data['etat'];
		$dataTarificationMedecinInami = $data['medecin_inami'];
		$dataTarificationPatientID= $data['patient_id'];
		$dataTarificationPatientMutuelleCode = $data['mutuelle_code'];
		$dataTarificationPatientCT1 = $data['ct1'];
		$dataTarificationPatientCT2 = $data['ct2'];
		$dataTarificationPatientMutuelleMatricule = $data['patient_matricule'];
		$dataTarificationTitulaireMutuelleMatricule = $data['titulaire_matricule'];
		$dataTarificationPatientType = $data['type'];
		$dataTarificationPatientTiersPayant = $data['tiers_payant'];
		$dataTarificationPatientChildren = $data['children']; 
		$dataTarificationPatientAge = $data['age'];
		$dataTarificationPatientSexe = $data['sex'];
		$dataTarificationLog = $data['log']; 
		
		// Recherche des infos sur ce patient
		$sql = "SELECT p.nom as patient_nom, p.prenom as patient_prenom, DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date_naissance, p.date_naissance as patient_date_naissance_standart, p.sexe as patient_sexe, p.rue as patient_rue, p.code_postal as patient_code_postal, p.commune as patient_commune, p.nationnalite as patient_nationnalite, p.telephone as patient_telephone, p.gsm as patient_gsm, p.mail as patient_mail, p.mutuelle_code as patient_mutuelle_code, p.mutuelle_matricule as patient_matricule, p.sis as patient_sis, p.ct1 as patient_ct1, p.ct2 as patient_ct2, p.tiers_payant as patient_tiers_payant, p.niss as patient_niss, p.titulaire_id as patient_titulaire_id, p.prescripteur as patient_prescipteur, t.nom as patient_titulaire_nom, t.prenom as patient_titulaire_prenom, t.mutuelle_matricule as patient_titulaire_matricule FROM patients p, patients t WHERE p.id ='$dataTarificationPatientID' and p.titulaire_id=t.id";
		
		$result = requete_SQL ($sql);
			
		// On trouve un patient
		if(mysql_num_rows($result)==1) {
			
			$data = mysql_fetch_assoc($result);
			
			$dataPatientTitulaireID= $data['patient_titulaire_id'];
			$dataPatientTitulaireNom= $data['patient_titulaire_nom'];
			$dataPatientTitulairePrenom= $data['patient_titulaire_prenom'];
			$dataPatientTitulaireMatricule= $data['patient_titulaire_matricule'];
			$dataPatientNom = $data['patient_nom'];
			$dataPatientPrenom = $data['patient_prenom']; 
			$dataPatientDateNaissance = $data['patient_date_naissance'];
			$dataPatientRue = $data['patient_rue'];
			$dataPatientCodePostal = $data['patient_code_postal'];
			$dataPatientCommune = $data['patient_commune'];
			$dataPatientNiss = $data['patient_niss'];
			$dataPatientSis = $data['patient_sis'];
			$dataPatientMatricule = $data['patient_matricule'];
			$dataPatientCt1 = $data['patient_ct1'];
			$dataPatientCt2 = $data['patient_ct2'];
			$dataPatientTiersPayant = $data['patient_tiers_payant'];
			$dataPatientMutuelleCode = $data['patient_mutuelle_code'];
			$dataPatientPrescripteur = $data['patient_prescipteur'];
			$dataPatientNationnalite = $data['patient_nationnalite'];
			$dataPatientSexe = $data['patient_sexe'];
			$dataPatientGsm = $data['patient_gsm'];
			$dataPatientMail = $data['patient_mail'];
			$dataPatientTelephone = $data['patient_telephone'];
			$datetools = new dateTools($data['patient_date_naissance_standart'],date("Y-m-d"));
			$dataPatientAge = $datetools->getAge();
						
		// On trouve pas un! patient
		} else {
		
		}
		
		// Recherche des infos sur ca mutuelle
		$sql = "SELECT nom FROM mutuelles WHERE ( code = '".$dataTarificationPatientMutuelleCode."')";
		
		$result = requete_SQL ($sql);
			
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);
			$dataMutuelleNom = $data['nom'];
	
		} else {
					
		}
		
		// Recherche des infos sur son medecin
		$sql = "SELECT nom, prenom, inami, specialite, taux_acte, taux_consultation FROM medecins WHERE ( inami = '".$dataTarificationMedecinInami."')";
		
		$result = requete_SQL ($sql);
			
		// On trouve un medecin
		if(mysql_num_rows($result)==1) {
			
			$data = mysql_fetch_assoc($result);
			
			$dataMedecinNom = $data['nom'];
			$dataMedecinPrenom =$data['prenom'];
			$dataMedecinINAMI = $data['inami'];
			$dataMedecinSpecialite = $data['specialite'];
			$dataMedecinTauxActe =$data['taux_acte'];
			$dataMedecinTauxConsul =$data['taux_consultation']; 
			
		// On trouve pas un ! medecin
		} else {
				
		}
		
		// tool date
		$datetools = new dateTools($dataTarificationDate,$dataTarificationDate);

		// titre patient
		$titrePatient = "Tarification du ".$datetools->transformDATE()." pour ".htmlentities($dataPatientNom)." ".htmlentities($dataPatientPrenom);
		$titrePatient .= " ( ".$dataTarificationPatientAge." ans - ";
		$titrePatient .= $dico['child'.$dataTarificationPatientChildren];
		$titrePatient .= " - ".$dico[$dataTarificationPatientType]." )"; 
		
		// informations patient
		$infoPatient = "<b>Patient : </b>".html_entity_decode($dataPatientNom)." ".html_entity_decode($dataPatientPrenom)."<br/>";	
		$infoPatient .= "<br/>";
		$infoPatient .= "<b>Mutuelle &agrave; l'encodage : </b>".$dataTarificationPatientMutuelleCode." - ".html_entity_decode($dataMutuelleNom)."<br/>";
		$infoPatient .= "<b>Age &agrave; l'encodage : </b>".$dataTarificationPatientAge." ans<br/>";
		$infoPatient .= "<b>Cat&eacute;gorie &agrave; l'encodage : </b>".$dico['child'.$dataTarificationPatientChildren]."<br/>";
		$infoPatient .= "<b>Assurabilit&eacute; &agrave; l'encodage : </b>".$dataTarificationPatientCT1." / ".$dataTarificationPatientCT2." - ".$dico[$dataTarificationPatientType]."<br/>";
		$infoPatient .= "<b>Matricule patient &agrave; l'encodage : </b>".$dataTarificationPatientMutuelleMatricule."<br/>";
		$infoPatient .= "<b>Matricule titulaire &agrave; l'encodage : </b>".$dataTarificationTitulaireMutuelleMatricule."<br/>";
		$infoPatient .= "<br/>";
		
		$infoPatient .= "<b>Sexe : </b>".$dico[$dataPatientSexe]."<br/>";
		$infoPatient .= "<b>Age : </b>".$dataPatientAge." ans<br/>";
		$infoPatient .= "<b>Titulaire : </b>".html_entity_decode($dataPatientTitulaireNom)." ".html_entity_decode($dataPatientTitulairePrenom)."<br/>";	
		$infoPatient .= "<b>Matricule du patient : </b>".html_entity_decode($dataPatientMatricule)."<br/>";	
		$infoPatient .= "<b>Matricule du titulaire : </b>".html_entity_decode($dataPatientTitulaireMatricule)."<br/>";
		$infoPatient .= "<b>Assurabilit&eacute; : </b>".$dataPatientCt1." / ".$dataPatientCt2." - Tiers payant : ".$dico['tiers_payant'.$dataPatientTiersPayant]."<br/>";
		$infoPatient .= "<b>Mutuelle : </b>".$dataPatientMutuelleCode."<br/>";
		$infoPatient .= "<b>NISS : </b>".$dataPatientNiss."<br/>";
		$infoPatient .= "<b>SIS : </b>".$dataPatientSis."<br/>";
		
		$infoPatient .= "<b>Adresse : </b>".html_entity_decode($dataPatientRue)." ".html_entity_decode($dataPatientCodePostal)." ".html_entity_decode($dataPatientCommune)."<br/>";	
		$infoPatient .= "<b>T&eacute;l&eacute;phone fixe : </b>".$dataPatientTelephone."<br/>";
		$infoPatient .= "<b>T&eacute;l&eacute;phone mobile (gsm) : </b>".$dataPatientGsm."<br/>";
		$infoPatient .= "<b>Adresse e-mail : </b>".$dataPatientMail."<br/>";
		$infoPatient .= "<b>Nationnalit&eacute; : </b>".html_entity_decode($dataPatientNationnalite)."<br/>";
		$infoPatient .= "<b>Prescripteur : </b>".html_entity_decode($dataPatientPrescripteur)."<br/>";
		
		// titre medecin
		$titreMedecin = htmlentities($dataMedecinNom)." ".htmlentities($dataMedecinPrenom);
		
		//$infoMedecin
		$infoMedecin = "<b>Sp&eacute;cialit&eacute : </b>".$dataMedecinSpecialite."<br/>";
		$infoMedecin .= "<b>Taux consultation : </b>".$dataMedecinTauxConsul."% - ";
		$infoMedecin .= "<b>Taux acte : </b>".$dataMedecinTauxActe."%<br/>";
		
	//on pas trouve une ! tarification
	} else {
		
	}
	
	$sql = "SELECT td.id as id, td.tarification_id as tarification_id, td.cecodi as cecodi, td.propriete as propriete, td.description as description, td.kdb as kdb, td.bc as bc, td.hono_travailleur as hono_travailleur, td.a_vipo as a_vipo, td.b_tiers_payant as b_tiers_payant, td.cout as cout,  td.caisse as caisse, t.etat as etat FROM tarifications_detail td, tarifications t WHERE ( td.tarification_id = t.id) AND ( td.tarification_id = $urlID) order by 1";
	$result = requete_SQL ($sql);
	
	if(mysql_num_rows($result)!=0) {
										
		$cecodi =  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
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
	
	
	echo "<h1>".$titrePatient."</h1>";
	
	echo $infoPatient;

	echo "<h1>".$titreMedecin."</h1>";
	
	echo $infoMedecin;

	echo "<h1>Prestations</h1>";
	
	echo $cecodi;

	echo "<h1>Detail des actions</h1>";
	
	echo $dataTarificationLog;
	
	deconnexion_DB();

?>




 