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
	
	//vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours
	$nom_fichier = "add_cecodi.php";
	
	// Variables du formulaire
	$actionCecodi = isset($_POST['actionCecodi']) ? $_POST['actionCecodi'] : ''; 

	$info = ''; 
	
	$nbr = 0;
	
	// Validation des variables
	if ($actionCecodi == 1) {
	
		for ($i=1;$i<6;$i++){
			
			$test = new testTools("info");
			
			$formCecodi = isset($_POST['cecodi'.$i]) ? $_POST['cecodi'.$i] : '';
			$formCecodi = $test->convert($formCecodi);
			
			$formPropriete = isset($_POST['propriete1']) ? $_POST['propriete1'] : '';
			$formPropriete = $test->convert($formPropriete);
			
			$formDescription = isset($_POST['description'.$i]) ? $_POST['description'.$i] : '';
			$formDescription = ucfirst(strtolower($formDescription));
			$formDescription = $test->convert($formDescription);
			
			$formKdb = isset($_POST['kdb'.$i]) ? $_POST['kdb'.$i] : '';
			$formKdb = $test->convert($formKdb);
			
			$formBc = isset($_POST['bc'.$i]) ? $_POST['bc'.$i] : '';
			$formBc = $test->convert($formBc);
			
			$formHonoTravailleur = isset($_POST['hono_travailleur'.$i]) ? $_POST['hono_travailleur'.$i] : '';
			$formHonoTravailleur = $test->convert($formHonoTravailleur);
			
			$formAVipo = isset($_POST['a_vipo'.$i]) ? $_POST['a_vipo'.$i] : '';
			$formAVipo = $test->convert($formAVipo);
			
			$formBTiersPayant  = isset($_POST['b_tiers_payant'.$i]) ? $_POST['b_tiers_payant'.$i] : '';
			$formBTiersPayant = $test->convert($formBTiersPayant);
			
			$formPrixVIPO  = isset($_POST['prix_vipo'.$i]) ? $_POST['prix_vipo'.$i] : '0';
			$formPrixVIPO = $test->convert($formPrixVIPO);
			
			$formPrixTP  = isset($_POST['prix_tp'.$i]) ? $_POST['prix_tp'.$i] : '0';
			$formPrixTP = $test->convert($formPrixTP);
			
			$formPrixTR  = isset($_POST['prix_tr'.$i]) ? $_POST['prix_tr'.$i] : '0';
			$formPrixTP = $test->convert($formPrixTP);
			
			$formClasse = isset($_POST['classe'.$i]) ? $_POST['classe'.$i] : '';
			$formClasse = $test->convert($formClasse);
			
			$formAge = isset($_POST['age'.$i]) ? $_POST['age'.$i] : '';
			$formAge = $test->convert($formAge);
			$formAgeShort = $formAge;
			
			$tok = strtok($formAge,";");
			$formAge = "";
			while ($tok !== false) {
				list($start, $end) = split('-', $tok);
				for($y=$start ; $y<=$end ; $y++) {
					$formAge .= "|$y|";
				}
  				$tok = strtok(";");
			}
		
			$formCondition = isset($_POST['condition'.$i]) ? $_POST['condition'.$i] : '';
			$formCondition = $test->convert($formCondition);
			
			$formTPforTR = isset($_POST['tp_for_tr'.$i]) ? $_POST['tp_for_tr'.$i] : '';
			
			$test->cecoditest($formCecodi,"cecodi","num&eacute;ro de CECODI");
  			$test->propriete_cecoditest($formPropriete,"propriete","type (acte/consultation)");
  			$test->stringtest($formAge,"age","age de validit&eacute;");
  			
			if ($formPropriete == 'consultation') {
				$test->stringtest($formHonoTravailleur,"hono_travailleur","hono_travailleur");
				$test->stringtest($formAVipo,"a_vipo","a_vipo");
				$test->stringtest($formBTiersPayant,"b_tiers_payant","b_tiers_payant");
				$formBc = "";
				$formKdb = "";
			} 
		
			if ($formPropriete == 'acte') {
				$test->stringtest($formKdb,"kbd","kbd");
				$test->stringtest($formBc,"bc","bc");
				$formHonoTravailleur = "";
				$formAVipo = "";
				$formBTiersPayant  = "";
			}
			
			// Traitement lorsque tous les tests sont passés avec succès
			if ($test->Count == 0) {

				$sql = "INSERT INTO cecodis2 (cecodi, propriete, description, kdb, bc, hono_travailleur, a_vipo,  b_tiers_payant,  classe,  age, age_short, children , prix_vp,  prix_tp, prix_tr, cond, tpfortr) VALUES ('$formCecodi','$formPropriete','$formDescription', '$formKdb','$formBc','$formHonoTravailleur','$formAVipo','$formBTiersPayant','$formClasse', '$formAge', '$formAgeShort', '$formChildren','$formPrixVIPO','$formPrixTP','$formPrixTR', '$formCondition', '$formTPforTR')";
				$info .= "Ajout d'un code INAMI ($formCecodi)<br/>";
				$result = requete_SQL($sql);
				
				$nbr++;

				//header('Location: ../menu/menu.php');
				// Fonction de deconnexion à la base de données
				//deconnexion_DB();
				//die();
				
			} else {
				
				if ($formCecodi != '') {
					$info .= "Impossible d'ajouter un code INAMI &agrave; cause $test->ListeErreur <br/>";
				}
				
			}
			
		}
		
		if ($nbr > 0 ) {
			$_SESSION['information']="<div id='dbinfo'>$info</div>";
			header('Location: ../menu/menu.php');
		}
		
	}
	
	// Fonction de deconnexion à la base de données
	deconnexion_DB();
		
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'une consultation ou d'un acte technique</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">

		<h1>Prestations INAMI - Ajout d'une nouvelle prestation</h1>

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
   
					<a href="./recherche_cecodi.php">Recherche</a>

    				<span>Ajout prestation INAMI</span> 

	  				<a href="./listing_cecodi.php">Listing</a>

					<a href="../actes/add_acte.php">Ajout acte interne</a>
      					
					<a href="../actes/recherche_acte.php">Recherche</a>

	  				<a href="../actes/listing_acte.php">Listing</a>
							
				</div>
						
				<div class="ViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet de rentrer une nouvelle consultation ou un nouvel acte technique.<br />
						</div>
						<div id='formmodif'>
							<?php echo $info; ?>
						</div>
							
					</div>
					
					<div id="secondheader">
        				<ul id="sec_primary_tabs">
        					<li id="sec_li_1" class="nodelete current">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(1);">Base</a>
		 			 		</li>
		 			 		<li id="sec_li_2" class="nodelete">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(2);">Variant</a>
		 			 		</li>
		 			 		<li id="sec_li_3" class="nodelete" style="display:none">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(3);">Variant</a>
		 			 		</li>
		 			 		<li id="sec_li_4" class="nodelete" style="display:none">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(4);">Variant</a>
		 			 		</li>
		 			 		<li id="sec_li_5" class="nodelete" style="display:none">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneral(5);">Variant</a>
		 			 		</li>
        				</ul>
					</div>
					
					<div id="secondmain" class="formBox">
					
						<form action="" method='post' name="myform" >
						
							<input type='hidden' name='actionCecodi' value='1'>

							<div id = 'table_1'></div>
						
							<div id = "table_2" style="display:none"></div>
						
							<div id = "table_3" style="display:none"></div>

							<div id = "table_4" style="display:none"></div>

							<div id = "table_5" style="display:none"></div>
								
						</form>
														
					</div>
						
					<div id="calendarSideBar" class="">
  						<div id="cal1Container">
						</div>
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
						<img src='../images/96x96/add.png'>
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
	
	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"></script>
	
	<!-- ALL JS -->
	<script type='text/javascript' src="../js/cecodi.js"></script>
	<script type="text/javascript" src='../js/common.js'></script>
	<script type="text/javascript" src="../js/submit_validatorv.js"> </script>
	<script type='text/javascript'>
		loadCecodi(1,'base','');
		var frmvalidator  = new Validator("myform");
	</script>

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
		function openModifAssurabilite(html,id) {
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 600, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
	  	function openDialogConfirm(id,comment) {
  			Dialog.confirm("Vouler vous supprimer cette prestation INAMI ?<br> ["+comment+"]", {width:300, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {supprime(id); return true;} });
		}
	</script>
        
</body>
</html>
