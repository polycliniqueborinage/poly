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
	$nom_fichier = "activation_motif.php";
	
	$formModifierListe = isset($_POST['actionModifierListe'])    ? $_POST['actionModifierListe']    : ''; 

	if($formModifierListe == 1){
		
		// Modifier DB
		$sql = "SELECT * FROM mp_activation_motifs ";
		$req = requete_SQL ($sql);
		
		while($liste = mysql_fetch_assoc($req)) 	{
			$formCheckbox = isset($_POST[$liste['id_motif']]) ? $_POST[$liste['id_motif']] : '';

			if($formCheckbox == 'on') $activation = '1';
			else $activation = '0';	
			
			$sql = "UPDATE `mp_activation_motifs` 
					SET `actif` = '$activation' 
				    WHERE `id_motif`   = '".$liste['id_motif']."'";
			
			$q = requete_SQL ($sql);
			
		}	
		// Valider l'ajout dans la DB
		$_SESSION['information']="Op&eacute;ration r&eacute;ussie ";
	
	}	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Poly - M&eacute;decine pr&eacute;ventive</title>
	<script type="text/javascript" src='../js/medecinepreventive.js'></script>

	<link href="../thickbox_fichiers/thickbox.css" media="screen" rel="stylesheet" type="text/css">
	<link href="../style/basic.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/tabs.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/appt.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/calendar.css" media="all" rel="Stylesheet" type="text/css">
    <link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css">
    
    <link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
	
	<?php echo"checkbx = ".$formCheckbox;
		get_MENUBAR_START();
		echo "</div></div>";
	?>
		
	<div id="top">
		
		<h1>M&eacute;decine pr&eacute;ventive - Activer/D&eacute;sactiver des motifs</h1>

	</div>

	<div id="middle">
	
	<div id="header">
        <ul id="primary_tabs">
			<?php get_MENU('medecine_preventive')?>
        </ul>
	</div>  
      
	  	<div id="main">        
	        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
					<a href="./consulter_pile.php">Liste des motifs de m&eacute;decine pr&eacute;ventive</a>
	   
	   				<a href="./creer_motif.php">Cr&eacute;ation d'un nouveau motif de m&eacute;decine pr&eacute;ventive</a> 
	      				
					<span>Activer/d&eacute;sactiver des motifs</span>
					
					<a href="./mp_batch_fill_pile.php">Activer manuellement la v&eacute;rification de la pile</a>
				</div>								
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<h2>Liste des motifs de m&eacute;decine pr&eacute;ventive</h2>
						
						<fieldset class=''>
							<legend>Aide</legend>
							Ce formulaire permet de consulter la liste des motifs de m&eacute;decine pr&eacute;ventive afin de les d&eacute;sactiver ou de les r&eacute;activer.<br>
						</fieldset>
						
					</div>
					
					<div id="secondmain" class="formBox">
						
						<form name='updateListe' id='updateListe' method='post' action='<?=$nom_fichier?>'>
                            <?php echo $info_erreurs; ?>
   
						<input type='hidden' name='actionModifierListe' value='1'>
						
						<!-- Insert -->
						<fieldset class=''>
							<legend>Liste des motifs de m&eacute;decine pr&eacute;ventive</legend>
								<?
								// On fait la requête

								$sql = "SELECT * FROM mp_activation_motifs ";

								// VERIFICATION
								$result = requete_SQL ($sql);
	
								if(mysql_num_rows($result)!=0) {

									echo "<table border='0' cellpadding='2' cellspacing='1'>";
									echo "<th>ID du motif</th>";
									echo "<th>Description</th>";
									echo "<th>Actif</th>";
									echo "</th>";

									$i = 0;

									?>
									
									<div id="boxElementList">
									</div>
									
									<?
									
									while($data = mysql_fetch_assoc($result)) 	{
									
									if ($i == 20) {
										
										$i = 0;
										echo "<table border='0' cellpadding='2' cellspacing='1'>";
										echo "<th>ID du motif</th>";
										echo "<th>Description</th>";
										echo "<th>Actif</th>";
										echo "</th>";
							  		}
									
									$i++;
																			
									// on affiche les informations de l'enregistrement en cours
									echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";
									
									$req_select_motif   = "select * FROM medecine_preventive WHERE motif_ID = ".$data['id_motif'];
									
									$res_motif   = requete_SQL($req_select_motif);
									
									$motif   = mysql_fetch_assoc($res_motif);
									
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $motif['motif_ID'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $motif['description'];
									echo "</td>";
									
									if($data['actif'] == 0){
										echo"<td align='center'>";
										echo"<input type=checkbox id='".$motif['motif_ID']."' name='".$motif['motif_ID']."'>";
										echo"</td>";
									}	
									else{
										echo"<td align='center'>";
										echo"<input type=checkbox id='".$motif['motif_ID']."' name='".$motif['motif_ID']."' checked>";
										echo"</td>";
									}	
										
									echo"</tr>";
								}
							
								echo "</table>";
						
							}?>
							</fieldset>

						 <center><input type="submit" value="Valider les changements"></center>

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
		var _editor_url = document.location.href.replace(/activation_motif\.php.*/, '');
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