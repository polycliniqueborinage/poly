<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
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
	
	// Vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "modif_medecin.php";
	$info_erreurs = "";
	$interneExterne = "";
	
	// Variables vides
	$formNom = '';
	$formPrenom = '';
	$formDateNaissance='';
	$formRue = '';
	$formLocalite = '';
	$formCommune = '';
	$formCodePostal = '';
	$formTelephonePrive = '';
	$formTelephoneTravail = '';
	$formTelephoneMobile = '';
	$formFax = '';
	$formMail = '';
	$formSpecialite = '';
	$formInami = '';
	$formTauxConsultation = '';
	$formTauxActe = '';
	$formTauxProthese = '';
	$formDureeConsult = '';
	$formType = '';
	$formComment = '';
	$formAgenda ='';
	$formProtocole ='';
	$formTextComment ='';
	$formTextHoraire ='';
	
	// Variables de l'url
	if (isset($_GET['id'])) {
		// from url
		$urlID = $_GET['id'];
		
  		$sql = "select id, nom, prenom, date_naissance, rue, code_postal, commune, telephone_prive, telephone_travail, telephone_mobile, fax, mail, type, specialite, inami, taux_acte, taux_consultation, taux_prothese,length_consult, comment, protocole, agenda, textcomment, texthoraire FROM medecins WHERE id='$urlID'";
				
		$result = requete_SQL ($sql);
	
		//on trouve un medecin
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);
			
			$formID = $data['id'];
			$formNom = $data['nom'];
			$formPrenom = $data['prenom'];
			
			$formDateNaissance = $data['date_naissance'];
			$tok = strtok($formDateNaissance,"-");
			$formDateNaissanceAnnee = $tok;
			$tok = strtok("-");
			$formDateNaissanceMois = $tok;
			$tok = strtok("-");
			$formDateNaissanceJour = $tok;
			$formDateNaissance = $formDateNaissanceJour."/".$formDateNaissanceMois."/".$formDateNaissanceAnnee;
			
			$formRue = $data['rue'];
			$formCommune = $data['commune'];
			$formCodePostal = $data['code_postal'];
			$formLocalite = trim($formCodePostal." ".$formCommune);
			$formTelephonePrive = $data['telephone_prive'];
			$formTelephoneTravail = $data['telephone_travail'];
			$formTelephoneMobile = $data['telephone_mobile'];
			$formFax = $data['fax'];
			$formMail = $data['mail'];
			$formSpecialite = $data['specialite'];
			$formInami = $data['inami'];
			$_SESSION['oldInami'] = $formInami; //peut être vide
			$formTauxConsultation = $data['taux_consultation'];
			$formTauxActe = $data['taux_acte'];
			$formTauxProthese = $data['taux_prothese'];
			$formDureeConsult = $data['length_consult'];
			$formComment = $data['comment'];
			$formProtocole = $data['protocole'];
			$formAgenda = $data['agenda'];
			$formTextComment = $data['textcomment'];
			$formTextHoraire = $data['texthoraire'];
			$formType = $data['type'];
			if ($formType == 'interne') {
				$interneExterne = 'required';
			}


		} else {
	
			// Impossible de trouver le medecin avec cet ID
			$_SESSION['information']="<div id='dbinfo'>Op&eacute;ration manqu&eacute;e - Impossible de trouver le m&eacute;decin correspondant - Contacter votre adminitstrateur IT</div>";
			header('Location: ../menu/menu.php');
			die();
	
		}
	}
	
	// Variable du formulaire
	$actionModifMedecin = isset($_POST['actionModifMedecin']) ? $_POST['actionModifMedecin'] : '';

	if ($actionModifMedecin == 1) {

		// ID du m&eacute;decin
		$formID = isset($_POST['id']) ? $_POST['id'] : '';
		$formID = $test->convert($formID);
		
		// OLD ID d mededin 
		$sessionOldInami = isset($_SESSION['oldInami']) ? $_SESSION['oldInami'] : '';
		
		// Nom du m&eacute;decin
		$formNom = isset($_POST['nom']) ? $_POST['nom'] : '';
		$formNom = ucfirst(strtolower($formNom));
		$formNom = $test->convert($formNom);

		// Pr&eacute;nom du m&eacute;decin
		$formPrenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
		$formPrenom = ucfirst(strtolower($formPrenom));
		$formPrenom = $test->convert($formPrenom);

		// Ann&eacute;e de naissance du m&eacute;decin
		$formDateNaissance = isset($_POST['date_naissance']) ? $_POST['date_naissance'] : '';
		$formDateNaissance = $test->convert($formDateNaissance);
		$tok = strtok($formDateNaissance,"/");	
		$formDateNaissanceJour = $tok;
		$tok = strtok("/");
		$formDateNaissanceMois = $tok;
		$tok = strtok("/");
		$formDateNaissanceAnnee = $tok;
		
		// Rue de l'adresse du m&eacute;decin
		$formRue = isset($_POST['rue']) ? $_POST['rue'] : '';
		$formRue = $test->convert($formRue);
		
		// Code postal + Ville de l'adresse du m&eacute;decin
		$formLocalite = isset($_POST['localite']) ? $_POST['localite'] : '';
		$formLocalite = $test->convert($formLocalite);
	
		// Ville de l'adresse du m&eacute;decin
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

		// Num&eacute;ro de t&eacute;l&eacute;phone au domicile du m&eacute;decin
		$formTelephonePrive = isset($_POST['telephone_prive']) ? $_POST['telephone_prive'] : '';
		$formTelephonePrive = $test->convert($formTelephonePrive);

		// Num&eacute;ro de t&eacute;l&eacute;phone sur le lien de travail du m&eacute;decin
		$formTelephoneTravail = isset($_POST['telephone_travail']) ? $_POST['telephone_travail'] : '';
		$formTelephoneTravail = $test->convert($formTelephoneTravail);

		// Num&eacute;ro de t&eacute;l&eacute;phone mobile du m&eacute;decin
		$formTelephoneMobile = isset($_POST['telephone_mobile']) ? $_POST['telephone_mobile'] : '';
		$formTelephoneMobile = $test->convert($formTelephoneMobile);

		// Num&eacute;ro de fax du m&eacute;decin
		$formFax = isset($_POST['fax']) ? $_POST['fax'] : '';
		$formFax = $test->convert($formFax);
		
		// Adresse E-mail du m&eacute;decin
		$formMail = isset($_POST['mail']) ? $_POST['mail'] : '';
		$formMail = $test->convert($formMail);

		// Domaine de sp&eacute;cialisation du m&eacute;decin
		$formSpecialite = isset($_POST['specialite']) ? $_POST['specialite'] : '';
		$formSpecialite = $test->convert($formSpecialite);

		// Code INAMI du m&eacute;decin
		$formInami = isset($_POST['inami']) ? $_POST['inami'] : '';
		$formInami = $test->convert($formInami);

		// Pourcentage du m&eacute;decin sur les consultations
		$formTauxConsultation = isset($_POST['taux_consultation']) ? $_POST['taux_consultation'] : '0';
		$formTauxConsultation = $test->convert($formTauxConsultation);

		// Pourcentage du m&eacute;decin sur les consultations
		$formTauxActe = isset($_POST['taux_acte']) ? $_POST['taux_acte'] : '0';
		$formTauxActe = $test->convert($formTauxActe);

		// Pourcentage du m&eacute;decin sur les actes techniques
		$formTauxProthese = isset($_POST['taux_prothese']) ? $_POST['taux_prothese'] : '0';
		$formTauxProthese = $test->convert($formTauxProthese);

		// Dur&eacute;e moyenne d'une consultation pour ce m&eacute;decin
		$formDureeConsult = isset($_POST['duree_consult']) ? $_POST['duree_consult'] : '';
		$formDureeConsult = $test->convert($formDureeConsult);

		// Commentaire sur ce m&eacute;decin
		$formComment = isset($_POST['comment']) ? $_POST['comment'] : '';
		$formComment = $test->convert($formComment);
		
		// Type de m&eacute;decin
		$formType = isset($_POST['type']) ? $_POST['type'] : '';
		$formType = $test->convert($formType);

		// Calendrier de m&eacute;decin
		$formAgenda = isset($_POST['agenda']) ? $_POST['agenda'] : '';
		$formAgenda = $test->convert($formAgenda);
		
		// Protocoles de m&eacute;decin
		$formProtocole = isset($_POST['protocole']) ? $_POST['protocole'] : '';
		$formProtocole = $test->convert($formProtocole);
		
		// Commentaire sur ce m&eacute;decin
		$formTextComment = isset($_POST['TextArea1']) ? $_POST['TextArea1'] : '';
		$formTextComment = addslashes($formTextComment);
	
		// Horaire
		$formTextHoraire = isset($_POST['TextArea2']) ? $_POST['TextArea2'] : '';
		$formTextHoraire = addslashes($formTextHoraire);
							
		// Validation des variables
		$test->stringtest($formNom,"nom","nom");
		$test->stringtest($formSpecialite,"specialite","specialité");
		$test->stringtest($formPrenom,"prenom","prénom");
		$test->mailtest($formMail,"mail","adresse mail");
		$test->stringtest($formType,"type","type (interne/externe)");
				
		// CAS D UN MEDECIN INTERNE
		if ($formType == 'interne') {
			$interneExterne = 'required';
			$test->inamitest($formInami,"inami","numéro INAMI");
		}
			
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
		
			$sql ="SELECT inami, nom, prenom FROM medecins WHERE inami='$formInami' and type='interne'";
			
			$q = requete_SQL ($sql);
			
			$n = mysql_num_rows($q);
					
    		if ($n == 0 || $formInami == $sessionOldInami) {

				$sql = "UPDATE medecins set nom='$formNom', prenom='$formPrenom', date_naissance='$formDateNaissanceAnnee-$formDateNaissanceMois-$formDateNaissanceJour', rue='$formRue', code_postal='$formCodePostal', commune='$formCommune', telephone_prive='$formTelephonePrive', telephone_travail='$formTelephoneTravail', telephone_mobile='$formTelephoneMobile', fax='$formFax', mail='$formMail', specialite='$formSpecialite', type='$formType', inami='$formInami', taux_acte='$formTauxActe', taux_consultation= '$formTauxConsultation', taux_prothese = '$formTauxProthese', length_consult = '$formDureeConsult', comment='$formComment', protocole='$formProtocole', agenda='$formAgenda', textcomment='$formTextComment', texthoraire='$formTextHoraire' where id= '$formID'";

				$q = requete_SQL ($sql);
				
				// Valider l'ajout dans la DB
				$_SESSION['information']="<div id='dbinfo'>Op&eacute;ration r&eacute;ussie - Le m&eacute;decin ".html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))." ".html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))." a &eacute;t&eacute; correctement modifi&eacute; dans la base de donn&eacute;e</div>";
				
				/** Redirection
				if(isset($_SESSION['redirection'])) {
					unset($_SESSION['redirection']);
					header('Location: ../menu.php');
				} else {
					header('Location: ../menu.php');
				}**/
			
				header('Location: ../menu/menu.php');
				// Fonction de deconnexion à la base de données
				deconnexion_DB();
				die();
				
			} else {
				$data = mysql_fetch_assoc($q);
				$nom = $data ['nom'];
				$prenom = $data ['prenom'];
			} 
				
       	} // if ($test->Count == 0) {
		
		// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 1) {
			$info_erreurs = "<div id='formerreur'>Corriger le champ &eacute;rron&eacute; : $test->ListeErreur !</div>";
		} else {
			if ($test->Count == 0) {
			$info_erreurs = "<div id='formerreur'>Le m&eacute;decin ".htmlentities($nom)." ".htmlentities($prenom)." poss&egrave;de d&eacute;j&agrave; ce code Inami!</div>";
			} else {
				$info_erreurs = "<div id='formerreur'>Corriger les $test->Count champs &eacute;rron&eacute;s : $test->ListeErreur !</div>";
			}
		}
	
	} // if ($actionModifMedecin == 1) {

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Poly - Modification d'un m&eacute;decin</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>
<body id='body'>

   	<?php
   		get_MENUBAR_START();
		echo "              <li class='yuimenubaritem'>M&eacute;decin";
		echo "              	<div id='medecinsupp' class='yuimenu'>";
		echo "                		<div class='bd'>       ";             
		echo "                      	<ul>";
		echo "								<li class='yuimenuitem'>";
		echo "									<a href='#' onclick='openMedecin(\"medecin_comment\");' title='Information sur le m&eacute;decin en cours' >Information</a>";
		echo "								</li>";
		echo "								<li class='yuimenuitem'>";
		echo "									<a href='#' onclick='openMedecin(\"medecin_horaire\");' title='Information sur le m&eacute;decin en cours' >Horaire</a>";
		echo "								</li>";
		echo "                           </ul>                    ";
		echo "                		</div>";
		echo "              	</div>";
		echo "              </li>";
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>
 			Medecins -  Modification d'un m&eacute;decin			
		</h1>
    
	</div>
	
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>m&eacute;decins</a>
				</li>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">

						<a href="./recherche_medecin.php">Recherche</a>

						<a href="./add_medecin.php">Ajout</a>

    					<span>Modification</span> 

	  					<a href="./listing_medecin.php">Listing</a>

				</div>
					
	
				<div class="ViewPane">

						<div class="navigation-hight">
							
							<div id='formhelp'>
								Ce formulaire permet de modifier un ancien m&eacute;decin &agrave; condition que celui-ci existe d&eacute;j&agrave; dans l'application.<br />
							</div>
							<?php echo $info_erreurs ?>
							
						</div>
						
						<div id="secondheader">
	        				<ul id="sec_primary_tabs">
	        					<li id="sec_li_1" class="nodelete current">
			  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(1);">G&eacute;n&eacute;rale</a>
			 			 		</li>
			 			 		<li id="sec_li_2" class="nodelete">
			  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(2);">Info</a>
			 			 		</li>
			 			 		<li id="sec_li_3" class="nodelete">
			  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(3);">Horaire</a>
			 			 		</li>
	        				</ul>
						</div>
					
						<div id="secondmain" class="formBox">
	
							<form name='editors_here' id='editors_here' method='post' action='<?=$nom_fichier?>'>
														
								<input type='hidden' name='actionModifMedecin' value='1'>
								<input type='hidden' name='id' value='<?=$formID?>'>
							
								<div id = 'table_1'>
								
									<table id='general'  border='1' cellspacing='0' cellpadding='0'>
										
										<!-- Nom -->
										<tr>
											<th class='<?=$test->fieldError("nom","required")?>'>Nom</th>
											<td><input type='text' name='nom' id='nom' size='40' maxlength='32' class='txtField' title='Nom du m&eacute;decin' value='<?=html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))?>' autocomplete='off' onKeyUp='javascript:medecinRechercheDirect();' />
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("nom","hide")?>">Rentrer un nom de famille valide</td></tr>
										
										<!-- Prenom -->
										<tr>
											<th class='<?=$test->fieldError("nom","required")?>'>Prénom</th>
											<td><input type='text' name='prenom' id='prenom' size='40' maxlength='32' class='txtField' title='Pr&eacute;nom du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))?>' autocomplete='off' onKeyUp='javascript:medecinRechercheDirect();'/>
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("prenom","hide")?>">Rentrer un pr&eacute;nom valide</td></tr>
										
										<!-- Date de naissance -->
										<tr>
											<th>Date de naissance</th>
											<td class='formInput'><input type='text' name='date_naissance' id='date_naissance' size='10' maxlength='10' class='txtField' title='Date de naissance du m&eacute;decin'  value='<?=$formDateNaissance?>' onfocus="javascript:this.select()" onkeyup="javascript:dateFirstExecutionresult = checkDate(this, '', '');" autocomplete='off' />
											Format (jj/mm/aaaa)
											</td>
										</tr>
										
										<!-- Adresse -->
										<tr>
											<th>Rue</th>
											<td>
												<input type='text' name='rue' id='rue' size='40' maxlength='100' class='txtField' title='Rue de l adresse du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formRue),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>
										<tr>
											<th>Code Postal - Localit&eacute;</th>
											<td>
												<input type="text" id="localite" name="localite" alt="Code postal et ville de l adresse du m&eacute;decin" size='40' maxlength='32' value='<?=html_entity_decode(htmlentities(stripcslashes($formLocalite),ENT_QUOTES))?>' autocomplete="off" />
											</td>
										</tr>
						

										<!-- Téléphones -->
										<tr>
											<th>T&eacute;l&eacute;phone professionel</th>
											<td>
												<input type='text' name='telephone_travail' id='telephone_travail' size='40' maxlength='32' class='txtField' title='Num&eacute;ro de t&eacute;l&eacute;phone sur le lien de travail du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formTelephoneTravail),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>
										<tr>
											<th>T&eacute;l&eacute;phone priv&eacute;</th>
											<td>
												<input type='text' name='telephone_prive' id='telephone_prive' size='40' maxlength='32' class='txtField' title='Num&eacute;ro de t&eacute;l&eacute;phone au domicile du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formTelephonePrive),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>

										<!-- GSM -->
										<tr>
											<th>T&eacute;l&eacute;phone mobile (GSM)</th>
											<td><input type='text' name='telephone_mobile' id='telephone_mobile' size='40' maxlength='32' class='txtField' title='Num&eacute;ro de t&eacute;l&eacute;phone mobile du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formTelephoneMobile),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>

										<!-- Fax -->
										<tr>
											<th>Num&eacute;ro de fax</th>
											<td><input type='text' name='fax' id='fax' size='40' maxlength='32' class='txtField' title='Num&eacute;ro de fax du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formFax),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>
										
										<!-- E-mail -->
										<tr>
											<th>E-Mail</th>
											<td><input type='text' name='mail' id='mail' size='40' maxlength='32' class='txtField' title='Adresse E-Mail du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formMail),ENT_QUOTES))?>' autocomplete='off'/>
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("mail","hide")?>">Rentrer une adresse E-Mail valide</td></tr>
										
										<!-- Interne / Externe -->
										<tr class='<?=$test->fieldError("type","required")?>'>
											<th>Type</th>
											<td>
												<select width="332px" style="width: 332px" id='type' name='type' title='Sp&eacute;cialité du m&eacute;decin' onChange='changeTypeMedecin(this.value)'>
													<option value=''>Choisir..</option>
													<option value='interne' <?php if($formType=='interne') echo 'selected';?>>M&eacute;decin interne</option>
													<option value='externe' <?php if($formType=='externe') echo 'selected';?>>M&eacute;decin externe</option>
												</select>
												
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("type","hide")?>">S'agit il d'un interne ou d'un externe ?</td></tr>
										
										
										<!-- Specialite -->
										<tr>
											<th class='<?=$test->fieldError("specialite","required")?>'>Sp&eacute;cialisation</th>
											<td>
											<select width="332px" style="width: 332px" id='specialite' name='specialite' title='Domaine de sp&eacute;cialisation du m&eacute;decin'>
											<?php	
												connexion_DB('poly');
												$sql = 'SELECT id, specialite FROM specialites order by 2';
												$result = mysql_query($sql);
												echo "<option value=''>Choisir</option>";
												while($data = mysql_fetch_assoc($result)) 	{
													// on affiche les specialité
		   											echo "<option value='";
													echo $data['id'];
													echo "' ";
													if($formSpecialite==$data['id']) echo 'selected';
													echo " >";
													echo $data['specialite'];
													echo "</option>";
												}	 
												deconnexion_DB();
											?>
											</select>
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("specialite","hide")?>">Rentrer une specialit&eacute;</td></tr>
										
										
										<!-- Numéro INAMI -->
										<script type='text/javascript'>var valeurinami = '';</script>
										<tr>
											<th id='int_ext' class='<?=$test->fieldError("inami",$interneExterne)?>'>Inami</th>
											<td>
											<input type='text' name='inami' id='inami' size='40' maxlength='11' class='txtField' title='Numéro Inami du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formInami),ENT_QUOTES))?>' autocomplete='off' onKeyUp='javascript:valeurinami = checkNumber(this, valeurinami, 11, false);' autocomplete='off'/>
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("inami","hide")?>">Rentrer un num&eacute;ro d'INAMI valide</td></tr>
										
										<!-- Taux acte -->
										<script type='text/javascript'>var tauxacte = '';</script>
										<tr>
											<th>Taux acte technique</th>
											<td><input type='text' name='taux_acte' id='taux_acte' size='40' maxlength='10' class='txtField' title='Pourcentage du m&eacute;decin sur les actes techniques'  value='<?=$formTauxActe?>' onKeyUp='javascript:tauxacte = checkPourcent(this, tauxacte, 2, 2);' autocomplete='off' />
											</td>
										</tr>
										
										<!-- Taux consultation -->
										<script type='text/javascript'>var tauxconsultation = '';</script>
										<tr>
											<th>Taux consultation</th>
											<td><input type='text' name='taux_consultation' id='taux_consultation' size='40' maxlength='10' class='txtField' title='Pourcentage du m&eacute;decin sur les consultations'  value='<?=$formTauxConsultation?>' onKeyUp='javascript:tauxconsultation = checkPourcent(this, tauxconsultation, 2, 2);' autocomplete='off' />
											</td>
										</tr>

										<!-- Taux prothèse -->
										<script type='text/javascript'>var tauxprothese = '';</script>
										<tr>
											<th>Taux proth&egrave;se</th>
											<td><input type='text' name='taux_prothese' id='taux_prothese' size='40' maxlength='10' class='txtField' title='Pourcentage du m&eacute;decin sur les proth&egrave;ses'  value='<?=$formTauxProthese?>' onKeyUp='javascript:tauxprothese = checkPourcent(this, tauxprothese, 2, 2);' autocomplete='off' />
											</td>
										</tr>

										<!-- Durée consultation -->
										<tr>
											<th>Dur&eacute;e</th>
											<td>
												<select id='duree_consult' name='duree_consult' title='Dur&eacute;e moyenne de la une consultation pour ce m&eacute;decin'>
												<?php
													connexion_DB('poly');
													$sql = 'SELECT id FROM length_consult';
													$result = mysql_query($sql);
													echo "<option value=''>Choisir</option>";
													while($data = mysql_fetch_assoc($result)) 	{
														echo "<option value='".$data['id']."' ";
														if($formDureeConsult==$data['id']) echo 'selected';
														echo " >".$data['id']."</option>";
													}
													deconnexion_DB();
												?>
												</select>
												<b>
													<input type='checkbox' name='agenda' id='agenda' value="checked" <?=$formAgenda?> title='Calendrier de m&eacute;decin'>
													Cadendrier</b> 
												<b>
													<!-- input type='checkbox' name='protocole' id='protocole' value="checked" <?=$formProtocole?> title='Gestion des protocoles pour ce m&eacute;decin'>
													Protocole -->
												</b>
												
												
											</td>
										</tr>

										<!-- Commentaire -->
										<tr>
											<th>Commentaire</th>
											<td><input type='text' name='comment' id='comment' size='40' maxlength='100' class='txtField' title='Commentaire sur le m&eacute;decin (Cecodi, ...)'  value='<?=html_entity_decode(htmlentities(stripcslashes($formComment),ENT_QUOTES))?>' autocomplete='off'/>
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

							<div id = 'table_2' style="display: none;">
							
								<table border='1' cellspacing='0' cellpadding='0'>
								
										<tr>
											<th colspan="2">
										 	<textarea id="TextArea1" name="TextArea1" rows="10" cols="80" style="width:100%">
									    		<? print html_entity_decode(htmlentities(stripcslashes($formTextComment),ENT_QUOTES)); ?>
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
							
							<div id = 'table_3' style="display: none;">
							
								<table border='1' cellspacing='0' cellpadding='0'>
								
										<tr>
											<th colspan="2">
										 	<textarea id="TextArea2" name="TextArea2" rows="10" cols="80" style="width:100%">
									    		<? print html_entity_decode(htmlentities(stripcslashes($formTextHoraire),ENT_QUOTES)); ?>
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
                	
						<div id="findMedecinForm" class="inlineForm">
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
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
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
						<img src='../images/96x96/edit.png'>
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
		var _editor_url = document.location.href.replace(/modif_medecin\.php.*/, '');
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
			
			areaedit_editors = ['TextArea2'];
			areaedit_config = new HTMLArea.Config();
			areaedit_editors   = HTMLArea.makeEditors(areaedit_editors, areaedit_config, areaedit_plugins_minimal);
			areaedit_editors.TextArea2.config.width  = 600;
       		areaedit_editors.TextArea2.config.height = 400;
			HTMLArea.startEditors(areaedit_editors);
			
    	}
 		var submitHandler = function(formname) {
			var form = document.getElementById(formname);
			form.onsubmit(); 
			form.submit();
		}
    	//areaedit_init();
  	</script>

	<!-- ALL JS -->	
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src='../js/medecin.js'></script>
	<script type="text/javascript" src='../js/autosuggest.js'></script>
    <script type="text/javascript">
		var valeurinami = '';
		var tauxacte = '';
		var tauxconsultation = '';
		var tauxprothese = '';
    	var oTextbox = new AutoSuggestControl(document.getElementById("localite"), new StateSuggestions());        
	</script>
	
	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var help = new Window('1', {className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window('2', {className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
		var medecin = new Window('3',{className: "alphacube", title: "Information sur le m&eacute;decin", destroyOnClose:false, top:40, right:40, width:500, height:300});
  		var information = new Window('4', {className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
		function openHelp() {
	  		help.setURL("../lib/aide_en_ligne.php?type=aide&id=<?=$nom_fichier?>");
	  		help.show();
		}
		function openNotice(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=notice&id="+id);
	  		notice.show();
		}
		function openMedecin(type) {
	  		medecin.setURL("../lib/aide_en_ligne.php?type="+type+"&id=<?=$formID?>");
	  		medecin.show();
		}
		function openInformation(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=information_patient&id="+id);
	  		notice.show();
		}
	  	function openModifAssurabilite(html,id) {
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 600, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
  		areaedit_init();
	</script>
		
</body>
</html>