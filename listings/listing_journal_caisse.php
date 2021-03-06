<?php 

	// Demarre une session
	session_start();
	
	die();
	
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
	$nom_fichier = "listing_mutuelles.php";

	include_once '../lib/fonctions.php';
	
	connexion_DB('poly');
	
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

	// get caisse
	$caisse = isset($_SESSION['caisse']) ? $_SESSION['caisse'] : 'all';
	$caisse = isset($_GET['caisse']) ? $_GET['caisse'] : $caisse;

	// get code
	$code = isset($_SESSION['code']) ? $_SESSION['code'] : 'all';
	$code = isset($_GET['code']) ? $_GET['code'] : $code;
	
	// get periode
	$periode = isset($_SESSION['periode']) ? $_SESSION['periode'] : "day";
	$periode = isset($_GET['periode']) ? $_GET['periode'] : $periode;
	 
	// mise en session
	$_SESSION['jour'] = $jour;
	$_SESSION['mois'] = $mois;
	$_SESSION['annee'] = $annee;
	$_SESSION['caisse'] = $caisse;
	$_SESSION['code'] = $code;
	$_SESSION['periode'] = $periode;
	
	$listingTitle = "";
	$sqlglobal = "SELECT DATE_FORMAT(date, GET_FORMAT(DATE, 'EUR')), heure, caisse, code,  montant , mode, description  FROM caisses_transaction WHERE code!=5000";
	
	if ($caisse !='all') {
		$sql= "select nom, prenom FROM users WHERE login = '$caisse'";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$sqlglobal .= " and caisse = '".$caisse."'";
		$listingTitle .= " ".$data['nom']." ".$data['prenom']." -";
	} else {
		$listingTitle .= " Toutes les caisses -";
	}

	if ($code !='all') {
		$sql= "select code, description FROM caisse_code WHERE id = '$code'";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$sqlglobal .= " and code = ".$code;
		$listingTitle .= " ".$data['code']." ".htmlentities($data['description'])." -";
	} else {
		$listingTitle .= " Tous les codes -";
	}
	
	switch($periode) {
		case 'day':
			$sqlglobal .= " and date like '".$annee."-".$mois."-".$jour."%'";
			$sqlglobal .= " order by date";
			$impression_url = "../factures/print_facture_journal_caisse.php?id=day";
			$listingTitle .= " Journ&eacute;e";
		break;
		case 'first':
			$sqlglobal .= " and date < '".$annee."-".$mois."-16'";
			$sqlglobal .= " and date >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by date";
			$impression_url = "../factures/print_facture_journal_caisse.php?id=first";
			$listingTitle .= " Premi&egrave;re quinzaine";
		break;
		case 'second':
			$sqlglobal .= " and date < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and date >= '".$annee."-".$mois."-16'";
			$sqlglobal .= " order by date";
			$impression_url = "../factures/print_facture_journal_caisse.php?id=second";
			$listingTitle .= " Deuxi&egrave;me quinzaine";
		break;
		case 'month':
			$sqlglobal .= " and date < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and date >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by date";
			$impression_url = "../factures/print_facture_journal_caisse.php?id=month";
			$listingTitle .= " Mois";
		break;
		case 'all':
			$sqlglobal .= " order by date";
			$impression_url = "../factures/print_facture_journal_caisse.php?id=all";
			$listingTitle .= " Complet";
		break;
		default:
	}

	deconnexion_DB();
	
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
	
		echo "				<li class='yuimenuitem'>Caisses";
		echo "					<div id='caissesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		connexion_DB('poly');
		$sql = "SELECT login, nom, prenom FROM users order by nom, prenom";
		$result = mysql_query($sql);
		while($data = mysql_fetch_assoc($result)) 	{
			echo "							<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?caisse=".$data['login']."'>";
			echo $data['login']." - ".htmlentities($data['nom'])." ".htmlentities($data['prenom']);
			echo "							</a></li>";
		}
		deconnexion_DB();
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?caisse=all'>Toutes les caisses</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";

		echo "				<li class='yuimenuitem'>Codes";
		echo "					<div id='codesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		connexion_DB('poly');
		$sql = "SELECT code, description FROM caisse_code order by code";
		$result = mysql_query($sql);
		while($data = mysql_fetch_assoc($result)) 	{
			echo "							<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?code=".$data['code']."'>";
			echo $data['code']." - ".htmlentities($data['description']);
			echo "							</a></li>";
		}
		deconnexion_DB();
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?code=all'>Tous les codes</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";
		
		echo "				<li class='yuimenuitem'>P&eacute;riode";
		echo "					<div id='periodesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?periode=day'>Journ&eacute;e</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?periode=first'>Premi&egrave;re quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?periode=second'>Deuxi&egrave;me quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?periode=month'>Mois</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_journal_caisse.php?periode=all'>Complet</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";
		echo "			</ul>";
		echo "		</div>";
		echo "	</div>";
		echo "</li>";
		get_MENUBAR_END();
	?>
	
    <div id="top">
		
		<h1>
 			Journal de caisse : <?=$listingTitle?>
		</h1>

		<a class="impression" href="<?=$impression_url?>&mode=portrait"></a>
		<a class='impressionlarge' href="<?=$impression_url?>&mode=landscape"></a>

	</div>
    
	<div id="middleleft">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('listings')?>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div class="secondary_tabs">
   
    				<a href="./listing_mutuelles.php">Facturation aux mutuelles</a>
   
    				<a href="./listing_medecins.php">Facturation aux m&eacute;decins</a>
						
    				<span>Journal de caisse</span> 

    				<!--a href="./listing_mutuelles_bis.php">Re-Facturation aux mutuelles</a-->

				</div>
					
				<div class="View">
					
					<div class="navigation-hight">

						<div class="navigation-calendar">

							<a class="previousMajor" href="./listing_journal_caisse.php?action=previous_month" onclick="" title="Mois pr&eacute;c&eacute;dent"></a>
							<a class="previousMinor" href="./listing_journal_caisse.php?action=previous_day" onclick="" title="Jour pr&eacute;c&eacute;dent"></a>
							<a class="nextMajor" href="./listing_journal_caisse.php?action=next_month" onclick="" title="Mois suivant"></a>
							<a class="nextMinor" href="./listing_journal_caisse.php?action=next_day" onclick="" title="Jour suivant"></a>
	  						<h2><? echo $jour." - ".$mois." - ".$annee ?></h2>

						</div>
							
					</div>
																	
					<span id="ex2_bookmark"></span>
						
					<table id="ex2" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
								<colgroup>
								<col style='width:80px;' >
								<col style='width:80px;' >
								<col style='width:80px;' >
								<col style='width:80px;' >
								<col style='width:80px;' >
								<col style='width:80px;' >
								<col style='width:140px;' >
								</colgroup>
					  <tr>
					  
						  <th>Date#</th>
						  <th>Heure</th>
						  <th>Caisse</th>
						  <th>Code</th>
						  <th>Montant</th>
						  <th>Mode</th>
						  <th>Description</th>
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
		var valeurcouttp = '';
		var valeurcoutvp = '';
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