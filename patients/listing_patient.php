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
	$urlLetter = isset($_GET['letter']) ? $_GET['letter'] : '%';
	$currentClass[$urlLetter] = 'current';	

	// Inclus le fichier contenant les fonctions personalisées
	include_once "../lib/fonctions.php";
	
	// Vider la redirection
	unset($_SESSION['redirect']);
	
	$nom_fichier="listing_patient.php";
	
	$modif1 = "<a href=\'./modif_patient.php?id=";
	$modif2 = "\' ><img width=\'16\' height=\'16\' src=\'../images/modif_small.gif\' alt=\'Modifier\' title=\'Modifier\' border=\'0\' /></a>";

	$detail1 = "<a href=\'#\' onMouseDown=openPatientInfo(";
	$detail2 = ")><img width=16 height=16 src=../images/icon_clipboard.gif alt=Detail title=Detail border=0 /></a>";
	
	$tierspayant1 = "<input type=\'checkbox\' ";
	$tierspayant2 = " disabled=\'true\' />";
										
	$sqlglobal= "select concat('$modif1',p.id,'$modif2'),concat('$detail1',p.id,'$detail2'),p.nom, p.prenom, concat('<div style=\'display: none;\' >',p.date_naissance,'</div>',DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR'))), concat(t.nom,' ',t.prenom),  p.mutuelle_code, p.ct1, p.ct2, concat('$tierspayant1',p.tiers_payant,'$tierspayant2'), p.mutuelle_matricule, p.telephone, p.gsm FROM patients p , patients t WHERE p.titulaire_id = t.id AND p.nom like '$urlLetter%' ORDER BY 1,2";
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Listing des patients</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<? 
		require "applib.php";

		session_set_cookie_params(60*60);

		$_SESSION['ex0']=$sqlglobal;

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
  		orderGrid=new Rico.LiveGrid ('ex0', buffer, opts);
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
		<h1>Patients - Listing des patients</h1>

		<a class="impression" href="../factures/printpatient.php?letter=<?=$urlLetter?>"></a>

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

	  				<span>Listing</span>
      					
	  				<a href="./listing_patient_comment.php">Patient &agrave; suivre</a>

				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">
						
						<div id='formhelp'>
							Liste de tous les patients encod&eacute;s dans l'application. Il est possible de les limiter sur la premi&egrave;re lettre de leur nom de famille.
						</div>
					
					</div>
						
					<div id="secondheader">
        				<ul id="sec_primary_tabs">
        					<li class="letter <?=$currentClass['%']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=%">*</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['A']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=A">A</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['B']?>">
	  							<a class="nodelete" href="listing_patient.php?letter=B">B</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['C']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=C">C</a>
		 			 		</li>
       						<li class="letter <?=$currentClass['D']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=D">D</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['E']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=E">E</a>
		 				 	</li>
        					<li class="letter <?=$currentClass['F']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=F">F</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['G']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=G">G</a>
		 				 	</li>
        					<li class="letter <?=$currentClass['H']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=H">H</a>
		 			 		</li>
       						<li class="letter <?=$currentClass['I']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=I">I</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['J']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=J">J</a>
					 		</li>
        					<li class="letter <?=$currentClass['K']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=K">K</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['L']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=L">L</a>
		 			 		</li>
       						<li class="letter <?=$currentClass['M']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=M">M</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['N']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=N">N</a>
						 	</li>
       						<li class="letter <?=$currentClass['O']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=O">O</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['P']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=P">P</a>
						 		</li>
       						<li class="letter <?=$currentClass['Q']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=Q">Q</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['R']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=R">R</a>
					 		</li>
       						<li class="letter <?=$currentClass['S']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=S">S</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['T']?>">
		  					<a class="nodelete" href="listing_patient.php?letter=T">T</a>
						 		</li>
       						<li class="letter <?=$currentClass['U']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=U">U</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['V']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=V">V</a>
					 		</li>
       						<li class="letter <?=$currentClass['W']?>">
	  							<a class="nodelete" href="listing_patient.php?letter=W">W</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['X']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=X">X</a>
		 			 		</li>
        					<li class="letter <?=$currentClass['Y']?>">
	  							<a class="nodelete" href="listing_patient.php?letter=Y">Y</a>
	 				 		</li>
        					<li class="letter <?=$currentClass['Z']?>">
		  						<a class="nodelete" href="listing_patient.php?letter=Z">Z</a>
		 			 		</li>
       					</ul>
					</div>
						
					<div id="secondmain">
						
						<span id="ex0_bookmark"></span>
							
						<table id="ex0" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
							<colgroup>
								<col style='width:20px;' >
								<col style='width:20px;' >
								<col style='width:70px;' >
								<col style='width:70px;' >
								<col style='width:40px;' >
								<col style='width:60px;' >
								<col style='width:30px;' >
								<col style='width:25px;' >
								<col style='width:25px;' >
								<col style='width:20px;' >
								<col style='width:70px;' >
								<col style='width:50px;' >
								<col style='width:50px;' >
							</colgroup>
							<tr>
		  						<th></th>
		  						<th></th>
		  						<th>Nom</th>
								<th>Pr&eacute;nom</th>
								<th>Date de naissance</th>
		  						<th>Titulaire</th>
		  						<th>Mutuelle</th>
		  						<th>CT1</th>
		  						<th>CT2</th>
		  						<th>T.P.</th>
		  						<th>Matricule</th>
		  						<th>T&eacute;l&eacute;phone</th>
		  						<th>GSM</th>
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
