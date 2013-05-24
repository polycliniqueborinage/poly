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

	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Nom du fichier en cours 
	$nom_fichier = "modif_tarification.php";
	//dico
	$dico = array('vpia' =>'Vipo Ind&eacute;p Assur&eacute;', 'vpisa'=>'Vipo Ind&eacute;p Non Assur&eacute;', 'sm' => 'Sans Mutuelle', 'as' => 'Assurance (Sans Mutuelle)', 'tp' => 'Tiers payant', 'tr' => 'Travailleur', 'vp' => 'Vipo', 'child0' => 'Adulte', 'child1' => 'Enfant', 'tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	// current role
	$role = $_SESSION['role'];
	
	// redirection
	$_SESSION['redirect'] = $nom_fichier;	
	
	// from url
	if (isset($_GET['id'])) {
		$formTarificationID = $_GET['id'];
		unset ($_SESSION['tarification_id']);
	} else {
		// from session
		if (isset($_SESSION['tarification_id'])) {
			$formTarificationID= $_SESSION['tarification_id'];
			unset ($_SESSION['tarification_id']);
		} else {
			header('Location: ../tarifications/recherche_tarification.php');
			die();
		}
	}

	// iframe pour le protocole
	//$iframe  = "";
	// Creation du protocole par une iframe
	//if (isset($_SESSION['protocole_url'])) {
	//	$formProtocoleUrl = $_SESSION['protocole_url'];
	//	// just one time
	//	unset($_SESSION['protocole_url']);
	//	if ($formProtocoleUrl !='') {
	//		$iframe = "<iframe name='' SRC='$formProtocoleUrl' scrolling='no' height='150' width='107' FRAMEBORDER='no'></iframe>";
	//		//echo $iframe;
	//	}
	//}
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Recherche des infos sur cette tarification
	$sql = "SELECT id, date, caisse, medecin_inami, patient_id, mutuelle_code, patient_matricule, titulaire_matricule, type, ct1, ct2, tiers_payant, children, age, sex, etat, a_payer, paye, log FROM tarifications WHERE id='$formTarificationID' and utilisation = 'tarification'";
	
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
		
			if (isset($_SESSION['tarification_id'])) unset ($_SESSION['tarification_id']);
			$_SESSION['information']="Erreur dans la lecture des informations du patient ! ($dataTarificationPatientID)";
			header('Location: ../menu/menu.php');
		}
		
		// Recherche des infos sur ca mutuelle
		$sql = "SELECT nom FROM mutuelles WHERE ( code = '".$dataTarificationPatientMutuelleCode."')";
		
		$result = requete_SQL ($sql);
			
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);
			$dataMutuelleNom = $data['nom'];
	
		} else {
		
			if (isset($_SESSION['tarification_id'])) unset ($_SESSION['tarification_id']);
			$_SESSION['information']="Erreur dans la lecture des informations de la mutuelle ($dataTarificationPatientMutuelleCode)!";
			header('Location: ../menu/menu.php');
					
		}
		
		// Recherche des infos sur son medecin
		$sql = "SELECT m.nom as nom, m.prenom as prenom, m.inami as inami, s.specialite as specialite, m.taux_acte as taux_acte, m.taux_consultation as taux_consultation, m.taux_prothese as taux_prothese, m.comment, m.telephone_travail as telephone_travail, m.telephone_prive as telephone_prive, m.telephone_mobile as telephone_mobile  FROM medecins m, specialites s WHERE m.specialite = s.id AND ( inami = '".$dataTarificationMedecinInami."')";
		
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
			$dataMedecinTauxProthese =$data['taux_prothese']; 
			$dataMedecinComment =$data['comment'];
			$dataMedecinTelephonePrive = $data['telephone_travail'];
			$dataMedecinTelephoneMobile = $data['telephone_travail'];
			$dataMedecinTelephonePrive = $data['telephone_prive'];
			$dataMedecinMail = $data['mail'];
			$dataMedecinFax = $data['fax'];
			$dataMedecinComment = $data['comment'];
			
		// On trouve pas un ! medecin
		} else {

			if (isset($_SESSION['tarification_id'])) unset ($_SESSION['tarification_id']);
			header('Location: ../menu/menu.php');
				
		}
		
		// tool date
		$datetools = new dateTools($dataTarificationDate,$dataTarificationDate);

		//mise en session
		$_SESSION['tarification_id'] = $dataTarificationID; 
		$_SESSION['tarification_type'] = $dataTarificationPatientType;
		$_SESSION['tarification_children'] = $dataTarificationPatientChildren;
		$_SESSION['tarification_sex'] = $dataTarificationPatientSexe;
		$_SESSION['tarification_age'] = $dataTarificationPatientAge;
		$_SESSION['taux_consultation'] = $dataMedecinTauxConsul;
		$_SESSION['taux_acte'] = $dataMedecinTauxActe;
		
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
		
		$infoPatient .= "<div id='pic'><img width='70' height='100' alt='' src='../images/thumb.jpg'/></div>";

		// titre medecin
		$titreMedecin = htmlentities($dataMedecinNom)." ".htmlentities($dataMedecinPrenom);
		$titreMedecin .= " - Sp&eacute;cialit&eacute; = ".htmlentities($dataMedecinSpecialite); 
		
		//$infoMedecin
		$infoMedecin = "<b>Sp&eacute;cialit&eacute : </b>".$dataMedecinSpecialite."<br/>";
		$infoMedecin .= "<b>Taux consultation : </b>".$dataMedecinTauxConsul."%<br/>";
		$infoMedecin .= "<b>Taux acte : </b>".$dataMedecinTauxActe."%<br/>";
		$infoMedecin .= "<b>Taux proth&egrave;se : </b>".$dataMedecinTauxProthese."%<br/>";
		$infoMedecin .= "<b>T&eacute;l&eacute;phone travail : </b>".$dataMedecinTelephoneTravail."<br/>";
		$infoMedecin .= "<b>T&eacute;l&eacute;phone mobile : </b>".$dataMedecinTelephoneMobile."<br/>";
		$infoMedecin .= "<b>T&eacute;l&eacute;phone priv&eacute; : </b>".$dataMedecinTelephonePrive."<br/>";
		$infoMedecin .= "<b>Fax : </b>".$dataMedecinFax."<br/>";
		$infoMedecin .= "<b>Mail : </b>".$dataMedecinMail."<br/>";
		$infoMedecin .= "<b>Commentaire : </b>".$dataMedecinComment."<br/>";
		
	//on pas trouve une ! tarification
	} else {
		
		if (isset($_SESSION['tarification_id'])) { unset ($_SESSION['tarification_id']);}
		$_SESSION['information']="Erreur dans la lecture des informations sous la tarification !";
		header('Location: ../menu/menu.php');
		
	}
	
	// Gestion des etiquettes
	$_SESSION['impression_medecin_last_name'] = $dataMedecinNom;
	$_SESSION['impression_medecin_first_prenom'] = $dataMedecinPrenom;
	$_SESSION['impression_medecin_inami'] = $dataMedecinINAMI;
	
	$_SESSION['impression_tarification_mutuelle_code'] = $dataTarificationPatientMutuelleCode;
	$_SESSION['impression_tarification_ct1'] = $dataTarificationPatientCT1;
	$_SESSION['impression_tarification_ct2'] = $dataTarificationPatientCT2;
	$_SESSION['impression_tarification_patient_mutuelle_matricule'] = $dataTarificationPatientMutuelleMatricule;
	$_SESSION['impression_tarification_titulaire_mutuelle_matricule'] = $dataTarificationTitulaireMutuelleMatricule;
	$_SESSION['impression_tarification_patient_type'] = $dataTarificationPatientType;
	$_SESSION['impression_tarification_patient_children'] = $dataTarificationPatientChildren;
	$_SESSION['impression_tarification_patient_age'] = $dataTarificationPatientAge;
	$_SESSION['impression_tarification_patient_sex'] = $dataTarificationPatientSexe;
	$_SESSION['impression_tarification_patient_tiers_payant'] = $dataTarificationPatientTiersPayant;
	
	$_SESSION['impression_patient_last_name'] = $dataPatientNom;
	$_SESSION['impression_patient_first_prenom'] = $dataPatientPrenom;
	$_SESSION['impression_patient_birthday'] = $dataPatientDateNaissance;
	$_SESSION['impression_patient_addresse'] = $dataPatientRue." ".$dataPatientCodePostal."".$dataPatientCommune;
	$_SESSION['impression_patient_niss'] = $dataPatientNiss;
	$_SESSION['impression_patient_sis'] = $dataPatientSis;
	
	deconnexion_DB();
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Reprise d'une tarification</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<script type="text/javascript" src="../js/submit_validatorv.js"> </script>
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		echo "<li class='yuimenuitem'>Patients";
		echo "	<div id='patient2' class='yuimenu'>";
		echo "		<div class='bd'>";
		echo "			<ul class='first-of-type' id='patientmenu'>";
		echo "				<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/modif_patient.php?id=$dataTarificationPatientID'>Modification du patient ($dataPatientNom $dataPatientPrenom)</a></li>";
		echo "				<li class='yuimenuitem'><a class='yuimenuitemlabel' href='../patients/modif_patient.php?id=$dataPatientTitulaireID'>Modification du titulaire ($dataPatientTitulaireNom $dataPatientTitulairePrenom)</a></li>";
		echo "			</ul>";
		echo "		</div>";
		echo "	</div>  ";
		echo "</li>";
		get_MENUBAR_END();
	?>
	
    <div id="top">
		
		<h1>Tarifications - Reprise d'une tarification</h1>

	</div>

	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('tarifications')?>
	    	</ul>
		</div>        
     
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
					
					<a href="./add_tarification.php">Ajout</a>

    				<span>Reprise derni&egrave;re tarification</span> 

					<a href="./recherche_tarification.php">Recherche</a>

					<a href="./listing_tarification_day.php">Tarifications du jour</a>
	  				
	  				<a href="./listing_tarification.php">Tarifications encours</a>
														
				</div>
										
				<div class="ViewPane">

					<div class="navigation-hight">
							
						<div id='formhelp'>
							<font color="red"><b>Il n'est plus possible de modifier les matricules mutuelles, le type du patient (Vipo,...) et la mutuelle du patient</b></font>.<br />
						</div>
					
						<div id='BoxTitlePatient' class="patient" onclick="javascript:Element.toggle('BoxContentPatient');changeClassBox('patientImageLeft','openBox','closeBox')">
							<?=$titrePatient?>
							<div id="patientImageLeft" class="openBox"><a href="#"></a></div>
						</div>

						<div id='BoxContentPatient' style='display: none;'>
							<?=$infoPatient?>
						</div>
						
						<div id='BoxTitleMedecin' class="medecin" onclick="javascript:Element.toggle('BoxContentMedecin');changeClassBox('medecinImageLeft','openBox','closeBox')">
							<?=$titreMedecin?>
							<div id="medecinImageLeft" class="openBox"><a href="#"></a></div>
						</div>

						<div id='BoxContentMedecin' style='display: none;'>
							<?=$infoMedecin?>
						</div>
						
					</div>
						
					<?
						if (strpos($dataTarificationEtat, "close")===false) {
					?>
						
						<div id='BoxAddCecodi' class="cecodi">
		
		
								<form action="" name="myform" >
							
								<table border="1" cellspacing="0" cellpadding="0">

									<tr>
										<th class='formLabel'>Cecodi</th>
										<td class='formInput'>
											<input type='text' name='' id='cecodi_input'  class='txtField' title='Cecodi' autocomplete='off' maxlength='6' onKeyUp='javascript:valeurcecodi = checkNumber(this, valeurcecodi, 6, false);tarificationCheckCecodi(this.value);' />
											&nbsp;&nbsp;&nbsp;
											<select id='cecodi_number' name='cecodi_number' title='Nombre de prestation INAMI' width="40px" style="width: 40px">
												<option value='1'>1</option>
												<option value='2'>2</option>
												<option value='3'>3</option>
												<option value='4'>4</option>
												<option value='5'>5</option>
												<option value='6'>6</option>
												<option value='7'>7</option>
												<option value='8'>8</option>
												<option value='9'>9</option>
												<option value='10'>10</option>
											</select>
											&nbsp;&nbsp;&nbsp;
											<input type='checkbox' name='cecodi_input_check' id='cecodi_input_check' value='check' > Code Inami non signal&eacute; par le m&eacute;decin					
										</td>
									</tr>
									<tr>
										<th class='formLabel'>Description</th>
										<td>
											<div id='cecodi_desc'>
											</div>					
										</td>
									</tr>
									<tr>
										<th class='formLabel'>Acte</th>
										<td class='formInput'>
											<select id='acte_input' name='acte_input' title='Acte technique' width="415px" style="width: 415px">
												<option value='0'>Choisir</option>
													<?php
														connexion_DB('poly');
														$sql = 'SELECT * FROM actes ORDER BY description';
														$result = requete_SQL ($sql);
														while($data = mysql_fetch_assoc($result)) 	{
															// on affiche les specialité
   				 											echo "<option value='";
															echo $data['id'];
															echo "' >";
															echo htmlentities($data['code']." - ".$data['description']);
															echo "</option>";
														}	 
														deconnexion_DB()
													?>
											</select>
											&nbsp;&nbsp;&nbsp;
											<select id='acte_number' name='acte_number' title="Nombre d'acte interne" width="40px" style="width: 40px">
												<option value='1'>1</option>
												<option value='2'>2</option>
												<option value='3'>3</option>
												<option value='4'>4</option>
												<option value='5'>5</option>
												<option value='6'>6</option>
												<option value='7'>7</option>
												<option value='8'>8</option>
												<option value='9'>9</option>
												<option value='10'>10</option>
											</select>
											&nbsp;&nbsp;&nbsp;
										</td>
									</tr>
									<tr>
										<th class='formLabel'><label for='validation'><br /></label>
										</th>
										<td class='formInput'>
										<input type="submit" class="button" value="Valider" />
										</td>
									</tr>
								</table>
								
							</form>
							<script language="JavaScript" type="text/javascript">
							var frmvalidator  = new Validator("myform");
							</script>
							
							
						</div>
														
					<?
						}
					?>
						
						<div id="BoxListCecodi">
						</div>
				
						<div id="BoxCaisse" class="caisse">
		
							<form id='caisseForm' name='caisseForm'>
							
								<table border='1' cellspacing='0' cellpadding='0'>
									<tr>
										<td class='big'>Reste &agrave; payer = </td>
										<td class='big'><input type='text' name='reste_paye' id='reste_paye' size='10' maxlength='10' class='txtField' title='Reste &agrave; payer' value='' onKeyUp='javascript:reste_paye_valeur = checkAmount(this, reste_paye_valeur, 10, 2, false);' autocomplete='off'/></td>
										<td class='big'>Total &agrave; payer = </td>
										<td class='big' id='a_payer'></td>
										<td class='big'>D&eacute;j&agrave pay&eacute; = </td>
										<td class='big' id='deja_paye'></td>
									</tr>
								</table>
							</form>
								
							<div id="buttonBox">
							</div>
								
						</div>	
						
					<div id="calendarSideBar" class="">
						<?php echo $dataTarificationLog; ?>
					</div>
						
				</div>

			</div>

		</div>

	</div>
   	
	<div id="left">
	
		<table id="left-drawer" cellpadding="0" cellspacing="0">
	    	<tr>
				<!-- CONTENT -->
    	    	<td class="drawer-content">
				
					<a class="taskControl" href="../tarifications/listing_tarification.php">Tarifications du jour</a>
				
					<div class="sidebar labels-green">

						<a onclick="javascript:if($('tarificationDayList').innerHTML==''){ loadTarification ('new_tarification','','tarificationDayList','findNewTarificatonInput'); };Element.toggle('addLabelFormNewTarification');Element.hide('addLabelFormOldTarification');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormNewTarification" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findNewTarificatonInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript:loadTarification('new_tarification',this.value,'tarificationDayList','findNewTarificatonInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="tarificationDayList"></div>
						</div>

					</div>
					
					<a class="taskControl" href="../tarifications/listing_tarification.php">Tarifications ant&eacute;rieures</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="javascript:if($('tarificationOldList').innerHTML==''){ loadTarification ('old_tarification','','tarificationOldList','findOldTarificatonInput');};Element.toggle('addLabelFormOldTarification');Element.hide('addLabelFormNewTarification');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormOldTarification" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findOldTarificatonInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript:loadTarification('old_tarification',this.value,'tarificationOldList','findOldTarificatonInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="tarificationOldList"></div>
						</div>
						
					</div>
					
					<a class="taskControl" href="#">Etiquettes</a>
			
					<div class="sidebar labels-red">
					
						<h2>Nombre :</h2>

						<select name='etiquette' id='etiquette' width="179" style="width: 179px" onClick="document.getElementById('etiquette').style.pixelWidth = 179" onchange='javascript:etiquettePrint(this.value);'>
							<option value='0'>&eacute;tiquettes...</option>
							<option value='1'>1 &eacute;tiquette</option>
							<option value='2'>2 &eacute;tiquettes</option>
							<option value='3'>3 &eacute;tiquettes</option>
							<option value='4'>4 &eacute;tiquettes</option>
							<option value='5'>5 &eacute;tiquettes</option>
							<option value='3'>6 &eacute;tiquettes</option>
							<option value='10'>10 &eacute;tiquettes</option>
							<option value='15'>15 &eacute;tiquettes</option>
						</select>
					
					</div>
					
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/edit.png'>
 					</div>
				</td>
  			    	
				<td class="drawer-handle" onclick="toggleSidebars(); return false;">
           			<div class="top-corner"></div>
           			<div class="bottom-corner"></div>
       	   	 	</td>
				
      		</tr>
		</table>
	</div>

	<div id="paiement_confirm" style="display:none">  
	    <p>
			Faites votre choix dans cette liste : 
	   	</p>
		<form id='liste' name='liste'>
			<SELECT id='paiement_type' name='paiement_type'>
				<OPTION value="">Votre choix ...</OPTION>
				<OPTION value="espece">Paiement en esp&egrave;ce</OPTION>
				<OPTION value="banksys">Paiement par bancontact</OPTION>
			</SELECT>
		</form>
	</div>
	
	<div id="cecodi_confirm" style="display:none">  
		 <p>
			Choisir un code INAMI pour remplacer le code interne
	   	</p>
		<input type='text' name='popup_cecodi' id='popup_cecodi' size='6' maxlength='6' class='txtField' autocomplete='off' value='' onKeyUp='javascript:valeurcecodipopup = checkNumber(this, valeurcecodipopup, 6, false);tarificationCheckCecodiPopUp(this.value);'>
		<div id = 'popup_description'>
		<br/><br/><br/><br/><br/><br/>
		</div>
	</div>
		
	<div id="etiquetteLabel">
	</div>
	
	<!-- MENU JS -->
	<script type="text/javascript" src="../yui/build/menu.js"></script>
    <script type="text/javascript">
    	YAHOO.util.Event.onContentReady("productsandservices", function () {
        	var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                            autosubmenudisplay: true, 
                                                            hidedelay: 1000, 
                                                            lazyload: false });

			oMenuBar.render();
		});
	</script>
	
	<!-- ALL JS -->
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src='../js/tarification_prothese.js'></script>
	<script type='text/javascript' src='../js/tarification.js'></script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	
	<script type="text/javascript">  
		var reste_paye_valeur = '';
		var valeurcecodi='';
		var valeurcecodipopup = '';
		submitForm('');
		var help = new Window('1', {className: "alphacube", title: "Aide en ligne", top:0, right:0, width:500, height:300});  
  		var notice = new Window('2', {className: "alphacube", title: "Notice", top:20, right:20, width:500, height:300 });  
		function openHelp() {
	  		help.setURL("../lib/aide_en_ligne.php?type=aide&id=<?=$nom_fichier?>");
	  		help.show();
		}
		function openNotice(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=notice&id="+id);
	  		notice.show();
		}
	  	function tarificationCecodiChange(html,id) {
	  		Dialog.confirm($('cecodi_confirm').innerHTML, {className:"alphacube", top:50, width:500, okLabel: "OK", cancelLabel: "Annuler",  buttonClass: "myButtonClass",  onOk:function(win){tarificationCecodiChangeConfirm(id);return true;}});
  		}
	  	function tarificationPayer(html,id) {
	  		Dialog.confirm($('paiement_confirm').innerHTML, {className:"alphacube", top:50, width:400, okLabel: "OK", cancelLabel: "Annuler",  buttonClass: "myButtonClass", onOk:function(win){tarificationPayerConfirm(id);return true;}});
  		}
	  	function openDialogConfirmCloture(id) {
  			Dialog.confirm("Vouler vous cloturer cette tarification ?<br>", {width:300, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {tarificationCloturer(id); return true;} });
		}
	  	function openAlert(comment) {
  			Dialog.alert(comment, {width:300, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", ok:function(win) {return true;} });
		}
	</script>

</body>
</html>