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
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';

	// Nom du fichier en cours 
	$nom_fichier = "add_anomalie.php";
	
	// Variables du formulaire
	$actionTarification = isset($_POST['actionTarification']) ? $_POST['actionTarification'] : '';  
	$formTarificationID = isset($_POST['tarification_input']) ? $_POST['tarification_input'] : '';
	
	// Validation des variables
	if ($actionTarification == 1) {
		
		$test = new testTools("info");
		$test->stringtest($formTarificationID,"tarification","tarification");
			
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
			
			connexion_DB('poly');

			$sql = "INSERT INTO anomalies (tarification_id, textcomment,log, cloture, etat) VALUES ('$formTarificationID', '', '', '','start')";
			$q = requete_SQL ($sql);
			
			$_SESSION['anomalie_id'] = $formTarificationID;
				
			header('Location: ./modif_anomalie.php');

			deconnexion_DB();
			die();
			
		}
	}
				
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'une anomalie</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">
	
		<h1 class="tarification">Anomalies - Ajout d'une anomalie</h1>
		
		<div id="etiquette">
		</div>
		
	</div>
	
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Anomalies</a>
				</li>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
					<a href="./recherche_anomalie.php">Recherche</a>

					<span>Ajout</span>

	  				<a href="./listing_anomalie.php">Anomalie en cours</a>
								
				</div>

				<form name='searchForm' id='searchForm' method='post' action='<?=$nom_fichier?>'>
						
					<input type='hidden' name='actionTarification' value='1'/>

					<div class="listViewPane">

						<div class="navigation-hight">

							<fieldset class=''>
								<legend>Aide</legend>
								Ce formulaire permet d'ajouter de nouvelles anomalies suite aux retour des mutuelles.<br />
							</fieldset>
							
						</div>

						<div id='Info'>
						</div>
							
						<div id='Box'>
							
							<table cellspacing="1" cellpadding="1">
								<tbody>
									<tr>
										<th class="green patient">
											Patient : <input type='text' id='patient_input' size='32' maxlength='32' class='txtField' title='patient' autocomplete='off'  onKeyUp="javascript:$('prestation_input').value='';$('tarification_input').value='';tarificationRechercheComplete();" />
										</th>
										<th class="green medecin">
											M&eacute;decin : <input type='text' id='medecin_input' size='32' maxlength='32' class='txtField' title='m&eacute;decin' autocomplete='off'  onKeyUp="javascript:$('prestation_input').value='';$('tarification_input').value='';tarificationRechercheComplete();" />
										</th>
									</tr>
									<tr>
										<th class="green">
											Date de d&eacute;but : <input type='text' id='start_date_input' size='32' maxlength='32' class='txtField' title='Recherche du patient' autocomplete='off' onkeyup="javascript:$('prestation_input').value='';$('tarification_input').value='';dateFirstExecutionresult = checkDate(this, '', '');tarificationRechercheComplete();" />
										</th>
										<th class="green">
											Date de fin : <input type='text' id='end_date_input' size='32' maxlength='32' class='txtField' title='Recherche du m&eacute;decin' autocomplete='off'  onKeyUp="javascript:$('prestation_input').value='';$('tarification_input').value='';dateFirstExecutionresult = checkDate(this, '', '');tarificationRechercheComplete();" />
										</th>
									</tr>
									<tr>
										<th class="green">
											Identifiant prestation : <input type='text' id='prestation_input' size='32' maxlength='32' class='txtField' title='Identifiant prestation' autocomplete='off' onkeyup="javascript:$('tarification_input').value='';tarification_number = checkNumber(this, tarification_number, 20, false);tarificationRechercheComplete();" />
																	 <input type='hidden' id='tarification_input' name='tarification_input' />
										</th>
										<th class="green">
											Status : 
											<select id='etat_input' title='Status tarification' onchange="javascript:$('prestation_input').value='';$('tarification_input').value='';tarificationRechercheComplete(,15);">
												<option value=''>Toutes les tarifications</option>
												<option value="AND (t.etat = 'close' AND t.paye < t.a_payer)">Tarifications clotur&eacute;es et non pay&eacute;es</option>
												<option value="AND (t.etat = 'close' AND t.paye >= t.a_payer)">Tarifications clotur&eacute;es et pay&eacute;es</option>
											</select>
										</th>
									</tr>
									<tr>
										<td colspan='2' class='texte' id='tarificationBox'>
										</td>
									</tr>
									<tr>
										<td colspan='2'>
										<input type="submit" class="button" value="Valider" />
										</td>
									</tr>
								</tbody>
							</table>
							
						</div>
						
					</div>
					
				</form>
			
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

						<a onclick="Element.toggle('findMedecinForm');Element.hide('findPatientForm');Element.hide('addLabelFormNewTarification');Element.hide('addLabelFormOldTarification');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
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

						<a onclick="Element.toggle('findPatientForm');Element.hide('addLabelFormNewTarification');Element.hide('addLabelFormOldTarification');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
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
	<script type="text/javascript" src='../js/anomalie.js'></script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var compteur = 0;
		var tarification_number =""
		var prestation_number =""
		$('patient_input').focus();
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
  		function openTarificationInfo(id) {
			var url = "../tarifications/tarification_detail.php?id="+id;
			switch ( compteur )	{
			case 0:
				compteur = (compteur+1)%4;
				win0 = new Window({className: "alphacube", title: "Information Tarification", top:0, right:0, width:540, height:400 });  
				win0.setURL(url)
				win0.show();
			break;
			case 1:
				compteur = (compteur+1)%4;
				win1 = new Window({className: "alphacube", title: "Information Tarification", top:20, right:20, width:540, height:400 });  
				win1.setURL(url)
				win1.show();
			break;
			case 2:
				compteur = (compteur+1)%4;
				win2 = new Window({className: "alphacube", title: "Information Tarification", top:40, right:40, width:540, height:400 });  
				win2.setURL(url)
				win2.show();
			break;
			default :
				compteur = (compteur+1)%4;
				wind = new Window({className: "alphacube", title: "Information Tarification", top:60, right:60, width:540, height:400 });  
				wind.setURL(url)
				wind.show();
			}
		}
		function openDialogConfirmDelTarification(utilisation,id) {
  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer compl&egrave;tement</b> cette tarification ?<br></td></tr></table>", {width:400, height:200, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {tarificationAction(utilisation,'del_tarification',id); return true;} });
		}
		function openDialogConfirmDelPrestation(utilisation,id) {
  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Etes-vous certain de vouloir <b>supprimer</b> la prestation pour cette tarification ?<br></td></tr></table>", {width:400, height:200, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {tarificationAction(utilisation,'del_prestation',id); return true;} });
		}
	</script>

</body>
</html>