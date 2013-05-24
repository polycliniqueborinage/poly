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
	$nom_fichier = "listing_acte.php";
	
	$modif1 = "<a href=\'./modif_acte.php?id=";
	$modif2 = "\' ><img width=\'16\' height=\'16\' src=\'../images/modif_small.gif\' alt=\'Modifier\' title=\'Modifier\' border=\'0\' /></a>";
	
	$sqlglobal= "select concat('$modif1',id,'$modif2'), code, description, cecodis, cout_tr, cout_tp, cout_vp, length FROM actes order by description";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Listing des actes</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<? 
		require "applib.php";

		session_set_cookie_params(60*60);

		$_SESSION['ex50']=$sqlglobal;

		require "../rico/plugins/chklang.php";
		require "../rico/plugins/settings.php";
	?>

	<script src="../rico/src/rico.js" type="text/javascript"></script>
	<script type='text/javascript'>
		Rico.loadModule('LiveGridAjax');
		Rico.loadModule('LiveGridMenu');
		<?
			setStyle();
			setLang();
		?>
		var orderGrid,buffer;

		Rico.onLoad( function() {
			var opts = {  
				<? GridSettingsScript(); ?>,
    			columnSpecs   : [,,,,,{type:'date'},{type:'date'}]
  			};
  		buffer=new Rico.Buffer.AjaxSQL('ricoXMLquery.php', {TimeOut:<? print array_shift(session_get_cookie_params())/60 ?>});
  		orderGrid=new Rico.LiveGrid ('ex50', buffer, opts);
  		orderGrid.menu=new Rico.GridMenu(<? GridSettingsMenu(); ?>);
		});

	</script>
</head>

<body id='body'>

	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Acte interne - Listing des actes internes</h1>

		<a class="impression" href="../factures/printacte.php"></a>

	</div>
    
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('prestations')?>
        	</ul>
		</div>      
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
					<a href="../cecodis/recherche_cecodi.php">Recherche</a>

					<a href="../cecodis/add_cecodi.php">Ajout prestation INAMI</a>

      				<a href="../cecodis/listing_cecodi.php">Listing</a>
      					
					<a href="../actes/recherche_acte.php">Recherche</a>

					<a href="../actes/add_acte.php">Ajout acte interne</a>
      					
	  				<span>Listing</span> 
												
				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">
						
						<div id='formhelp'>
							Liste de tous les actes techniques internes encod&eacute;s dans l'application.<br />
						</div>
							
					</div>
						
					<div id="secondmain" >
						
						<span id="ex50_bookmark"></span>
							
						<table id="ex50" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
							<colgroup>
								<col style='width:20px;' >
								<col style='width:40px;' >
								<col style='width:75px;' >
								<col style='width:75px;' >
								<col style='width:25px;' >
								<col style='width:25px;' >
								<col style='width:25px;' >
								<col style='width:40px;' >
							</colgroup>
							<tr>
		  						<th></th>
		  						<th>Code</th>
		  						<th>Description</th>
		  						<th>Codes Inami Associ&eacute;s</th>
								<th>Co&ucirc;t Travailleur</th>
								<th>Co&ucirc;t Tiers payant</th>
								<th>Co&ucirc;t Vipo</th>
								<th>Dur&eacute;e</th>
	  						</tr>
						</table>						
	
					</div>

				</div>

			</div>
`
		</div>

	</div>
	
	<div id="left">
	
		<table id="left-drawer" cellpadding="0" cellspacing="0">
	    	<tr>
				<!-- CONTENT -->
    	    	<td class="drawer-content">
			
					<a class="taskControl" href="../patients/recherche_patient.php">Recherche patient</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="Element.toggle('findPatientForm');Element.hide('createPatientForm');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
							</div>
						</div>

					</div>
			
					<a class="taskControl" href="../medecins/recherche_medecin.php">Recherche m&eacute;decin</a>
				
					<div class="sidebar labels-red">

						<a onclick="Element.toggle('findMedecinForm'); Element.hide('findPatientForm');Element.hide('createPatientForm');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findMedecinForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMedecinInput" type="text" onFocus="this.select()" onKeyUp="javascript:medecin_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>
                			<div id="informationMedecin">
							</div>
						</div>

					</div>

					<a class="taskControl" href="../actes/recherche_acte.php">Recherche acte interne</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="Element.toggle('findActeForm');Element.hide('findPatientForm');Element.hide('findMedecinForm');try{$('findActeInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findActeForm" class="inlineForm" style="display: block;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findActeInput" type="text" onFocus="this.select()" onKeyUp="javascript:acte_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationActe">
							</div>
						</div>

					</div>
			
            		<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p> 
						<br/>
						<img src='../images/96x96/liste.png'> 					
					</div>
				</td>
  			    	
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
	
	<script type="text/javascript" src='../js/acte.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" src="../js/functions.js"></script>
	
	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
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

</body>
</html>