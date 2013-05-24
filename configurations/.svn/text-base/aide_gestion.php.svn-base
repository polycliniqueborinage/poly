<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
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
		
	// Vider la redirection
	unset($_SESSION['redirect']);

	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "aide_gestion.php";
	$info_erreurs = "";
	//$lettre = array('a' => 'Adulte', 'children1' => 'Enfant', 'typetr' => 'Travailleur', 'typetp' => 'Tiers payant', 'typevp' => 'Vipo', 'typesm' => 'Sans Mutuelle', 'typevpia' => 'Vipo Indépendant Assuré', 'typevpisa' => 'Vipo Indépendant Non Assuré');
	
	// Variables du formulaire
	$formActionGestionAide = isset($_POST['actionGestionAide']) ? $_POST['actionGestionAide'] : '';

	// id de l'aide
	$formID = isset($_POST['id']) ? $_POST['id'] : '';
	$formID = $test->convert($formID);

	// text are
	$formTextArea = isset($_POST['TextArea1']) ? $_POST['TextArea1'] : '';
	$formTextArea = addslashes($formTextArea);
	
	// Validation des variables
	if ($formActionGestionAide == 1) {
		
		$test->stringtest($formID,"id","choisir une aide en ligne");
		
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			$sql = "UPDATE aides SET textarea='$formTextArea' WHERE id='$formID'";	
			$result = requete_SQL ($sql);
    						
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 0) {
			$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>L'aide en ligne a &eacute;t&eacute; correctement modifi&eacute;e!<br /></legend_red></fieldset>";
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
	
	deconnexion_DB();
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Ajout d'un m&eacute;decin</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

   	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
   	?>
	
	<div id="top">
		<h1>Configuration - gestion des aides en ligne</h1>
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
				
					<a href='../configurations/code_tarification_gestion.php'>Gestion des codes de tarification</a>
					<a href='../configurations/user_gestion.php'>Gestion des utilisateurs</a>
					<span>Gestion des aides en ligne</span> 
      				<a href='../configurations/notice_gestion.php'>Gestion des notices</a>
	  					
				</div>
					
	
					<div class="ViewPane">

						<div class="navigation-hight">

							<h2 class="code">Gestion des aides en ligne</h2>
							
							<fieldset class=''>
								<legend>Aide</legend>
								Ce formulaire permet de g&eacute;rer les aides en ligne de l'application<br />
							</fieldset>
							
							<?php echo $info_erreurs ?>
							
						</div>
						
						<div id="secondmain" class="formBox">
							
							<form name='editors_here' id="editors_here" method='post' action='<?=$nom_fichier?>'>
							
								<input type='hidden' name='actionGestionAide' value='1'>
									
								<table id='information'  border='1' cellspacing='0' cellpadding='0'>
								
									
									<!-- Nom -->
									<tr>
										<th class='<?=$test->fieldError("id","required")?>'>Titre</th>
										<td>
											<select id='id' name='id' title='Aides en ligne' onChange='changeAide(this.value)'>
											<?php
												connexion_DB('poly');
												$sql = 'SELECT * FROM aides order by position';
												$result = mysql_query($sql);
												
												echo "<option value='' >Choisir</option>";
												
												while($data = mysql_fetch_assoc($result)) 	{
												// on affiche les specialité
	   											echo "<option value='".$data['id']."' ";
												if($formID==$data['id']) echo 'selected';
												echo " >".$data['titre']."</option>";
												}	 
												deconnexion_DB();
												?>
											</select>
										</td>
									</tr>
									<tr><td></td><td class="<?=$test->fieldError("nom","hide")?>">Rentrer un nom de famille valide</td></tr>
								
									<tr>
										<th colspan="2" id=globalText>
									 	<textarea id="TextArea1" name="TextArea1" rows="10" cols="160" style="width:100%">
								    		<? print stripcslashes($formTextArea); ?>
										</textarea>
										</th>
									</tr>
								
									<tr>
										<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<td class='formInput'>
											<input type="submit" value="Valider" class="button" onclick="javascript:submitHandler('editors_here');">
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
			
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/note.png'>
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
	
	<!-- EDITEUR JS -->
	<script type="text/javascript">
		var _editor_url = document.location.href.replace(/aide_gestion\.php.*/, '');
		var _editor_lang = "en";
	</script>
	<script type="text/javascript" src="../areaedit/htmlarea-min.js"></script>
	<script type="text/javascript">
		areaedit_init = function(){
			if ( HTMLArea.is_ie && document.readyState != "complete" ){
				setTimeout( function() { areaedit_init()}, 50 );
				return false;
			}
			HTMLArea.init();
			var areaedit_plugins_minimal = ['ContextMenu'];
			if ( !HTMLArea.loadPlugins( areaedit_plugins_minimal, areaedit_init)){
				return;
			}
			areaedit_editors = ['TextArea1'];
			areaedit_config = new HTMLArea.Config();
			areaedit_editors   = HTMLArea.makeEditors(areaedit_editors, areaedit_config, areaedit_plugins_minimal);
			areaedit_editors.TextArea1.config.width  = 600;
       		areaedit_editors.TextArea1.config.height = 400;
			HTMLArea.startEditors(areaedit_editors);
    	}
 		var submitHandler = function(formname) {
			var form = document.getElementById(formname);
			form.onsubmit(); 
			form.submit();
		}
		areaedit_init();
  	</script>
	
	<!-- ALL JS -->	
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src='../js/aide.js'></script>
	
</body>
</html>
