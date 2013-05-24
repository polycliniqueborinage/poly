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
	$nom_fichier = "modif_anomalie.php";
	//dico
	$dico = array('vpia' =>'Vipo Ind&eacute;p Assur&eacute;', 'vpisa'=>'Vipo Ind&eacute;p Non Assur&eacute;', 'sm' => 'Sans Mutuelle', 'tp' => 'Tiers payant', 'tr' => 'Travailleur', 'vp' => 'Vipo', 'child0' => 'Adulte', 'child1' => 'Enfant', 'tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	// current role
	$role = $_SESSION['role'];
	// Link to the webapp INAMI
	$url = "https://www.riziv.fgov.be/webapp/nomen/Honoraria.aspx?lg=F&id=";
	
	
	// from url
	if (isset($_GET['id'])) {
		$formTarificationID = $_GET['id'];
		unset ($_SESSION['anomalie_id']);
	} else {
		// from session
		if (isset($_SESSION['anomalie_id'])) {
			$formTarificationID= $_SESSION['anomalie_id'];
			unset ($_SESSION['anomalie_id']);
		} else {
			header('Location: ../tarifications/recherche_tarification.php');
			die();
		}
	}

	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	
	// Variables du formulaire
	$formModifAnomalie = isset($_POST['actionModifAnomalie']) ? $_POST['actionModifAnomalie'] : '';
	
	// Validation des variables
	if ($formModifAnomalie == 1) {
		
		// text are
		$formTextArea = isset($_POST['TextArea1']) ? $_POST['TextArea1'] : '';
		$formTextArea = addslashes($formTextArea);
		
		$sql = "UPDATE anomalies SET textcomment='$formTextArea' WHERE id='$formTarificationID'";
		$result = requete_SQL ($sql);
       	       	
	}
	
	
	// Recherche des infos sur cette tarification
	$sql = "SELECT a.id as anomalie_id, a.etat as anomalie_etat, DATE_FORMAT(a.cloture, GET_FORMAT(DATE, 'EUR')) as anomalie_cloture, a.log as anomalie_log, a.textcomment as anomalie_textcomment, t.id as id, t.date as date, t.caisse as caisse, t.medecin_inami as medecin_inami, t.patient_id as patient_id, t.mutuelle_code as mutuelle_code, t.patient_matricule as patient_matricule, t.titulaire_matricule as titulaire_matricule, type, t.ct1 as ct1, t.ct2 as ct2, t.tiers_payant as tiers_payant, t.children as children, t.age as age, t.sex as sex, t.etat as etat, t.a_payer as a_payer, t.paye as paye, t.log as log FROM tarifications t, anomalies a WHERE t.id = a.tarification_id AND a.id='$formTarificationID'";
	
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

		$dataAnomalieLog = $data['anomalie_log']; 
		$dataAnomalieEtat = $data['anomalie_etat']; 
		$dataAnomalieTextComment = $data['anomalie_textcomment'];
		
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
		
			if (isset($_SESSION['anomalie_id'])) unset ($_SESSION['anomalie_id']);
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
		
			if (isset($_SESSION['anomalie_id'])) unset ($_SESSION['anomalie_id']);
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
			$dataMedecinTauxConsul =$data['taux_prothese']; 
			$dataMedecinComment =$data['comment'];
			$dataMedecinTelephonePrive = $data['telephone_travail'];
			$dataMedecinTelephoneMobile = $data['telephone_travail'];
			$dataMedecinTelephonePrive = $data['telephone_prive'];
			$dataMedecinMail = $data['mail'];
			$dataMedecinFax = $data['fax'];
			$dataMedecinComment = $data['comment'];
			
		// On trouve pas un ! medecin
		} else {

			if (isset($_SESSION['anomalie_id'])) unset ($_SESSION['anomalie_id']);
			header('Location: ../menu/menu.php');
				
		}
		
		// recherche des informations sur les prestations
		$sql = "SELECT td.id as id, td.tarification_id as tarification_id, td.cecodi as cecodi, td.propriete as propriete, td.description as description, td.kdb as kdb, td.bc as bc, td.hono_travailleur as hono_travailleur, td.a_vipo as a_vipo, td.b_tiers_payant as b_tiers_payant, td.cout as cout,  td.caisse as caisse, t.etat as etat FROM tarifications_detail td, tarifications t WHERE ( td.tarification_id = t.id) AND ( td.tarification_id = $formTarificationID) order by 1";
		$result = requete_SQL ($sql);
		
		if(mysql_num_rows($result)!=0) {
											
			$infoCecodi .=  "<table class='formTable simple'  id='' border='0' cellpadding='2' cellspacing='1'>";
			$infoCecodi .= "<th>CECODI</th>";
			$infoCecodi .= "<th>KDB</th>";
			$infoCecodi .= "<th>BC</th>";
			$infoCecodi .= "<th>HONO</th>";
			$infoCecodi .= "<th>VIPO</th>";
			$infoCecodi .= "<th>TIERS</th>";
			$infoCecodi .= "<th>Co&ucirc;t</th>";
			$infoCecodi .= "<th>Caisse</th>";
			
			while($data = mysql_fetch_assoc($result)) 	{
			
				// on affiche les informations de l'enregistrement en cours
				$infoCecodi .= "<tr>";
	
				// CECODI
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				if ($data['cecodi'] != '0') {
					$infoCecodi .= "<a target='_blank' href='".$url.$data['cecodi']."' title='".strtoupper($data['propriete'])." ".htmlentities($data['description'])."'>".$data['cecodi']."</a>";
				} else {
					$infoCecodi .= "<a href='#' title='".strtoupper($data['propriete'])." ".htmlentities($data['description'])."'>".htmlentities($data['description'])."</a>";
				}
				$infoCecodi .= "</td>";
			
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['kdb']."</td>";
		
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['bc']."</td>";
	
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['hono_travailleur']."</td>";
		
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['a_vipo']."</td>";
			
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['b_tiers_payant']."</td>";
			
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['cout']."</td>";
			
				$infoCecodi .= "<td align='center' bgcolor='#d5d5d5' valign='top' width='16'>";
				$infoCecodi .= $data['caisse']."</td>";
				
				$infoCecodi .= "</tr>";
				
			}
		
			$infoCecodi .= "</table>";
	
		}
		
		// tool date
		$datetools = new dateTools($dataTarificationDate,$dataTarificationDate);

		//mise en session
		$_SESSION['anomalie_id'] = $formTarificationID; 
		
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
		
		if (isset($_SESSION['anomalie_id'])) { unset ($_SESSION['anomalie_id']);}
		$_SESSION['information']="Erreur dans la lecture des informations sous la tarification !";
		header('Location: ../menu/menu.php');
		
	}
	
	
	deconnexion_DB();
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Reprise d'une anomalie</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<script type="text/javascript" src="../js/submit_validatorv.js"> </script>
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Anomalies - Modification d'une anomalie</h1>

	</div>

	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Anomalies</a>
				</li>
        	</ul>
		</div>        
     
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
					<a href="./recherche_anomalie.php">Recherche</a>

					<a href="./add_anomalie.php">Ajout</a>

    				<span>Modification anomalie</span> 

	  				<a href="./listing_anomalie.php">Anomalie en cours</a>
								
				</div>
										
				<div class="ViewPane">

					<div class="navigation-hight">
							
						<div id='BoxTitlePatient' class="patient" onclick="javascript:Element.toggle('BoxContentPatient');//change_class_box('patientImageLeft','open','close')">
							<?=$titrePatient?>
							<div id="patientImageLeft" class="open"><a href="#"></a></div>
						</div>

						<div id='BoxContentPatient' style='display: none;'>
							<?=$infoPatient?>
						</div>
						
						<div id='BoxTitleMedecin' class="medecin" onclick="javascript:Element.toggle('BoxContentMedecin');//change_class_box('medecinImageLeft','open','close')">
							<?=$titreMedecin?>
							<div id="medecinImageLeft" class="open"><a href="#"></a></div>
						</div>

						<div id='BoxContentMedecin' style='display: none;'>
							<?=$infoMedecin?>
						</div>
						
						<div id='BoxTitleAcompte' onclick="javascript:Element.toggle('BoxContentAcompte');">
							D&eacute;tail des prestations
							<div id="medecinImageLeft" class="open"><a href="#"></a></div>
						</div>

						<div id='BoxContentAcompte' style='display: none;'>
							<?=$infoCecodi?>
						</div>
					
					</div>
					
					<div id="secondheader">
        				<ul id="sec_primary_tabs">
        					<li id="sec_li_2" class="nodelete">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(1);">Statut</a>
		 			 		</li>
		 			 		<li id="sec_li_3" class="nodelete">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(2);">Info</a>
		 			 		</li>
        				</ul>
					</div>
						
					<div id="secondmain" class="formBox">
						
						<form name='actionGestionCodeTarificationForm' id='actionGestionCodeTarificationForm' method='post' action='<?=$nom_fichier?>'>

							<input type='hidden' name='actionModifAnomalie' value='1'>

							<table id='general'  border='1' cellspacing='0' cellpadding='0'>
							
								<tr>
									<th>Raison 1</th>
									<td class='formInput'>
										<input type='checkbox' name='raison1' id='raison1' value='checked'>Raison 1
									</td>
								</tr>
								
								<tr>
									<th>Raison 1</th>
									<td class='formInput'>
										<input type='checkbox' name='raison1' id='raison1' value='checked'>Raison 1
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
								
							<table id='information'  border='1' cellspacing='0' cellpadding='0' style="display: none;">
							
							<!-- style='width:100%;display:none' -->
								
								<tr id='link'>
									<th colspan='2'><a href='#' onclick="javascript:editComment();return false;">Edition</a></th>
								</tr>
								
								<tr id='resumeText'>
									<th colspan='2'><?=$dataAnomalieTextComment?></th>
								</tr>
								
								<tr id='globalText' style="display: none;">
									<th colspan='2'>
									<textarea id='TextArea1' name='TextArea1' rows='10' cols='100' >
									 	<?=$dataAnomalieTextComment?>
									</textarea>
								</th>
								</tr>
	
									
								<tr>
									<th class='formLabel'><label for='validation'><br /></label>
									</th>
									<td class='formInput'>
									<input type="submit" class="button" value="Valider" />
									</td>
								</tr>
												
								<!-- Nom -->
																				
							</table>
								
						</form>
							
					</div>
						
					<div id="calendarSideBar" class="">
						<?=$dataAnomalieLog?>
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

	<div id="anomalie_confirm" style="display:none">  
		 <p>
			Choisir un code INAMI pour remplacer le code interne
	   	</p>
		<input type='text' name='popup_cecodi' id='popup_cecodi' size='6' maxlength='6' class='txtField' autocomplete='off' value='' onKeyUp='javascript:valeurcecodipopup = checkNumber(this, valeurcecodipopup, 6, false);tarificationCheckCecodiPopUp(this.value);'>
		<div id = 'popup_description'>
		<br/><br/><br/><br/><br/><br/>
		</div>
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
	
	<!-- EDITEUR JS -->
	<script type="text/javascript">
		var _editor_url = document.location.href.replace(/modif_anomalie\.php.*/, '');
		var _editor_lang = "fr";
		var titrelabel = "titre";  
	</script>
	<script type="text/javascript" src="../areaedit/htmlarea-min.js"></script>
	<script type="text/javascript">
		areaedit_init = function(){
			if ( HTMLArea.is_ie && document.readyState != "complete" ){
				setTimeout( function() { areaedit_init()}, 50 );
				return false;
			}
			HTMLArea.init();
			var areaedit_plugins_minimal = ['ContextMenu'];
			if ( !HTMLArea.loadPlugins( areaedit_plugins_minimal, areaedit_init)){
				return;
			}
			areaedit_editors = ['TextArea1'];
			areaedit_config = new HTMLArea.Config();
			areaedit_editors   = HTMLArea.makeEditors(areaedit_editors, areaedit_config, areaedit_plugins_minimal);
			areaedit_editors.TextArea1.config.width  = 600;
       		areaedit_editors.TextArea1.config.height = 400;
			HTMLArea.startEditors(areaedit_editors);
    	}
 		var submitHandler = function(formname) {
			var form = document.getElementById(formname);
			form.onsubmit(); 
			form.submit();
		}
  	</script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	
	<script type="text/javascript">  
		var reste_paye_valeur = '';
		var valeurcecodi='';
		var valeurcecodipopup = '';
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
	
		<!-- ALL JS -->
	<script type="text/javascript" src="../js/common.js"></script>
	<script type='text/javascript' src='../js/anomalie.js'></script>
	

</body>
</html>