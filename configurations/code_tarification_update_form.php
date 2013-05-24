<?php 

	// Demarre une session
	session_start();
	
	// Validation du Login
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
	
	connexion_DB('poly');
									
	$sql = "SELECT id, code, type, description, code_couleur, interne FROM caisse_code ORDER BY 1 asc";
	$result = requete_SQL ($sql);
											
	$jsStart = "";

	echo "<tr>";
	echo "<th>";
	echo "</th>";
	echo "<td>";
	echo "<input type='text' size='24'alt='Description' title='Description' maxlength='32' value='Description' readonly='true'/>";
	echo "<input type='text' size='8' alt='Code' title='Code' maxlength='7' value='Code' readonly='true'/>";
	echo "<input type='text' size='7' alt='Code couleur' title='Code couleur' maxlength='7' value='Couleur' readonly='true'/>";
	echo "<input type='text' size='8' alt='Type' title='Type' maxlength='6' value='Type' readonly='true'/>";
	echo "</td>";
	echo "</tr>";
	
	if(mysql_num_rows($result)!=0) {

		while($data = mysql_fetch_assoc($result)) 	{
			
			$dataID = $data['id'];

			$dataCode = $data['code'];

			$dataDescription = $data['description'];

			$dataCodeCouleur = $data['code_couleur'];

			$dataInterne = $data['interne'];

			$dataType = $data['type'];

			
			if ($dataType=='1') {$tempIn = 'selected';$tempOut = '';} else {$tempIn = '';$tempOut = 'selected';}  
			if ($dataInterne != 'checked') {$tempClass = '';} else {$tempClass = 'required';}

			echo "<tr>";
			echo "<th class='$tempClass'>".htmlentities($dataDescription)."</th>";
			echo "<td>";
			echo "<input type='text' size='24'alt='Description' title='Description' maxlength='32' value='".htmlentities($dataDescription)."'  onfocus='this.select()' onkeyup='javascript:modifChamp($dataID,descriptionlabel,this.value)' autocomplete='off'/>";
			echo "<input type='text' size='8' alt='Code' title='Code' maxlength='32' value='".htmlentities($dataCode)."'  onfocus='this.select()' onkeyup='javascript:modifChamp($dataID,codelabel,this.value)' autocomplete='off'/>";
			echo "<input id='show$dataID' style='font-weight: bold;color: #$dataCodeCouleur' type='text' size='6' alt='Code couleur' title='Code couleur' maxlength='6' value='".htmlentities($dataCodeCouleur)."'  onfocus='this.select()' onchange='javascript:modifChamp($dataID,code_couleurlabel,this.value);' autocomplete='off'/>";
			//echo "<a href='#' id='show$dataID'><img width='16' height='16' src='../images/delete_small.gif' alt='Choix de la couleur' title='Choix de la couleur' border='0' /></a>"; 
			echo "<select onchange='javascript:modifChamp($dataID,typelabel,this.value)'>"; 
			echo "<option value='-1' $tempOut>Sortie</option>";
			echo "<option value='1' $tempIn>Entr&eacute;e</option>";
			echo "</select>";

			if ($dataInterne != "checked") {
				echo "&nbsp;&nbsp;&nbsp;<a href='#' onClick='javascript:openDialogConfirm($dataID,\"".htmlentities($dataDescription)."\");return false;' >";
				echo "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' />";
				echo "</a>";
			} else {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}

			echo "<div id ='info$dataID'></div>";
			echo "</td>";
			echo "</tr>";

		}

	}

	deconnexion_DB();

?>										