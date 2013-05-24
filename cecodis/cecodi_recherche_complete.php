<?
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
	
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	//$dico = array('tiers_payant' => 'Non', 'tiers_payantchecked' => 'Oui');
	
	$jsPseudo = isset($_GET['pseudo']) ? $_GET['pseudo'] : '';
	
	$jsPseudo = strtolower($test->convert($jsPseudo));
	$jsPseudo = trim($jsPseudo);
		
	// protect empty conten in editor's field
	if ($jsPseudo=="") $jsPseudo="%";
	
	// On fait la requête
	$sql = "SELECT * FROM cecodis2 WHERE ((lower(cecodi)) like '$jsPseudo%' OR (lower(description)) regexp '$jsPseudo') LIMIT 10";

	$result = requete_SQL($sql);
	
	$i = 1;
	
	if(mysql_num_rows($result)>0) {
		
		echo "<table border='0' cellpadding='2' cellspacing='1'>";
		echo "<th class='td'  colspan='2' align='center'>";
		echo "</th>";
		echo "<th>&nbsp;Cecodi</th>";
		echo "<th>&nbsp;Age</th>";
		echo "<th>&nbsp;Prop</th>";
		echo "<th>&nbsp;kdb</th>";
		echo "<th>&nbsp;bc</th>";
		echo "<th>&nbsp;hono</th>";
		echo "<th>&nbsp;vipo</th>";
		echo "<th>&nbsp;tiers</th>";
		if ($_SESSION['role'] == 'Administrateur') {
			echo "<th>&nbsp;Prix_vp</th>";
			echo "<th>&nbsp;Prix_tp</th>";
			echo "<th>&nbsp;Prix_tr</th>";
		} 

		while($data = mysql_fetch_assoc($result)) {
			
			$age = substr($data['age'], 1, (strlen($data['age'])-2));
			$tok = strtok($age,"||");
			$temp = "";
			$currentAge = "";
			$oldAge = "";
			while ($tok !== false) {
				$currentAge = $tok;
				if ($currentAge != ($oldAge+1)) {
					$temp .= "-".$oldAge.";".$currentAge;
				}
				$tok = strtok("||");
  				$oldAge = $currentAge;
			}
			$temp.= "-".$currentAge.";"; 
			$temp =  substr($temp, 2);
			$age = $temp;
			

			// on affiche les informations de l'enregistrement en cours
			echo "<tr onMouseOver='setPointer(this, 0, 0 );' onMouseOut='setPointer(this, 0, 1 );'>";

			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			echo "<a href='../cecodis/modif_cecodi.php?cecodi=".$data['cecodi']."' >";
			echo "<img width='16' height='16' src='../images/modif_small.gif' alt='Modifier' title='Modifier' border='0' /></a>";
			echo "</td>";

			echo "<td width='16' align='center' valign=top' bgcolor='#D5D5D5'>";
			echo "<a href='#' onClick='openDialogConfirm(".$data['id'].",".$data['cecodi'].")'>";
			echo "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			echo "</td>";
		
			echo "<td valign='top' align='center' bgcolor='#D5D5D5' nowrap='nowrap'>";
			echo "<a href='#' title='".((htmlentities(stripcslashes($data['description']),ENT_QUOTES)));
			echo "'>".$data['cecodi'];
			echo "</a>";
			echo "</td>";

			echo "<td valign='top' align='center' bgcolor='#D5D5D5' nowrap='nowrap'>";
			echo $age;
			echo "</td>";

		
			echo "<td valign='top' align='center' bgcolor='#D5D5D5' nowrap='nowrap'>";
			echo substr(strtoupper($data['propriete']),0,5)."</td>";
			echo "</td>";
		
			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
			if ($data['propriete']=='acte') {
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['kdb']."' autocomplete='off' onKeyUp='javascript:kdb".$i." = checkAmount(this, kdb".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"kdb\",this.value);' />";
			} else {
				echo " ";
			}
			echo "</td>";

			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
			if ($data['propriete']=='acte') {
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['bc']."' autocomplete='off' onKeyUp='javascript:bc".$i." = checkAmount(this, bc".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"bc\",this.value);' />";
			} else {
				echo " ";
			}
			echo "</td>";

			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
			if ($data['propriete']=='consultation') {
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['hono_travailleur']."' autocomplete='off' onKeyUp='javascript:hono".$i." = checkAmount(this, hono".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"hono_travailleur\",this.value);' />";
			} else {
				echo " ";
			}
			echo "</td>";

			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";	
			if ($data['propriete']=='consultation') {
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['a_vipo']."' autocomplete='off' onKeyUp='javascript:vipo".$i." = checkAmount(this, vipo".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"a_vipo\",this.value);' />";
			} else {
				echo " ";
			}
			echo "</td>";

			echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
			if ($data['propriete']=='consultation') {
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['b_tiers_payant']."' autocomplete='off' onKeyUp='javascript:tiers".$i." = checkAmount(this, tiers".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"b_tiers_payant\",this.value);' />";
			} else {
				echo " ";
			}
			echo "</td>";


			if ($_SESSION['role'] == 'Administrateur') {
				echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['prix_vp']."' autocomplete='off' onKeyUp='javascript:prix_vp".$i." = checkAmount(this, prix_vp".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"prix_vp\",this.value);' />";
				echo "</td>";
				
				echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['prix_tp']."' autocomplete='off' onKeyUp='javascript:prix_tp".$i." = checkAmount(this, prix_tp".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"prix_tp\",this.value);' />";
				echo "</td>";
				
				echo "<td valign='top' bgcolor='#D5D5D5' nowrap='nowrap'>";
				echo "<input type='text' name='id".$i."' id='id".$i."' size='4' maxlength='6' class='txtField' value='".$data['prix_tr']."' autocomplete='off' onKeyUp='javascript:prix_tr".$i." = checkAmount(this, prix_tr".$i.", 10, 2, false);cecodiChangeValeur(".$data['id'].",\"prix_tr\",this.value);' />";
				echo "</td>";
			} 


			echo "</tr>";
			
			$i ++;
		
		}


	} else {
		
		echo "";
			
	}

	
?>