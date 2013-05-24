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

	include_once '../lib/fonctions.php';

	// DATE
	if (isset($_SESSION['jour'])) {
		$Jour = $_SESSION['jour'];
	} else {
		$_SESSION['jour'] = date("d");
	}
	
	if (isset($_SESSION['mois'])) {
		$Mois = $_SESSION['mois'];
	} else {
		$_SESSION['mois'] = date("m");
	}
	
	if (isset($_SESSION['annee'])) {
		$Annee = $_SESSION['annee'];
	} else {
		$_SESSION['annee'] = date("Y");
	}
			
	if (isset($_GET['action'])) {
		
		$day = mktime();
		
		if ($_GET['action']== 'next_day') {
			//add on day to the day in session	
			$day  = mktime(0, 0, 0, $Mois , $Jour+1, $Annee);
		}
		if ($_GET['action']== 'previous_day') {
			//remove on day to the day in session
			$day  = mktime(0, 0, 0, $Mois , $Jour-1, $Annee);
		}
	
		if ($_GET['action']== 'next_month') {
			//add on day to the day in session
			$day  = mktime(0, 0, 0, $Mois+1 , $Jour, $Annee);
		}
		if ($_GET['action']== 'previous_month') {
			//remove on day to the day in session	
			$day  = mktime(0, 0, 0, $Mois-1 , $Jour, $Annee);
		}
	
		$_SESSION['jour'] = date ("d", $day);
		$_SESSION['mois'] = date ("m", $day);
		$_SESSION['annee'] = date ("Y", $day);
	
	 }
	 
	$Jour = $_SESSION['jour'];
	$Mois = $_SESSION['mois'];
	$Annee = $_SESSION['annee'];
	
	// get mutuelle code
	if (isset($_GET['mutuelle_code'])) {
		$MutuelleCode =  $_GET['mutuelle_code'];
		$_SESSION['mutuelle_code'] = $MutuelleCode;
	} else {
		if (isset($_SESSION['mutuelle_code'])) {
			$MutuelleCode =  $_SESSION['mutuelle_code'];
		} else {
			$MutuelleCode =  "all";
			$_SESSION['mutuelle_code'] =  "all";
		}
	}

	// get medecin_inami
	if (isset($_GET['medecin_inami'])) {
		$MedecinInami = $_GET['medecin_inami'];
		$_SESSION['medecin_inami'] = $MedecinInami;
	} else {
		if (isset($_SESSION['medecin_inami'])) {
			$MedecinInami =  $_SESSION['medecin_inami'];
		} else {
			$MedecinInami =  "all";
			$_SESSION['medecin_inami'] =  "all";
		}
	}

	// get periode
	if (isset($_GET['periode'])) {
		$Periode = $_GET['periode'];
		$_SESSION['periode'] = $Periode;
	} else {
		if (isset($_SESSION['periode'])) {
			$Periode =  $_SESSION['periode'];
		} else {
			$Periode =  "day";
			$_SESSION['periode'] =  $Periode;
		}
	}
	
	$sqlglobal= "select td.id as tarification_detail_id, ta.cloture, DATE_FORMAT(ta.date, GET_FORMAT(DATE, 'EUR')) as tarification_date, ta.mutuelle_code as tarification_mutuelle_code, pa.nom as patient_nom, pa.prenom as patient_prenom, ta.patient_matricule as patient_matricule, concat(ta.ct1, '/' ,ta.ct2), ti.nom as titulaire_nom, ti.prenom as titulaire_prenom, ta.titulaire_matricule as titulaire_matricule, me.nom as medecin_nom, me.prenom as medecin_prenom, td.cecodi as cecodi, round((td.cout_mutuelle - td.cout),2) as cout from tarifications ta, retarifications_detail td, medecins me, patients pa, patients ti where ta.utilisation = 'retarification' and ta.medecin_inami = me.inami and ta.patient_id = pa.id and td.tarification_id = ta.id and pa.titulaire_id = ti.id";

	if ($MutuelleCode !='all') {
		$sqlglobal .= " and ta.mutuelle_code = ".$MutuelleCode;
	}

	if ($MedecinInami !='all') {
		$sqlglobal .= " and ta.medecin_inami = ".$MedecinInami;
	}
	
	if ($Periode =='day') {
		$sqlglobal .= " and ta.cloture like '".$Annee."-".$Mois."-".$Jour."%'";
		$sqlglobal .= " order by ta.cloture, td.id";
		$impression_url = "../factures/print_facture_mutuelle_bis.php?id=day";
	}
	
	if ($Periode =='first') {
		$sqlglobal .= " and ta.cloture < '".$Annee."-".$Mois."-16'";
		$sqlglobal .= " and ta.cloture >= '".$Annee."-".$Mois."-01'";
		$sqlglobal .= " order by ta.cloture, td.id";
		$impression_url = "../factures/print_facture_mutuelle_bis.php?id=first";
	}

	if ($Periode =='second') {
		$sqlglobal .= " and ta.cloture < '".$Annee."-".$Mois."-32'";
		$sqlglobal .= " and ta.cloture >= '".$Annee."-".$Mois."-16'";
		$sqlglobal .= " order by ta.cloture, td.id";
		$impression_url = "../factures/print_facture_mutuelle_bis.php?id=second";
	}

	if ($Periode =='month') {
		$sqlglobal .= " and ta.cloture < '".$Annee."-".$Mois."-32'";
		$sqlglobal .= " and ta.cloture >= '".$Annee."-".$Mois."-01'";
		$sqlglobal .= " order by ta.cloture, td.id";
		$impression_url = "../factures/print_facture_mutuelle_bis.php?id=month";
	}

	if ($Periode =='all') {
		$sqlglobal .= " order by ta.cloture, td.id";
		$impression_url = "../factures/print_facture_mutuelle_bis.php?id=all";
	}

	//echo $sqlglobal;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

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

	<!-- DropDown javascript -->
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src="../js/agenda.js"></script>
	<script type="text/javascript" src="../js/listing.js"></script>

	<link href="../style/basic.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/tabs.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
	<link href="../style/calendar.css" media="all" rel="Stylesheet" type="text/css">

</head>

<body>

	<div id="ribbon">
  		<p>
			<a href="../../login/index.php">Logout</a> - 
			<a href="../menu/menu.php">Menu</a>
			<a>
			<?php
				echo get_INFOS(); 	
			?>
			</a>
		</p>
	</div>
	
    <div id="topcalendrier">
		
		<h1>
		Listings
		</h1>
		
		<div id="listspecialite">
			<select id='specialite' name='specialite' onchange='javascript:listings_mutuelle_bis_mutuelle(this.value);'>
				<option value='all'>Toutes les mutuelles</option>
				<?php
					connexion_DB('poly');
					$sql = "SELECT code, nom FROM mutuelles order by nom";
					$result = mysql_query($sql);
					while($data = mysql_fetch_assoc($result)) 	{
						echo "<option value='".$data['code']."' ";
						if ($MutuelleCode == $data['code']) echo "selected";
						echo " >";
						echo $data['code'];
						echo " ";
						echo substr($data['nom'],0,29);
						echo "</option>";
					}
					deconnexion_DB();

					?>
			</select>
		</div>

		<div id="listmedecin">
			<select id='medecin' name='medecin' onchange='javascript:listings_mutuelle_bis_medecin(this.value);'>
				<option value='all'>Tous les m&eacute;decins</option>
					<?php
						connexion_DB('poly');
						$sql = "SELECT nom, prenom, inami FROM medecins order by nom";
						$result = mysql_query($sql);
						while($data = mysql_fetch_assoc($result)) 	{
							echo "<option value='".$data['inami']."' ";
							if ($MedecinInami == $data['inami']) echo "selected";
							echo " >";
							echo $data['nom'];
							echo " ";
							echo $data['prenom'];
							echo "</option>";
						}
						deconnexion_DB();
					?>
			</select>
		</div>	

		<div id="listduree">
			<select id='duree' name='duree' onchange='javascript:listings_mutuelle_bis_periode(this.value);'>
				<?php
					echo "<option value='day' ";
					if ($Periode == 'day') echo "selected";
					echo " >";
					echo "Jour";
					echo "</option>";
					echo "<option value='first' ";
					if ($Periode == 'first') echo "selected";
					echo " >";
					echo "1er quinzaine";
					echo "</option>";
					echo "<option value='second' ";
					if ($Periode == 'second') echo "selected";
					echo " >";
					echo "2eme quinzaine";
					echo "</option>";
					echo "<option value='month' ";
					if ($Periode == 'month') echo "selected";
					echo " >";
					echo "Mois";
					echo "</option>";
					echo "<option value='all' ";
					if ($Periode == 'all') echo "selected";
					echo " >";
					echo "Complet";
					echo "</option>";
				?>
			</select>
		</div>	

		<div id="impression">
			<a href="<?=$impression_url?>"><img src="../images/imprimer.gif" /></a>
		</div>

	</div>
    
	<div id="middleleft">
    	
		<div id="header">
        	<ul id="primary_tabs">
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../calendrier/day.php">Agenda</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../tarifications/add_tarification.php">Tarifications</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../protheses/add_prothese.php">Proth&egrave;ses</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../patients/add_patient_titulaire.php">Patients</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../medecins/add_medecin.php">M&eacute;decins</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../cecodis/add_cecodi.php">Prestations</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../mutuelles/add_mutuelle.php">Mutuelles</a>
				</li>
        		<li id="calendar_tab" class="nodelete current">
		  			<a class="nodelete" href="../listings/listing_mutuelles.php">Listings</a>
				</li>
        		<li id="calendar_tab" class="nodelete">
		  			<a class="nodelete" href="../caisses/detail_transactions.php">Autres</a>
				</li>
        	</ul>
		</div>        
      
	  	<div class="dojoTabPanelContainer" id="main">
        
			<div id="tab_panel">
			
				<div id="calendar_display_wrapper_0" style="" class="pullUp">
	
					<div class="formTitle secondary-tabs" id="calendar_view_title">
   
   						<a href="./listing_mutuelles.php">Facturation aux mutuelles</a>
    					
    					<a href="./listing_medecins.php">Facturation aux m&eacute;decins</a>
						
    					<a href="./listing_journal_caisse.php">Journal de caisse</a>

    					<a href="./listing_erreurs_medecin.php">Erreurs m&eacute;decin</a>

						<span>Re-Facturation aux mutuelles</span> 
   
					</div>
					
					<div class="View">
					
						<div class="navigation-hight">

							<h2 class="listing">Facturation aux mutuelles</h2>
	
							<div class="navigation-calendar">

								<a class="previousMajor" href="./listing_mutuelles.php?action=previous_month" onclick="" title="Mois pr&eacute;c&eacute;dent"></a>
								<a class="previousMinor" href="./listing_mutuelles.php?action=previous_day" onclick="" title="Jour pr&eacute;c&eacute;dent"></a>
								<a class="nextMajor" href="./listing_mutuelles.php?action=next_month" onclick="" title="Mois suivant"></a>
								<a class="nextMinor" href="./listing_mutuelles.php?action=next_day" onclick="" title="Jour suivant"></a>
	  							<h2 id="week_calendar_title_0"><? echo $Jour." - ".$Mois." - ".$Annee ?></h2>

							</div>
							
							<fieldset class=''>
								<legend>Aide</legend>
								Listing de facturation des tarifications aux mutuelles. Il est possible de limiter l'affichage sur la période (journée, première quinzaine, deuxième quinzaine, mois complet et l'ensemble de toute les prestations). <br />
							</fieldset>
							
						</div>
						

												
						<fieldset class=''>
							<legend>Liste</legend>
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
	  <th>Clôture</th>
	  <th>Prestation</th>
	  <th>Mut.</th>
	  <th>Pat. Nom</th>
	  <th>Prénom</th>
	  <th>Matricule</th>
	  <th>CT1/CT2</th>
	  <th>Tit. Nom</th>
	  <th>Prénom</th>
	  <th>Matricule</th>
	  <th>M&eacute;decin</th>
	  <th>Prénom</th>
	  <th>Cecodi</th>
	  <th>Co&ucirc;t</th>
  </tr>
</table>
						</fieldset>
						
						



						
						</div>
					
					</div>
				
				</div>


 


</div>

</div>
        
</div>
</div>
    
    
</body>
</html>

