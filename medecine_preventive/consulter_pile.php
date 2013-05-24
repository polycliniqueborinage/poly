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
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
        
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "consulter_pile.php";
	
	$formModifierPile = isset($_POST['actionModifierPile'])    ? $_POST['actionModifierPile']    : ''; 

	if($formModifierPile == 1){
		
		// Modifier DB
		$sql = "SELECT * FROM mp_pile ";
		$req = requete_SQL ($sql);
		
		while($liste = mysql_fetch_assoc($req)) 	{
			$formDate     = isset($_POST["date_".$liste['id_motif']."_".$liste['id_patient']])     ? $_POST["date_".$liste['id_motif']."_".$liste['id_patient']]     : '';
			$formStatut   = isset($_POST["statut_".$liste['id_motif']."_".$liste['id_patient']])   ? $_POST["statut_".$liste['id_motif']."_".$liste['id_patient']]   : '';
			
			$formDelete   = isset($_POST["delete_".$liste['id_motif']."_".$liste['id_patient']])   ? $_POST["delete_".$liste['id_motif']."_".$liste['id_patient']]   : '';
			
			$sql = "UPDATE `mp_pile` 
					SET `date_derniere_modification` = '$formDate',
					    `statut`                     = '$formStatut' 
				    WHERE `id_motif`   = '".$liste['id_motif']."'
				    AND   `id_patient` = '".$liste['id_patient']."'";
			
			$q = requete_SQL ($sql);
			
			if($formDelete != ''){
				$sql = "DELETE FROM `mp_pile` 
						WHERE `id_motif`   = '".$liste['id_motif']."'
					    AND   `id_patient` = '".$liste['id_patient']."'";
				
				$q = requete_SQL ($sql);
			}
			
		}	
		// Valider l'ajout dans la DB
		$_SESSION['information']="Op&eacute;ration r&eacute;ussie ";
	
	}	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Poly - M&eacute;decine pr&eacute;ventive</title>
	<script type="text/javascript" src='../js/medecinepreventive.js'></script>
	<!-- <script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" src="../scriptaculous/lib/prototype.js"></script>
	<script type="text/javascript" src='../js/inputControl.js'></script>
    <script type="text/javascript" src='../js/autosuggest.js'></script>
	<script type="text/javascript" src='../js/suggestions.js'></script>
	<script type="text/javascript" src="../thickbox_fichiers/urchin.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/overlib.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/jQuery.js"></script>
	<script type="text/javascript" src="../thickbox_fichiers/thickbox.js"></script> 

	<link href="../thickbox_fichiers/thickbox.css" media="screen" rel="stylesheet" type="text/css">
	<link href="../style/basic.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/tabs.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/appt.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/calendar.css" media="all" rel="Stylesheet" type="text/css">
    <link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css"> -->
    
    <link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body'>
	
	<?php
		get_MENUBAR_START();
		echo "</div></div>";
	?>
		
	<div id="top">
		
		<h1>M&eacute;decine pr&eacute;ventive - Consulter la pile</h1>

	</div>

	<div id="middle">
	
	<div id="header">
        <ul id="primary_tabs">
			<?php get_MENU('medecine_preventive')?>
        </ul>
	</div>  
      
	  	<div id="main">        
	        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
					<span>Liste de contacts en cours</span>
	   
	   				<a href="./creer_motif.php">Cr&eacute;ation d'un nouveau motif de m&eacute;decine pr&eacute;ventive</a> 
	      				
					<a href="./activation_motif.php">Activer/d&eacute;sactiver des motifs</a>
					
					<a href="./mp_batch_fill_pile.php">Activer manuellement la v&eacute;rification de la pile</a>
				</div>								
					
				<div class="ViewPane">

					<div class="navigation-hight">

						<h2>Liste de contacts</h2>
						
						<fieldset class=''>
							<legend>Aide</legend>
							Ce formulaire permet de consulter la liste des personnes à contacter ou à recontacter.<br>
						</fieldset>
						
					</div>
					
					<div id="secondmain" class="formBox">
						
						<form name='updateListe' id='updateListe' method='post' action='<?=$nom_fichier?>'>
                            <?php echo $info_erreurs; ?>
   
						<input type='hidden' name='actionModifierPile' value='1'>
						
						<!-- Insert -->
						<fieldset class=''>
							<legend>Liste de contacts</legend>
								<?
								// On fait la requête

								$sql = "SELECT * FROM mp_pile ORDER BY statut";

								// VERIFICATION
								$result = requete_SQL ($sql);
	
								if(mysql_num_rows($result)!=0) {

									echo "<table border='0' cellpadding='2' cellspacing='1'>";
									echo "<th>D&eacute;tails</th>";
									echo "<th><img src='../images/delete_small.gif' alt='Delete' title='Delete' border='0' width=15/></th>";
									echo "<th>Nom du patient</th>";
									echo "<th>Pr&eacute;nom du patient</th>";
									echo "<th>Adresse</th>";
									echo "<th>T&eacute;l&eacute;phone</th>";
									echo "<th>E-mail</th>";
									echo "<th>Motif</th>";
									echo "<th>Date de derni&egrave;re modification</th>";
									echo "<th>Statut</th>";
									echo "<th valign='center' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo "<a id='print' name='print' onclick='recupererLettresImprimer();'>";
									echo "<img src='../images/document_print.gif' alt='Lettre' title='Lettre' border='0' /></a>";
									echo "</th>";
									echo "<th valign='center' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo "<a id='mail' name='mail' onclick='recupererMailAEnvoyer();'>";
									echo "<img src='../images/24x24/newmailing.gif' alt='Mail' title='Mail' border='0' width=25/></a>";
									echo "</th>";

									$i = 0;

									?>
									
									<div id="boxElementList">
									</div>
									
									<?
									
									while($data = mysql_fetch_assoc($result)) 	{
									
									if ($i == 20) {
										
										$i = 0;
										echo "<th>D&eacute;tails</th>";
										echo "<th><img src='../images/delete_small.gif' alt='Delete' title='Delete' border='0' width=15/></th>";
										echo "<th>Nom du patient</th>";
										echo "<th>Pr&eacute;nom du patient</th>";
										echo "<th>Adresse</th>";
										echo "<th>T&eacute;l&eacute;phone</th>";
										echo "<th>E-mail</th>";
										echo "<th>Motif</th>";
										echo "<th>Date de derni&egrave;re modification</th>";
										echo "<th>Statut</th>";
										echo "<th valign='center' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
										echo "<a id='print' name='print' onclick='recupererLettresImprimer();'>";
										echo "<img src='../images/document_print.gif' alt='Lettre' title='Lettre' border='0' /></a>";
										echo "</th>";
										echo "<th valign='center' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
										echo "<a id='mail' name='mail' onclick='recupererMailAEnvoyer();'>";
										echo "<img src='../images/24x24/newmailing.gif' alt='Mail' title='Mail' border='0' width=25/></a>";
										echo "</th>";
							  		}
									
									$i++;
																			
									// on affiche les informations de l'enregistrement en cours
									echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";
									
									$req_select_patient = "select * FROM patients WHERE id = ".$data['id_patient'];
									$req_select_motif   = "select * FROM medecine_preventive WHERE motif_ID = ".$data['id_motif'];
									
									$res_patient = requete_SQL($req_select_patient);
									$res_motif   = requete_SQL($req_select_motif);
									
									$patient = mysql_fetch_assoc($res_patient);
									$motif   = mysql_fetch_assoc($res_motif);
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo "<a onclick='mpDisplayDetails(".$data['id_motif'].", ".$data['id_patient'].")';>";
									echo "<img id='close_arrow_".$data['id_motif']."_".$data['id_patient']."' width='16' height='16' src='../images/16x16/arrow_rotate_anticlockwise.png' alt='D&eacute;tails' title='D&eacute;tails' border='0' />";
									echo "<img id='open_arrow_".$data['id_motif']."_".$data['id_patient']."' style=display:none width='16' height='16' src='../images/16x16/arrow_rotate_clockwise.png' alt='D&eacute;tails' title='D&eacute;tails' border='0' />";
									echo "</a>";
									echo "</td>";
									
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo "<input type=checkbox id='delete_".$data['id_motif']."_".$data['id_patient']."' name='delete_".$data['id_motif']."_".$data['id_patient']."'>";
									echo "</td>";
									

									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $patient['nom'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $patient['prenom'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $patient['rue'].". ".$patient['code_postal']." ".$patient['commune'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									if($patient['telephone'] != '')                          echo $patient['telephone'];
									if($patient['gsm'] != '' && $patient['telephone'] != '') echo" - "; 
									if($patient['gsm'] != '')                                echo $patient['gsm'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $patient['mail'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo $motif['description'];
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo "<input type=date size=10 id='date_".$data['id_motif']."_".$data['id_patient']."' name='date_".$data['id_motif']."_".$data['id_patient']."' value='".$data['date_derniere_modification']."'>";
									echo "</td>";
									
									echo "<td valign='top' bgcolor='#D5D5D5' align='center' nowrap='nowrap'>";
									echo"<select id='statut_".$data['id_motif']."_".$data['id_patient']."' name='statut_".$data['id_motif']."_".$data['id_patient']."'>";
 
									
									$a_contacter = '';
									$contacte    = '';
									$rdv_pris    = '';
									$a_rappeler  = '';
									$termine     = '';
									
									switch($data['statut']){
										case 'a_contacter':
											$a_contacter = 'SELECTED';
											break;
										case 'contacte':
											$contacte    = 'SELECTED';
											break;
										case 'rdv_pris':
											$rdv_pris    = 'SELECTED';
											break;
										case 'a_rappeler':
											$a_rappeler  = 'SELECTED';
											break;
										case 'termine':
											$a_contacter = 'SELECTED';
											break;		
										default:
											$a_contacter = 'SELECTED';
											break;			
									}
									
										echo"<option value='a_contacter'".$a_contacter.">A contacter     </option>";
										echo"<option value='contacte'   ".$contacte."   >Contact&eacute; </option>";
										echo"<option value='rdv_pris'   ".$rdv_pris."   >Rendez-vous pris</option>";
										echo"<option value='a_rappeler' ".$a_rappeler." >A rappeler      </option>";
										echo"<option value='termine'    ".$termine."    >Termin&eacute;  </option>";
									
									echo"</select>";
									echo "</td>";
									
									echo"<td align='center'>";
									echo"<input type=checkbox id='Lprint_".$data['id_motif']."_".$data['id_patient']."' name='Lprint_".$data['id_motif']."_".$data['id_patient']."'>";
									echo"</td>";
									
									echo"<td align='center'>";
									echo"<input type=checkbox id='Mprint_".$data['id_motif']."_".$data['id_patient']."' name='Mprint_".$data['id_motif']."_".$data['id_patient']."'>";
									echo"</td>";
									
									echo"</tr>";
									
									echo"<tr><td></td><td>";

							?>  
										
										<?echo"<table id='tab_patient_".$data['id_motif']."_".$data['id_patient']."' style='display:none'>";?>
										
										<!-- 
										<tr>
										<td><b>Nom</b></td>
										<td><i><?echo $patient['nom'];?></i></td>
										</tr>
										
										<tr>
										<td><b>Pr&eacute;nom</b></td>
										<td><i><?echo $patient['prenom'];?></i></td>
										</tr>
										-->
										<tr>
										<td><b>Date de naissance</b></td>
										<td><i><?echo substr($patient['date_naissance'], 8, 2).".".substr($patient['date_naissance'], 5, 2).".".substr($patient['date_naissance'], 0, 4);?></i></td>
										</tr>
										
										<tr>
										<td><b>Adresse</b></td>
										<td><i><?echo $patient['rue']."<br>".$patient['code_postal'].", ".$patient['commune'];?></i></td>
										</tr>
										
										<tr>
										<td><b>T&eacute;l&eacute;phone</b></td>
										<td><i><?echo $patient['telephone'];?></i></td>
										</tr>
										
										<tr>
										<td><b>GSM</b></td>
										<td><i><?echo $patient['gsm'];?></i></td>
										</tr>
										
										<tr>
										<td><b>E-mail</b></td>
										<td><i><?echo $patient['mail'];?></i></td>
										</tr>
										
										<?
										$r_titulaire   = "SELECT * FROM patients WHERE id = ".$patient['titulaire_id'];
										$res_titulaire = requete_SQL($r_titulaire);
										
										$titulaire = mysql_fetch_assoc($res_titulaire);
										?>
										
										<tr>
										<td><b>Titulaire</b></td>
										<td><i><?echo $titulaire['prenom']." ".$titulaire['nom'];?></i></td>
										</tr>
										
										</table>
										
										</td><td></td><td></td><td></td><td></td><td>
										
										<?echo"<table id='tab_motif_".$data['id_motif']."_".$data['id_patient']."' style='display:none' border='0'>";?>
										
										<!-- 
										<tr>
										<td><b>Motif</b></td>
										<td><i><?echo $motif['description'];?></i></td>
										</tr>
										-->
										
										<tr>
										<td><b>R&eacute;currence</b></td>
										<td><i><?echo $motif['recurrence'];?></i></td>
										</tr>
										
										<tr>
										<td><b>Texte de la lettre</b></td>
										<td><i><?echo $motif['texte_principal'];?></i></td>
										</tr>
										
										</table>
								
								</td><td></td><td></td><td></td></tr>
							
							<?	
								}
								echo "</table>";
						
							}?>
							</fieldset>

						 <center><input type="submit" value="Valider les changements"></center>

						</form>
						
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
	
						<a onclick="Element.toggle('addLabelFormMedecin'); Element.hide('addLabelFormPatient'); Element.hide('addLabelFormMutuelle');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
	                
						<h2>Informations</h2>
	                	
						<div id="addLabelFormMedecin" name="addLabelFormMedecin" class="inlineForm" style="display: none;">
							<form id="createLabelFormMedecin" onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMedecinInput" type="text" onFocus="this.select()" onKeyUp="javascript:medecin_recherche_simple(this.value)">
	                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
	                  		</form>
	                		<div id="information_medecin" class="allApplied">
							</div>
						</div>
	
					</div>
				
				<a class="taskControl" href="../patients/recherche_patient.php">Recherche patient</a>

				<div id="labels" class="sidebar labels-red">

					<a onclick="Element.toggle('addLabelFormPatient');Element.hide('addLabelFormMedecin');Element.hide('addLabelFormMutuelle');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                
					<h2>Informations</h2>
                	
					<div id="addLabelFormPatient" name="addLabelFormPatient" class="inlineForm">
						<form id="createLabelFormPatient" onsubmit="">
                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
                  		</form>        
                		<div id="information_patient" class="allApplied">
						</div>
					</div>

				</div>

				<a class="taskControl" href="../mutuelles/recherche_mutuelle.php">Recherche mutuelle</a>
			
				<div class="sidebar labels-green">

					<a onclick="Element.toggle('addLabelFormMutuelle'); Element.hide('addLabelFormPatient'); Element.hide('addLabelFormMedecin'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                
					<h2>Informations</h2>
                	
					<div id="addLabelFormMutuelle" name="addLabelFormMutuelle" class="inlineForm" style="display: none;">
						<form id="createLabelFormMutuelle" onsubmit="">
                  			<input autocomplete="off" class="text-input" id="findMutuelleInput" type="text" onFocus="this.select()" onKeyUp="javascript:mutuelle_recherche_simple(this.value)">
                  			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
                  		</form>
                		<div id="information_mutuelle" class="allApplied">
						</div>
					</div>

				</div>
		
				<div id="footer">
					<p>targoo@gmail.com bmangel@gmail.com</p>  
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
	
	<!-- EDITEUR JS -->
	<script type="text/javascript">
		var _editor_url = document.location.href.replace(/consulter_pile\.php.*/, '');
		var _editor_lang = "fr";
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
  	</script>
	
	<!-- ALL JS -->
	<script type="text/javascript" src='../js/common.js'></script>
	<script type="text/javascript" src='../js/patient.js'></script>
    <script type="text/javascript" src='../js/autosuggest.js'></script>
	<script type="text/javascript">
		areaedit_init();
		var valeurniss = '';
		var valeursis = '';
    	var oTextbox = new AutoSuggestControl(document.getElementById("localite"), new StateSuggestions());        
	</script>

	<!-- MODAL JS -->
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		$('nom').focus();
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
	</script>

	<!-- CONTROL JS -->
	<script	type="text/javascript" src="../js/control_rating/control_002.js"></script>
	<script>
		var rating_rendez_vous_info = new Control.Rating('rating_rendez_vous',{
			input: 'rating_rendez_vous_info',
			multiple: true
		});
		var rating_frequentation_info = new Control.Rating('rating_frequentation',{
			input: 'rating_frequentation_info',
			multiple: true
		});
		var rating_preference_info = new Control.Rating('rating_preference',{
			input: 'rating_preference_info',
			multiple: true
		});

	</script>    

</body>
</html>