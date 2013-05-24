<?php 

	// Demarre une session
	session_start();
	
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
	$nom_fichier = "user_gestion.php";
	$info_erreurs = "";
	//$lettre = array('a' => 'Adulte', 'children1' => 'Enfant', 'typetr' => 'Travailleur', 'typetp' => 'Tiers payant', 'typevp' => 'Vipo', 'typesm' => 'Sans Mutuelle', 'typevpia' => 'Vipo Indépendant Assuré', 'typevpisa' => 'Vipo Indépendant Non Assuré');
	
	$formLettreMax = isset($_GET['lettre_max']) ? $_GET['lettre_max'] : '-1';
	$formLettreMax = $test->convert($formLettreMax);
	
	$formLettreMin = isset($_GET['lettre_min']) ? $_GET['lettre_min'] : '-1';
	$formLettreMin = $test->convert($formLettreMin);
	
	// Variables du formulaire
	$actionGestionUser = isset($_POST['actionGestionUser']) ? $_POST['actionGestionUser'] : '';
		
	$formNom = isset($_POST['nom']) ? $_POST['nom'] : '';
	$formNom = ucfirst(strtolower($formNom));
	$formNom = $test->convert($formNom);
	
	$formPrenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
	$formPrenom = ucfirst(strtolower($formPrenom));
	$formPrenom = $test->convert($formPrenom);
	
	$formLogin = isset($_POST['login']) ? $_POST['login'] : '';
	$formLogin = $test->convert($formLogin);

	$formPassword = isset($_POST['password']) ? $_POST['password'] : '';
	$formPassword = $test->convert($formPassword);
	
	$formRole = isset($_POST['role']) ? $_POST['role'] : '';
	$formRole = $test->convert($formRole);
	
	$formApplication = isset($_POST['application']) ? $_POST['application'] : '';
	$formApplication = $test->convert($formApplication);

	$formDroit = isset($_POST['droit']) ? $_POST['droit'] : '';
	$formDroit = $test->convert($formDroit);
	
	$formInami = isset($_POST['inami']) ? $_POST['inami'] : '';
	$formInami = $test->convert($formInami);
	
	$InamiDisable ="disabled";
	$AgendaDisable ="disabled";
	
	// Validation des variables
	if ($actionGestionUser == 1) {
	
  		$test->stringtest($formLogin,"login","login");
  		$test->passwordtest($formPassword,"password","mot de passe trop court (minimum 6 caract&egrave;res)", "mot de passe trop simple");
  		
  		// test supplémentaire pour les agenda
  		if (strpos($formApplication,'agenda')>0) {
  			$test->inamitest($formInami,"inami","num&eacute;ro INAMI");
  			$test->stringtest($formDroit,"droit","type de permission sur agenda");
  			$AgendaDisable ="";
  			$InamiDisable ="";
  		} else {
 			$AgendaDisable ="disabled";
 			$InamiDisable ="disabled";
  		}
  		
		// Traitement lorsque tous les tests sont passés avec succès
		if ($test->Count == 0) {
    	
			$q = requete_SQL ("SELECT login FROM users WHERE login='$formLogin'");
			
			$nombreCode = mysql_num_rows($q);
					
    		if ($nombreCode == 0) {
	
				// Ajout DB - mutuelles
				$q = requete_SQL ("INSERT INTO users (nom, prenom, login, password, role, application, inami, droit) VALUES ('$formNom','$formPrenom','$formLogin', md5('$formPassword'), '$formRole', '$formApplication', '$formInami' , '$formDroit')");
				// Valider l'ajout dans la DB
				$formNom = '';
				$formPrenom = '';
				$formLogin = '';
				$formPassword = '';
				$formRole = '';
				$formApplication = '';
				$formDroit = '';
				$formInami = '';
				
			}
       	}
       	
       	// une ou plusieurs erreurs dans le formulaire
		if ($test->Count == 0) {
			if ($nombreCode == 0 ) {
				$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>L'utilisateur a &eacute;t&eacute; correctement ajout&eacute;!<br /></legend_red></fieldset>";
			} else {
			$info_erreurs = "<fieldset class=''><legend>Erreur</legend>
<legend_red>Un utilisateur avec ce login existe d&eacute;j&agrave;!<br /></legend_red></fieldset>";
			}
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
	<title>Poly - Gestion des utilisateurs</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>

    <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Configurations - Gestion des utillisateurs</h1>

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
   					<span>Gestion des utilisateurs</span> 
      				<a href='../configurations/aide_gestion.php'>Gestion des aides en ligne</a>
					<a href='../configurations/notice_gestion.php'>Gestion des notices</a>
      					
				</div>
					
					<div class="ViewPane">

						<div class="navigation-hight">

							<h2 class="code">Gestion des utilisateurs</h2>
							
							<fieldset class=''>
								<legend>Aide</legend>
								Ce formulaire permet de g&eacute;rer les utilisateurs de l'application classifié par nom de famille.<br />
							</fieldset>
							
							<?php echo $info_erreurs ?>
							
						</div>
						
						<div id="secondheader">
        					<ul id="sec_primary_tabs"><!-- [a [e   [e [h   .... [x [zzz -->
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == '-1') echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=-1&lettre_max=-1">Nouveau</a>
		 				 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == '') echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=&lettre_max=dZZ">A - D</a>
		 				 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == e) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=E&lettre_max=hZZ">E - H</a>
		 				 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == i) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=I&lettre_max=lZZ">I - L</a>
		 				 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == m) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=M&lettre_max=pZZ">M - P</a>
		 				 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == q) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=Q&lettre_max=tZZ">Q - T</a>
						 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == u) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=U&lettre_max=wZZ">U - W</a>
						 		</li>
        						<li id="calendar_tab" class="nodelete <?if ($formLettreMin == x) echo "current"; ?>">
		  							<a class="nodelete" href="./user_gestion.php?lettre_min=X&lettre_max=ZZZ">X - Z</a>
								</li>
       			    		</ul>
						</div>
						
						<div id="secondmain" class="formBox">
						
							<table border='1' cellspacing='0' cellpadding='0'>
							
								<!-- Ajout d'un user -->
								<?if ($formLettreMin == '-1') { ?>
								
									<form name='actionGestionUserForm' id='actionGestionUserForm' method='post' action='<?=$nom_fichier?>'>
																
										<input type='hidden' name='actionGestionUser' value='1'>
										
										<tr>
											<th class='<?=$test->fieldError("nom","required")?>'>Nom</th>
											<td>
												<input type='text' name='nom' size='32' alt='Nom' title='Nom' value='<?=html_entity_decode(htmlentities(stripcslashes($formNom),ENT_QUOTES))?>' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
											</td>
 										</tr>				
										
										<tr>
											<th class='<?=$test->fieldError("prenom","required")?>'>Pr&eacute;nom</th>
											<td>
												<input type='text' name='prenom' size='32' alt='Pr&eacute;nom' title='Pr&eacute;nom' value='<?=html_entity_decode(htmlentities(stripcslashes($formPrenom),ENT_QUOTES))?>' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
											</td>
 										</tr>				
										
										<tr>
											<th class='<?=$test->fieldError("login","required")?>'>Login</th>
											<td>
												<input type='text' name='login' size='32' alt='Login' title='Login' value='<?=html_entity_decode(htmlentities(stripcslashes($formLogin),ENT_QUOTES))?>' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
											</td>
 										</tr>				
										<tr><td></td><td class="<?=$test->fieldError("login","hide")?>">Rentrer un login correct</td></tr>
										
										<tr>
											<th class='<?=$test->fieldError("password","required")?>'>Mot de passe</th>
											<td>
												<input type='password' name='password' size='32' alt='Mot de passe' title='Mot de passe' value='<?=html_entity_decode(htmlentities(stripcslashes($formPassword),ENT_QUOTES))?>' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off'/>
											</td>
 										</tr>				
										<tr><td></td><td class="<?=$test->fieldError("password","hide")?>">Rentrer un mot de passe correct</td></tr>
										
										<tr>
											<th class='<?=$test->fieldError("role","required")?>'>R&ocirc;le</th>
											<td>
											<select name='role'>
												<option value='Gestionnaire' <? if ($formRole=='Gestionnaire') echo "selected"; ?> >Gestionnaire</option>
 												<option value='Administrateur' <? if ($formRole=='Administrateur') echo "selected"; ?> >Administrateur</option>
 											</select>
 											</td>
 										</tr>				
										
										<tr>
											<th class='<?=$test->fieldError("application","required")?>'>Application</th>
											<td>
											<select name='application' onchange="disable_inami(0,0,this.value);">
												<option value='|poly|' <? if ($formApplication=='|poly|') echo "selected"; ?> >Poly</option>
 												<option value='|agenda|' <? if ($formApplication=='|agenda|') echo "selected"; ?> >Agenda</option>
 												<option value='|poly|agenda|' <? if ($formApplication=='|poly|agenda|') echo "selected"; ?> >Agenda & Poly</option>
 											</select>
 											</td>
 										</tr>				
										
										<tr>
											<th class='<?=$test->fieldError("droit","required")?>'>Agenda</th>
											<td>
											<select id='agenda0' name='droit'"  <?=$AgendaDisable?>>
												<option value='' <? if ($formDroit=='') echo "selected"; ?> >Choisir...</option>
 												<option value='lecture' <? if ($formDroit=='lecture') echo "selected"; ?> >Lecture seule</option>
 												<option value='ecriture' <? if ($formDroit=='ecriture') echo "selected"; ?> >Lecture et &eacute;criture</option>
 											</select>
 											</td>
 										</tr>			
										<tr><td></td><td class="<?=$test->fieldError("droit","hide")?>">Rentrer le type d'acces &agrave; l'agenda</td></tr>
										
										<tr>
											<th class='<?=$test->fieldError("inami","required")?>'>Num&eacute;ro Inami</th>
											<td>
												<input id='inami0' type='text' name='inami' size='32' maxlength='11' alt='Num&eacute;ro Inami' title='Num&eacute;ro Inami' value='<?=html_entity_decode(htmlentities(stripcslashes($formInami),ENT_QUOTES))?>' maxlength='32' value=''  onfocus='this.select()'  autocomplete='off' <?=$InamiDisable?> onKeyUp='javascript:valeurinami = checkNumber(this, valeurinami, 11, false);'/>
											</td>
 										</tr>				
										<tr><td></td><td class="<?=$test->fieldError("inami","hide")?>">Rentrer un num&eacute;ro Inami correct</td></tr>
												
										<tr>
											<th><label for='validation'><br /></label>
											</th>
											<td class='formInput'>
											<input type="submit" class="button" value="Valider" />
											</td>
										</tr>
												
									</form>
						
							<!-- Modification d'un user -->
							<? } else {
									
								connexion_DB('poly');
									
								// On fait la requête
								$sql = "SELECT * FROM users where nom >= '$formLettreMin' and nom < '$formLettreMax' ORDER BY nom asc";
								$result = requete_SQL ($sql);
											
								if(mysql_num_rows($result)!=0) {
												
									$i = 0;
												
									while($data = mysql_fetch_assoc($result)) 	{
													
										$i++;
										if ($i % 2 == 0) $class="required"; else $class="";
													
										$dataNom = $data['nom'];
										$dataPrenom = $data['prenom'];
										$dataLogin = $data['login'];
										$dataPassword = $data['password'];
										$dataRole = $data['role'];
										$dataApplication = $data['application'];
										$dataDroit = $data['droit'];
										$dataInami = $data['inami'];
													
										if (strpos($dataApplication,'agenda')>0) {
											$AgendaDisable ="";
											$InamiDisable ="";
										} else {
											$AgendaDisable ="disabled";
											$InamiDisable ="disabled";
										}
															  		
										echo "<tr>";
										echo "<th class='$class'>Nom&nbsp;&nbsp;&nbsp;<a href='#' onClick='openDialogConfirmDelUser(\"$dataLogin\")' ><img width='16' height='16' src='../images/delete_small.gif' alt='Effacer $dataLogin' title='Effacer $dataLogin' border='0' /></a></th>";
										echo "<td><input type='text' size='32'alt='Nom' title='Nom' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataNom),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:actionUser(\"$dataLogin\",\"nom\",this.value)' autocomplete='off'/></td>";
										echo "</tr>";

										echo "<tr>";
										echo "<th class='$class'>Pr&eacute;nom</th>";
										echo "<td><input type='text' size='32'alt='Pr&eacute;nom' title='Pr&eacute;nom' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataPrenom),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:actionUser(\"$dataLogin\",\"prenom\",this.value)' autocomplete='off'/></td>";
										echo "</tr>";
													
										echo "<tr>";
										echo "<th class='$class'>Login</th>";
										echo "<td><input type='text' size='32'alt='Login' title='Login' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataLogin),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:actionUser(\"$dataLogin\",\"login\",this.value)' autocomplete='off'/></td>";
										echo "</tr>";
													
										echo "<tr>";
										echo "<th class='$class'>Mot de passe</th>";
										echo "<td><input type='password' size='32'alt='Mot de passe' title='Mot de passe' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataPassword),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:actionUser(\"$dataLogin\",\"password\",this.value)' autocomplete='off'/></td>";
										echo "</tr>";

										echo "<tr>";
										echo "<th class='$class'>R&ocirc;le</th>";
										echo "<td>";
										echo "<select onchange='javascript:actionUser(\"$dataLogin\",\"role\",this.value)'>"; 
										echo "<option value='Gestionnaire' ";
										if ($dataRole=='Gestionnaire') echo "selected";
										echo " >Gestionnaire</option>"; 
 										echo "<option value='Administrateur' ";
 										if ($dataRole=='Administrateur') echo "selected";
										echo " >Administrateur</option>";
 										echo "</select>";
 										echo "</td>";
										echo "</tr>";

										echo "<tr>";
										echo "<th class='$class'>Application</th>";
										echo "<td>";
										echo "<select onchange='javascript:actionUser(\"$dataLogin\",\"application\",this.value);disable_inami($dataLogin,$dataLogin,this.value);'>"; 
										echo "<option value='|poly|' ";
										if ($dataApplication=='|poly|') echo "selected";
										echo " >Poly</option>";
 										echo "<option value='|agenda|' ";
 										if ($dataApplication=='|agenda|') echo "selected";
										echo " >Agenda</option>";
 										echo "<option value='|poly|agenda|' ";
 										if ($dataApplication=='|poly|agenda|') echo "selected";
										echo " >Agenda & Poly</option>";
 										echo "</select>";
										echo "</td>";
										echo "</tr>";
									
										echo "<tr>";
										echo "<th class='$class'>Agenda</th>";
										echo "<td>";
										echo "<select id='agenda$dataID' onchange='javascript:actionUser(\"$dataLogin\",\"droit\",this.value);'>"; 
										echo "<option value='' ";
										if ($dataDroit=='') echo "selected";
										echo " >Choisir</option>";
 										echo "<option value='lecture' ";
 										if ($dataDroit=='lecture') echo "selected";
										echo " >Lecture seule</option>";
 										echo "<option value='ecriture' ";
 										if ($dataDroit=='ecriture') echo "selected";
										echo " >Lecture et &eacute;criture</option>";
 										echo "</select>";
										echo "</td>";
										echo "</tr>";
									
										echo "<tr>";
										echo "<th class='$class'>Inami</th>";
										echo "<td><input id='inami$dataID' type='text' size='32'alt='inami' title='inami' maxlength='32' value='".html_entity_decode(htmlentities(stripcslashes($dataInami),ENT_QUOTES))."'  onfocus='this.select()' onkeyup='javascript:actionUser(\"$dataLogin\",\"inami\",this.value);' autocomplete='off'/></td>";
 										echo "</tr>";
													
									}
								}
							}
							
							?>
										
						</table>

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
						<img src='../images/96x96/users.png'>
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

	<script type="text/javascript" src='../js/user.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" language="javascript">
		var nomlabel = 'nom';
		var prenomlabel = 'prenom';
		var loginlabel = 'login';
		var passwordlabel = 'password';
		var rolelabel = 'role';
		var applicationlabel = 'application';
		var inamilabel = 'inami';
		var agendalabel = 'agenda';
		var valeurinami = '';										
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
		function openDialogConfirmDelUser(id) {
			Dialog.confirm("Etes-vous certain de vouloir <b>supprimer</b> cette utilisateur ?<br>", {width:300, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {actionUser(id,'del_user',''); return true;} });
		}
	</script>
    
	
</body>
</html>