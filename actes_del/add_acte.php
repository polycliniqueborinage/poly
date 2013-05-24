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
		
	//vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');

	// Nom du fichier en cours 
	$nom_fichier = "add_acte.php";
	
	// Variables du formulaire
	$actionAddActe = isset($_POST['actionAddActe']) ? $_POST['actionAddActe'] : '';
	$actionAddActe = $test->convert($actionAddActe);

	$formCode = isset($_POST['code']) ? $_POST['code'] : '';
	$formCode = $test->convert($formCode);
	
	$formDescription = isset($_POST['description']) ? $_POST['description'] : '';
	$formDescription = ucfirst(strtolower($formDescription));
	$formDescription = $test->convert($formDescription);
	
	$formCecodis = isset($_POST['cecodis']) ? $_POST['cecodis'] : '';
	$formCecodis = $test->convert($formCecodis);
	
	$formCoutTR = isset($_POST['cout_tr']) ? $_POST['cout_tr'] : '';
	$formCoutTR = $test->convert($formCoutTR);
	
	$formCoutTP = isset($_POST['cout_tp']) ? $_POST['cout_tp'] : '';
	$formCoutTP = $test->convert($formCoutTP);
	
	$formCoutVP = isset($_POST['cout_vp']) ? $_POST['cout_vp'] : '';
	$formCoutVP = $test->convert($formCoutVP);
	
	$formLength = isset($_POST['length']) ? $_POST['length'] : '';
	$formLength = $test->convert($formLength);
	
	// Validation des variables
	if ($actionAddActe == 1) {
	
  		$test->stringtest($formCode,"code","code");
  		$test->stringtest($formDescription,"description","description");
  		$test->stringtest($formCoutVP,"cout_vp","co&ucirc;t vipo");
		$test->stringtest($formCoutTR,"cout_tr","co&ucirc;t travailleur");
		$test->stringtest($formCoutTP,"cout_tp","co&ucirc;t tiers payant");
		
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			$q = requete_SQL ("INSERT INTO actes (code,description,cecodis,cout_vp,cout_tr,cout_tp,length) VALUES ('$formCode','$formDescription','$formCecodis','$formCoutVP','$formCoutTR','$formCoutTP','$formLength')");
	
				// Valider l'ajout dans la DB
				$_SESSION['information']="<div id='dbinfo'>Op&eacute;ration r&eacute;ussie - Le code interne ".html_entity_decode(htmlentities(stripcslashes($formDescription),ENT_QUOTES))." a &eacute;t&eacute; correctement ajout&eacute; &agrave; la base de donn&eacute;es</div>";
				
				header('Location: ../menu/menu.php');
				// Fonction de deconnexion à la base de données
				deconnexion_DB();
				die();
							
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 1) {
			$info_erreurs = "<div id='formerreur'>Corriger le champ &eacute;rron&eacute; : $test->ListeErreur !</div>";
		} else {
			$info_erreurs = "<div id='formerreur'>Corriger les $test->Count champs &eacute;rron&eacute;s : $test->ListeErreur !</div>";
		}
       	
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'un acte interne</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">

		<h1>Acte interne - Ajout d'une nouvel acte interne</h1>

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

      					<span>Ajout acte interne</span> 
      					
	  					<a href="../actes/listing_acte.php">Listing</a>

				</div>
					
	
				<div class="ViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Ce formulaire permet d'encoder un nouvel acte &agrave; condition que celui-ci n'existe pas encore dans l'application.<br />
						</div>
						<?php echo $info_erreurs ?>
				
					</div>
						
					<!-- DEBUT DU CALENDRIER -->
					<div id="secondmain" class="formBox">
							
						<form name='acteForm' id='acteForm' method='post' action='<?=$nom_fichier?>'>
						

							<input type="hidden" name="actionAddActe" value="1">
						
							<table border='1' cellspacing='0' cellpadding='0'>
										
									
								<!-- Code -->
								<tr>
									<th class='<?=$test->fieldError("code","required")?>'>Code</th>
									<td><input type='text' name='code' id='code' size='40' maxlength='5' autocomplete='off' class='txtField' title='Code' onKeyUp='javascript:acteRechercheDirect();' value='<?=html_entity_decode(htmlentities(stripcslashes($formCode),ENT_QUOTES))?>' />
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("code","hide")?>">Rentrer un code valide</td></tr>

								<!-- Descritption -->
								<tr>
									<th class='<?=$test->fieldError("description","required")?>'>Description</th>
									<td><input type='text' name='description' id='description' size='40' maxlength='32' autocomplete='off' class='txtField' title='Descripton' onKeyUp='javascript:acteRechercheDirect();' value='<?=html_entity_decode(htmlentities(stripcslashes($formDescription),ENT_QUOTES))?>' />
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("description","hide")?>">Rentrer une description valide</td></tr>
								
								<!-- Code Inami -->
								<tr>
									<th>Codes Inami Associ&eacute;s</th>
									<td><input type='text' name='cecodis' id='cecodis' size='40' maxlength='100' autocomplete='off' class='txtField' title='Codes Inami associ&eacute;s' value='<?=html_entity_decode(htmlentities(stripcslashes($formCecodis),ENT_QUOTES))?>' />
									</td>
								</tr>
										
								<!-- Taux tr -->
								<tr>
									<th class='<?=$test->fieldError("cout_tr","required")?>'>Co&ucirc;t Travailleur</th>
									<td><input type='text' name='cout_tr' id='cout_tr' size='40' maxlength='40' class='txtField' title='Co&ucirc;t pour le travailleur' value='<?=$formCoutTR?>' onKeyUp='javascript:valeurcouttr = checkAmount(this, valeurcouttr, 10, 2, false);' autocomplete='off'/>
									</td>
								</tr>										
								<tr><td></td><td class="<?=$test->fieldError("cout_tr","hide")?>">Rentrer un co&ucirc;t pour le travailleur</td></tr>

								<!-- Taux tp -->
								<tr>
									<th class='<?=$test->fieldError("cout_tp","required")?>'>Co&ucirc;t Tiers Payant</th>
									<td><input type='text' name='cout_tp' id='cout_tp' size='40' maxlength='40' class='txtField' title='Co&ucirc;t pour le tiers payant' value='<?=$formCoutTP?>' onKeyUp='javascript:valeurcouttp = checkAmount(this, valeurcouttp, 10, 2, false);' autocomplete='off'/>
									</td>
								</tr>										
								<tr><td></td><td class="<?=$test->fieldError("cout_tp","hide")?>">Rentrer un co&ucirc;t pour le tiers payant</td></tr>

								<!-- Taux vp -->
								<tr>
									<th class='<?=$test->fieldError("cout_vp","required")?>'>Co&ucirc;t Vipo</th>
									<td><input type='text' name='cout_vp' id='cout_vp' size='40' maxlength='10' class='txtField' title='Co&ucirc;t pour le Vipo'  value='<?=$formCoutVP?>' onKeyUp='javascript:valeurcoutvp = checkAmount(this, valeurcoutvp, 10, 2, false);' autocomplete='off' />
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("cout_vp","hide")?>">Rentrer un co&ucirc;t pour le vipo</td></tr>
								
								<!-- Duree -->
								<tr>
									<th>Dur&eacute;e</th>
									<td>
									<select id='length' name='length' width="332px" style="width: 332px" title='Dur&eacute;e moyenne de la une consultation pour cet acte interne'>
										<?php
											connexion_DB('poly');
											$sql = 'SELECT id FROM length_consult';
											$result = mysql_query($sql);
											echo "<option value='0'>Choisir</option>";
											while($data = mysql_fetch_assoc($result)) 	{
												echo "<option value='".$data['id']."' ";
												if($formLength==$data['id']) echo 'selected';
												echo " >".$data['id']."</option>";
											}	 
											deconnexion_DB();
										?>
									</select>
									</td>
								</tr>
										
								<tr>
									<th class='formLabel'><label for='validation'><br /></label>
									</th>
									<td class='formInput'>
									<input type="submit" class="button" value="Valider" />
									</td>
								</tr>
										
							</table>
								
						</form>
							
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

	<!--  ALL JS -->
	<script type="text/javascript" src='../js/acte.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
	
	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var valeurcouttr = '';
		var valeurcouttp = '';
		var valeurcoutvp = '';
		$('code').focus();
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