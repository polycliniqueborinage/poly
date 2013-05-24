<?
// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';

// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	$result = requete_sql("SELECT * FROM medecine_preventive, mp_activation_motifs WHERE motif_ID = id_motif AND actif = 1");
	
	$date_jour = date("Y-m-d");
	
	while($data = mysql_fetch_assoc($result)) 	{
		$requete_nettoyee = str_replace('\\', '', $data['requete']);
		for($i=0; $i<strlen($requete_nettoyee); $i++){
			if($requete_nettoyee[$i] == 0 && $requete_nettoyee[$i+4] == '-' && $requete_nettoyee[$i+7] == '-'){
				$annee_en_cours = date("Y");
				$annee_calculee = substr($requete_nettoyee, $i, 4);
				
				$mois_en_cours = date("m");
				$mois_calculee = substr($requete_nettoyee, $i+5, 2);
				
				$jour_en_cours = date("d");
				$jour_calculee = substr($requete_nettoyee, $i+8, 2);
				
				$annee     = $annee_en_cours - $annee_calculee;
				$mois      = $mois_en_cours  - $mois_calculee;
				$jour      = $jour_en_cours  - $jour_calculee;
				
				
				if(strlen($mois) == 1){
					$mois = '0'.$mois; 
				}
				
				if(strlen($jour) == 1){
					$jour = '0'.$jour; 
				}
				
				$requete_nettoyee = substr_replace($requete_nettoyee, $annee, $i,   4);
				$requete_nettoyee = substr_replace($requete_nettoyee, $mois,  $i+5, 2);
				$requete_nettoyee = substr_replace($requete_nettoyee, $jour,  $i+8, 2);
			}
		}
		//$requete_nettoyee = str_replace('0000-00-00', $date_jour, $requete_nettoyee);
		$requete_mp = requete_SQL($requete_nettoyee);
		
		while($population = mysql_fetch_assoc($requete_mp)){
			$exist_already = "SELECT * FROM mp_pile WHERE id_motif = ".$data['motif_ID']." AND id_patient = ".$population['id'];
			
			$record = requete_sql($exist_already);
			
			//Un record existe deja pour ce motif et cette personne
			if(mysql_num_rows($record)!=0) {
				$pile = mysql_fetch_assoc($record);
				//On considere que la duree de rappel equivaut a la periode de prevention / 2
				switch($data['periode_base']){
					case 'jours':
					$duree_rappel = round($data['periode_nb'] / 2);
					break;
					
					case 'mois':
					$duree_rappel = round($data['periode_nb'] * 30 / 2);
					break;
					
					case 'annees':
					$duree_rappel = round($data['periode_nb'] * 365 / 2);
					break; 
				}
				
				//si la date de rappel est depassee et qu'on a deja contacte, il faut avertir l'utilisateur pour effectuer un rappel
				if($duree_rappel >= round((strtotime($date_jour) - strtotime($pile['date_derniere_modification']))/(60*60*24)-1) && $pile['statut'] == 'contacte'){
				 	$insert_rappel = "UPDATE `mp_pile` SET statut='a_rappeler', date_derniere_modification='".$date_jour."' WHERE id_motif = '".$data['motif_ID']."' AND id_patient  	= '".$population[0]."'";
				 	requete_sql($insert_rappel);
				}
				//sinon, si la periode entre maintenant et le dernier contact est plus grande que la recurrence du motif
				else{
					switch($data['recurrence']){
						case 'annuelle':
						$duree_recurrence = 365;
						break;
						
						case 'semestrielle':
						$duree_recurrence = 183;
						break;
						
						case 'trimestrielle':
						$duree_recurrence = 91;
						break;
						
						case 'mensuelle':
						$duree_recurrence = 30;
						break;
						
						case 'hebdomadaire':
						$duree_recurrence = 7;
						break;
					}
					if($duree_recurrence < round((strtotime($date_jour) - strtotime($pile['date_derniere_modification']))/(60*60*24)-1)){
						//supprimer l'ancien record
						$delete_record = "DELETE FROM mp_pile WHERE id_motif = ".$pile['id_motif']." AND id_patient = ".$pile['id_patient'];
						requete_sql($delete_record);
						
						//ajouter le nouveau
						$insert_record = "INSERT INTO `mp_pile` ( `id_motif` , `id_patient` , `date_derniere_modification` , `statut`)
						VALUES ('".$data['motif_ID']."', '".$population['id']."',  '', 'a_contacter')";
						
						requete_sql($insert_record);
					}
				}
			}
			//Il faut inserer un record car la personne doit etre contactee
			else{
				$insert_record = "INSERT INTO `mp_pile` ( `id_motif` , `id_patient` , `date_derniere_modification` , `statut`)
				VALUES ('".$data['motif_ID']."', '".$population['id']."',  '', 'a_contacter')";
				
				requete_sql($insert_record);
			}
		}	
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
		
		<h1>M&eacute;decine pr&eacute;ventive - Consulter la pile</h1>

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
					<a href="./consulter_pile.php">Liste de contacts en cours</a>					
	   
	   				<a href="./creer_motif.php">Cr&eacute;ation d'un nouveau motif de m&eacute;decine pr&eacute;ventive</a> 
	      				
					<a href="./activation_motif.php">Activer/d&eacute;sactiver des motifs</a>
					
					<span>Activer manuellement la v&eacute;rification de la pile</span>
				</div>								
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<h2>Liste de contacts</h2>
						
						<fieldset class=''>
							<legend>Aide</legend>
							Ce formulaire permet de consulter la liste des personnes à contacter ou à recontacter.<br>
						</fieldset>
						
					</div>
					
					<div id="secondmain" class="formBox">
						
						Les v&eacute;rification de m&eacute;decine pr&eacute;ventive ont &eacute;t&eacute; appliqu&eacute;es.
						
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
		var _editor_url = document.location.href.replace(/mp_batch_fill_pile\.php.*/, '');
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