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
	$nom_fichier = "listing_medecins.php";
	
	include_once '../lib/fonctions.php';
	
	$jour = date("d");
	$mois = date("m");
	$annee = date("Y");
	$dataCurrent = date("Y-m-d", mktime(0, 0, 0, $mois - 1, $jour, $annee));
	
	$dateMin = isset($_SESSION['stat_date_min']) ? $_SESSION['stat_date_min'] : $dataCurrent;
	$dateMax = isset($_SESSION['stat_date_max']) ? $_SESSION['stat_date_max'] : date("Y-m-d");
		
	$datetools1 = new dateTools($dateMin,$dateMin);
	$datetools2 = new dateTools($dateMax,$dateMax);
	
	$statStatistique = isset($_SESSION['stat_statistique']) ? $_SESSION['stat_statistique'] : 'COUNT(ta.id)';
	$statGroupe = isset($_SESSION['stat_groupe']) ? $_SESSION['stat_groupe'] : 'groupe1';
	$statStatistiqueNumber = isset($_SESSION['stat_statistique_number']) ? $_SESSION['stat_statistique_number'] : 10;
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Poly - Agenda journalier</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
</head>

<body id='body' class="yui-skin-sam">

   <?php
		get_MENUBAR_START();
		get_MENUBAR_END($nom_fichier);
	?>
	
    <div id="top">
		<h1>Statistiques en camenbert</h1>
		
		<a class="impression" href="../factures/printstatistiquetable.php"></a>
		
	</div>

	<div id="middle">
    	
		<div id="header">
        	<ul id="primary_tabs">
				<?php get_MENU('none')?>
        	</ul>
		</div>        
      
	  	<div id="main">
        
			<div id="tab_panel">
			
				<div id="calendar_view_title">
   
   				</div>
					
				<div class="ViewPane">

					<br/>
					<br/>
											
					<div id="secondheader">
        					<ul id="sec_primary_tabs">
        						<li id="sec_tab_general" class="nodelete current">
		  							<a class="nodelete" href="#" onclick="javascript:switchGeneralInfo('general');">Graphe</a>
		 				 		</li>
        						<li id="sec_tab_info" class="nodelete">
		  							<a class="nodelete" href="#" onclick="javascript:switchGeneralInfo('information');">Tableau</a>
		 				 		</li>
        					</ul>
						</div>
						
						<!-- DEBUT DU CALENDRIER -->
						<div id="secondmain" class="formBox">
							
							<div id='general'>
								<div id='generalinfo'>
									<img class='centerimage' src='../images/attente.gif'/>
								</div>
								<div id='generalimage'>
									<img class='centerimage' src='../images/attente.gif'/>
								</div>
							</div>
															
							<div id='information' style="display: none;">
								<div id='informationinfo'>
									<img class='centerimage' src='../images/attente.gif'/>
								</div>
								<div id='informationtable'>
									<img class='centerimage' src='../images/attente.gif'/>
								</div>
							</div>

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
			
					<a class="taskControl" href="#">Selection</a>
			
					<div class="sidebar labels-red">

						<h2>Date de d&eacute;but :</h2>
                	
						<div class="inlineForm">
							<form onsubmit="">
								<input autocomplete="off" class="text-input" id="startdate" name="startdate" type="text" value="<?=$datetools1->transformDATE2()?>" title="Date de d&eacute;but" onfocus="javascript:this.select();" onClick="javascript:Element.show('calStartContainer');" onkeyup="javascript:dateStartStatistique = checkDate(this, '', '');Element.hide('calStartContainer');">
                	  		</form>
							<div id="calStartContainer" style="display: none;">
								
								<table id="cal1" cellspacing="0">
								<thead>
								<tr>
								<th colspan="7" class="calhead">
								<div class="calheader">
								<a class="calnavleft">&nbsp;</a>
								<a class="calnavright">&nbsp;</a>
								</div>
								</th>
								</tr>
								<tr class="calweekdayrow">
								<th class="calweekdaycell">Di</th>
								<th class="calweekdaycell">Lu</th>
								<th class="calweekdaycell">Ma</th>
								<th class="calweekdaycell">Me</th>
								<th class="calweekdaycell">Je</th>
								<th class="calweekdaycell">Ve</th>
								<th class="calweekdaycell">Sa</th>
								</tr>
								</thead>
								<tbody class="m3 calbody">
								<tr class="w9">
								<td id="cal1_cell0" class="calcell oom calcelltop calcellleft">24</td>
								<td id="cal1_cell1" class="calcell oom calcelltop">25</td>
								<td id="cal1_cell2" class="calcell oom calcelltop">26</td>
								<td id="cal1_cell3" class="calcell oom calcelltop">27</td>
								<td id="cal1_cell4" class="calcell oom calcelltop">28</td>
								<td id="cal1_cell5" class="calcell oom calcelltop">29</td>
								<td id="cal1_cell6" class="calcell wd6 d1 selectable calcelltop calcellright"><a href="#" class="selector">1</a></td>
								</tr>
								<tr class="w10">
								<td id="cal1_cell7" class="calcell wd0 d2 selectable calcellleft"><a href="#" class="selector">2</a></td>
								<td id="cal1_cell8" class="calcell wd1 d3 selectable"><a href="#" class="selector">3</a></td>
								<td id="cal1_cell9" class="calcell wd2 d4 selectable"><a href="#" class="selector">4</a></td>
								<td id="cal1_cell10" class="calcell wd3 d5 selectable"><a href="#" class="selector">5</a></td>
								<td id="cal1_cell11" class="calcell wd4 d6 selectable"><a href="#" class="selector">6</a></td>
								<td id="cal1_cell12" class="calcell wd5 d7 selectable"><a href="#" class="selector">7</a></td>
								<td id="cal1_cell13" class="calcell wd6 d8 selectable calcellright"><a href="#" class="selector">8</a></td>
								</tr>
								<tr class="w11">
								<td id="cal1_cell14" class="calcell wd0 d9 selectable calcellleft"><a href="#" class="selector">9</a></td>
								<td id="cal1_cell15" class="calcell wd1 d10 selectable"><a href="#" class="selector">10</a></td>
								<td id="cal1_cell16" class="calcell wd2 d11 selectable"><a href="#" class="selector">11</a></td>
								<td id="cal1_cell17" class="calcell wd3 d12 selectable"><a href="#" class="selector">12</a></td>
								<td id="cal1_cell18" class="calcell wd4 d13 selectable"><a href="#" class="selector">13</a></td>
								<td id="cal1_cell19" class="calcell wd5 d14 selectable"><a href="#" class="selector">14</a></td>
								<td id="cal1_cell20" class="calcell wd6 d15 selectable calcellright"><a href="#" class="selector">15</a></td>
								</tr>
								<tr class="w12">
								<td id="cal1_cell21" class="calcell wd0 d16 selectable calcellleft"><a href="#" class="selector">16</a></td>
								<td id="cal1_cell22" class="calcell wd1 d17 selectable"><a href="#" class="selector">17</a></td>
								<td id="cal1_cell23" class="calcell wd2 d18 selectable"><a href="#" class="selector">18</a></td>
								<td id="cal1_cell24" class="calcell wd3 d19 selectable"><a href="#" class="selector">19</a></td>
								<td id="cal1_cell25" class="calcell wd4 d20 selectable"><a href="#" class="selector">20</a></td>
								<td id="cal1_cell26" class="calcell wd5 d21 selectable"><a href="#" class="selector">21</a></td>
								<td id="cal1_cell27" class="calcell wd6 d22 selectable calcellright"><a href="#" class="selector">22</a></td>
								</tr>
								<tr class="w13">
								<td id="cal1_cell28" class="calcell wd0 d23 today selectable calcellleft"><a href="#" class="selector">23</a></td>
								<td id="cal1_cell29" class="calcell wd1 d24 selectable"><a href="#" class="selector">24</a></td>
								<td id="cal1_cell30" class="calcell wd2 d25 selectable"><a href="#" class="selector">25</a></td>
								<td id="cal1_cell31" class="calcell wd3 d26 selectable"><a href="#" class="selector">26</a></td>
								<td id="cal1_cell32" class="calcell wd4 d27 selectable"><a href="#" class="selector">27</a></td>
								<td id="cal1_cell33" class="calcell wd5 d28 selectable"><a href="#" class="selector">28</a></td>
								<td id="cal1_cell34" class="calcell wd6 d29 selectable calcellright"><a href="#" class="selector">29</a></td>
								</tr>
								<tr class="w14">
								<td id="cal1_cell35" class="calcell wd0 d30 selectable calcellleft calcellbottom"><a href="#" class="selector">30</a></td>
								<td id="cal1_cell36" class="calcell wd1 d31 selectable calcellbottom"><a href="#" class="selector">31</a></td>
								<td id="cal1_cell37" class="calcell oom calcellbottom">1</td>
								<td id="cal1_cell38" class="calcell oom calcellbottom">2</td>
								<td id="cal1_cell39" class="calcell oom calcellbottom">3</td>
								<td id="cal1_cell40" class="calcell oom calcellbottom">4</td>
								<td id="cal1_cell41" class="calcell oom calcellright calcellbottom">5</td>
								</tr>
								</tbody>
								</table>
								
							</div>
					    
                		</div>
					
					</div>
		
					<div class="sidebar labels-green">

						<h2>Date de fin :</h2>
                	
						<div class="inlineForm">
							<form onsubmit="">
								<input autocomplete="off" class="text-input" id="enddate" name="enddate" type="text" value="<?=$datetools2->transformDATE2()?>" title="Date de fin" onfocus="javascript:this.select();" onClick="javascript:Element.show('calEndContainer');" onkeyup="javascript:dateEndStatistique = checkDate(this, '', '');Element.hide('calEndContainer');">
                	  		</form>
							<div id="calEndContainer" style="display: none;">
								
								<table id="cal2" cellspacing="0">
								<thead>
								<tr>
								<th colspan="7" class="calhead">
								<div class="calheader">
								<a class="calnavleft">&nbsp;</a>
								<a class="calnavright">&nbsp;</a>
								</div>
								</th>
								</tr>
								<tr class="calweekdayrow">
								<th class="calweekdaycell">Di</th>
								<th class="calweekdaycell">Lu</th>
								<th class="calweekdaycell">Ma</th>
								<th class="calweekdaycell">Me</th>
								<th class="calweekdaycell">Je</th>
								<th class="calweekdaycell">Ve</th>
								<th class="calweekdaycell">Sa</th>
								</tr>
								</thead>
								<tbody class="m3 calbody">
								<tr class="w9">
								<td id="cal1_cell0" class="calcell oom calcelltop calcellleft">24</td>
								<td id="cal1_cell1" class="calcell oom calcelltop">25</td>
								<td id="cal1_cell2" class="calcell oom calcelltop">26</td>
								<td id="cal1_cell3" class="calcell oom calcelltop">27</td>
								<td id="cal1_cell4" class="calcell oom calcelltop">28</td>
								<td id="cal1_cell5" class="calcell oom calcelltop">29</td>
								<td id="cal1_cell6" class="calcell wd6 d1 selectable calcelltop calcellright"><a href="#" class="selector">1</a></td>
								</tr>
								<tr class="w10">
								<td id="cal1_cell7" class="calcell wd0 d2 selectable calcellleft"><a href="#" class="selector">2</a></td>
								<td id="cal1_cell8" class="calcell wd1 d3 selectable"><a href="#" class="selector">3</a></td>
								<td id="cal1_cell9" class="calcell wd2 d4 selectable"><a href="#" class="selector">4</a></td>
								<td id="cal1_cell10" class="calcell wd3 d5 selectable"><a href="#" class="selector">5</a></td>
								<td id="cal1_cell11" class="calcell wd4 d6 selectable"><a href="#" class="selector">6</a></td>
								<td id="cal1_cell12" class="calcell wd5 d7 selectable"><a href="#" class="selector">7</a></td>
								<td id="cal1_cell13" class="calcell wd6 d8 selectable calcellright"><a href="#" class="selector">8</a></td>
								</tr>
								<tr class="w11">
								<td id="cal1_cell14" class="calcell wd0 d9 selectable calcellleft"><a href="#" class="selector">9</a></td>
								<td id="cal1_cell15" class="calcell wd1 d10 selectable"><a href="#" class="selector">10</a></td>
								<td id="cal1_cell16" class="calcell wd2 d11 selectable"><a href="#" class="selector">11</a></td>
								<td id="cal1_cell17" class="calcell wd3 d12 selectable"><a href="#" class="selector">12</a></td>
								<td id="cal1_cell18" class="calcell wd4 d13 selectable"><a href="#" class="selector">13</a></td>
								<td id="cal1_cell19" class="calcell wd5 d14 selectable"><a href="#" class="selector">14</a></td>
								<td id="cal1_cell20" class="calcell wd6 d15 selectable calcellright"><a href="#" class="selector">15</a></td>
								</tr>
								<tr class="w12">
								<td id="cal1_cell21" class="calcell wd0 d16 selectable calcellleft"><a href="#" class="selector">16</a></td>
								<td id="cal1_cell22" class="calcell wd1 d17 selectable"><a href="#" class="selector">17</a></td>
								<td id="cal1_cell23" class="calcell wd2 d18 selectable"><a href="#" class="selector">18</a></td>
								<td id="cal1_cell24" class="calcell wd3 d19 selectable"><a href="#" class="selector">19</a></td>
								<td id="cal1_cell25" class="calcell wd4 d20 selectable"><a href="#" class="selector">20</a></td>
								<td id="cal1_cell26" class="calcell wd5 d21 selectable"><a href="#" class="selector">21</a></td>
								<td id="cal1_cell27" class="calcell wd6 d22 selectable calcellright"><a href="#" class="selector">22</a></td>
								</tr>
								<tr class="w13">
								<td id="cal1_cell28" class="calcell wd0 d23 today selectable calcellleft"><a href="#" class="selector">23</a></td>
								<td id="cal1_cell29" class="calcell wd1 d24 selectable"><a href="#" class="selector">24</a></td>
								<td id="cal1_cell30" class="calcell wd2 d25 selectable"><a href="#" class="selector">25</a></td>
								<td id="cal1_cell31" class="calcell wd3 d26 selectable"><a href="#" class="selector">26</a></td>
								<td id="cal1_cell32" class="calcell wd4 d27 selectable"><a href="#" class="selector">27</a></td>
								<td id="cal1_cell33" class="calcell wd5 d28 selectable"><a href="#" class="selector">28</a></td>
								<td id="cal1_cell34" class="calcell wd6 d29 selectable calcellright"><a href="#" class="selector">29</a></td>
								</tr>
								<tr class="w14">
								<td id="cal1_cell35" class="calcell wd0 d30 selectable calcellleft calcellbottom"><a href="#" class="selector">30</a></td>
								<td id="cal1_cell36" class="calcell wd1 d31 selectable calcellbottom"><a href="#" class="selector">31</a></td>
								<td id="cal1_cell37" class="calcell oom calcellbottom">1</td>
								<td id="cal1_cell38" class="calcell oom calcellbottom">2</td>
								<td id="cal1_cell39" class="calcell oom calcellbottom">3</td>
								<td id="cal1_cell40" class="calcell oom calcellbottom">4</td>
								<td id="cal1_cell41" class="calcell oom calcellright calcellbottom">5</td>
								</tr>
								</tbody>
								</table>
								
							</div>
					    
                		</div>
					
					</div>
					
					
					<div id="labels" class="sidebar labels-red">

						<h2>Statistique :</h2>
						
						<select id='statistique' name='statistique' width="179" style="width: 179px" onClick="document.getElementById('number').style.pixelWidth = 179" onchange="javascript:loadStatistique('stat_statistique',this.value);">
							<option value='statistique1' <?php if ($statStatistique == 'statistique1') echo "selected"; ?> >% consultations</option>
							<option value='statistique2' <?php if ($statStatistique == 'statistique2') echo "selected"; ?> >% codes Inami</option>
							<option value='statistique3' <?php if ($statStatistique == 'statistique3') echo "selected"; ?> >% rentr&eacute;e total</option>
							<option value='statistique4' <?php if ($statStatistique == 'statistique4') echo "selected"; ?> >% rentr&eacute;e m&eacute;decin</option>
							<option value='statistique5' <?php if ($statStatistique == 'statistique5') echo "selected"; ?> >% rentr&eacute;e poly (sans TM)</option>
							<option value='statistique6' <?php if ($statStatistique == 'statistique6') echo "selected"; ?> >% rentr&eacute;e poly (avec TM)</option>
							<option value='statistique7' <?php if ($statStatistique == 'statistique7') echo "selected"; ?> >% remboursement mutuelle</option>
							<option value='statistique8' <?php if ($statStatistique == 'statistique8') echo "selected"; ?> >% rentr&eacute;e en caisse</option>
						</select>

					</div>
					
					<div id="labels" class="sidebar labels-red">

						<h2>Groupe :</h2>

						<select id='groupe' name='groupe' width="179" style="width: 179px" onClick="document.getElementById('number').style.pixelWidth = 179" onchange="javascript:loadStatistique('stat_groupe',this.value);">
							<option value='groupe1' <?php if ($statGroupe == 'groupe1') echo "selected"; ?> >Par m&eacute;decins</option>
							<option value='groupe2' <?php if ($statGroupe == 'groupe2') echo "selected"; ?> >Par patients</option>
							<option value='groupe3' <?php if ($statGroupe == 'groupe3') echo "selected"; ?> >Par sp&eacute;cialit&eacute;</option>
							<option value='groupe4' <?php if ($statGroupe == 'groupe4') echo "selected"; ?> >Par code Inami</option>
							<option value='groupe5' <?php if ($statGroupe == 'groupe5') echo "selected"; ?> >Par assurabilit&eacute; (CT1-CT2)</option>
							<option value='groupe6' <?php if ($statGroupe == 'groupe6') echo "selected"; ?> >Par assurabilit&eacute; (Type)</option>
							<option value='groupe7' <?php if ($statGroupe == 'groupe7') echo "selected"; ?> >Par mutuelle</option>
							<option value='groupe8' <?php if ($statGroupe == 'groupe8') echo "selected"; ?> >Par age</option>
							<option value='groupe9' <?php if ($statGroupe == 'groupe9') echo "selected"; ?> >Par sexe</option>
							<!-- option value='groupe4' <?php if ($_SESSION['stat_groupe'] == 'groupe4') echo "selected"; ?> >Par mutuelle</option-->
						</select>

					</div>
					
					<div id="labels" class="sidebar labels-red">

						<h2>Nombre de r&eacute;sultat :</h2>

						<select id='number' name='number' width="179" style="width: 179px" onClick="document.getElementById('number').style.pixelWidth = 179" onchange="javascript:loadStatistique('stat_statistique_number',this.value);">
							<option value='1' <?php if ($statStatistiqueNumber == '1') echo "selected"; ?> >1 r&eacute;sultat</option>
							<option value='2' <?php if ($statStatistiqueNumber == '2') echo "selected"; ?> >2 r&eacute;sultats</option>
							<option value='3' <?php if ($statStatistiqueNumber == '3') echo "selected"; ?> >3 r&eacute;sultats</option>
							<option value='4' <?php if ($statStatistiqueNumber == '4') echo "selected"; ?> >4 r&eacute;sultats</option>
							<option value='5' <?php if ($statStatistiqueNumber == '5') echo "selected"; ?> >5 r&eacute;sultats</option>
							<option value='6' <?php if ($statStatistiqueNumber == '6') echo "selected"; ?> >6 r&eacute;sultats</option>
							<option value='7' <?php if ($statStatistiqueNumber == '7') echo "selected"; ?> >7 r&eacute;sultats</option>
							<option value='8' <?php if ($statStatistiqueNumber == '8') echo "selected"; ?> >8 r&eacute;sultats</option>
							<option value='9' <?php if ($statStatistiqueNumber == '9') echo "selected"; ?> >9 r&eacute;sultats</option>
							<option value='10' <?php if ($statStatistiqueNumber == '10') echo "selected"; ?> >10 r&eacute;sultats</option>
							<option value='11' <?php if ($statStatistiqueNumber == '11') echo "selected"; ?> >11 r&eacute;sultats</option>
							<option value='12' <?php if ($statStatistiqueNumber == '12') echo "selected"; ?> >12 r&eacute;sultats</option>
							<option value='13' <?php if ($statStatistiqueNumber == '13') echo "selected"; ?> >13 r&eacute;sultats</option>
							<option value='14' <?php if ($statStatistiqueNumber == '14') echo "selected"; ?> >14 r&eacute;sultats</option>
							<option value='15' <?php if ($statStatistiqueNumber == '15') echo "selected"; ?> >15 r&eacute;sultats</option>
							<option value='16' <?php if ($statStatistiqueNumber == '16') echo "selected"; ?> >16 r&eacute;sultats</option>
							<option value='17' <?php if ($statStatistiqueNumber == '17') echo "selected"; ?> >17 r&eacute;sultats</option>
							<option value='18' <?php if ($statStatistiqueNumber == '18') echo "selected"; ?> >18 r&eacute;sultats</option>
							<option value='19' <?php if ($statStatistiqueNumber == '19') echo "selected"; ?> >19 r&eacute;sultats</option>
							<option value='20' <?php if ($statStatistiqueNumber == '20') echo "selected"; ?> >20 r&eacute;sultats</option>
							<option value='50' <?php if ($statStatistiqueNumber == '50') echo "selected"; ?> >50 r&eacute;sultats</option>
							<option value='75' <?php if ($statStatistiqueNumber == '75') echo "selected"; ?> >75 r&eacute;sultats</option>
							<option value='100' <?php if ($statStatistiqueNumber == '100') echo "selected"; ?> >100 r&eacute;sultats</option>
							<option value='150' <?php if ($statStatistiqueNumber == '150') echo "selected"; ?> >150 r&eacute;sultats</option>
							<option value='200' <?php if ($statStatistiqueNumber == '200') echo "selected"; ?> >200 r&eacute;sultats</option>
							<option value='250' <?php if ($statStatistiqueNumber == '250') echo "selected"; ?> >250 r&eacute;sultats</option>
							<option value='500' <?php if ($statStatistiqueNumber == '500') echo "selected"; ?> >500 r&eacute;sultats</option>
							<option value='1000' <?php if ($statStatistiqueNumber == '1000') echo "selected"; ?> >1000 r&eacute;sultats</option>
							<option value='2000' <?php if ($statStatistiqueNumber == '2000') echo "selected"; ?> >2000 r&eacute;sultats</option>
							<option value='100000' <?php if ($statStatistiqueNumber == '100000') echo "selected"; ?> >Tous les r&eacute;sultats</option>
						</select>

					</div>
					
					<div id="footer">
						<p>targoo@gmail.com bmangel@gmail.com</p>
						<br/>
						<img src='../images/96x96/stat.png'>
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
	<script type="text/javascript" src="../yui/build/menu.js"></script>
    <script type="text/javascript">
    	YAHOO.util.Event.onContentReady("productsandservices", function () {
        	var oMenuBar = new YAHOO.widget.MenuBar("productsandservices", { 
                                                            autosubmenudisplay: true, 
                                                            hidedelay: 1000, 
                                                            lazyload: false });

			oMenuBar.render();
		});
	</script>


	<script type="text/javascript" src="../yui/build/yahoo-dom-event/yahoo-dom-event.js"></script>
	<script type="text/javascript" src="../yui/build/calendar/calendar-min.js"></script>


	<!-- ALL JS -->
	<script type="text/javascript" src="../js/common.js"></script>
	<script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" src="../js/statistique.js"></script>

	<!-- MODAL JS -->	
	<script type="text/javascript" src="../js/prototype/prototype.js"></script>
	<script type="text/javascript" src="../js/window/window.js"> </script>
	<script type="text/javascript">  
		var dateEndStatistique;
		var dateStartStatistique;
		loadStatistique('empty','empty');
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
	</script>
	
<script type="text/javascript">
	YAHOO.namespace("start.calendar");
	YAHOO.start.calendar.init = function() {
		function handleSelect(type,args,obj) {
			var dates = args[0]; 
			var date = dates[0];
			var year = date[0], month = date[1], day = date[2];
			var txtDate1 = document.getElementById("startdate");
			txtDate1.value = day + "/" + month + "/" + year;
			Element.hide('calStartContainer');
			loadStatistique('stat_date_min',year + "-" + month + "-" + day);
		}
		YAHOO.start.calendar.cal1 = new YAHOO.widget.Calendar("cal1","calStartContainer",{ mindate:"1/1/2000",maxdate:"12/31/2099" });
		YAHOO.start.calendar.cal1.selectEvent.subscribe(handleSelect, YAHOO.start.calendar.cal1, true);
		YAHOO.start.calendar.cal1.render();
	}
	YAHOO.util.Event.onDOMReady(YAHOO.start.calendar.init);
	
	YAHOO.namespace("end.calendar");
	YAHOO.end.calendar.init = function() {
		function handleSelect(type,args,obj) {
			var dates = args[0]; 
			var date = dates[0];
			var year = date[0], month = date[1], day = date[2];
			var txtDate2 = document.getElementById("enddate");
			txtDate2.value = day + "/" + month + "/" + year;
			loadStatistique('stat_date_max',year + "-" + month + "-" + day);
			Element.hide('calEndContainer');
		}
		YAHOO.end.calendar.cal2 = new YAHOO.widget.Calendar("cal2","calEndContainer",{ mindate:"1/1/2000",maxdate:"12/31/2099" });
		YAHOO.end.calendar.cal2.selectEvent.subscribe(handleSelect, YAHOO.end.calendar.cal2, true);
		YAHOO.end.calendar.cal2.render();
	}
	YAHOO.util.Event.onDOMReady(YAHOO.end.calendar.init);
</script>		

	</body>
</html>