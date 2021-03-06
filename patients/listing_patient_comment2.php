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
		
	$currentClass = array();
	$urlLetter = isset($_GET['letter']) ? $_GET['letter'] : 'A';
	$currentClass[$urlLetter] = 'current';	

	// Inclus le fichier contenant les fonctions personalisées
	include_once "../lib/fonctions.php";
	
	// Vider la redirection
	unset($_SESSION['redirect']);
	
	$nom_fichier="listing_patient_comment.php";
	
	//$modif1 = "<a href=\'./modif_patient.php?id=\'";
	
	$modif1 = "<a href=\'./modif_patient.php?id=";
	$modif2 = "\' ><img width=\'16\' height=\'16\' src=\'../images/modif_small.gif\' alt=\'Modifier\' title=\'Modifier\' border=\'0\' /></a>";

	$detail1 = "<div onMouseDown=openPatientInfo(";
	$detail2 = ")><img width=16 height=16 src=../images/icon_clipboard.gif alt=Detail title=Detail border=0 /></div>";
	
	$tierspayantinfo1 = "<input type=\'checkbox\' "; 	 	 	 	 	 
	$tierspayantinfo2 = " disabled=\'true\' />";
		 	
	$vipoinfo1 =	"<input type=\'checkbox\' "; 	 	 	 	 
	$vipoinfo2 = " disabled=\'true\' />"; 	 	 	 	 
		 	 	 	 	
	$mutuelleinfo1 = "<input type=\'checkbox\' ";		 	 	 	 	 	 	 
	$mutuelleinfo2 = " disabled=\'true\' />";	 	 	 	 	 	 
	
	$interditinfo1 = "<input type=\'checkbox\' ";	 	 	 	 	 	 	 
	$interditinfo2 = " disabled=\'true\' />";	 	 	 	 	 	 
	
	$sqlglobal= "select concat('$modif1',p.id,'$modif2'),concat('$detail1',p.id,'$detail2'),p.nom, p.prenom, concat('<div style=\'display: none;\' >',p.date_naissance,'</div>',DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR'))), p.commentaire, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(SUBSTR(LENGTH(trim(p.textcomment),1,1), '0', 'Vide'),1,'<b>Info</b>'),2,'<b>Info</b>'),3,'<b>Info</b>'),4,'<b>Info</b>'),5,'<b>Info</b>'),6,'<b>Info</b>'),7,'<b>Info</b>'),8,'<b>Info</b>'),9,'<b>Info</b>'), concat('$tierspayantinfo1',p.tiers_payant_info,'$tierspayantinfo2'), concat('$vipoinfo1',p.vipo_info,'$vipoinfo2'), concat('$mutuelleinfo1',p.mutuelle_info,'$mutuelleinfo2'),	concat('$interditinfo1',p.interdit_info,'$interditinfo2'), concat('$ratingrendezvousinfo1',p.rating_rendez_vous_info,'$ratingrendezvousinfo2'), concat('$ratingfrequentationinfo1',p.rating_frequentation_info,'$ratingfrequentationinfo2'), concat('$ratingpreferenceinfo1',p.rating_preference_info,'$ratingpreferenceinfo2') from patients p WHERE (p.commentaire !='' or length(p.textcomment) >3 or p.tiers_payant_info='checked' or p.vipo_info='checked' or p.mutuelle_info='checked' or p.interdit_info='checked')";

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Listing des patients &agrave; suivre</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<? 
		require "applib.php";

		session_set_cookie_params(60*60);

		$_SESSION['ex5']=$sqlglobal;

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
  		orderGrid=new Rico.LiveGrid ('ex5', buffer, opts);
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
		<h1>Patients - Listing des patients &agrave; suivre</h1>

		<!-- a class="impression" href="../factures/printpatient.php?letter=<?=$urlLetter?>"></a-->

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

	  				<a href="./recherche_patient.php">Recherche</a>
   
    				<a href="./add_patient_titulaire.php">Ajout d'un patient titulaire</a>
						
					<a href="./add_patient_non_titulaire.php">Ajout d'un patient non titulaire</a>

	  				<a href="./listing_patient.php">Listing</a>

	  				<span>Patient &agrave; suivre</span> 
      					
				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">
						
						<div id='formhelp'>
							Liste de tous les patients &agrave; suivre pour des raisons telles que sujet &agrave; commentaire ou &agrave; information, interdit d'&eacute;tablissement, refus du tiers payant, de remboursement mutuelle...<br />
						</div>
					
					</div>
						
					<div id="secondmain">
					
					
						<span id="ex5_bookmark"></span>
							
						<table id="ex5" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
							<colgroup>
								<col style='width:10px;' >
								<col style='width:10px;' >
								<col style='width:50px;' >
								<col style='width:50px;' >
								<col style='width:35px;' >
								<col style='width:50px;' >
								<col style='width:20px;' >
								<col style='width:30px;' >
								<col style='width:30px;' >
								<col style='width:30px;' >
								<col style='width:30px;' >
								<col style='width:20px;' >
								<col style='width:20px;' >
								<col style='width:20px;' >
							</colgroup>
							<tr>
		  						<th></th>
		  						<th></th>
		  						<th>Nom</th>
								<th>Pr&eacute;nom</th>
								<th>Date de naissance</th>
		  						<th>Commentaire</th>
		  						<th>Info</th>
		  						<th>T.P.</th>
		  						<th>Vipo</th>
		  						<th>Mut</th>
		  						<th>Interdit</th>
		  						<th>RV</th>
		  						<th>Fr&eacute;q</th>
		  						<th>Pr&eacute;f</th>
	  						</tr>
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
						<img src='../images/96x96/liste.png'>
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
		var help = new Window({className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window({className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
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
	</script>
	
</body>
</html>
