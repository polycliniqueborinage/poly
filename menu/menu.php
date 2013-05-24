<?php

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

	// Nom du fichier en cours 
	$nom_fichier = "menu.php";
	
	$role = $_SESSION['role'];
	
	unset ($_SESSION['redirect']);
	
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Menu</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Menu</h1>
		
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
				</div>
					
				<div class="ViewPane">
				
					<?php 
						echo $_SESSION['information'];
						unset ($_SESSION['information']);
					?>
					<div id='flash'>
					<?php
					
						include_once '../lib/aide_en_ligne.php';
					?>
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

						<a onclick="Element.toggle('findMedecinForm'); Element.hide('findPatientForm');Element.hide('createPatientForm');Element.hide('findMutuelleForm');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
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

						<a onclick="Element.toggle('findPatientForm');Element.hide('createPatientForm');Element.hide('findMutuelleForm');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
							</div>
						</div>

					</div>
			
            		<a class="taskControl" href="#">Nouveau patient</a>

					<div id="labels" class="sidebar labels-green">
                	
						<a onclick="Element.toggle('createPatientForm');Element.hide('findPatientForm');Element.hide('findMedecinForm');Element.hide('findMutuelleForm');" href="#" class="controls" style="display: block;">Ajout d'un patient...</a>
                	
						<div id="createPatientForm" class="inlineForm" style="display: none;">
							<input autocomplete="off" class="text-input" id="createLastNamePatientInput" type="text" onBlur="setInput(this,'Nom du patient')" value="Nom du patient" title="Nom du patient" onfocus="javascript:this.value=''">
							<input autocomplete="off" class="text-input" id="createFirstNamePatientInput" type="text" onBlur="setInput(this,'Prenom du patient')" value="Prenom du patient" title="Prénom du patient" onfocus="javascript:this.value=''">
							<input autocomplete="off" class="text-input" id="createBirthdayPatientInput" type="text" onBlur="setInput(this,'Date de naissance')" value="Date de naissance" title="Date de naissance" onfocus="javascript:this.value=''" onkeyup="javascript:dateFirstExecutionresult = checkDate(this, '', '');">
							<input autocomplete="off" class="text-input" id="createPhoneNumberInput" type="text" onBlur="setInput(this,'T&eacute;l&eacute;phone')" value="T&eacute;l&eacute;phone" title="T&eacute;l&eacute;phone" onfocus="javascript:this.value=''">
							<input class="button" name="commit" value="Sauver..." onClick="savePatient();">                			
                		</div>
					</div>
					
					<a class="taskControl" href="../mutuelles/recherche_mutuelle.php">Recherche mutuelle</a>
				
					<div class="sidebar labels-red">

						<a onclick="Element.toggle('findMutuelleForm'); Element.hide('createPatientForm'); Element.hide('findMedecinForm'); Element.hide('findPatientForm'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
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
						<img src='../images/96x96/go-home.png'>
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
	<!-- script type="text/javascript" src="../yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="../yui/build/container/container_core-min.js"></script>
    <script type="text/javascript" src="../yui/build/menu/menu-min.js"></script-->
	<script type='text/javascript'>
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

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var dateFirstExecutionresult='';
		help = new Window('1', {className: "alphacube", title: "Aide en ligne", top:0, right:0, width:500, height:300}); 
  		notice = new Window('2', {className: "alphacube", title: "Notice", top:20, right:20, width:500, height:300 });
  		var information = new Window('4', {className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
		function openModifAssurabilite(html,id) {
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 600, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
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
	</script>
	
</body>
</html>


