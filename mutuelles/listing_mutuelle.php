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
	
	// Vider la redirection
	unset($_SESSION['redirect']);
	
	// Nom du fichier en cours 
	$nom_fichier = "listing_mutuelle.php";
	
	$choix1 = "<input type=\'checkbox\' name=\'cases\' value=\'";
	$choix2 = "\' onclick=controle_choix(";
	$choix3 = ") id=\'check";
	$choix4 = "\' />";
	
	$modif1 = "<a href=\'./modif_mutuelle.php?code=";
	$modif2 = "\' ><img width=\'16\' height=\'16\' src=\'../images/modif_small.gif\' alt=\'Modifier\' title=\'Modifier\' border=\'0\' /></a>";

	$detail1 = "<a href=\'#\' onMouseDown=openMutuelleInfo(";
	$detail2 = ")><img width=16 height=16 src=../images/icon_clipboard.gif alt=Detail title=Detail border=0 /></a>";
	
	$sqlglobal= "select concat('$choix1',m.code,'$choix2',m.code,'$choix3',m.code,'$choix4'), concat('$modif1',m.code,'$modif2'),concat('$detail1',m.code,'$detail2'), m.code, m.nom,  concat(m.commune,' - ',m.rue), m.telephone, m.fax, m.mail, m.contact FROM mutuelles m order by code";
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Listing des mutuelles</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<? 
		require "applib.php";

		session_set_cookie_params(60*60);

		$_SESSION['ex20']=$sqlglobal;

		require "../rico/plugins/chklang.php";
		require "../rico/plugins/settings.php";
	?>

	<script src="../rico/src/rico.js" type="text/javascript"></script>
	<script type='text/javascript'>
		Rico.loadModule('LiveGridAjax');
		Rico.loadModule('LiveGridMenu');
		<?
			setStyle();
			setLang();
		?>
		var orderGrid,buffer;

		Rico.onLoad( function() {
			var opts = {  
				<? GridSettingsScript(); ?>,
    			columnSpecs   : [,,,,,{type:'date'},{type:'date'}]
  			};
  		buffer=new Rico.Buffer.AjaxSQL('ricoXMLquery.php', {TimeOut:<? print array_shift(session_get_cookie_params())/60 ?>});
  		orderGrid=new Rico.LiveGrid ('ex20', buffer, opts);
  		orderGrid.menu=new Rico.GridMenu(<? GridSettingsMenu(); ?>);
		});

	</script>
</head>

<body id='body'>

	<?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>Mutuelles - Listing des mutuelles</h1>

		<a class="impression" href="../factures/printmutuelle.php"></a>

		<div id="etiquette">
		</div>

	</div>
    
		<div id="middle">
    	
				<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Mutuelles</a>
				</li>
        	</ul>
		</div>      
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">

					<a href="./recherche_mutuelle.php">Recherche</a>
   
					<a href="./add_mutuelle.php">Ajout</a>
    					
	  				<span>Listing</span> 
												
				</div>
					
				<div class="listViewPane">

					<div class="navigation-hight">

						<div id='formhelp'>
							Liste de toutes les mutuelles encod&eacute;es dans l'application.<br />
						</div>
					
					</div>
						
					<div id="secondmain" >
					
					<span id="ex20_bookmark"></span>
							
						<table id="ex20" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
							<colgroup>
								<col style='width:20px;' >
								<col style='width:20px;' >
								<col style='width:20px;' >
								<col style='width:35px;' >
								<col style='width:80px;' >
								<col style='width:100px;' >
								<col style='width:60px;' >
								<col style='width:60px;' >
								<col style='width:60px;' >
								<col style='width:60px;' >
							</colgroup>
							<tr>
		  						<th></th>
		  						<th></th>
		  						<th></th>
		  						<th>Code</th>
								<th>Nom</th>
								<th>Adresse</th>
		  						<th>T&eacute;l&eacute;phone</th>
		  						<th>Fax</th>
		  						<th>Mail</th>
		  						<th>Contact</th>
	  						</tr>
						</table>
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

						<a onclick="Element.toggle('findMedecinForm'); Element.hide('findPatientForm');Element.hide('findMutuelleForm');try{$('findMedecinInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
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

						<a onclick="Element.toggle('findPatientForm'); Element.hide('findMutuelleForm');Element.hide('findMedecinForm');try{$('findPatientInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findPatientForm" class="inlineForm" style="display: none;">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findPatientInput" type="text" onFocus="this.select()" onKeyUp="javascript:patient_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>        
                			<div id="informationPatient">
							</div>
						</div>

					</div>
					
					<a class="taskControl" href="../mutuelles/recherche_mutuelle.php">Recherche mutuelle</a>
				
					<div class="sidebar labels-red">

						<a onclick="Element.toggle('findMutuelleForm'); Element.hide('findMedecinForm'); Element.hide('findPatientForm'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<div id="findMutuelleForm" class="inlineForm">
							<form onsubmit="">
	                  			<input autocomplete="off" class="text-input" id="findMutuelleInput" type="text" onFocus="this.select()" onKeyUp="javascript:mutuelle_recherche_simple(this.value)">
    	              			<input class="button" name="commit" value="" type="submit">
        	          		</form>
                			<div id="informationMutuelle">
							</div>
						</div>

					</div>
					
					<a class="taskControl" href="#">Etiquettes</a>
					
					<div id="labels" class="sidebar labels-red">

						<a onclick="Element.toggle('addLabelFormEtiquette'); Element.hide('addLabelFormMutuelle'); Element.hide('addLabelFormPatient'); Element.hide('addLabelFormMedecin'); try{$('findMutuelleInput').focus()} catch(e){}; return false;" href="#" class="controls" style="display: block;">Recherche...</a>
                	
						<h2>Impresion</h2>
	                	
						<div id="addLabelFormEtiquette" name="addLabelFormEtiquette" class="inlineForm">
							<form id="etiquetteForm" onsubmit="">
							<select name='etiquetteselect' id='etiquetteselect' onchange='javascript:etiquettePrint(this.value);'>
									<option value=''>Nombre d'impression...</option>
									<option value='1'>1 &eacute;tiquette</option>
									<option value='2'>2 &eacute;tiquettes</option>
									<option value='3'>3 &eacute;tiquettes</option>
									<option value='4'>4 &eacute;tiquettes</option>
									<option value='5'>5 &eacute;tiquettes</option>
									<option value='3'>6 &eacute;tiquettes</option>
									<option value='10'>10 &eacute;tiquettes</option>
									<option value='15'>15 &eacute;tiquettes</option>
								</select>
	       	          			<input class="button defaultAction" id="submitLabelCreate" name="commit" value="" type="submit">
        	          		</form>        
						</div>

					</div>
			
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/liste.png'>
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
	
	<!-- ALL JS -->
	<script type="text/javascript" src='../js/mutuelle.js'></script>
	<script type="text/javascript" src='../js/common.js'></script>
    <script type="text/javascript" src="../js/functions.js"></script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">
		var compteur = 0;
		var help = new Window( {className: "alphacube", title: "Aide en ligne", destroyOnClose:false, top:0, right:0, width:500, height:300});  
  		var notice = new Window( {className: "alphacube", title: "Notice", destroyOnClose:false, top:20, right:20, width:500, height:300 });  
  		var information = new Window({className: "alphacube", title: "Information sur le patient", top:20, right:20, width:500, height:300 });  
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
	  		Dialog.alert({url: "../patients/modif_patient_mutuelle.php?id="+id, options: {method: 'get'}}, {className: "alphacube", width: 700, height:350, okLabel: "Fermer", ok:function(win) {patient_recherche_list(id);return true;}});
  		}
		function openMutuelleInfo(id) {
			var url = "../mutuelles/mutuelle_detail.php?id="+id;
			switch ( compteur )	{
			case 0:
				compteur = (compteur+1)%4;
				win0 = new Window({className: "alphacube", title: "Information Mutuelle", top:0, right:0, width:540, height:400 });  
				win0.setURL(url)
				win0.show();
			break;
			case 1:
				compteur = (compteur+1)%4;
				win1 = new Window({className: "alphacube", title: "Information Mutuelle", top:20, right:20, width:540, height:400 });  
				win1.setURL(url)
				win1.show();
			break;
			case 2:
				compteur = (compteur+1)%4;
				win2 = new Window({className: "alphacube", title: "Information Mutuelle", top:40, right:40, width:540, height:400 });  
				win2.setURL(url)
				win2.show();
			break;
			default :
				compteur = (compteur+1)%4;
				wind = new Window({className: "alphacube", title: "Information Mutuelle", top:60, right:60, width:540, height:400 });  
				wind.setURL(url)
				wind.show();
			}
		}
		function openDialogConfirmDelMutuelle(id) {
			new Ajax.Request('../mutuelles/mutuelle_action.php',
				{
					method:'get',
					parameters: {type : 'info_mutuelle', id : id},
					asynchronous:false,
					requestHeaders: {Accept: 'application/json'},
			  		onSuccess: function(transport, json){
			  			var comment = json.root.info_mutuelle;
			  			Dialog.confirm("Etes-vous certain de vouloir <b>supprimer</b> la mutuelle suivante : <br><br>"+comment, {width:300, top:50, okLabel: "OUI", cancelLabel: "Annuler", className: "alphacube", buttonClass: "myButtonClass", id: "myDialogId", cancel:function(win) {return false;}, ok:function(win) {mutuelleAction('del_mutuelle',id,'',''); return true;} });
		    	    },
				    onFailure:  function(){ alert('failure');} 
				});
		}
	</script>
	

</body>
</html>