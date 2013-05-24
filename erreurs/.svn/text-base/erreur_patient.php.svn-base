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
	
	// Nom du fichier en cours 
	$nom_fichier = "erreur_patient.php";

	include_once '../lib/fonctions.php';

	// DATE
	$jour = (isset($_SESSION['jour']) && $_SESSION['jour']!='') ? $_SESSION['jour'] : date("d");
	$mois = (isset($_SESSION['mois']) && $_SESSION['mois']!='') ? $_SESSION['mois'] : date("m");
	$annee = (isset($_SESSION['annee']) && $_SESSION['annee']!='') ? $_SESSION['annee'] : date("Y");

	if (isset($_GET['action'])) {
		$day = mktime();
		switch($_GET['action']) {
			case 'next_day':
				$day  = mktime(0, 0, 0, $mois , $jour+1, $annee);
			break;
			case 'previous_day':
				$day  = mktime(0, 0, 0, $mois , $jour-1, $annee);
			break;
			case 'next_month':
				$day  = mktime(0, 0, 0, $mois+1 , $jour, $annee);
			break;
			case 'previous_month':
				$day  = mktime(0, 0, 0, $mois-1 , $jour, $annee);
			break;
			default:
		}
		$jour = date ("d", $day);
		$mois = date ("m", $day);
		$annee = date ("Y", $day);
	 }

	// get periode
	$periode = isset($_SESSION['periode']) ? $_SESSION['periode'] : "day";
	$periode = isset($_GET['periode']) ? $_GET['periode'] : $periode;
	 
	// mise en session
	$_SESSION['jour'] = $jour;
	$_SESSION['mois'] = $mois;
	$_SESSION['annee'] = $annee;
	$_SESSION['periode'] = $periode;
	
	$listingTitle = "";

	$sqlglobal= "select ta.id as id, DATE_FORMAT(ta.date, GET_FORMAT(DATE, 'EUR')) as tarification_date, pa.nom as patient_nom, pa.prenom as patient_prenom, me.nom as medecin_nom, me.prenom as medecin_prenom, ROUND( -1 * ( ta.a_payer - ta.paye ) , 2 ) as a_payer  FROM patients pa, medecins me, tarifications ta WHERE a_payer <0 AND ta.medecin_inami = me.inami and ta.patient_id = pa.id";
	
	switch($periode) {
		case 'day':
			$sqlglobal .= " and ta.date like '".$annee."-".$mois."-".$jour."%'";
			$sqlglobal .= " order by ta.date";
			$impression_url = "../factures/print_erreur_patient.php?id=day";
			$listingTitle .= " Journ&eacute;e";
		break;
		case 'first':
			$sqlglobal .= " and ta.date < '".$annee."-".$mois."-16'";
			$sqlglobal .= " and ta.date >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by ta.date";
			$impression_url = "../factures/print_erreur_patient.php?id=first";
			$listingTitle .= " Premi&egrave;re quinzaine";
		break;
		case 'second':
			$sqlglobal .= " and ta.date < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and ta.date >= '".$annee."-".$mois."-16'";
			$sqlglobal .= " order by ta.date";
			$impression_url = "../factures/print_erreur_patient.php?id=second";
			$listingTitle .= " Deuxi&egrave;me quinzaine";
		break;
		case 'month':
			$sqlglobal .= " and ta.date < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and ta.date >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by ta.date";
			$impression_url = "../factures/print_erreur_patient.php?id=month";
			$listingTitle .= " Mois";
		break;
		case 'all':
			$sqlglobal .= " order by ta.date";
			$impression_url = "../factures/print_erreur_patient.php?id=all";
			$listingTitle .= " ( complet )";
		break;
		default:
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<? 
		require "applib.php";

		session_set_cookie_params(60*60);

		$_SESSION['ex2']=$sqlglobal;

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
  		orderGrid=new Rico.LiveGrid ('ex2', buffer, opts);
  		orderGrid.menu=new Rico.GridMenu(<? GridSettingsMenu(); ?>);
		});

	</script>
</head>

<body id='body'>
		
   <?php
		get_MENUBAR_START();
		echo "<li class='yuimenubaritem'>Listing";
		echo "	<div id='listing' class='yuimenu'>";
		echo "		<div class='bd'>";
		echo "			<ul>";
		echo "				<li class='yuimenuitem'>P&eacute;riode";
		echo "					<div id='periodesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='erreur_patient.php?periode=day'>Journ&eacute;e</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='erreur_patient.php?periode=first'>Premi&egrave;re quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='erreur_patient.php?periode=second'>Deuxi&egrave;me quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='erreur_patient.php?periode=month'>Mois</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='erreur_patient.php?periode=all'>Complet</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";
		echo "			</ul>";
		echo "		</div>";
		echo "	</div>";
		echo "</li>";
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		
		<h1>
 			Erreurs dues aux patients : <?=$listingTitle?>
		</h1>

		<a class="impression" href="<?=$impression_url?>"></a>

	</div>
    
	<div id="middleleft">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
				<li class='nodelete current'>
					<a class='nodelete' href='#'>Erreurs</a>
				</li>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">

    				<a href="./erreur_medecin.php">Erreurs des m&eacute;decins</a>
   
    				<span>Erreurs des patients</span> 
						
    				<a href="./erreur_caisse.php">Erreurs d'encodage</a>
   
    				<a href="./erreur_poly.php">Cadeaux de la polyclinique</a>

    				<a href="./erreur_commune.php">Perte de ticket mod&eacute;rateur</a>
    				
				</div>
					
				<div class="View">
					
					<div class="navigation-hight">

						<div class="navigation-calendar">

							<a class="previousMajor" href="./erreur_patient.php?action=previous_month" onclick="" title="Mois pr&eacute;c&eacute;dent"></a>
							<a class="previousMinor" href="./erreur_patient.php?action=previous_day" onclick="" title="Jour pr&eacute;c&eacute;dent"></a>
							<a class="nextMajor" href="./erreur_patient.php?action=next_month" onclick="" title="Mois suivant"></a>
							<a class="nextMinor" href="./erreur_patient.php?action=next_day" onclick="" title="Jour suivant"></a>
	  						<h2><? echo $jour." - ".$mois." - ".$annee ?></h2>

						</div>
							
					</div>
																	
					<span id="ex2_bookmark"></span>
						
					<table id="ex2" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
							<colgroup>
								<col style='width:120px;'>
								<col style='width:120px;'>
								<col style='width:120px;'>
								<col style='width:120px;'>
								<col style='width:120px;'>
								<col style='width:120px;'>
								<col style='width:120px;'>
							</colgroup>
							<tr>
								<th>ID</th>
								<th>Date</th>
								<th>Patient</th>
								<th>Pr&eacute;nom</th>
								<th>M&eacute;decin</th>
								<th>Pr&eacute;nom</th>
								<th>Montant</th>
							</tr>
					</table>
									
				</div>
					
			</div>
				
		</div>

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
	</script>
    
</body>
</html>

