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
	
	// Inclus le fichier contenant les fonctions personalis�es
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';

	// Nom du fichier en cours 
	$nom_fichier = "add_tarification.php";
	
	// Redirection
	$_SESSION['redirect'] = $nom_fichier;	

	// Gestion des etiquettes + Vider le cache
	if(isset($_SESSION['impression_medecin_last_name'])) { unset($_SESSION['impression_medecin_last_name']); }
	if(isset($_SESSION['impression_medecin_first_prenom'])) { unset($_SESSION['impression_medecin_first_prenom']); }
	if(isset($_SESSION['impression_medecin_inami'])) { unset($_SESSION['impression_medecin_inami']); }	

	if(isset($_SESSION['impression_tarification_mutuelle_code'])) { unset($_SESSION['impression_tarification_mutuelle_code']); }
	if(isset($_SESSION['impression_tarification_ct1'])) { unset($_SESSION['impression_tarification_ct1']); }
	if(isset($_SESSION['impression_tarification_ct2'])) { unset($_SESSION['impression_tarification_ct2']); }
	if(isset($_SESSION['impression_tarification_patient_mutuelle_matricule'])) { unset($_SESSION['impression_tarification_patient_mutuelle_matricule']); }
	if(isset($_SESSION['impression_tarification_patient_type'])) { unset($_SESSION['impression_tarification_patient_type']); }
	if(isset($_SESSION['impression_tarification_patient_children'])) { unset($_SESSION['impression_tarification_patient_children']); }
	if(isset($_SESSION['impression_tarification_patient_age'])) { unset($_SESSION['impression_tarification_patient_age']); }
	if(isset($_SESSION['impression_tarification_patient_sex'])) { unset($_SESSION['impression_tarification_patient_sex']); }
	if(isset($_SESSION['impression_tarification_patient_tiers_payant'])) { unset($_SESSION['impression_tarification_patient_tiers_payant']); }
	
	if(isset($_SESSION['impression_patient_last_name'])) { unset($_SESSION['impression_patient_last_name']); }
	if(isset($_SESSION['impression_patient_first_prenom'])) { unset($_SESSION['impression_patient_first_prenom']); }
	if(isset($_SESSION['impression_patient_birthday'])) { unset($_SESSION['impression_patient_birthday']); }
	if(isset($_SESSION['impression_patient_sex'])) { unset($_SESSION['impression_patient_sex']); }
	if(isset($_SESSION['impression_patient_age'])) { unset($_SESSION['impression_patient_age']); }
	if(isset($_SESSION['impression_patient_addresse'])) { unset($_SESSION['impression_patient_addresse']); }
	if(isset($_SESSION['impression_patient_niss'])) { unset($_SESSION['impression_patient_sis']); }
	if(isset($_SESSION['impression_patient_sis'])) { unset($_SESSION['impression_patient_niss']); }
	
	connexion_DB('poly');
	
	// Variables du formulaire
	$actionTarification = isset($_POST['actionTarification']) ? $_POST['actionTarification'] : '';  
	
	$formDate = date("Y-m-d");
	$sessCaisse = $_SESSION['login'];
	
	$formPatientID = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
	$formPatientChildren = isset($_POST['patient_children']) ? $_POST['patient_children'] : '';
	$formPatientAge = isset($_POST['patient_age']) ? $_POST['patient_age'] : '';
	$formPatientSex = isset($_POST['patient_sexe']) ? $_POST['patient_sexe'] : '';
	$formPatientMutuelleCode = isset($_POST['patient_mutuelle_code']) ? $_POST['patient_mutuelle_code'] : '';
	$formPatientMutuelleMatricule = isset($_POST['patient_mutuelle_matricule']) ? $_POST['patient_mutuelle_matricule'] : '';
	$formTitulaireMutuelleMatricule = isset($_POST['titulaire_mutuelle_matricule']) ? $_POST['titulaire_mutuelle_matricule'] : '';
	$formPatientCT1 = isset($_POST['patient_ct1']) ? $_POST['patient_ct1'] : '';
	$formPatientCT2 = isset($_POST['patient_ct2']) ? $_POST['patient_ct2'] : '';
	$formPatientTiersPayant = isset($_POST['patient_tiers_payant']) ? $_POST['patient_tiers_payant'] : '';
	$formPatientType = isset($_POST['patient_type']) ? $_POST['patient_type'] : '';
	
	$formMedecinInami = isset($_POST['medecin_inami']) ? $_POST['medecin_inami'] : '';
	
	$formRefact = isset($_POST['refact']) ? $_POST['refact'] : '';
	//$_SESSION['protocole_url'] = isset($_POST['protocole_url']) ? $_POST['protocole_url'] : '';
	
	// Validation des variables
	if ($actionTarification == 1) {
	
		$test = new testTools("info");
		$test->stringtest($formPatientID,"patient","patient");
		$test->stringtest($formMedecinInami,"medecin","medecin");
			
		// Traitement lorsque tous les tests sont pass�s avec succ�s
		if ($test->Count == 0) {
			
			$log .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." cr&eacute;e la tarification</b><br/><br/>";
			
			// gestion des re-tarifications
			if ($formRefact) {

				// Ajout de la tarification		
				$sql = "INSERT INTO tarifications (date, caisse, medecin_inami, patient_id, mutuelle_code, patient_matricule, titulaire_matricule, type, ct1, ct2, tiers_payant, children, age, sex, etat, a_payer, paye, utilisation, cloture,log) 
						VALUES ('$formDate', '$sessCaisse', '$formMedecinInami', '$formPatientID','$formPatientMutuelleCode', '$formPatientMutuelleMatricule', '$formTitulaireMutuelleMatricule', '$formPatientType', '$formPatientCT1', '$formPatientCT2', '$formPatientTiersPayant', '$formPatientChildren', '$formPatientAge', '$formPatientSex', 'start-close', '0', '0', 'retarification', now(),'$log')";
				$q = requete_SQL ($sql);
			
			} else {
			// gestion des tarifications
			
				// Gestion des mauvais payeurs
				$payeurSQL = "UPDATE `tarifications` SET `a_payer` = -1*`a_payer` WHERE ( patient_id  = '$formPatientID') AND a_payer < 0";
				$payeurResult = requete_SQL ($payeurSQL);
				
				// Ajout de la tarification	standard
				$sql = "INSERT INTO tarifications (date, caisse, medecin_inami, patient_id, mutuelle_code, patient_matricule, titulaire_matricule, type, ct1, ct2, tiers_payant, children, age, sex, etat, a_payer, paye, utilisation,log) 
					VALUES ('$formDate', '$sessCaisse', '$formMedecinInami', '$formPatientID', '$formPatientMutuelleCode', '$formPatientMutuelleMatricule', '$formTitulaireMutuelleMatricule', '$formPatientType', '$formPatientCT1', '$formPatientCT2', '$formPatientTiersPayant', '$formPatientChildren', '$formPatientAge', '$formPatientSex', 'start', '0', '0', 'tarification', '$log')";
				$q = requete_SQL ($sql);
			}
			
			// recuperation de l'id de la tarifacation 
			$sql = "select max(id) as max FROM tarifications";
			
			$result = requete_SQL($sql);
	
			if(mysql_num_rows($result)==1) { 
				
				$data = mysql_fetch_assoc($result);
				
				$_SESSION['tarification_id'] = $data['max'];
				
				if ($formRefact) {
					header('Location: ./modif_retarification.php');
				} else {
					header('Location: ./modif_tarification.php');
				}

			} else {
				
				header('Location: ../menu/menu.php');
			
			}
			
			deconnexion_DB();
			die();
			
		}
	}
			
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'une tarification</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		echo "<li class='yuimenuitem'>Patients";
		echo "	<div id='patient2' class='yuimenu'>";
		echo "		<div class='bd'>";
		echo "			<ul class='first-of-type'>";
		echo "				<li class='yuimenuitem' id='patientMenu'><a class='yuimenuitemlabel' href='../patients/recherche_patient.php'>Recherche et modification du patient&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
		echo "				<li class='yuimenuitem' id='titulaireMenu'><a class='yuimenuitemlabel' href='../patients/recherche_patient.php'>Recherche et modification du titulaire&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>";
		echo "			</ul>";
		echo "		</div>";
		echo "	</div>  ";
		echo "</li>";
		get_MENUBAR_END();
	?>
	
	<div id="top">
	
		<h1 class="tarification">Tarifications - Ajout d'une tarification</h1>
		
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
   
    				<span>Ajout</span> 

					<a href="./modif_tarification.php">Reprise derni&egrave;re tarification</a>

					<a href="./recherche_tarification.php">Recherche</a>

					<a href="./listing_tarification_day.php">Tarifications du jour</a>
	  				
	  				<a href="./listing_tarification.php">Tarifications encours</a>
								
				</div>

				<form name='searchForm' id='searchForm' method='post' action='<?=$nom_fichier?>'>
						
					<input type='hidden' name='actionTarification' value='1'/>
					<!-- input type='hidden' name='protocole_url' id='protocole_url' value=''/ -->
	
					<div class="listViewPane">

						<div class="navigation-hight">

							<div id='formhelp'>
								Ce formulaire permet d'encoder une nouvelle tarification pour des <b>patients valides</b>.<font color="red"><b>  Il est fondamentale que les informations d'assurabilit&eacute; soient correctement encod&eacute;es (CT1, CT2, code de mutuelle, matricule).</b></font><br />
							</div>
							
						</div>
							
						<div id='Box'>
							
							<table cellspacing="1" cellpadding="1">
								<tbody>
									<tr>
										<th class="green patient">
											Patient : <input type='text' name='patient' id='patient' size='32' maxlength='32' class='txtField' title='Recherche du patient' autocomplete='off'  onKeyUp='tarificationRecherchePatient(this.value)' />
										</th>
										<th class="green medecin">
											M&eacute;decin : <input type='text' name='medecin' id='medecin' size='32' maxlength='32' class='txtField' title='Recherche du m&eacute;decin' autocomplete='off'  onKeyUp='tarificationRechercheMedecin(this.value)' />
										</th>
									</tr>
									<tr>
										<td class='texte' id='patientBox'>
										</td>
										<td class='texte' id='medecinBox'>
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
				
					<a class="taskControl" href="../tarifications/listing_tarification.php">Tarifications du jour</a>
				
					<div class="sidebar labels-green">

						<a onclick="javascript:;if($('tarificationDayList').innerHTML==''){ loadTarification ('new_tarification','','tarificationDayList','findNewTarificatonInput'); };Element.toggle('addLabelFormNewTarification');Element.hide('addLabelFormOldTarification');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormNewTarification" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findNewTarificatonInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript:loadTarification('new_tarification',this.value,'tarificationDayList','findNewTarificatonInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="tarificationDayList"></div>
						</div>

					</div>
					
					<a class="taskControl" href="../tarifications/listing_tarification.php">Tarifications ant&eacute;rieures</a>

					<div id="labels" class="sidebar labels-green">

						<a onclick="javascript:if($('tarificationOldList').innerHTML==''){ loadTarification ('old_tarification','','tarificationOldList','findOldTarificatonInput');};Element.toggle('addLabelFormOldTarification');Element.hide('addLabelFormNewTarification');" href="#" class="controls">Recherche...</a>

						<div id="addLabelFormOldTarification" class="inlineForm" style="display: none;">
							<form onsubmit="">
	               				<input autocomplete="off" id="findOldTarificatonInput" class="text-input" type="text" onFocus="this.select()" onKeyUp="javascript:loadTarification('old_tarification',this.value,'tarificationOldList','findOldTarificatonInput')">
    	           				<input class="button" value="" type="submit">
                			</form>
               				<div id="tarificationOldList"></div>
						</div>
						
					</div>
					
					<a class="taskControl" href="#">M&eacute;decine pr&eacute;ventive</a>
			
					<div class="sidebar labels-red">
					
						<h2>Imprimer les documents :</h2>

						<div id="motifBox"></div>
					
					</div>
					
					<a class="taskControl" href="#">Etiquettes</a>
			
					<div class="sidebar labels-red">
					
						<h2>Nombre :</h2>

						<select name='etiquette' id='etiquette' width="179" style="width: 179px" onClick="document.getElementById('etiquette').style.pixelWidth = 179" onchange='javascript:etiquettePrint(this.value);'>
							<option value='0'>&eacute;tiquettes...</option>
							<option value='1'>1 &eacute;tiquette</option>
							<option value='2'>2 &eacute;tiquettes</option>
							<option value='3'>3 &eacute;tiquettes</option>
							<option value='4'>4 &eacute;tiquettes</option>
							<option value='5'>5 &eacute;tiquettes</option>
							<option value='3'>6 &eacute;tiquettes</option>
							<option value='10'>10 &eacute;tiquettes</option>
							<option value='15'>15 &eacute;tiquettes</option>
						</select>
					
					</div>
					
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/add_tarif.png'>
 					</div>
				</td>
  			    	
				<td class="drawer-handle" onclick="toggleSidebars(); return false;">
           			<div class="top-corner"></div>
           			<div class="bottom-corner"></div>
       	   	 	</td>
				
      		</tr>
		</table>
	</div>
	
	<div id="etiquetteLabel">
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
	</script>

</body>
</html>