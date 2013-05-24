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
	$nom_fichier = "recherche_cecodi.php";
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Recherche des consultations ou des actes techniques</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">

		<h1>Prestations INAMI - Recherche d'une prestation</h1>

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

					<span>Recherche</span> 
      			
      				<a href="./add_cecodi.php">Ajout prestation INAMI</a>
      					
	  				<a href="./listing_cecodi.php">Listing</a>

					<a href="../actes/recherche_acte.php">Recherche</a>

					<a href="../actes/add_acte.php">Ajout acte interne</a>

	  				<a href="../actes/listing_acte.php">Listing</a>
												
				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet de rechercher et de modifier les couts relatifs aux consultations et actes techniques encod&eacute;s dans l'application. Il est également possible de supprimer un code erroné ou de modifier complètement les informations relatives à un code INAMI.<br />
						</div>
						<div id='formmodif'>
						</div>
							
					</div>
					
						
					<div id='Box'>
						<table cellspacing="1" cellpadding="1">
							<tbody>
								<tr>
									<th class="green">
										Recherche : <input type='text' name='cecodi1' id='cecodi1' size='40' maxlength='6' class='txtField' title='Code du CECODI' value='' onKeyUp='javascript:cecodiRechercheComplete(this.value);' autocomplete='off' />
									</th>
								</tr>
								<tr>
									<td colspan='2' class='texte' id='cecodiBox'>
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
				<!-- CONTENT -->
    	    	<td class="drawer-content">
			
					<a class="taskControl" href="../medecins/recherche_medecin.php">Recherche m&eacute;decin</a>
				
					<div class="sidebar labels-green">

						<a onclick="Element.toggle('findMedecinForm'); Element.hide('findPatientForm');Element.hide('findCecodiForm');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
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

						<a onclick="Element.toggle('findPatientForm');Element.hide('findCecodiForm');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
							</div>
						</div>

					</div>

					<a class="taskControl" href="../cecodis/recherche_cecodi.php">Recherche code Inami</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="Element.toggle('findCecodiForm');Element.hide('findPatientForm');Element.hide('findMedecinForm');try{$('findCecodiInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findCecodiForm" class="inlineForm" style="display: block;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findCecodiInput" type="text" onFocus="this.select()" onKeyUp="javascript:cecodi_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationCecodi">
							</div>
						</div>

					</div>
			
            		<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/find.png'>
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
	
	<script type='text/javascript' src="../js/cecodi.js"></script>
	<script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" src="../js/functions.js"></script>

	<script type='text/javascript'>var valeurcecodi = '';</script>
	<script type='text/javascript'>var valeurkdb = '';</script>
	<script type='text/javascript'>var valeurbc = '';</script>
	<script type='text/javascript'>var valeurhono_travailleur = '';</script>
	<script type='text/javascript'>var valeura_vipo = '';</script>
	<script type='text/javascript'>var valeurb_tiers_payant = '';</script>
	
	<script type='text/javascript'>var kdb1 = '';</script>
	<script type='text/javascript'>var bc1 = '';</script>
	<script type='text/javascript'>var hono1 = '';</script>
	<script type='text/javascript'>var vipo1 = '';</script>
	<script type='text/javascript'>var tiers1 = '';</script>
	<script type='text/javascript'>var prix_vp1 = '';</script>
	<script type='text/javascript'>var prix_tp1 = '';</script>
	<script type='text/javascript'>var prix_tr1 = '';</script>
	
	<script type='text/javascript'>var kdb2 = '';</script>
	<script type='text/javascript'>var bc2 = '';</script>
	<script type='text/javascript'>var hono2 = '';</script>
	<script type='text/javascript'>var vipo2 = '';</script>
	<script type='text/javascript'>var tiers2 = '';</script>
	<script type='text/javascript'>var prix_vp2 = '';</script>
	<script type='text/javascript'>var prix_tp2 = '';</script>
	<script type='text/javascript'>var prix_tr2 = '';</script>
	
	<script type='text/javascript'>var kdb3 = '';</script>
	<script type='text/javascript'>var bc3 = '';</script>
	<script type='text/javascript'>var hono3 = '';</script>
	<script type='text/javascript'>var vipo3 = '';</script>
	<script type='text/javascript'>var tiers3 = '';</script>
	<script type='text/javascript'>var prix_vp3 = '';</script>
	<script type='text/javascript'>var prix_tp3 = '';</script>
	<script type='text/javascript'>var prix_tr3 = '';</script>
	
	<script type='text/javascript'>var kdb4 = '';</script>
	<script type='text/javascript'>var bc4 = '';</script>
	<script type='text/javascript'>var hono4 = '';</script>
	<script type='text/javascript'>var vipo4 = '';</script>
	<script type='text/javascript'>var tiers4 = '';</script>
	<script type='text/javascript'>var prix_vp4 = '';</script>
	<script type='text/javascript'>var prix_tp4 = '';</script>
	<script type='text/javascript'>var prix_tr4 = '';</script>
	
	<script type='text/javascript'>var kdb5 = '';</script>
	<script type='text/javascript'>var bc5 = '';</script>
	<script type='text/javascript'>var hono5 = '';</script>
	<script type='text/javascript'>var vipo5 = '';</script>
	<script type='text/javascript'>var tiers5 = '';</script>
	<script type='text/javascript'>var prix_vp5 = '';</script>
	<script type='text/javascript'>var prix_tp5 = '';</script>
	<script type='text/javascript'>var prix_tr5 = '';</script>
	
	<script type='text/javascript'>var kdb6 = '';</script>
	<script type='text/javascript'>var bc6 = '';</script>
	<script type='text/javascript'>var hono6 = '';</script>
	<script type='text/javascript'>var vipo6 = '';</script>
	<script type='text/javascript'>var tiers6 = '';</script>
	<script type='text/javascript'>var prix_vp6 = '';</script>
	<script type='text/javascript'>var prix_tp6 = '';</script>
	<script type='text/javascript'>var prix_tr6 = '';</script>
	
	<script type='text/javascript'>var kdb7 = '';</script>
	<script type='text/javascript'>var bc7 = '';</script>
	<script type='text/javascript'>var hono7 = '';</script>
	<script type='text/javascript'>var vipo7 = '';</script>
	<script type='text/javascript'>var tiers7 = '';</script>
	<script type='text/javascript'>var prix_vp7 = '';</script>
	<script type='text/javascript'>var prix_tp7 = '';</script>
	<script type='text/javascript'>var prix_tr7 = '';</script>
	
	<script type='text/javascript'>var kdb8 = '';</script>
	<script type='text/javascript'>var bc8 = '';</script>
	<script type='text/javascript'>var hono8 = '';</script>
	<script type='text/javascript'>var vipo8 = '';</script>
	<script type='text/javascript'>var tiers8 = '';</script>
	<script type='text/javascript'>var prix_vp8 = '';</script>
	<script type='text/javascript'>var prix_tp8 = '';</script>
	<script type='text/javascript'>var prix_tr8 = '';</script>
	
	<script type='text/javascript'>var kdb9 = '';</script>
	<script type='text/javascript'>var bc9 = '';</script>
	<script type='text/javascript'>var hono9 = '';</script>
	<script type='text/javascript'>var vipo9 = '';</script>
	<script type='text/javascript'>var tiers9 = '';</script>
	<script type='text/javascript'>var prix_vp9 = '';</script>
	<script type='text/javascript'>var prix_tp9 = '';</script>
	<script type='text/javascript'>var prix_tr9 = '';</script>
	
	<script type='text/javascript'>var kdb10 = '';</script>
	<script type='text/javascript'>var bc10 = '';</script>
	<script type='text/javascript'>var hono10 = '';</script>
	<script type='text/javascript'>var vipo10 = '';</script>
	<script type='text/javascript'>var tiers10 = '';</script>
	<script type='text/javascript'>var prix_vp10 = '';</script>
	<script type='text/javascript'>var prix_tp10 = '';</script>
	<script type='text/javascript'>var prix_tr10 = '';</script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
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
		function openDialogConfirm(id,comment) {
			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer</b> cette prestation INAMI ["+comment+"]</td></tr></table>", {width:400, height:200, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {cecodiSuppresion(id); return true;} });
		}
	</script>
	
</body>
</html>