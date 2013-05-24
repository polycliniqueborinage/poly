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
	// SECURITE

	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Listing des tarifications de proth&egrave;ses en cours</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">
	
		<h1 class="tarification">Proth&egrave;ses - Listing des tarifications de proth&egrave;ses cours</h1>
		
		<div id="etiquette">
		</div>
		
	</div>
	
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('tarifications')?>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
   					<a href="./add_prothese.php">Ajout</a>

					<a href="./modif_prothese.php">Reprise derni&egrave;re tarification</a>

    				<a href="./recherche_prothese.php">Recherche</a>
						
					<span>Proth&egrave;ses en cours</span> 
      					
				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Liste de toutes les tarifications de proth&egrave;ses encod&eacute;es mais non cl&ocirc;tur&eacute;es ou non pay&eacute;es.<br />
						</div>
						<div id='formmodif'>
						</div>
							
					</div>
						
					<div id='Box'>

						<input type="hidden" id="patient_input" />
						<input type="hidden" id="medecin_input" />
						<input type="hidden" id="start_date_input" />
						<input type="hidden" id="end_date_input" />
						<input type="hidden" id="tarification_input" />
						<input type="hidden" id="prestation_input" />
						<input type="hidden" id="etat_input" value="AND ((t.etat = 'close' AND t.paye < t.a_payer) OR  (t.etat != 'close'))"/>
									
						<!-- DEBUT DU CALENDRIER -->
						<div id='tarificationBox'><img class='centerimage' src='../images/attente.gif'/></div>
						
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
				
					<a class="taskControl" href="../protheses/listing_prothese.php">Proth&egrave;ses du jour</a>
				
					<div class="sidebar labels-green">

						<a onclick="javascript:if($('protheseDayList').innerHTML==''){ loadTarification ('new_prothese','','protheseDayList','findNewProtheseInput'); };Element.toggle('addLabelFormNewProthese');Element.hide('addLabelFormOldProthese');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormNewProthese" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findNewProtheseInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript:loadTarification('new_prothese',this.value,'protheseDayList','findNewProtheseInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="protheseDayList"></div>
						</div>

					</div>
					
					<a class="taskControl" href="../protheses/listing_prothese.php">Proth&egrave;ses ant&eacute;rieures</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="javascript:if($('protheseOldList').innerHTML==''){ loadTarification ('old_prothese','','protheseOldList','findOldProtheseInput');};Element.toggle('addLabelFormOldProthese');Element.hide('addLabelFormNewProthese');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormOldProthese" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findOldProtheseInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript: loadTarification('old_prothese',this.value,'protheseOldList','findOldProtheseInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="protheseOldList"></div>
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
	<script type="text/javascript" src="../yui/build/menu.js"></script>
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
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" src='../js/tarification_prothese.js'></script>
	<script type="text/javascript" src='../js/prothese.js'></script>
	<script type="text/javascript" src="../js/tarification.js"></script>
	
	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var help = new Window('1', {className: "alphacube", title: "Aide en ligne", top:0, right:0, width:500, height:300});  
  		var notice = new Window('2', {className: "alphacube", title: "Notice", top:20, right:20, width:500, height:300 });  
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
  		function openProtheseInfo(id) {
			var url = "../protheses/prothese_detail.php?id="+id;
			switch ( compteur )	{
			case 0:
				compteur = (compteur+1)%4;
				win0 = new Window({className: "alphacube", title: "Information sur la proth&egrave;se", top:0, right:0, width:540, height:400 });  
				win0.setURL(url)
				win0.show();
			break;
			case 1:
				compteur = (compteur+1)%4;
				win1 = new Window({className: "alphacube", title: "Information sur la proth&egrave;se", top:20, right:20, width:540, height:400 });  
				win1.setURL(url)
				win1.show();
			break;
			case 2:
				compteur = (compteur+1)%4;
				win2 = new Window({className: "alphacube", title: "Information sur la proth&egrave;se", top:40, right:40, width:540, height:400 });  
				win2.setURL(url)
				win2.show();
			break;
			default :
				compteur = (compteur+1)%4;
				wind = new Window({className: "alphacube", title: "Information sur la proth&egrave;se", top:60, right:60, width:540, height:400 });  
				wind.setURL(url)
				wind.show();
			}
		}
		var compteur = 0;
		function openDialogConfirmDelProthese(utilisation,id) {
  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer compl&egrave;tement</b> cette proth&egrave;se ?<br></td></tr></table>", {width:400, height:200, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {protheseAction(utilisation,'del_tarification',id); return true;} });
		}
		function openDialogConfirmDelPrestation(utilisation,id) {
  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer</b> la prestation pour cette proth&egrave;se ?<br></td></tr></table>", {width:400, height:200, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {protheseAction(utilisation,'del_prestation',id); return true;} });
		}
		protheseRechercheComplete('prothese',1000);
	</script>
    
</body>
</html>