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
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
		
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "modif_caisse.php";
	$login = $_SESSION['login'];
	$role = $_SESSION['role'];
	
	$_SESSION['caisse_date'] = date("Y-m-d");
	$_SESSION['caisse_login'] = $_SESSION['login'];
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - D&eacute;tail de la caisse</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<script type="text/javascript" src="../js/submit_validatorv.js"> </script>
</head>

<body id='body'>

   	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>
 			Caisse - Gestion de la caisse		
		</h1>
    
	</div>
	
	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('caisses')?>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
					
    				<span>Caisse</span> 
								
				</div>
						
				<div class="ViewPane">

					<div class="navigation-hight">

						<fieldset>
							<legend>Aide</legend>
							Cette interface permet de visualiser le d&eacute;tail de la caisse par jour<br />
						</fieldset>

						<div id='BoxTitlePatient' onclick="javascript:Element.toggle('BoxContentPatient');changeClassBox('patientImageLeft','closeBox','openBox')">
						</div>

						<div id='BoxContentPatient' style='display: none;'>
							<table border="1" cellspacing="0" cellpadding="0">
								<tr>
									<th class='formLabel'>Caisse</th>
									<td colspan='2' class='formInput'>
										<select id='caisse_input' name='caisse_input' title='Caisse' width="267px" style="width: 267px" onChange="javascript:submitForm('','',this.value)">
											<option value=''>Choisir</option>
											<?php
												connexion_DB('poly');
												if ($_SESSION['role'] == 'Administrateur') {
													$sql = "SELECT nom, prenom, login FROM users";
												} else {
													$sql = "SELECT nom, prenom, login FROM users where login = $login";
												}
												$result = mysql_query($sql);
													while($data = mysql_fetch_assoc($result)) 	{
														echo "<option value='";
														echo $data['login'];
														echo "' ";
														if ($formCaisseLogin == $data['login']) echo "selected";
														echo ">";
														echo $data['nom'];
														echo " ";
														echo $data['prenom'];
														echo "</option>";
													}
												deconnexion_DB();
											?>
										</select>
									</td>
								</tr>
							</table>	
						</div>

						<div id='BoxTitleMedecin' onclick="javascript:Element.toggle('BoxContentMedecin');changeClassBox('medecinImageLeft','closeBox','openBox')">
						</div>

						<div id='BoxContentMedecin' style='display: none;'>
							<table border="1" cellspacing="0" cellpadding="0">
								<tr>
									<!-- td><input type='text' name='date' id='date' size='32' class='txtField' title='Date de la caisse' autocomplete='off' maxlength='12' onkeyup="javascript:dateFirstExecutionresult = checkDate(this, '', '');" /></td-->
									<td><div id="cal1Container" style='float:left;' >
										</div>
									</td>
								</tr>
							</table>
							
							
						</div>
						
							
					</div>
					
					<div id='BoxAddCecodi' class="cecodi">

						<form action="" name="myform" >
							
							<table border="1" cellspacing="0" cellpadding="0">

								<tr>
									<th class='formLabel'><label for='nom'>Transaction <br /></label></th>
									<td colspan='2' class='formInput'>
										<select id='transaction_id' name='transaction_id' title='Type de transaction' width="267px" style="width: 267px" onChange="javascript:caisseAction('change_transaction',this.value)">
											<option value=''>Choisir...</option>
											<?php
												connexion_DB('poly');
												if ($_SESSION['role'] == 'Administrateur') {
													echo "<option value='0'>Initialisation</option>";
												}
												$sql = "SELECT id, description FROM caisse_code where interne!='checked'";
												$result = requete_SQL ($sql);
												while($data = mysql_fetch_assoc($result)) 	{
   	 												echo "<option value='".$data['id']."'>";
													echo $data['description'];
													echo "</option>";
												}	
												deconnexion_DB();
											?>
										</select>
									</td>
								</tr>
								<tr>
									<th class='formLabel'>Montant</th>
									<td colspan='2' class='formInput'>
										<input type='text' name='transaction_valeur' id='transaction_valeur' size='32' maxlength='10' class='txtField' title='Cecodi' autocomplete='off' onKeyUp='javascript:cout_tarification = checkAmount(this, cout_tarification, 10, 2, false);' />
									</td>
								</tr>
								<tr>
									<th class='formLabel'>Commentaire</th>
									<td colspan='2' class='formInput'>
										<input type='text' name='comment' id='comment' size='32' class='txtField' title='Commentaire' autocomplete='off' maxlength='100' />
									</td>
								</tr>
								<tr>
									<th class='formLabel'><label for='nom'>Mode <br /></label></th>
									<td colspan='2' class='formInput'>
										<select id='mode' name='mode' title='Type de transaction' width="267px" style="width: 267px" onChange="javascript:if ($('mode').value == 'virement') {Element.show('compte_label');} else {Element.hide('compte_label');$('compte').value=''}">
										</select>
									</td>
								</tr>
								<tr id="compte_label" style="display:none">
									<th class='formLabel'>Compte</th>
									<td colspan='2' class='formInput'>
										<input type='text' name='compte' id='compte' size='32' class='txtField' title='Compte bancaire' autocomplete='off' maxlength='100' onKeyUp='javascript:compte = checkAccountNumber(this, compte, false);' />
									</td>
								</tr>
								<tr>
									<th class='formLabel'><label for='validation'><br /></label></th>
									<td colspan='2' class='formInput'>
										<input type="submit" class="button" value="Valider" />
									</td>
								</tr>
							</table>
								
						</form>
						<script language="JavaScript" type="text/javascript">
						var frmvalidator  = new Validator("myform");
						</script>
					
					</div>

					<div id="BoxListCecodi">
					</div>
						
					<div id="BoxCaisse" class="caisse">
						<table border='1' cellspacing='0' cellpadding='0'>
							<tr>
								<td class='big' id='montant_ouverture'></td>
								<td class='big' id='montant_fermeture'></td>
								<td class='big' id='banksys_fermeture'></td>
							</tr>
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
	
	<div id="paiement_confirm" style="display:none">  
	    <p>
			Faites votre choix dans cette liste : 
	   	</p>
		<form id='liste' name='liste'>
			
		</form>
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
	
	
	<!-- CALENDAR JS -->
	<script type="text/javascript" src="../yui/build/calendar/calendar-min.js"></script>	
	<script>
	function init() {
		var mySelectHandler = function(type,args,obj) {
			var selected = args[0];
			var dateselected = "" + selected[0];
			dateselected = dateselected.replace(",","-");
			dateselected = dateselected.replace(",","-");
			submitForm('',dateselected,'');
		};
		YAHOO.namespace("calendar");
		YAHOO.calendar.init = function() {
			YAHOO.calendar.cal1 = new YAHOO.widget.CalendarGroup("cal1","cal1Container", { pagedate: "1/2008", mindate: "1/1/1970",  maxdate: "<?=date('m/d/Y')?>" }, {PAGES:2});
			YAHOO.calendar.cal1.cfg.setProperty("pagedate", <?=(date(m)-1)?> + "/" + <?=(date(Y))?>); 	
			YAHOO.calendar.cal1.selectEvent.subscribe(mySelectHandler, YAHOO.calendar.cal1, true);
			YAHOO.calendar.cal1.render();
		}
		YAHOO.util.Event.onDOMReady(YAHOO.calendar.init);
	}
	init(); 
	</script>
   
   	<!-- ALL JS -->	
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src='../js/caisse.js'></script>
	
   	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var cout_tarification='';
		var compte='';
		submitForm('','','');
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
	  	function openDialogConfirm(id,comment) {
  			Dialog.confirm("Vouler vous supprimer ce rendez-vous ?<br> ["+comment+"]", {width:300, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {supprime(id); return true;} });
		}
		function tarificationPayer(html,id) {
	  		Dialog.confirm($('paiement_confirm').innerHTML, {className:"alphacube", top:50, width:400, okLabel: "OK", cancelLabel: "Annuler",  buttonClass: "myButtonClass", onOk:function(win){tarificationPayerConfirm(id);return true;}});
  		}
	</script>
   
</body>
</html>