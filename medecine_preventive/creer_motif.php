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
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
        
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "creer_motif.php";
	
	$formNouveauMotif   = isset($_POST['nouveau_motif'])   ? $_POST['nouveau_motif']   : '';
	$formPeriodeNb      = isset($_POST['periode_nb'])      ? $_POST['periode_nb']      : '';
	$formPeriodeBase    = isset($_POST['periode_base'])    ? $_POST['periode_base']    : '';
	$formRequete        = isset($_POST['requete'])         ? $_POST['requete']         : '';
	$formTexteCourrier  = isset($_POST['texteCourrier'])   ? $_POST['texteCourrier']   : '';
	$formSignature      = isset($_POST['signature'])       ? $_POST['signature']       : '';
	$formNomExpediteur  = isset($_POST['nom_expediteur'])  ? $_POST['nom_expediteur']  : '';
	$formMailExpediteur = isset($_POST['mail_expediteur']) ? $_POST['mail_expediteur'] : '';
	$formMailReply      = isset($_POST['mail_reply'])      ? $_POST['mail_reply']      : '';
	$formRueNumero      = isset($_POST['rue_numero'])      ? $_POST['rue_numero']      : '';
	$formCodePostal     = isset($_POST['code_postal'])     ? $_POST['code_postal']     : '';
	$formLocalite       = isset($_POST['localite'])        ? $_POST['localite']        : '';
	$formRecurrence     = isset($_POST['recurrence'])      ? $_POST['recurrence']      : '';

	$formMedecinePreventive = isset($_POST['actionMedecinePreventive'])    ? $_POST['actionMedecinePreventive']    : ''; 

	if($formMedecinePreventive == 1){
		$formRequete       = addslashes($formRequete);
		$formTexteCourrier = html_entity_decode(htmlentities(stripcslashes($formTexteCourrier),ENT_QUOTES));
	
		// Ajout DB
		$adr_ligne1 = $formRueNumero;
		$adr_ligne2 = $formCodePostal." ".$formLocalite;
		$sql = "INSERT INTO `medecine_preventive` ( `motif_ID` , `description` , `periode_nb` , `periode_base` , `texte_principal` , `signature` , `recurrence` , `requete`, `nom_expediteur`, `adr_exp_ligne1`, `adr_exp_ligne2`, `mail_expediteur`,`mail_reply` )
				VALUES ('', '$formNouveauMotif',  '$formPeriodeNb', '$formPeriodeBase', '$formTexteCourrier', '$formSignature', '$formRecurrence', '$formRequete', '$formNomExpediteur', '$adr_ligne1', '$adr_ligne2', '$formMailExpediteur', '$formMailReply' )";
		
		$q = requete_SQL ($sql);
		
		//Ajouter une entrŽe dans la table mp_activation_motifs
		$sql = "SELECT * FROM medecine_preventive WHERE description      = '$formNouveauMotif'
													AND periode_nb       = '$formPeriodeNb'
													AND periode_base     = '$formPeriodeBase'
													AND texte_principal  = '$formTexteCourrier'
													AND signature        = '$formSignature'
													AND recurrence       = '$formRecurrence'
													AND requete          = '$formRequete'
													AND nom_expediteur   = '$formNomExpediteur'
													AND adr_exp_ligne1   = '$adr_ligne1'
													AND adr_exp_ligne2   = '$adr_ligne2'
													AND mail_expediteur  = '$formMailExpediteur'
													AND mail_reply       = '$formMailReply'";
		
		$q = requete_SQL ($sql);
		$res = mysql_fetch_assoc($q);
		$motif = $res['motif_ID'];
		
		$sql = "INSERT INTO `mp_activation_motifs` ( `id_motif` , `actif` )
				VALUES ( '$motif', '1' )";
		
		$q = requete_SQL ($sql);
		//D'abord faire un select pour retrouver l'id du motif => select id_motif where tous les champs
		//faire un insert avec id_motif et '1'
		
		// Valider l'ajout dans la DB
		$_SESSION['information']="Op&eacute;ration r&eacute;ussie ";
				
		// redirection
		header('Location: ../menu/menu.php');
	
		// Fonction de deconnexion à la base de données
		deconnexion_DB();
		die();
	}	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Poly - M&eacute;decine pr&eacute;ventive</title>
	<script type="text/javascript" src='../js/medecinepreventive.js'></script>
	<!-- <script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" src="../scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src='../js/inputControl.js'></script>
    <script type="text/javascript" src='../js/autosuggest.js'></script>
	<script type="text/javascript" src='../js/suggestions.js'></script>
	<script type="text/javascript" src="../thickbox_fichiers/urchin.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/overlib.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/jQuery.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/thickbox.js"></script> 

	<link href="../thickbox_fichiers/thickbox.css" media="screen" rel="stylesheet" type="text/css">
	<link href="../style/basic.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/tabs.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/appt.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/calendar.css" media="all" rel="Stylesheet" type="text/css">
    <link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css"> -->
    
    <link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

	<?php
		get_MENUBAR_START();
		echo "</div></div>";
	?>
	
	<div id="top">
		
		<h1>M&eacute;decine pr&eacute;ventive - Cr&eacute;er un nouveau motif</h1>

	</div>
    
	<div id="middle">
	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
        	</ul>
		</div> 
		
		<div id="main">        
	        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
	
	  				<a href="./consulter_pile.php">Liste de contacts en cours</a>
	   
	   				<span>Cr&eacute;ation d'un nouveau motif de m&eacute;decine pr&eacute;ventive</span> 
	      				
					<a href="./activation_motif.php">Activer/d&eacute;sactiver des motifs</a>
					
					<a href="./mp_batch_fill_pile.php">Activer manuellement la v&eacute;rification de la pile</a>	
				</div>	
					
					
				<div class="ViewPane">
	
					<div class="navigation-hight">
	
						<h2>Nouveau motif</h2>
						
						<fieldset class=''>
							<legend>Aide</legend>
							Ce formulaire permet de rentrer un nouveau motif pour la m&eacute;decine pr&eacute;ventive. Il est demand&eacute; d'entrer le motif, la p&eacute;riode pr&eacute;c&eacute;dant le rappel, les crit&egrave;res de s&eacute;lection (sources et conditions), le texte &agrave; ins&eacute;rer dans le courrier et &eacute;ventuellement la r&eacute;currence du motif.<br>
						</fieldset>
						
					</div>
					
	
					<div id="secondmain" class="formBox">
						
						<form name='creer_motif' id='creer_motif' method='post' action='<?=$nom_fichier?>'>
	                            <?php echo $info_erreurs; ?>
	   
						<input type='hidden' name='actionMedecinePreventive' value='1'>
						
						<!-- Insert -->
						<fieldset class=''>
							<legend>Description du motif</legend>
								<table ID="motif" border='1' cellspacing='0' cellpadding='0'>
								    
								    <!-- Motif -->
									<tr>
										<th class='<?=$test->fieldError("motif","required")?>'>Motif</th>
										<td class='formInput'>
										
											<select name='motif' id='motif' onChange="checkmotif(this);">
												<?
													$sql = "SELECT motif_ID, description FROM medecine_preventive";
													$result = requete_SQL ($sql);
													echo"<option value='-1'></option>";
													while($data = mysql_fetch_assoc($result)){
														echo"<option id=".htmlentities(stripcslashes($data['motif_ID']),ENT_QUOTES).
														        " value=".htmlentities(stripcslashes($data['motif_ID']),ENT_QUOTES).">".
													       	              htmlentities(stripcslashes($data['description']),ENT_QUOTES).
														    "</option>";
													}       
												?>
												<option id="0" value="0">Nouveau</option>
											</select>
										
											<input type='text' name='nouveau_motif' id='nouveau_motif' size='50' maxlength='45' class='txtField' title='Nouveau motif' value='<?=html_entity_decode(htmlentities(stripcslashes($formNouveauMotif),ENT_QUOTES))?>' autocomplete='off' readonly='true'>
										</td>
									</tr>
									<!-- FIN Motif -->
		
									
									<!-- Periode -->
									<tr>
										<th class='<?=$test->fieldError("periode","required")?>'>P&eacute;riode</th>
										<td class='formInput'>
											<input type='text' name='periode_nb' id='periode_nb' size='5' maxlength='3' class='txtField' title='P&eacute;riode' value='<?=html_entity_decode(htmlentities(stripcslashes($formPeriodeNb),ENT_QUOTES))?>' autocomplete='off' onfocus="javascript:this.select()">
											<select name='periode_base' id='periode_base' title='P&eacute;riode'>
												<option id="jours"  value='jours' >Jours</option>
												<option id="mois"   value='mois'  >Mois</option>
												<option id="annees" value='annees'>Ann&eacute;es</option>
											</select>
										</td>
									</tr>
									<!-- FIN Periode -->
									
									
									<!-- Criteres -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Requ&ecirc;te pour la s&eacute;lection</th>
										<td><br>
											<b><u>
											<a onclick="window.open('./formulaire_requete_type.php'); ">Cr&eacute;ation simplifi&eacute;e des crit&egrave;res</a>
											</u></b>
											<br>
											<br>
											<b><u>
											<a onclick="window.open('./creer_criteres.php'); ">Cr&eacute;ation des crit&egrave;res (mode expert)</a>
											</u></b>
											<br>
											<br>
											Requ&egrave;te: <input type='text' name='requete' id='requete' size='110' class='txtField' title='Requ&ecirc;te' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Critere -->
									
									<!-- Texte pour courrier -->
									
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Texte principal pour le courrier</th>
										<td><textarea name='texteCourrier' id='texteCourrier' class='txtField' cols='170' rows='25' title='Texte principal pour le courrier' onfocus='javascript:this.select()'>
											 <?echo $formTexteCourrier;?>
											</textarea>	
										</td>
									</tr>
									
									<!-- FIN Texte pour courrier -->
									
									<!-- Signature -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Signature pour le courrier</th>
										<td><input type='text' name='signature' id='signature' size='60' class='txtField' title='Signature' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Signature -->
									
									<!-- Nom de l expediteur -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Nom de l'exp&eacute;diteur</th>
										<td><input type='text' name='nom_expediteur' id='nom_expediteur' size='60' class='txtField' title='Nom de l\'exp&eacute;diteur' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Nom de l expediteur -->
									
									<!-- Adresse de l expediteur -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Adresse de l'exp&eacute;diteur</th>
										<td><input type='text' name='rue_numero'  id='rue_numero'  size='60' class='txtField' title='Rue et num&eacute;ro' autocomplete='off' onfocus='javascript:this.select()'>
										<br><input type='text' name='code_postal' id='code_postal' size='4'  class='txtField' title='Code postal' autocomplete='off' onfocus='javascript:this.select()'>
											<input type='text' name='localite'    id='localite'    size='60' class='txtField' title='Localit&eacute;' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Adresse de l expediteur -->
									
									<!-- Mail de l expediteur -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>Mail de l'exp&eacute;diteur</th>
										<td><input type='text' name='mail_expediteur' id='mail_expediteur' size='60' class='txtField' title='Mail de l\'exp&eacute;diteur' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Mail de l expediteur -->
									
									<!-- Mail reply -->
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>R&eacute;pondre &agrave; l'adresse mail</th>
										<td><input type='text' name='mail_reply' id='mail_reply' size='60' class='txtField' title='R&eacute;pondre &agrave; l\'adresse mail' autocomplete='off' onfocus='javascript:this.select()'>
										</td>
									</tr>
							
									<!-- FIN Mail reply -->
									
									<!-- Recurrence -->
									
									<tr>
										<th class='<?=$test->fieldError("requete","required")?>'>R&eacute;currence</th>
										<td><select name='recurrence' id='recurrence' class='txtField' title='R&eacute;currence par rapport au 1er janvier'>
												<option value='annuelle'>     Annuelle     </option>
												<option value='semestrielle'> Semestrielle </option>
												<option value='trimestrielle'>Trimestrielle</option>
												<option value='mesuelle'>     Mensuelle    </option>
												<option value='hebdomadaire'> Hebdomadaire </option>
											</select>	
										</td>
									</tr>
									
									<!-- FIN Recurrence -->
										
									<tr>
										<th class='formLabel'><label for='validation'></label>
										</th>
										<td class='formInput'>
											<input type="submit" class="button" value="Valider">
										</td>
									</tr>
									
								</table>
							</fieldset>
	
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
	
						<a onclick="Element.toggle('addLabelFormMedecin'); Element.hide('addLabelFormPatient'); Element.hide('addLabelFormMutuelle');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
	                
						<h2>Informations</h2>
	                	
						<div id="addLabelFormMedecin" name="addLabelFormMedecin" class="inlineForm" style="display: none;">
							<form id="createLabelFormMedecin" onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMedecinInput" type="text" onFocus="this.select()" onKeyUp="javascript:medecin_recherche_simple(this.value)">
	                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
	                  		</form>
	                		<div id="information_medecin" class="allApplied">
							</div>
						</div>
	
					</div>
				
				<a class="taskControl" href="../patients/recherche_patient.php">Recherche patient</a>

				<div id="labels" class="sidebar labels-red">

					<a onclick="Element.toggle('addLabelFormPatient');Element.hide('addLabelFormMedecin');Element.hide('addLabelFormMutuelle');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                
					<h2>Informations</h2>
                	
					<div id="addLabelFormPatient" name="addLabelFormPatient" class="inlineForm">
						<form id="createLabelFormPatient" onsubmit="">
                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
                  		</form>        
                		<div id="information_patient" class="allApplied">
						</div>
					</div>

				</div>

				<a class="taskControl" href="../mutuelles/recherche_mutuelle.php">Recherche mutuelle</a>
			
				<div class="sidebar labels-green">

					<a onclick="Element.toggle('addLabelFormMutuelle'); Element.hide('addLabelFormPatient'); Element.hide('addLabelFormMedecin'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                
					<h2>Informations</h2>
                	
					<div id="addLabelFormMutuelle" name="addLabelFormMutuelle" class="inlineForm" style="display: none;">
						<form id="createLabelFormMutuelle" onsubmit="">
                  			<input autocomplete="off" class="text-input" id="findMutuelleInput" type="text" onFocus="this.select()" onKeyUp="javascript:mutuelle_recherche_simple(this.value)">
                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
                  		</form>
                		<div id="information_mutuelle" class="allApplied">
						</div>
					</div>

				</div>
		
				<div id="footer">
					<p>targoo@gmail.com bmangel@gmail.com</p>  
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
		var _editor_url = document.location.href.replace(/creer_motif\.php.*/, '');
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
		function openHelp() {
	  		help.setURL("../lib/aide_en_ligne.php?type=aide&id=<?=$nom_fichier?>");
	  		help.show();
		}
		function openNotice(id) {
	  		notice.setURL("../lib/aide_en_ligne.php?type=notice&id="+id);
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