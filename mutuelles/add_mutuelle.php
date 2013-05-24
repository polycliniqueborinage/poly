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
		
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "add_mutuelle.php";
	$info_erreurs = "";
	
	// Variables du formulaire
	$actionAddMutuelle = isset($_POST['actionAddMutuelle']) ? $_POST['actionAddMutuelle'] : '';
		
	$formNom = isset($_POST['nom']) ? $_POST['nom'] : '';
	$formNom = ucfirst(strtolower($formNom));
	$formNom = $test->convert($formNom);
	
	$formCode = isset($_POST['code']) ? $_POST['code'] : '';
	$formCode = $test->convert($formCode);
	
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
	
	$formTelephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
	$formTelephone = $test->convert($formTelephone);
	
	$formMail = isset($_POST['mail']) ? $_POST['mail'] : '';
	$formMail = $test->convert($formMail);
	
	$formFax = isset($_POST['fax']) ? $_POST['fax'] : '';
	$formFax = $test->convert($formFax);
	
	$formContact = isset($_POST['contact']) ? $_POST['contact'] : '';
	$formContact = ucfirst(strtolower($formContact));
	$formContact = $test->convert($formContact);
	
	// Validation des variables
	if ($actionAddMutuelle == 1) {
	
  		$test->stringtest($formNom,"nom","nom");
  		$test->codemututest($formCode,"code","code");
		$test->mailtest($formMail,"mail","adresse mail");

		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			$q = requete_SQL ("SELECT code FROM mutuelles WHERE code='$formCode'");
			
			$n = mysql_num_rows($q);
					
    		if ($n == 0) {
	
				// Ajout DB - mutuelles
				$q = requete_SQL ("INSERT INTO mutuelles (code,nom,rue,code_postal,commune,telephone,mail, fax,contact) VALUES ('$formCode','$formNom','$formRue','$formCodePostal','$formCommune','$formTelephone','$formMail','$formFax','$formContact')");
				// Valider l'ajout dans la DB
				
				// Valider l'ajout dans la DB
				$_SESSION['information']="<div id='dbinfo'>Op&eacute;ration r&eacute;ussie - La mutuelle ".html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))." a &eacute;t&eacute; correctement ajout&eacute; &agrave; la base de donn&eacute;e</div>";

				if(isset($_SESSION['redirection'])) {
					unset($_SESSION['redirection']);
					header('Location: ../menu/menu.php');
				} else {
					header('Location: ../menu/menu.php');
				}
				
				die();
				
			}
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 1) {
			$info_erreurs = "<div id='formerreur'>Corriger le champ &eacute;rron&eacute; : $test->ListeErreur !</div>";
		} else {
			if ($test->Count == 0) {
				$info_erreurs = "<div id='formerreur'>Une mutuelle existe d&eacute;j&agrave; avec ce code !</div>";
			} else {
				$info_erreurs = "<div id='formerreur'>Corriger les $test->Count champs &eacute;rron&eacute;s : $test->ListeErreur !</div>";
			}
		}
       	
       	
	}
	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'une mutuelle</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

   	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Mutuelles - Ajout d'une mutuelle</h1>

	</div>
    
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Mutuelles</a>
				</li>
        	</ul>
		</div>      
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
					<a href="./recherche_mutuelle.php">Reherche</a>

    				<span>Ajout</span> 

	  				<a href="./listing_mutuelle.php">Listing</a>
												
				</div>
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet d'encoder une nouvelle mutuelle &agrave; condition que celle-ci n'existe pas encore dans l'application.<br />
						</div>
						<?php echo $info_erreurs ?>
							
						</div>
						
						<div id="secondmain" class="formBox">

							<form name='addMutuelleForm' id='addMutuelleForm' method='post' action='<?=$nom_fichier?>'>
							
								<input type='hidden' name='actionAddMutuelle' value='1'>

								<!-- Insert -->
								<table border='1' cellspacing='0' cellpadding='0'>
										
										
										
										<!-- Nom -->
										<tr>
											<th class='<?=$test->fieldError("nom","required")?>'>Nom</th>
											<td><input type='text' name='nom' id='nom' size='40' maxlength='32' class='txtField' title='Nom du mutuelle' value='<?=html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))?>' onKeyUp='javascript:mutuelleRechercheDirect(this.value);' onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>										
										<tr><td></td><td class="<?=$test->fieldError("nom","hide")?>">Rentrer un nom valide</td></tr>
										
										<!-- code -->
										<script type='text/javascript'>var codemut = '';</script>
										<tr>
											<th class='<?=$test->fieldError("code","required")?>'>Code</th>
											<td><input type='text' name='code' id='code' size='40' maxlength='3' class='txtField' title='Code de la mutuelle'  value='<?=$formCode?>' onKeyUp='javascript:codemut = checkNumber(this, codemut, 3, false);mutuelleRechercheDirect(this.value);'  onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("code","hide")?>">Rentrer un code valide</td></tr>
										
										<!-- Adresse -->
										<tr>
											<th>Rue</th>
											<td>
												<input type='text' name='rue' id='rue' size='40' maxlength='100' class='txtField' title='Rue de l adresse du m&eacute;decin'  value='<?=html_entity_decode(htmlentities(stripcslashes($formRue),ENT_QUOTES))?>'  onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>
										<tr>
											<th>Code Postal - Localit&eacute;</th>
											<td>
												<input type="text" id="localite" name="localite" alt="Code postal et ville de l adresse du m&eacute;decin" size='40' maxlength='32' value='<?=html_entity_decode(htmlentities(stripcslashes($formLocalite),ENT_QUOTES))?>'  onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>

										<!-- Télephone -->
										<tr>
											<th>T&eacute;l&eacute;phone</th>
											<td><input type='text' name='telephone' id='telephone' size='40' maxlength='32' class='txtField' title='T&eacute;l&eacute;phone de la mutuelle'  value='<?=$formTelephone?>'  onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>

										<!-- GSM -->
										<tr>
											<th>Fax</th>
											<td><input type='text' name='fax' id='fax' size='40' maxlength='32' class='txtField' title='Num&eacute;ro de Fax de la mutuelle'  value='<?=$formFax?>'  onfocus="this.select()" autocomplete='off'/>
											</td>
										</tr>
										
										<!-- E-mail -->
										<tr>
											<th  class='<?=$test->fieldError("mail","optionnel")?>'>E-Mail</th>
											<td><input type='text' name='mail' id='mail' size='40' maxlength='32' class='txtField' title='Adresse E-Mail de la mutuelle'  value='<?=$formMail?>' onfocus="this.select()" autocomplete='off' />
											</td>
										</tr>
										<tr><td></td><td class="<?=$test->fieldError("mail","hide")?>">Rentrer une adresse E-Mail valide</td></tr>
										
										<!-- Contact -->
										<tr>
											<th>Personne de contact</th>
											<td><input type='text' name='contact' id='contact' size='40' maxlength='32' class='txtField' title='Personne de contact &agrave; la mutuelle'  value='<?=html_entity_decode(htmlentities(stripcslashes($formContact),ENT_QUOTES))?>' autocomplete='off' onFocus="this.Select()" />
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
                	
						<div id="findMutuelleForm" class="inlineForm">
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
						<img src='../images/96x96/add.png'>
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

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>

	<!-- ALL JS -->
	<script type="text/javascript" src="../js/mutuelle.js"></script>
	<script type="text/javascript" src='../js/common.js'></script>
	<script type="text/javascript" src='../js/autosuggest.js'></script>
	<script type="text/javascript">
	    window.onload = function () {
	    	var oTextbox = new AutoSuggestControl(document.getElementById("localite"), new StateSuggestions());        
		}
		document.addMutuelleForm.nom.focus();
	</script>

	<script type="text/javascript">  
		var help = new Window('1', {className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window('2', {className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
  		var information = new Window({className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
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

</body>
</html>