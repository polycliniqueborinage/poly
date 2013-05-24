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

//vider la redirection
unset($_SESSION['redirect']);

// Inclus le fichier contenant les fonctions personalisées
include_once '../lib/fonctions.php';

// Inclus le fichier contenant la gestion des erreurs
include_once '../lib/gestionErreurs.php';
$test = new testTools("info");
$info_erreurs = "";

// Fonction de connexion à la base de données
connexion_DB('poly');

$formUseTablePatients     		 = 'X';
$formUseTableMedecins     		 = 'X';
$formUseTableVisites       		 = '';
$formUseTableTarifications       = '';
$formUseTableTarificationsDetail = '';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<title>Cr&eacute;ation de crit&egrave;res</title>

<head>

<script type="text/javascript" src="../js/bd_recherche_champs.js"></script>
<script type="text/javascript" src='../js/common.js'></script>
<script type="text/javascript" src="../scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src='../js/inputControl.js'></script>
<script type="text/javascript" src='../js/autosuggest.js'></script>
<script type="text/javascript" src='../js/suggestions.js'></script>
<script type="text/javascript" src='../js/medecinepreventive.js'></script>
<script type="text/javascript" src="../thickbox_fichiers/urchin.js"></script>
<script type="text/javascript" src="../thickbox_fichiers/overlib.js"></script>
<script type="text/javascript" src="../thickbox_fichiers/jQuery.js"></script>
<script type="text/javascript" src="../thickbox_fichiers/thickbox.js"></script> 

<link href="../thickbox_fichiers/thickbox.css" media="screen" rel="stylesheet" type="text/css">
<link href="../style/basic.css" media="all" rel="Stylesheet" type="text/css">
<link href="../style/tabs.css" media="all" rel="Stylesheet" type="text/css">
<link href="../style/appt.css" media="all" rel="Stylesheet" type="text/css">
<link href="../style/sidebar.css" media="all" rel="Stylesheet" type="text/css">
<link href="../style/autosuggest.css" media="all" rel="Stylesheet" type="text/css">


</head> 

<body>

<form id="form1" name="form1" action="formulaire_requete_type2.php" method="post">

<input type="hidden" id="patients"      	   value='<?=$formUseTablePatients?>'>
<input type="hidden" id="medecins"      	   value='<?=$formUseTableMedecins?>'>
<input type="hidden" id="visites"      		   value='<?=$formUseTableVisites?>'>
<input type="hidden" id="tarifications" 	   value='<?=$formUseTableTarifications?>'>
<input type="hidden" id="tarifications_detail" value='<?=$formUseTableTarificationsDetail?>'>


<h1>Etape 2: Choix des crit&egrave;res</h1>

<fieldset class=''>
	<legend>Aide</legend>
	Ce formulaire permet de cr&eacute;er des crit&egrave;res de s&eacute;lection de population pour vos motifs.<br>
	Cette &eacute;tape consiste &agrave; &eacute;tablir les r&egrave;gles de filtrage.<br>
	S&eacute;lectionnez les attributs des tables choisies, assignez les valeurs et couplez les crit&egrave;res de mani&egrave;re exclusive (ET) ou comme alternative (OU); les couples de crit&egrave;res pouvant &eacute;galement &ecirc;tre coupl&eacute; entre eux et ainsi de suite.<br>
	<b>!!! IMPORTANT: Lorsqu'une date est s&eacute;lection&eacute;e, vous pouvez utiliser la s&eacute;quence '0000-00-00' pour sp&eacute;cifier la date du jour !!!</b>  
</fieldset>

<br><br><br>

<h2><u>
Utiliser les crit&egrave;res de s&eacute;lection suivants pour effectuer la requ&ecirc;te sur les patients:
</u></h2>

<br><br>

<table id="error_message1" style="display:none">
	<tr>
		<td><font color=red><b>Aucune checkbox n'est coch&eacute;e.</b></font></td>
	</tr>
</table>
<table id="error_message2" style="display:none">
	<tr>
		<td><font color=red><b>Un ou plusieurs champs sont manquants dans la premi&egrave;re partie du crit&egrave;re.</b></font></td>
	</tr>
</table>
<table id="error_message3" style="display:none">
	<tr>
		<td><font color=red><b>Un ou plusieurs champs sont manquants dans la deuxi&egrave;me partie du crit&egrave;re.</b></font></td>
	</tr>
</table>
<table id="error_message4" style="display:none">
	<tr>
		<td><font color=red><b>Une ou plusieurs valeurs sont manquantes dans la deuxi&egrave;me partie du crit&egrave;re.</b></font></td>
	</tr>
</table>
<table id="error_message5" style="display:none">
	<tr>
		<td><font color=red><b>Toutes les lignes doivent contenir au moins une case coch&eacute;e.</b></font></td>
	</tr>
</table>
<table id="error_message6" style="display:none">
	<tr>
		<td><font color=red><b>La requ&ecirc;te n'est pas consistante.</b></font></td>
	</tr>
</table>
<table id="error_message7" style="display:none">
	<tr>
		<td><font color=red><b>Les insformations du code cecodi ne sont pas remplies.</b></font></td>
	</tr>
</table>

<table id="general">
<tbody>
<tr><td><table id="0">
			<tbody>
			<tr></tr>
			</tbody>
		</table>
	</td>		
	<td></td>	
	<td><select id="table0" name="table0" onclick="javascript:searchSuggest(0)">
			<?
				if($formUseTableMedecins      		!= '') echo"<option value=\"medecins\" selected>M&eacute;decins</option>";
				if($formUseTablePatients      		!= '') echo"<option value=\"patients\" selected>Patients</option>";
			?>
		</select></td>
	<td><input autocomplete="off" class="text-input" type="text" id="champs0" name="champs0" readonly onfocus="javascript:this.select()"/>
		<div id="search_suggest0"></div>
	</td>
	<td><select id="operateur0" name="operateur0">
     		<option value="=" selected>=</option>
     		<option value=">">&gt;</option>
     		<option value=">=">&ge;</option>
     		<option value="<">&lt;</option>
     		<option value="<=">&le;</option>
     		<option value="<>"><></option>
     		<option value="IN">IN</option>
     		<option value="NOT IN">NOT IN</option>
     	</select></td>
    <td>
    	<form id="formradio0" name="formradio0">
    	<input type="radio" id="valeur_ou_jointure" name="valeur_ou_jointure" value='0' onclick="document.getElementById('valeur0').style.display='';     document.getElementById('table1000').style.display='none'; document.getElementById('champs1000').style.display='none';" CHECKED>Valeur
    	<br>
    	<input type="radio" id="valeur_ou_jointure" name="valeur_ou_jointure" value='1' onclick="document.getElementById('valeur0').style.display='none'; document.getElementById('table1000').style.display='';     document.getElementById('champs1000').style.display='';" >Jointure
    	</form>
    </td>    
     	
    <td><input type=text id="valeur0" name="valeur0">
		<select id="table1000" name="table1000" onclick="javascript:searchSuggest(1000)" style='display:none'>
			<?
				if($formUseTableMedecins      		!= '') echo"<option value=\"medecins\" selected>M&eacute;decins</option>";
				if($formUseTablePatients      		!= '') echo"<option value=\"patients\" selected>Patients</option>";
			?>
		</select></td>
	<td><input autocomplete="off" class="text-input" type="text" id="champs1000" name="champs1000" style='display:none' readonly onfocus="javascript:this.select()">
		<div id="search_suggest1000"></div>
    </td>
    <td><a onclick='deletecritere(0);'><img src='../images/document_delete.gif' alt='Supprimer le crit&egrave;re' title='Supprimer le crit&egrave;re' border='0' width=15/></a></td>
</tr>

</tbody>
</table>

<br><br><br>

<table>

<tr>
<td><input type="button" value="Ajouter un autre crit&egrave;re" onclick='addcritere();'><td>
</tr>

</table>



<input id='number' name='number' type='hidden'/>


<hr>

<br><br>

<h2><u>
S&eacute;lection des crit&egrave;res concernant les tarifications.
</u></h2>

<br><br>

<table id='cecodi'>
<tr>
	<td><b>Cecodi</b></td>
	<td><input type=text name='cecodi' id='cecodi' size=6></td>
</tr>
<tr>
	<td><b>Date de d&eacute;but de l'utilisation du code</b></td>
	<td><input type=date name='begda' id='begda' size=10></td>
</tr>
<tr>
	<td><b>Date de fin de l'utilisation du code</b></td>
	<td><input type=date name='endda' id='endda' size=10></td>
</tr>

</table>	
	
<center>
<a onclick="checkCriteres(this.form); checkCriteresType();">
<input type='button' value='suivant'/>
</a>
</center>


</form>

<hr>	

</body>

</html>