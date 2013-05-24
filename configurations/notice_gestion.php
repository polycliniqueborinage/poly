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
	$nom_fichier = "notice_gestion.php";
	$info_erreurs = "";
	//$lettre = array('a' => 'Adulte', 'children1' => 'Enfant', 'typetr' => 'Travailleur', 'typetp' => 'Tiers payant', 'typevp' => 'Vipo', 'typesm' => 'Sans Mutuelle', 'typevpia' => 'Vipo Indépendant Assuré', 'typevpisa' => 'Vipo Indépendant Non Assuré');
	
	// Variables du formulaire
	$formActionGestionNotice = isset($_POST['actionGestionNotice']) ? $_POST['actionGestionNotice'] : '';

	// id de l'aide
	$formID = isset($_POST['id']) ? $_POST['id'] : '';
	$formID = $test->convert($formID);

	// text are
	$formTextArea = isset($_POST['TextArea1']) ? $_POST['TextArea1'] : '';
	$formTextArea = addslashes($formTextArea);
	
	// Validation des variables
	if ($formActionGestionNotice == 1) {
		
		$test->stringtest($formID,"id","choisir une notice");
		
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
			$sql = "UPDATE notices SET textarea='$formTextArea' WHERE id='$formID'";
			$result = requete_SQL ($sql);
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 0) {
			$info_erreurs = "";
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
	<title>Poly - Ajout d'une info</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<script type="text/javascript" src="../js/submit_validatorv.js"> </script>
</head>

<body id='body'>

   	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
	<div id="top">
		<h1>Configuration - gestion des notices</h1>
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
      				<a href='../configurations/aide_gestion.php'>Gestion des aides en ligne</a>
   					<span>Gestion des notices</span>
      					
				</div>
				
				<div class="ViewPane">

					<div class="navigation-hight">

						<h2 class="code">Gestion des notices</h2>
							
						<fieldset class=''>
							<legend>Aide</legend>
								Ce formulaire permet de g&eacute;rer les notices<br />
						</fieldset>
							
						<?php echo $info_erreurs ?>
							
						<div id ='modification' />

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
						
					<div id="secondmain" class="formBox">
							
						<form name='editors_here' id="editors_here" method='post' action='<?=$nom_fichier?>'>
							
							<input type='hidden' name='actionGestionNotice' value='1'/>
									
							<table id='general'  border='1' cellspacing='0' cellpadding='0'>
							</table>
																
						</form>
								
							<form action="" name="myform" >
								<table id='information'  border='1' cellspacing='0' cellpadding='0' style="display: none;">
									<tr>
										<th>Nouveau titre</th>
											<td>
												<input type='text' name='new_titre' id='new_titre' size='24'alt='Titre' title='Description' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
											</td>
										</tr>				
									<tr>
										<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
										<td class='formInput'>
											<input type="submit" value="Valider" class="button">
										</td>
									</tr>
								</table>
								<script language="JavaScript" type="text/javascript">
									var frmvalidator  = new Validator("myform");
								</script>
							</form>			
							
						</div>
					
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
	
	<!-- EDITEUR JS -->
	<script type="text/javascript">
		var _editor_url = document.location.href.replace(/notice_gestion\.php.*/, '');
		var _editor_lang = "fr";
		var titrelabel = "titre";  
		var over='';
 	   	var out='';
		var click='';
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
    	//areaedit_init();
  	</script>
	
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
		function openDialogConfirmDelNotice(id) {
			Dialog.confirm("Etes-vous certain de vouloir <b>supprimer</b> cette notice ?<br>", {width:300, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {submitForm(id); return true;} });
		}
	</script>
	
	<!-- ALL JS -->	
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src='../js/notice.js'></script>
	<script type="text/javascript">  
		noticeUpdateForm()
	</script>
 
</body>
</html>
