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

	// get mutuelle code
	$mutuelleCode = isset($_SESSION['mutuelle_code']) ? $_SESSION['mutuelle_code'] : "all";
	$mutuelleCode = isset($_GET['mutuelle_code']) ? $_GET['mutuelle_code'] : $mutuelleCode;

	// get medecin_inami
	$medecinInami = isset($_SESSION['medecin_inami']) ? $_SESSION['medecin_inami'] : "all";
	$medecinInami = isset($_GET['medecin_inami']) ? $_GET['medecin_inami'] : $medecinInami;

	// get periode
	$periode = isset($_SESSION['periode']) ? $_SESSION['periode'] : "day";
	$periode = isset($_GET['periode']) ? $_GET['periode'] : $periode;
	 
	// mise en session
	$_SESSION['jour'] = $jour;
	$_SESSION['mois'] = $mois;
	$_SESSION['annee'] = $annee;
	$_SESSION['mutuelle_code'] = $mutuelleCode;
	$_SESSION['medecin_inami'] = $medecinInami;
	$_SESSION['periode'] = $periode;
	
	$listingTitle = "";
	$sqlglobal= "select td.id as tarification_detail_id, ta.cloture, DATE_FORMAT(ta.date, GET_FORMAT(DATE, 'EUR')) as tarification_date, ta.mutuelle_code as tarification_mutuelle_code, pa.nom as patient_nom, pa.prenom as patient_prenom, ta.patient_matricule as patient_matricule, concat(ta.ct1, '/' ,ta.ct2), ti.nom as titulaire_nom, ti.prenom as titulaire_prenom, ta.titulaire_matricule as titulaire_matricule, me.nom as medecin_nom, me.prenom as medecin_prenom, td.cecodi as cecodi, round((td.cout_mutuelle - td.cout),2) as cout from tarifications ta, tarifications_detail td, medecins me, patients pa, patients ti where ta.etat = 'close' and ta.medecin_inami = me.inami and ta.patient_id = pa.id and td.tarification_id = ta.id and pa.titulaire_id = ti.id";

	if ($mutuelleCode !='all') {
		$sql= "select nom FROM mutuelles WHERE code = '$mutuelleCode'";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$sqlglobal .= " and ta.mutuelle_code = ".$mutuelleCode;
		$listingTitle .= " ".$data['nom']." -";
	} else {
		$listingTitle .= " Toutes les mutuelles -";
	}

	if ($medecinInami !='all') {
		$sql= "select nom, prenom FROM medecins WHERE inami = '$medecinInami'";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		$sqlglobal .= " and ta.medecin_inami = ".$medecinInami;
		$listingTitle .= " ".$data['nom']." ".$data['prenom']." -";
	} else {
		$listingTitle .= " Tous les m&eacute;decins -";
	}

	switch($periode) {
		case 'day':
			$sqlglobal .= " and ta.cloture like '".$annee."-".$mois."-".$jour."%'";
			$sqlglobal .= " order by ta.cloture, td.id";
			$impression_url = "../factures/print_facture_mutuelle.php?id=day";
			$listingTitle .= " Journ&eacute;e";
		break;
		case 'first':
			$sqlglobal .= " and ta.cloture < '".$annee."-".$mois."-16'";
			$sqlglobal .= " and ta.cloture >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by ta.cloture, td.id";
			$impression_url = "../factures/print_facture_mutuelle.php?id=first";
			$listingTitle .= " Premi&egrave;re quinzaine";
		break;
		case 'second':
			$sqlglobal .= " and ta.cloture < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and ta.cloture >= '".$annee."-".$mois."-16'";
			$sqlglobal .= " order by ta.cloture, td.id";
			$impression_url = "../factures/print_facture_mutuelle.php?id=second";
			$listingTitle .= " Deuxi&egrave;me quinzaine";
		break;
		case 'month':
			$sqlglobal .= " and ta.cloture < '".$annee."-".$mois."-32'";
			$sqlglobal .= " and ta.cloture >= '".$annee."-".$mois."-01'";
			$sqlglobal .= " order by ta.cloture, td.id";
			$impression_url = "../factures/print_facture_mutuelle.php?id=month";
			$listingTitle .= " Mois";
		break;
		case 'all':
			$sqlglobal .= " order by ta.cloture, td.id";
			$impression_url = "../factures/print_facture_mutuelle.php?id=all";
			$listingTitle .= " ( complet )";
		break;
		default:
	}

	$i=0;
	
	$sql = "SELECT inami, nom, prenom FROM medecins where type='interne' order by nom, prenom";
	$result = requete_SQL ($sql);
	while($data = mysql_fetch_assoc($result)) 	{
		if (($i%10) == 0) { $tabMedecin[floor($i/10)] = ""; $tabMedecinName[floor($i/10)] = "M&eacute;decin ".substr($data['nom'],0,3); }
		$tabMedecin[floor($i/10)] .= "<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?medecin_inami=".$data['inami']."'>".$data['nom']." ".$data['prenom']."</a></li>";
		if (($i%10) == 9) { $tabMedecinName[floor($i/10)] .= "...".substr($data['nom'],0,3); }
		$i++;
	}

	$i=0;
	
	$sql = "SELECT code, nom FROM mutuelles order by code";
	$result = requete_SQL ($sql);
	while($data = mysql_fetch_assoc($result)) 	{
		if (($i%10) == 0) { $tabMutuelle[floor($i/10)] = ""; $tabMutuelleName[floor($i/10)] = "Mutuelle ".$data['code']; }
		$tabMutuelle[floor($i/10)] .= "<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?mutuelle_code=".$data['code']."'>".$data['code']." ".$data['nom']."</a></li>";
		if (($i%10) == 9) { $tabMutuelleName[floor($i/10)] .= "...".$data['code']; }
		$i++;
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
		echo "				<li class='yuimenuitem'>M&eacute;decins";
		echo "					<div id='medecinsupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		$i=0;
		foreach($tabMedecin AS $valeur){
			echo "							<li class='yuimenuitem'>".$tabMedecinName[$i];
			echo "							<div id='".$tabMedecinName[$i]."' class='yuimenu'>";
			echo "							<div class='bd'>";
			echo "							<ul class='first-of-type'>";
			echo $valeur;
			echo "							</ul>            ";
			echo "							</div>";
			echo "							</div>";
			echo "							</li>";
			$i++;
		} 
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?medecin_inami=all'>Tous les m&eacute;decins</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";
		echo "				<li class='yuimenuitem'>Mutuelles";
		echo "					<div id='mutuellesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		$i=0;
		foreach($tabMutuelle AS $valeur){
			echo "							<li class='yuimenuitem'>".$tabMutuelleName[$i];
			echo "							<div id='".$tabMutuelleName[$i]."' class='yuimenu'>";
			echo "							<div class='bd'>";
			echo "							<ul class='first-of-type'>";
			echo $valeur;
			echo "							</ul>            ";
			echo "							</div>";
			echo "							</div>";
			echo "							</li>";
			$i++;
		} 
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?mutuelle_code=all'>Toutes les mutuelles</a></li>";
		echo "							</ul>";
		echo "						</div>";
		echo "					</div>";
		echo "				</li>";
		echo "				<li class='yuimenuitem'>P&eacute;riode";
		echo "					<div id='periodesupp' class='yuimenu'>";
		echo "						<div class='bd'>";
		echo "							<ul class='first-of-type'>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?periode=day'>Journ&eacute;e</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?periode=first'>Premi&egrave;re quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?periode=second'>Deuxi&egrave;me quinzaine</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?periode=month'>Mois</a></li>";
		echo "                          	<li class='yuimenuitem'><a class='yuimenuitemlabel' href='listing_mutuelles.php?periode=all'>Complet</a></li>";
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
 			Facturation aux mutuelles : <?=$listingTitle?>
		</h1>

		<a class="impression" href="<?=$impression_url?>"></a>

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
   
    				<span>Facturation aux mutuelles</span> 
   
    				<!--a href="./listing_medecins.php">Facturation aux m&eacute;decins</a-->
						
    				<!--a href="./listing_journal_caisse.php">Journal de caisse</a-->

    				<!--a href="./listing_mutuelles_bis.php">Re-Facturation aux mutuelles</a-->

				</div>
					
				<div class="View">
					
					<div class="navigation-hight">

						<div class="navigation-calendar">

							<a class="previousMajor" href="./listing_mutuelles.php?action=previous_month" onclick="" title="Mois pr&eacute;c&eacute;dent"></a>
							<a class="previousMinor" href="./listing_mutuelles.php?action=previous_day" onclick="" title="Jour pr&eacute;c&eacute;dent"></a>
							<a class="nextMajor" href="./listing_mutuelles.php?action=next_month" onclick="" title="Mois suivant"></a>
							<a class="nextMinor" href="./listing_mutuelles.php?action=next_day" onclick="" title="Jour suivant"></a>
	  						<h2><? echo $jour." - ".$mois." - ".$annee ?></h2>

						</div>
							
					</div>
																	
					<span id="ex2_bookmark"></span>
						
					<table id="ex2" class="ricoLiveGrid" cellspacing="0" cellpadding="0">
						<colgroup>
							<col style='width:35px;' >
							<col style='width:75px;' >
							<col style='width:60px;' >
							<col style='width:60px;'>
							<col style='width:80px;' >
							<col style='width:60px;' >
							<col style='width:60px;' >
							<col style='width:60px;'>
							<col style='width:80px;'>
							<col style='width:60px;'>
							<col style='width:60px;'>
							<col style='width:60px;'>
							<col style='width:50px;'>
						</colgroup>
						<tr>
	 		 				<th>ID#</th>
	  						<th>Cl&ocirc;ture</th>
							<th>Prestation</th>
							<th>Mut.</th>
						 	<th>Pat. Nom</th>
							<th>Pr&eacute;nom</th>
							<th>Matricule</th>
							<th>CT1/CT2</th>
							<th>Tit. Nom</th>
							<th>Pr&eacute;nom</th>
							<th>Matricule</th>
							<th>M&eacute;decin</th>
							<th>Pr&eacute;nom</th>
							<th>Cecodi</th>
							<th>Co&ucirc;t</th>
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

