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
	
	//vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
    $rate= new rateTool();
        
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
	
	// Fonction de connexion a la base de donnees
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "add_patient_titulaire.php";
	
	// Variables du formulaire
	$actionPatientTitulaire = isset($_POST['actionPatientTitulaire']) ? $_POST['actionPatientTitulaire'] : '';  
        
    $formNom = isset($_POST['nom']) ? $_POST['nom'] : '';
	$formNom = ucfirst(strtolower($formNom));
	$formNom = $test->convert($formNom);
	
	$formPrenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
	$formPrenom = ucfirst(strtolower($formPrenom));
	$formPrenom = $test->convert($formPrenom);
	
	$formDateNaissance = isset($_POST['date_naissance']) ? $_POST['date_naissance'] : '';
	$formDateNaissance = $test->convert($formDateNaissance);
	$tok = strtok($formDateNaissance,"/");
	$formDateNaissanceJour = $tok;
	$tok = strtok("/");
	$formDateNaissanceMois = $tok;
	$tok = strtok("/");
	$formDateNaissanceAnnee = $tok;

	// Sexe du patient
	$formSexe = isset($_POST['sexe']) ? $_POST['sexe'] : '';
	$formSexe = $test->convert($formSexe);
	
	// Rue de l'adresse du patient
	$formRue = isset($_POST['rue']) ? $_POST['rue'] : '';
	$formRue = $test->convert($formRue);

	// Code postal + Ville de l'adresse du patient
	$formLocalite = isset($_POST['localite']) ? $_POST['localite'] : '';
	$formLocalite = $test->convert($formLocalite);
	
	// Ville de l'adresse du patient
	$formCommune = trim(substr($formLocalite,4));
	$formCodePostal = substr($formLocalite,0,4);	
	
	// Validation des entrées pour la localité
	if (is_numeric($formCodePostal) && strlen($formCodePostal)==4){
		if (strlen($formCommune)>0){
			$formLocalite = $formCodePostal." ".$formCommune;
		} else {
			$formLocalite = $formCodePostal;
		}
	} else {
		$formLocalite = "";
	}
	
	$formNationnalite = isset($_POST['nationnalite']) ? $_POST['nationnalite'] : '';
	$formNationnalite = $test->convert($formNationnalite);
	
	$formNISS = isset($_POST['niss']) ? $_POST['niss'] : '';
	$formNISS = $test->convert($formNISS);
	
	$formTelephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
	$formTelephone = $test->convert($formTelephone);
	
	$formGSM = isset($_POST['gsm']) ? $_POST['gsm'] : '';
	$formGSM = $test->convert($formGSM);
	
	$formMail = isset($_POST['mail']) ? $_POST['mail'] : '';
	$formMail = $test->convert($formMail);
	
// NEW: Add fumeur & Surpoids & Amende
	$formFumeur = isset($_POST['fumeur']) ? $_POST['fumeur'] : '';
	$formFumeur = $test->convert($formFumeur);
	$formSurpoids = isset($_POST['surpoids']) ? $_POST['surpoids'] : '';
	$formSurpoids = $test->convert($formSurpoids);
	$formAmende = isset($_POST['amende']) ? $_POST['amende'] : '';
	$formAmende = $test->convert($formAmende);	
// END 		
	
	$formMutuelleCode = isset($_POST['mutuelle_code']) ? $_POST['mutuelle_code'] : '';
	$formMutuelleCode = $test->convert($formMutuelleCode);
	
	$formMutuelleMatricule = isset($_POST['mutuelle_matricule']) ? $_POST['mutuelle_matricule'] : '';
	$formMutuelleMatricule = $test->convert($formMutuelleMatricule);
	
	$formSIS = isset($_POST['sis']) ? $_POST['sis'] : '';
	$formSIS = $test->convert($formSIS);
	
	$formCT1CT2 = isset($_POST['ct1ct2']) ? $_POST['ct1ct2'] : '';
	$formCT1CT2 = $test->convert($formCT1CT2);
	$formCT1 = substr($formCT1CT2,0,3);
	$formCT2 = substr($formCT1CT2,4,3);
		
	$formTiersPayant = isset($_POST['tiers_payant']) ? $_POST['tiers_payant'] : '';
	$formTiersPayant = $test->convert($formTiersPayant);
	
	$formPrescripteur = isset($_POST['prescripteur']) ? $_POST['prescripteur'] : '';
	$formPrescripteur = ucfirst(strtolower($formPrescripteur));
	$formPrescripteur = $test->convert($formPrescripteur);
	
	$formTiersPayantInfo = isset($_POST['tiers_payant_info']) ? $_POST['tiers_payant_info'] : '';
	$formTiersPayantInfo = $test->convert($formTiersPayantInfo);

	$formVipoInfo = isset($_POST['vipo_info']) ? $_POST['vipo_info'] : '';
	$formVipoInfo = $test->convert($formVipoInfo);
	
	$formMutuelleInfo = isset($_POST['mutuelle_info']) ? $_POST['mutuelle_info'] : '';
	$formMutuelleInfo = $test->convert($formMutuelleInfo);

	$formInterditInfo = isset($_POST['interdit_info']) ? $_POST['interdit_info'] : '';
	$formInterditInfo = $test->convert($formInterditInfo);
	
	$formRatingRendezVousInfo = isset($_POST['rating_rendez_vous_info']) ? $_POST['rating_rendez_vous_info'] : '3';
	$formRatingRendezVousInfo = $test->convert($formRatingRendezVousInfo);
	
	$formRatingFrequentationInfo = isset($_POST['rating_frequentation_info']) ? $_POST['rating_frequentation_info'] : '3';
	$formRatingFrequentationInfo = $test->convert($formRatingFrequentationInfo);
	
	$formRatingPreferenceInfo = isset($_POST['rating_preference_info']) ? $_POST['rating_preference_info'] : '3';
	$formRatingPreferenceInfo = $test->convert($formRatingPreferenceInfo);
	
	$formCommentaire = isset($_POST['commentaire']) ? $_POST['commentaire'] : '';
	$formCommentaire = $test->convert($formCommentaire);
	
	$formValidation = isset($_POST['validation']) ? $_POST['validation'] : '';
	$formValidation = $test->convert($formValidation);

	$formPhoto = isset($_POST['photo']) ? $_POST['photo'] : '';
	
	$formTextComment = isset($_POST['TextArea1']) ? $_POST['TextArea1'] : '';
	$formTextComment = addslashes(trim($formTextComment));
	
	// Validation des variables
	if ($actionPatientTitulaire == 1) {
	
  		$test->stringtest($formNom,"nom","nom");
		$test->stringtest($formPrenom,"prenom","pr&eacute;nom");
		$test->datetest($formDateNaissanceJour,$formDateNaissanceMois,$formDateNaissanceAnnee,"date_naissance","date de naissance");
		
		if ($formValidation!='novalid') {
		
			$test->stringtest($formSexe,"sexe","sexe");
			$test->nisstest($formNISS,"niss","num&eacute;ro de NISS");
			$test->stringtest($formMutuelleCode,"mutuelle_code","mutuelle");
			$test->stringtest($formMutuelleMatricule,"mutuelle_matricule","matricule");
			$test->sistest($formSIS,"sis","num&eacute;ro de carte sis");
			$test->mailtest($formMail,"mail","adresse mail");
			$test->ctstest($formCT1CT2,"ct1ct2","donn&eacute;e d'assurabilit&eacute; (CT1/CT2)");
			
		}
			
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			$q = requete_SQL ("SELECT id FROM patients WHERE nom='$formNom' and prenom='$formPrenom' and date_naissance = '$formDateNaissanceAnnee-$formDateNaissanceMois-$formDateNaissanceJour'");
		
			$n = mysql_num_rows($q);
		
    		if ($n == 0) {
				
    			// Ajout DB
				$sql = "INSERT INTO `patients` ( `nom` , `prenom` , `date_naissance` , `sexe`, `rue`, `code_postal`, `commune`, `niss` , `mutuelle_code` , `mutuelle_matricule` , `sis` , `telephone` , `gsm` , `mail` , `nationnalite` , `prescripteur` , `ct1` , `ct2`, `tiers_payant`, `titulaire_id`, `tiers_payant_info`,  `vipo_info`, `mutuelle_info`, `interdit_info`, `rating_rendez_vous_info`, `rating_frequentation_info`, `rating_preference_info`, `commentaire`, `photo`, `textcomment` , `exported`, `fumeur`, `obese`, `amende` )
VALUES ('$formNom', '$formPrenom',  '$formDateNaissanceAnnee-$formDateNaissanceMois-$formDateNaissanceJour', '$formSexe', '$formRue', '$formCodePostal', '$formCommune',  '$formNISS', '$formMutuelleCode', '$formMutuelleMatricule', '$formSIS', '$formTelephone', '$formGSM', '$formMail', '$formNationnalite', '$formPrescripteur', '$formCT1', '$formCT2', '$formTiersPayant', 0 ,'$formTiersPayantInfo', '$formVipoInfo', '$formMutuelleInfo', '$formInterditInfo', '$formRatingRendezVousInfo', '$formRatingFrequentationInfo', '$formRatingPreferenceInfo', '$formCommentaire', '$formPhoto', '$formTextComment', '0', '$formFumeur', '$formSurpoids', '$formAmende')";
				
				$q = requete_SQL ($sql);

				$sql = "UPDATE `patients` set titulaire_id=id where titulaire_id = 0";
				
				$q = requete_SQL ($sql);
								
				// Valider l'ajout dans la DB
				$_SESSION['information']="<div id='dbinfo'>Op&eacute;ration r&eacute;ussie - ".html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))." ".html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))." a &eacute;t&eacute; correctement ajout&eacute; &agrave; la base de donn&eacute;e</div>";
				
				// redirection
				header('Location: ../menu/menu.php');

				// Fonction de deconnexion à la base de données
				deconnexion_DB();
				die();
			}
		}
		
		// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 1) {
			$info_erreurs = "<div id='formerreur'>Corriger le champ &eacute;rron&eacute; : $test->ListeErreur !</div>";
		} else {
			if ($test->Count == 0) {
				$info_erreurs = "<div id='formerreur'>Ce patient existe d&eacute;j&agrave; dans la base de donn&eacute;e!</div>";
			} else {
				$info_erreurs = "<div id='formerreur'>Corriger les $test->Count champs &eacute;rron&eacute;s : $test->ListeErreur !</div>";
			}
		}
		
	}

	// Inclus le fichier contenant les fonctions BeID
	include_once '../lib/BEIDCard.php';
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Poly - Ajout d'un patient titulaire</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		echo "<li class='yuimenubaritem'>Patient";
		echo "	<div id='patientsupp' class='yuimenu'>";
		echo "		<div class='bd'>       ";             
		echo "		  	<ul>";
		echo "				<li class='yuimenuitem'>";
		echo "					<a onclick='ReadCard();' href='#' title='Lecture de la carte d'identit&eacute;'>Lecture de la carte d'identit&eacute</a>";
		echo "				</li>";
		echo "			</ul>";
		echo "		</div>";
		echo "	</div>";
		echo "</li>";
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		<h1>Patients - Ajout d'un patient titulaire</h1>
	</div>

	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('patients')?>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">

	  				<a href="./recherche_patient.php">Recherche</a>
   
   					<span>Ajout d'un patient titulaire</span> 
      					
					<a href="./add_patient_non_titulaire.php">Ajout d'un patient non titulaire</a>

	  				<a href="./listing_patient.php">Listing</a>

	  				<a href="./listing_patient_comment.php">Patient &agrave; suivre</a>

				</div>
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet d'encoder un nouveau patient qui est titulaire de sa mutuelle.  Il importe d'encoder le nom, le pr&eacute;nom et la date de naissance. Les autres champs obligatoires peuvent être ignorés à l'aide du checkbox en bas du formulaire.<br />
						</div>
						<?php echo $info_erreurs ?>
                            
					</div>
						
					<div id="secondheader">
        				<ul id="sec_primary_tabs">
        					<li id="sec_li_1" class="nodelete current">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(1);">G&eacute;n&eacute;rale</a>
		 			 		</li>
		 			 		<li id="sec_li_2" class="nodelete">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(2);">Statut</a>
		 			 		</li>
		 			 		<li id="sec_li_3" class="nodelete">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(3);">Info</a>
		 			 		</li>
        				</ul>
					</div>
						
					<div id="secondmain" class="formBox">
							
						<form name='patientForm' id='patientForm' method='post' action='<?=$nom_fichier?>'>
                            
							<input type='hidden' name='actionPatientTitulaire' value='1'>

							<div id = 'table_1'>
								
							<table border='1' cellspacing='0' cellpadding='0'>
								
								<tr>
                                	<th class=''>Photo</th>
									<td class='formInput'>
										<applet
                                        	codebase = "."
                                            archive  = "beidlib.jar"
                                            code     = "be.belgium.eid.BEID_Applet.class"
                                            name     = "BEIDApplet"
                                            width    = "70"
                                            height   = "100"
                                            hspace   = "0"
                                            vspace   = "0"
                                            align    = "middle"
                                        >
                                        	<param name="Reader" value="">
                                   			<param name="OCSP" value="-1">
                                        	<param name="CRL" value="-1">
                                        	<param name="DisableWarning" value="true">
                                        </applet>
                                                
                                        <div class="right">
                                        	<label class="labelText" ID="StatusField">
                                        </div>
                                  	</td>    
                             	</tr>
									    
								<!-- Titulaire -->
								<tr>
									<th class=''>Titulaire</th>
									<td class='formInput'>
										<input type='text' name='titulaire' id='titulaire' size='40' maxlength='32' class='txtField' title='Titulaire' value='<?=html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))." ".html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))?>' autocomplete='off' readonly='true' />
									</td>
								</tr>
								<!-- FIN Titulaire -->
			
										
								<!-- Nom Patient -->
								<tr>
									<th class='<?=$test->fieldError("nom","required")?>'>Nom</th>
									<td class='formInput'>
										<input type='text' name='nom' id='nom' size='40' maxlength='32' class='txtField' title='Nom du patient' value='<?=html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))?>' autocomplete='off' onfocus="javascript:this.select()" onKeyUp='javascript:patientGestionTitulaire();patientRechercheDirect();' />
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("nom","hide")?>">Rentrer un nom de famille</td></tr>
								<!-- FIN Nom Patient -->
										
										
								<!-- Prenom Patient-->
								<tr>
									<th class='<?=$test->fieldError("prenom","required")?>'>Pr&eacute;nom</th>
									<td class='formInput'>
										<input type='text' name='prenom' id='prenom' size='40' maxlength='32' class='txtField' title='Pr&eacute;nom du patient'  value='<?=html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))?>' autocomplete='off' onfocus="javascript:this.select()" onKeyUp='javascript:patientGestionTitulaire();patientRechercheDirect();' />
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("prenom","hide")?>">Rentrer un pr&eacute;nom</td></tr>
								<!-- FIN Prenom Patient-->
										
										
								<!-- Date de naissance -->
								<tr>
									<th class='<?=$test->fieldError("date_naissance","required")?>'>Date de naissance</th>
									<td class='formInput'>
										<input type='text' name='date_naissance' id='date_naissance' size='10' maxlength='10' class='txtField' title='Jour de naissance du patient'  value='<?=$formDateNaissance?>' onfocus="javascript:this.select()" onkeyup="javascript:dateFirstExecutionresult = checkDate(this, '', '');" autocomplete='off' />
										Format (jj/mm/aaaa)	
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("date_naissance","hide")?>">Rentrer une date de naissance valide</td></tr>
								<!-- FIN Date de naissance -->

	
								<!-- Nationnalite -->
								<tr>
									<th class='<?=$test->fieldError("sexe","optionnel")?>' class=''>Sexe</th>
									<td class='formInput'>
										<select width="128px" style="width: 128px" id='sexe' name='sexe' title='Nationnalit&eacute; du patient'>
											<option value=''>Choisir</option>
											<option value='M' <?php if ($formSexe == 'M') echo "selected"; ?> >M</option>
											<option value='F' <?php if ($formSexe == 'F') echo "selected"; ?> >F</option>
										</select>
										&nbsp;<b>Nationnalit&eacute;</b>&nbsp;
										<select width="128px" style="width: 128px" id='nationnalite' name='nationnalite' title='Nationnalit&eacute; du patient'>
											<option value='generale'>Autre</option>
											<?php
												connexion_DB('poly');
												$sql = 'SELECT id, nationnalite FROM nationnalites';
												$result = mysql_query($sql);
												
												while($data = mysql_fetch_assoc($result)) 	{
													// on affiche les specialité
    												echo $data['nationnalite'];
													echo "<option value='";
													echo $data['id'];
													echo "' ";
													if ($formNationnalite == $data['id']) echo "selected";
													echo ">";
													echo $data['nationnalite'];
													echo "</option>";
												}
												deconnexion_DB();
											?>
										</select>
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("sexe","hide")?>">Compl&eacute;ter le sexe</td></tr>
								<!-- FIN Nationnalité -->

										
								<!-- Adresse -->
								<tr>
									<th>Rue</th>
									<td>
										<input type='text' name='rue' id='rue' size='40' maxlength='100' class='txtField' title='Rue et num&eacute;ro de l adresse du patient'  value='<?=html_entity_decode(htmlentities(stripcslashes($formRue),ENT_QUOTES))?>' onfocus="javascript:this.select()" autocomplete='off'/>
									</td>
								</tr>
								<tr>
									<th>Code Postal-Localit&eacute;</th>
									<td>
										<input type="text" id="localite" name="localite" alt="Code postal et ville de l adresse du patient" size='40' maxlength='32' onfocus="javascript:this.select()" onkeyup="searchSuggest(this.value);" value='<?=$test->convert($formLocalite)?>' autocomplete="off" />
										Format (7000 Mons)	
										<div id="search_suggest"></div>
									</td>
								</tr>
								<!-- FIN Adresse -->

																				
								<!-- Registre National -->
								<tr>
									<th class='<?=$test->fieldError("niss","optionnel")?>'>Registre National</th>
									<td class='formInput'><input type='text' name='niss' id='niss' size='40' maxlength='11' class='txtField' title='Num&eacute;ro de registe nationnal du patient - NISS'  value='<?=$formNISS?>' onfocus="javascript:this.select()" onKeyUp='javascript:valeurniss = checkNumber(this, valeurniss, 11, false);' autocomplete='off' /> 
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("niss","hide")?>">Rentrer un num&eacute;ro valide</td></tr>
								<!-- FIN Registre National -->


								<!-- Mutuelle -->
								<tr>
									<th class='<?=$test->fieldError("mutuelle_code","optionnel")?>'>Mutuelle</th>
									<td class='formInput'>
										<select width="332px" style="width: 332px" id='mutuelle_code' name='mutuelle_code' title='Mutuelle du patient'>
											<option value=''>Choisir...</option>
											<?php
												connexion_DB('poly');
												$sql = 'SELECT nom, code FROM mutuelles order by nom, code';
												$result = mysql_query($sql);
												while($data = mysql_fetch_assoc($result)) 	{
													echo "<option value='";
													echo $data['code'];
													echo "' ";
													if ($formMutuelleCode == $data['code']) echo "selected";
													echo " >";
													echo $data['code'];
													echo " - "; 
													echo $data['nom'];
													echo "</option>";
												}	 
												deconnexion_DB();
											?>
										</select>
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("mutuelle_code","hide")?>">Choisir une mutuelle</td></tr>
								<!-- FIN Mutuelle -->


								<!-- Matricule -->
								<tr>
									<th class='<?=$test->fieldError("mutuelle_matricule","optionnel")?>'>Mutuelle Matricule</th>
									<td class='formInput'>
										<input type='text' name='mutuelle_matricule' id='mutuelle_matricule' size='40' maxlength='20' class='txtField' title='Matricule du patient &agrave; la mutuelle'  value='<?=$formMutuelleMatricule?>' autocomplete='off' onfocus="javascript:this.select()"/>
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("mutuelle_matricule","hide")?>">Remplir le num&eacute;ro de matricule de la mutuelle</td></tr>
								<!-- FIN Matricule -->
										
	
								<!-- SIS -->
								<tr>
									<th class='<?=$test->fieldError("sis","optionnel")?>'>Carte SIS</th>
									<td class='formInput'>
										<input type='text' name='sis' id='sis' size='40' maxlength='10' class='txtField' title='Num&eacute;ro de la carte SIS'  value='<?=$formSIS?>' onKeyUp='javascript:valeursis = checkNumber(this, valeursis, 10, false);' autocomplete='off' onfocus="javascript:this.select()"/>
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("sis","hide")?>">Rentrer un num&eacute;ro de carte SIS valide</td></tr>
								<!-- FIN SIS -->

									
								<!-- TYPE -->
								<tr>
									<th class='<?=$test->fieldError("ct1ct2","optionnel")?>'>CT1/CT2</th>
									<td class='formInput'>
										<select id='ct1ct2' name='ct1ct2' width="332px" style="width: 332px" title='CT1 et CT2 du patient' onchange='patientRechercheType(this.value);'>
											<option value=''>Choisir</option>
												<?php
													connexion_DB('poly');
													$sql = 'SELECT distinct ct1, ct2, type, label FROM cts where ct1!=0 and ct2!=0';
													$result = mysql_query($sql);
													while($data = mysql_fetch_assoc($result)) 	{
														echo "<option value='".$data['ct1']."-".$data['ct2']."' ";
														if ($formCT1."-".$formCT2 == $data['ct1']."-".$data['ct2']) echo "selected";
														echo " >".$data['ct1']."/".$data['ct2']." - ".$data['label']."</option>";
													}	 
													deconnexion_DB();
												?>
										</select>
										<input type='checkbox' name='tiers_payant' id='tiers_payant' value='checked' <?=$formTiersPayant?> >R&eacute;duction du tiers payant
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("ct1ct2","hide")?>">Choisir un type valide</td></tr>
								<!-- FIN TYPE -->

										
								<!-- Prescripteur -->
								<tr>
									<th class=''><label for='prescripteur'>Prescripteur <br /></label>
									</th>
									<td class='formInput'><input type='text' name='prescripteur' id='prescripteur' size='40' maxlength='32' class='txtField' title='Prescripteur du patient'  value='<?=html_entity_decode(htmlentities(stripcslashes($formPrescripteur),ENT_QUOTES))?>' onfocus="javascript:this.select()"/>
									</td>
								</tr>

								<!-- Telephone -->
								<tr>
									<th class=''>T&eacute;l&eacute;phone priv&eacute;</th>
									<td class='formInput'><input type='text' name='telephone' id='telephone' size='40' maxlength='32' class='txtField' title='T&eacute;l&eacute;phone du patient'  value='<?=$formTelephone?>' onfocus="javascript:this.select()"/>
									</td>
								</tr>

								<!-- GSM -->
								<tr>
									<th class=''>T&eacute;l&eacute;phone mobile (GSM)</th>
									<td class='formInput'><input type='text' name='gsm' id='gsm' size='40' maxlength='32' class='txtField' title='GSM du patient'  value='<?=$formGSM?>' onfocus="javascript:this.select()"/>
									</td>
								</tr>
										
								
								<!-- E-mail -->
								<tr>
									<th class=''>E-Mail</th>
									<td class='formInput'><input type='text' name='mail' id='mail' size='40' maxlength='32' class='txtField' title='Adresse E-Mail du patient'  value='<?=$formMail?>' onfocus="javascript:this.select()"/>
									</td>
									</tr>
								<tr><td></td><td class="<?=$test->fieldError("mail","hide")?>">Rentrer une adresse E-Mail valide</td></tr>

								<!-- Fumeur -->
								<tr>
									<th class=''>Le patient est-il fumeur?</th>
									<td class='formInput'><input type='checkbox' name='fumeur' id='fumeur' class='txtField' title='Fumeur'  value='checked' <?=$formFumeur?> />
									</td>
								</tr>
								
								<!-- Surpoids -->
								<tr>
									<th class=''>Le patient est-il en surpoids?</th>
									<td class='formInput'><input type='checkbox' name='surpoids' id='surpoids' class='txtField' title='Surpoids'  value='checked' <?=$formSurpoids?> />
									</td>
								</tr>
								
								<!-- Amende -->
								<tr>
									<th class=''>Le patient a-t-il une amende?</th>
									<td class='formInput'><input type='checkbox' name='amende' id='amende' class='txtField' title='Amende'  value='checked' <?=$formAmende?> />
									</td>
								</tr>
								
								<tr>
									<th class='formLabel'><label for='validation'><br /></label>
									</th>
									<td class='formInput'>
									<input type="submit" class="button" value="Valider" />&nbsp;<input type='checkbox' name='validation' id='validation' value='novalid' <? if ($formValidation=='novalid') echo "checked"; ?> >Valider le minimum de champs pour ce patient
									</td>
								</tr>
									
								<input type='hidden' id='photo' name='photo'/>
																				
							</table>
							
							</div>
							
							<div id = "table_2" style="display:none">
							
							<table border='1' cellspacing='0' cellpadding='0'>

								<!-- Commentaire -->
								<tr>
									<th class=''>Commentaire</th>
									<td class='formInput'>
										<input type='text' name='commentaire' id='commentaire' size='50' maxlength='100' class='txtField' title='Commentaire sur le patient'  value='<?=html_entity_decode(htmlentities(stripcslashes($formCommentaire),ENT_QUOTES))?>' onfocus="javascript:this.select()"/>
									</td>
								</tr>
									
								<tr>
									<th class=''>Tiers Payant</th>
									<td class='formInput'>
										<input type='checkbox' name='tiers_payant_info' id='tiers_payant_info' value='checked' <?=$formTiersPayantInfo?> >Refus d'accorder la réduction du tiers payant
									</td>
								</tr>
									
								<tr>
										<th class=''>Vipo</th>
										<td class='formInput'>
										<input type='checkbox' name='vipo_info' id='vipo_info' value='checked' <?=$formVipoInfo?> >Refus d'accorder la tarification VIPO
										</td>
								</tr>

								<tr>
										<th class=''>Mutuelle</th>
										<td class='formInput'>
										<input type='checkbox' name='mutuelle_info' id='mutuelle_info' value='checked' <?=$formMutuelleInfo?> >Refus de la prise en charge du remboursement aux mutuelles
										</td>
								</tr>

								<tr>
										<th class=''>Interdit</th>
										<td class='formInput'>
										<input type='checkbox' name='interdit_info' id='interdit_info' value='checked' <?=$formInterditInfo?> >Interdit de l'&eacute;tablissement
										</td>
								</tr>
									
								<tr>
										<th class=''>Rendez-vous</th>
										<td class='formInput'>
											<div id="rating_rendez_vous" class="rating_container">
												<?
													$rate->init();
													$rate->transform($formRatingRendezVousInfo);
												?>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												&nbsp;&nbsp;&nbsp;&nbsp;
											</div>
											<select id="rating_rendez_vous_info" name="rating_rendez_vous_info">
												<option value="1" <?= $rate->getselected(1) ?> >Ne se pr&eacute;sente jamais aux rendez-vous</option>
												<option value="2" <?= $rate->getselected(2) ?> >Manque r&eacute;gulièrement ses rendez-vous</option>
												<option value="3" <?= $rate->getselected(3) ?> >Manque de temps à autre un rendez-vous</option>
												<option value="4" <?= $rate->getselected(4) ?> >Manque tr&eacute;s rarement ses rendez-vous</option>
												<option value="5" <?= $rate->getselected(5) ?> >Ne rate jamais ses rendez-vous</option>
											</select>
										</td>
								</tr>
									
								<tr>
										<th class=''>Fr&eacute;quentation</th>
										<td class='formInput'>
											<div id="rating_frequentation" class="rating_container">
												<?
													$rate->init();
													$rate->transform($formRatingFrequentationInfo);
												?>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												&nbsp;&nbsp;&nbsp;&nbsp;
											</div>
											<select id="rating_frequentation_info" name="rating_frequentation_info">
												<option value="1" <?= $rate->getselected(1) ?> >Ne viens plus jamais dans l'&eacute;tablissement</option>
												<option value="2" <?= $rate->getselected(2) ?> >Fr&eacute;quente rarement l'&eacute;tablissement</option>
												<option value="3" <?= $rate->getselected(3) ?> >Fr&eacute;quente normalement l'&eacute;tablissement</option>
												<option value="4" <?= $rate->getselected(4) ?> >Fr&eacute;quente r&eacute;guli&egrave;rement l'&eacute;tablissement</option>
												<option value="5" <?= $rate->getselected(5) ?> >Fr&eacute;quente tr&egrave;s souvent l'&eacute;tablissement</option>
											</select>
										</td>
								</tr>

								<tr>
										<th class=''>Pr&eacute;f&eacute;rence</th>
										<td class='formInput'>
											<div id="rating_preference" class="rating_container">
												<?
													$rate->init();
													$rate->transform($formRatingPreferenceInfo);
												?>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												<a class="" href=""></a>
												&nbsp;&nbsp;&nbsp;&nbsp;
											</div>
											<select id="rating_preference_info" name="rating_preference_info">
												<option value="1" <?= $rate->getselected(1) ?> >M&eacute;diocre</option>
												<option value="2" <?= $rate->getselected(2) ?> >Moyen</option>
												<option value="3" <?= $rate->getselected(3) ?> >Normal</option>
												<option value="4" <?= $rate->getselected(4) ?> >Tr&egrave;s bien</option>
												<option value="5" <?= $rate->getselected(5) ?> >Excellent</option>
											</select>
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
							
							</div>
							
							
							<div id ="table_3" style="display:none">
									
								<table border='1' cellspacing='0' cellpadding='0'>
									<tr>
										<th colspan="2">
									 	<textarea id="TextArea1" name="TextArea1" rows="10" cols="80" style="width:100%">
								    		<? print (stripslashes($formTextComment)); ?>
											</textarea>
										</th>
									</tr>
								
									<tr>
										<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<td class='formInput'>
											<input type="submit" value="Valider" class="button" onclick="javascript:submitHandler('editors_here');">
										</td>
									</tr>
									
								</table>

							</div>
							

						</form>
				
					</div>
				
				</div>
					
			</div>
		
		</div>
	
	</div>

	<div id="left">
	
		<table id="left-drawer" cellpadding="0" cellspacing="0">
		   	
		   	<tr>
				
				<td class="drawer-content">
			
					<a class="taskControl" href="../medecins/recherche_medecin.php">Recherche m&eacute;decin</a>
				
					<div class="sidebar labels-green">

						<a onclick="Element.toggle('findMedecinForm'); Element.hide('findPatientForm');Element.hide('findMutuelleForm');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findMedecinForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMedecinInput" type="text" onFocus="this.select()" onKeyUp="javascript:medecin_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>
                			<div id="informationMedecin">
							</div>
						</div>

					</div>
					
					<a class="taskControl" href="../patients/recherche_patient.php">Recherche patient</a>

					<div id="labels" class="sidebar labels-red">

						<a onclick="Element.toggle('findPatientForm'); Element.hide('findMutuelleForm');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
							</div>
						</div>

					</div>
					
					<a class="taskControl" href="../mutuelles/recherche_mutuelle.php">Recherche mutuelle</a>
				
					<div class="sidebar labels-red">

						<a onclick="Element.toggle('findMutuelleForm'); Element.hide('findMedecinForm'); Element.hide('findPatientForm'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findMutuelleForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMutuelleInput" type="text" onFocus="this.select()" onKeyUp="javascript:mutuelle_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>
                			<div id="informationMutuelle">
							</div>
						</div>

					</div>
			
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/add_patient.png'>
					</div>

				</td>
 			    	
				<!-- OPEN -->
				<td class="drawer-handle" onclick="toggleSidebars(); return false;">
           			<div class="top-corner"></div>
           			<div class="bottom-corner"></div>
       	   	 	</td>
				
   	  		</tr>

   	 	</table>

	</div>

	<!-- MENU JS -->
	<script type="text/javascript" src="../yui/menu.js"></script>
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
		var _editor_url = document.location.href.replace(/add_patient_titulaire\.php.*/, '');
		var _editor_lang = "fr";
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
	
	<!-- ALL JS -->
	<script type="text/javascript" src='../js/common.js'></script>
	<script type="text/javascript" src='../js/patient.js'></script>
    <script type="text/javascript" src='../js/autosuggest.js'></script>
	<script type="text/javascript">
		areaedit_init();
		var valeurniss = '';
		var valeursis = '';
    	var oTextbox = new AutoSuggestControl(document.getElementById("localite"), new StateSuggestions());        
	</script>

	<!-- MODAL JS -->
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		$('nom').focus();
		var help = new Window('1', {className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window('2', {className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
		var information = new Window('4', {className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
		function openHelp() {
	  		help.setURL("../lib/aide_en_ligne.php?type=aide&id=<?=$nom_fichier?>");
	  		help.show();
		}
		function openNotice(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=notice&id="+id);
	  		notice.show();
		}
		function openInformation(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=information_patient&id="+id);
	  		notice.show();
		}
		function openModifAssurabilite(html,id) {
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 600, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
	</script>

	<!-- CONTROL JS -->
	<script	type="text/javascript" src="../js/control_rating/control_002.js"></script>
	<script>
		var rating_rendez_vous_info = new Control.Rating('rating_rendez_vous',{
			input: 'rating_rendez_vous_info',
			multiple: true
		});
		var rating_frequentation_info = new Control.Rating('rating_frequentation',{
			input: 'rating_frequentation_info',
			multiple: true
		});
		var rating_preference_info = new Control.Rating('rating_preference',{
			input: 'rating_preference_info',
			multiple: true
		});
	</script>

</body>
</html>