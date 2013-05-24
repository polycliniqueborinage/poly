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

	// Nom du fichier en cours 
	$nom_fichier = "recherche_patient.php";
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Recherche des patients</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Patients - Recherche d'un patient</h1>

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
   
	  				<span>Recherche</span> 

    				<a href="./add_patient_titulaire.php">Ajout d'un patient titulaire</a>
						
					<a href="./add_patient_non_titulaire.php">Ajout d'un patient non titulaire</a>
      					
	  				<a href="./listing_patient.php">Listing</a>
												
	  				<a href="./listing_patient_comment.php">Patient &agrave; suivre</a>

				</div>
	
				<div class="listViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet de rechercher et de modifier un patient à condition que celui-ci existe d&eacute;j&agrave; dans l'application.<br />
						</div>
						<div id='formmodif'>
						</div>
							
					</div>
					
					<div id='Box'>
						<table cellspacing="1" cellpadding="1">
							<tbody>
								<tr>
									<th class="green patient">
										Patient : <input type='text' name='patient' id='patient' size='40' maxlength='32' class='txtField' title='Nom, pr&eacute;nom ou num&eacute;ro NISS du patient' value='' onKeyUp='patientRechercheComplete(this.value);patientRechercheDirectRecherche(this.value);' autocomplete='off' />
									</th>
									<th class="green patient">
										Titulaire : <input type='text' name='titulaire' id='titulaire' size='40' maxlength='32' class='txtField' title='Nom, pr&eacute;nom ou num&eacute;ro NISS du titulaire' value='' onKeyUp='titulaireRechercheComplete(this.value);patientRechercheDirectRecherche(this.value);' autocomplete='off' />
									</th>
								</tr>
								<tr>
									<td colspan='2' class='texte' id='patientBox'>
									</td>
								</tr>
							</tbody>
						</table>
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
						<img src='../images/96x96/find.png'>
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

	<!-- ALL JS -->
	<script type="text/javascript" src='../js/patient.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
	<script type="text/javascript" src="../js/functions.js"></script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var compteur = 0;
		$('patient').focus();
		var help = new Window('10', {className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window('11', {className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
  		var information = new Window('14', {className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
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
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 700, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
		function openPatientInfo(id) {
			var url = "../patients/patient_detail.php?id="+id;
			switch ( compteur )	{
			case 0:
				compteur = (compteur+1)%4;
				win0 = new Window({className: "alphacube", title: "Information Patient", top:0, right:0, width:540, height:400 });  
				win0.setURL(url)
				win0.show();
			break;
			case 1:
				compteur = (compteur+1)%4;
				win1 = new Window({className: "alphacube", title: "Information Patient", top:20, right:20, width:540, height:400 });  
				win1.setURL(url)
				win1.show();
			break;
			case 2:
				compteur = (compteur+1)%4;
				win2 = new Window({className: "alphacube", title: "Information Patient", top:40, right:40, width:540, height:400 });  
				win2.setURL(url)
				win2.show();
			break;
			default :
				compteur = (compteur+1)%4;
				wind = new Window({className: "alphacube", title: "Information Patient", top:60, right:60, width:540, height:400 });  
				wind.setURL(url)
				wind.show();
			}
		}
		function openDialogConfirmDelPatient(id) {
			new Ajax.Request('../patients/patient_action.php',
				{
					method:'get',
					parameters: {type : 'info_patient', id : id, champs : '', value : ''},
					asynchronous:false,
					requestHeaders: {Accept: 'application/json'},
			  		onSuccess: function(transport, json){
			  			var comment = json.root.info_patient;
			  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer</b> le patient suivant : <br><br>"+comment+"</tr></table", {width:400, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {patientAction('del_patient',id,'',''); return true;} });
		    	    },
				    onFailure:  function(){ alert('failure');} 
				});
		}
	</script>
    
</body>
</html>

