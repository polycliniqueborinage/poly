<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
	// SECURISE
	if(isset($_SESSION['application'])) {
		if ($_SESSION['application']=="|poly|" && $_SESSION['role']=="Administrateur") {
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
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "code_tarification_gestion.php";
	$info_erreurs = "";
	
	// Variables du formulaire
	$actionGestionCodeTarification = isset($_POST['actionGestionCodeTarification']) ? $_POST['actionGestionCodeTarification'] : '';
		
	$formDescription = isset($_POST['description']) ? $_POST['description'] : '';
	$formDescription = $test->convert($formDescription);
	
	$formCode = isset($_POST['code']) ? $_POST['code'] : '';
	$formCode = $test->convert($formCode);

	$formCodeCouleur = isset($_POST['code_couleur']) ? $_POST['code_couleur'] : '';
	$formCodeCouleur = $test->convert($formCodeCouleur);
	
	$formType = isset($_POST['type']) ? $_POST['type'] : '';
	$formType = $test->convert($formType);
	
	// Validation des variables
	if ($actionGestionCodeTarification == 1) {
	
  		$test->stringtest($formCode,"code","code de la tarification");

		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			//$q = requete_SQL ("SELECT code FROM caisse_code WHERE code='$formCode' and type='$formType'");
			//$nombreCode = mysql_num_rows($q);
			//if ($nombreCode == 0) {
	
			// Ajout DB - mutuelles
			$q = requete_SQL ("INSERT INTO caisse_code (description,code,code_couleur,type,interne) VALUES ('$formDescription','$formCode','$formCodeCouleur','$formType', '' )");
				// Valider l'ajout dans la DB
			$formDescription = '';
			$formCode = '';
			$formCodeCouleur = '';
			$formType = '';
				
			//}
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 0) {
			//if ($nombreCode == 0 ) {
				$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>Le code a &eacute;t&eacute; correctement ajout&eacute;!<br /></legend_red></fieldset>";
			//} else {
			//$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
			//<legend_red>Un code de ce type existe d&eacute;j&agrave;!<br /></legend_red></fieldset>";
			//}
		} else {
			if ($test->Count == 1) {
				$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>Corriger le champ &eacute;rron&eacute; : $test->ListeErreur !<br /></legend_red></fieldset>";
			} else {
				$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>Corriger les $test->Count champs &eacute;rron&eacute;s : $test->ListeErreur !<br /></legend_red></fieldset>";
			}
		}
	}
	

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Gestion des codes de tarifications</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../yui/build/menu/assets/menu.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../yui/build/fonts/fonts-min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../yui/build/container/assets/skins/sam/container.css" />
	<link rel="stylesheet" type="text/css" href="../yui/build/colorpicker/assets/skins/sam/colorpicker.css" />
	<link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>


	<div class="yui-skin-sam">

	<div id="top">
		
		<h1>Configurations - Gestion des codes de tarifications</h1>

	</div>
    
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Configs</a>
				</li>
	    	</ul>
		</div>        
          
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
				
    				<span>Gestion des codes de tarification</span> 
					<a href='../configurations/user_gestion.php'>Gestion des utilisateurs</a>
					<a href='../configurations/aide_gestion.php'>Gestion des aides en ligne</a>
      				<a href='../configurations/notice_gestion.php'>Gestion des notices</a>
												
				</div>
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<fieldset class=''>
							<legend>Aide</legend>
							Ce formulaire permet de g&eacute;rer les codes de tarification.<br />
						</fieldset>
						<?php echo $info_erreurs ?>
							
					</div>
					
					<div id="secondheader">
        				<ul id="sec_primary_tabs">
        					<li id="sec_tab_general" class="nodelete current">
		  						<a class="nodelete" href="#" onclick="javascript:switchGeneralInfo('general');">Modif</a>
		 			 		</li>
        					<li id="sec_tab_info" class="nodelete">
			  					<a class="nodelete" href="#" onclick="javascript:switchGeneralInfo('information');">Ajout</a>
					 		</li>
       					</ul>
					</div>
						
					<!-- DEBUT DU CALENDRIER -->
					<div id="secondmain" class="formBox">
						
						<form name='actionGestionCodeTarificationForm' id='actionGestionCodeTarificationForm' method='post' action='<?=$nom_fichier?>'>

							<input type='hidden' name='actionGestionCodeTarification' value='1'>

							<table id='general'  border='1' cellspacing='0' cellpadding='0'>
								
								<?php

									connexion_DB('poly');
																	
									$sql = "SELECT id, code, type, description, code_couleur, interne FROM caisse_code ORDER BY 1 asc";
									$result = requete_SQL ($sql);
																			
									$jsStart = "";
								
									echo "<tr>";
									echo "<th>";
									echo "</th>";
									echo "<td>";
									echo "<input type='text' size='24'alt='Description' title='Description' maxlength='32' value='Description' readonly='true'/>";
									echo "<input type='text' size='8' alt='Code' title='Code' maxlength='7' value='Code' readonly='true'/>";
									echo "<input type='text' size='7' alt='Code couleur' title='Code couleur' maxlength='7' value='Couleur' readonly='true'/>";
									echo "<input type='text' size='8' alt='Type' title='Type' maxlength='6' value='Type' readonly='true'/>";
									echo "</td>";
									echo "</tr>";
									
									if(mysql_num_rows($result)!=0) {
								
										while($data = mysql_fetch_assoc($result)) 	{
											
											$dataID = $data['id'];
											$dataCode = $data['code'];
											$dataDescription = $data['description'];
											$dataCodeCouleur = $data['code_couleur'];
											$dataInterne = $data['interne'];
											$dataType = $data['type'];
								
											
											if ($dataType=='1') {$tempIn = 'selected';$tempOut = '';} else {$tempIn = '';$tempOut = 'selected';}  
											if ($dataInterne != 'checked') {$tempClass = '';} else {$tempClass = 'required';}
								
											$jsStart .= "Event.on('show$dataID', 'click', clickHandler);";
											$jsStart .= "Event.on('show$dataID', 'click', this.dialog.show, this.dialog, true );";
								
											echo "<tr>";
											echo "<th class='$tempClass'>".htmlentities($dataDescription)."</th>";
											echo "<td>";
											
											if ($dataInterne != 'checked') {
												echo "<input type='text' size='24'alt='Description' title='Description' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataDescription),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:modifChamp($dataID,descriptionlabel,this.value)' autocomplete='off'/>";
											} else {
												echo "<input type='text' size='24'alt='Description' title='Description' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataDescription),ENT_QUOTES))."'  disabled='true'/>";
											}
											echo "<input type='text' size='8' alt='Code' title='Code' maxlength='32' value='".htmlentities($dataCode)."'  onfocus='this.select()' onkeyup='javascript:modifChamp($dataID,codelabel,this.value)' autocomplete='off'/>";
											
											echo "<input id='show$dataID' style='font-weight: bold;color: #$dataCodeCouleur' type='text' size='7' alt='Code couleur' title='Code couleur' maxlength='6' value='".htmlentities($dataCodeCouleur)."'  onfocus='this.select()' onchange='javascript:modifChamp($dataID,code_couleurlabel,this.value);' autocomplete='off'/>";
											
											//echo "<a href='#' id='show$dataID'><img width='16' height='16' src='../images/delete_small.gif' alt='Choix de la couleur' title='Choix de la couleur' border='0' /></a>"; 
											
											echo "<select width='75px'style='width: 75px' onchange='javascript:modifChamp($dataID,typelabel,this.value)'>"; 
											echo "<option value='-1' $tempOut>Sortie</option>";
											echo "<option value='1' $tempIn>Entr&eacute;e</option>";
											echo "</select>";
								
											if ($dataInterne != "checked") {
												echo "&nbsp;&nbsp;&nbsp;<a href='#' onClick='javascript:openDialogConfirm($dataID,\"".htmlentities($dataDescription)."\");return false;' >";
												echo "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' />";
												echo "</a>";
											} else {
												echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
											}
								
											echo "<div id ='info$dataID'></div>";
											echo "</td>";
											echo "</tr>";
								
										}
								
									}
								
									deconnexion_DB();
								
								?>
							</table>
								
							<table id='information'  border='1' cellspacing='0' cellpadding='0' style="display: none;">
								
								<tr>
									<th>Description</th>
									<td><input type='text' id='description' name='description' size='40' alt='Description' value='<?=html_entity_decode(htmlentities(stripcslashes($formDescription),ENT_QUOTES))?>' title='Description' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
									</td>
								</tr>
																		
								<tr>
									<th class='<?=$test->fieldError("code","required")?>'>Code</th>
									<td><input type='text' name='code' size='40' alt='Code' title='Code' maxlength='32' value='<?=html_entity_decode(htmlentities(stripcslashes($formCode),ENT_QUOTES))?>'  onfocus='this.select()'  autocomplete='off'/>
									</td>
								</tr>
								<tr><td></td><td class="<?=$test->fieldError("code","hide")?>">Rentrer un code valable</td></tr>
									
								<tr>
									<th>Code couleur</th>
									<td><input type='text' name='code_couleur' size='40' alt='Code couleur' title='Code couleur' maxlength='6' value='<?=html_entity_decode(htmlentities(stripcslashes($formCodeCouleur),ENT_QUOTES))?>'  onfocus='this.select()' autocomplete='off'/>
									</td>
								</tr>
									
									
								<tr>
									<th>Type</th>
									<td>
										<select width="332px" style="width: 332px" id='type' name='type' title='type de code (entrŽe ou sortie)'>
											<option value='-1' <? if ($formType=='-1') echo "selected"; ?> >Sortie</option>
 											<option value='1' <? if ($formType=='1') echo "selected"; ?> >Entr&eacute;e</option>
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
												
								<!-- Nom -->
																				
							</table>
								
						</form>
							
					</div>
					
					<div id="calendarSideBar" class="">
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
			
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/config.png'>
 					</div>
				</td>
  			    	
				<td class="drawer-handle" onclick="toggleSidebars(); return false;">
           			<div class="top-corner"></div>
           			<div class="bottom-corner"></div>
       	   	 	</td>
				
      		</tr>
		</table>
	</div>
	
	<div id="yui-picker-panel" class="yui-picker-panel">
		<div class="bd">
			<form name="yui-picker-form" id="yui-picker-form" method="post" action="assets/post.php">
			<div class="yui-picker" id="yui-picker"></div>
			</form>
		</div>
		<div class="ft"></div>
		</div>
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
  	  	function openDialogConfirm(id,comment) {
  			Dialog.confirm("<table><tr><td><img src='../images/96x96/help.png'></td><td>Vouler vous supprimer ce code de tarification ?<br> ["+comment+"]"+"</td></tr></table>", {width:300, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {supprimeCodeTarification(id); return true;} });
		}
	</script>
	
	<script type="text/javascript" src='../js/modif_code_tarification.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" language="javascript">
	    var currentDiv = '';
		var descriptionlabel = 'description';	
		var codelabel = 'code';
		var code_couleurlabel = 'code_couleur';
		var typelabel = 'type';
	//-->
    </script>
	
	<script type="text/javascript" src="../yui/build/utilities/utilities.js"></script>
	<script type="text/javascript" src="../yui/build/container/container.js"></script>
	<script type="text/javascript" src="../yui/build/slider/slider.js"></script>
	<script type="text/javascript" src="../yui/build/colorpicker/colorpicker-beta.js"></script>
	<script type="text/javascript">
		YAHOO.namespace("colorpicker")
		YAHOO.colorpicker.inDialog = function() {
		var Event=YAHOO.util.Event,	Dom=YAHOO.util.Dom,	lang=YAHOO.lang;
		return {
	        init: function() {

				// Instantiate the Dialog
	            this.dialog = new YAHOO.widget.Dialog("yui-picker-panel", { 
					width : "400px",
					close: true,
					fixedcenter : true,
					visible : false, 
					constraintoviewport : false,
					buttons : [ { text:"Valider", handler:this.handleSubmit },
								{ text:"Annuler", handler:this.handleCancel } ]
	             });
 
				// Once the Dialog renders, we want to create our Color Picker instance.
	            this.dialog.renderEvent.subscribe(function() {
					if (!this.picker) { //make sure that we haven't already created our Color Picker
						this.picker = new YAHOO.widget.ColorPicker("yui-picker", {
							container: this.dialog,
							images: {
								PICKER_THUMB: "../images/picker_thumb.png",
								HUE_THUMB: "../images/hue_thumb.png"
							},
							showhexcontrols: true // default is false
						});
						//listen to rgbChange to be notified about new values
						this.picker.on("rgbChange", function(o) {
						});
					}
				});	
				
	            this.dialog.validate = function() {
	            	return true;
	            };
	            
	            
	            function clickHandler(e) {
					var elTarget = YAHOO.util.Event.getTarget(e);
					currentDiv = elTarget.id;
					currentColor = elTarget.value;
					//alert(currentColor);
					$('yui-picker-hex').value=currentColor;
					$('description').focus();
					//$('yui-picker-r').focus();
					//$('yui-picker-g').focus();
					//$('yui-picker-b').focus();
					//$('yui-picker-bg').focus();
					
				}

	            // We're all set up with our Dialog's configurations now, render the Dialog
	            this.dialog.render();
				
				<?
					echo $jsStart;
				?>				
     		
			},
		
			//We'll wire this to our Dialog's submit button:
			handleSubmit: function() {
				var pickerVal = document.getElementById("yui-picker-hex").value;
				this.submit();
				currentID = currentDiv.replace(/show/g, '');
				modifChamp(currentID,code_couleurlabel,pickerVal);
				document.getElementById(currentDiv).value = pickerVal;
				document.getElementById(currentDiv).setAttribute("style","font-weight: bold; color: #" + pickerVal );
			},
 
	 		//If the Dialog's cancel button is clicked, this function fires
			handleCancel: function() {
				this.cancel();
			},
   
		}

		}();
		YAHOO.util.Event.onDOMReady(YAHOO.colorpicker.inDialog.init, YAHOO.colorpicker.inDialog, true);
	</script>
	
</body>
</html>