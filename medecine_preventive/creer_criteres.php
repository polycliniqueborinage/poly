<??>

<html>

<title>Cr&eacute;ation de crit&egrave;res</title>


<head>

<script language="JavaScript" type="text/JavaScript">
	function affiche(action, bulle){
		var voir;
		var display;
		if (action == "cache"){
			voir = "hidden";
			display = "none";
		}
		else {
			voir = "visible";
			display = "block";
		}
		//document.getElementById("main_bulle").innerHTML = document.getElementById(bulle).innerHTML;
		document.getElementById(bulle).style.visibility = voir;
		document.getElementById(bulle).style.display = display;
	}
	
	function hide(bulle){
		document.getElementById(bulle).style.display = 'none';
	}

</script>

</head> 


<body>

<h1>Etape 1: Choix des tables</h1>

<fieldset class=''>
	<legend>Aide</legend>
	Ce formulaire permet de cr&eacute;er des crit&egrave;res de s&eacute;lection de population pour vos motifs.<br>
	Cette &eacute;tape consiste &agrave; s&eacute;lectionner les donn&eacute;es pour &eacute;tablir les r&egrave;gles.<br>
</fieldset>

<br><br><br>

<h3>Utiliser les tables suivantes pour les cri&egrave;res de s&eacute;lection:</h3>

<form action="creer_criteres_part2.php" method="post">

<table>
<tr><td><input type=checkbox id="patients"      name="patients">     </td>
	<td>Patients</td>
	<td></td><td></td><td></td><td></td>
	<td><a onclick="affiche('', 'bulle_patients')">D&eacute;tails</a></td>
	<td></td><td></td><td></td><td></td>
	<td><hr>
		<div id="bulle_patients" style="display: none;">
			<legend><h3>"Patients" contient</h3></legend>
			
			Le nom - pr&eacute;nom      <br>
			L'&aring;ge                 <br>
			Le sexe                     <br>
			Les informations de contacts<br>
			Les donn&eacute;es mutuelles<br>
			<font align=right><a onclick='hide("bulle_patients");'><img src='../images/16x16/cog_delete.png' alt='Fermer les d&eacute;tails' title='Fermer les d&eacute;tails' border='0'/></a></font>
		</div>
		</hr></td></tr>
	
<tr><td><input type=checkbox id="medecins"      name="medecins">     </td>
	<td>M&eacute;decins</td>
	<td></td><td></td><td></td><td></td>
	<td><a onclick="affiche('', 'bulle_medecins')">D&eacute;tails</a></td>
	<td></td><td></td><td></td><td></td>
	<td><hr>
		<div id="bulle_medecins" style="display: none;">
			<legend><h3>"M&eacute;decins" contient</h3></legend>
			
			Le nom - pr&eacute;nom             <br>
			La sp&eatute;cialit&eacute;        <br>
			Le code INAMI                      <br>
			Les informations de contacts       <br>
			Les taux d'activit&eacute;         <br>
			<font align=right><a onclick='hide("bulle_medecins");'><img src='../images/16x16/cog_delete.png' alt='Fermer les d&eacute;tails' title='Fermer les d&eacute;tails' border='0'/></a></font>
		</div>
		</hr></td></tr>
	
<tr><td><input type=checkbox id="visites"       name="visites">      </td>
	<td>Mutualit&eacute;s</td>
	<td></td><td></td><td></td><td></td>
	<td><a onclick="affiche('', 'bulle_mutualites')">D&eacute;tails</a></td>
	<td></td><td></td><td></td><td></td>
	<td><hr>
		<div id="bulle_mutualites" style="display: none;">
			<legend><h3>"Mutualit&eacute;s" contient</h3></legend>
			
			Le nom de la mutualit&eacute;      			<br>
			Le code mutuelle                   			<br>
			Le num&eacute;ro de t&eacute;l&eacute;phone <br>
			Le contact                        			<br>
			<font align=right><a onclick='hide("bulle_mutualites");'><img src='../images/16x16/cog_delete.png' alt='Fermer les d&eacute;tails' title='Fermer les d&eacute;tails' border='0'/></a></font>
		</div>
		</hr></td></tr>
	
<tr><td><input type=checkbox id="tarifications" name="tarifications" onclick="if(document.getElementById('tarifications').checked==true) document.getElementById('tarifications_detail').checked=true;"></td><td>Tarifications </td>
	<td></td><td></td><td></td><td></td>
	<td><a onclick="affiche('', 'bulle_tarifications')">D&eacute;tails</a></td>
	<td></td><td></td><td></td><td></td>
	<td><hr>
		<div id="bulle_tarifications" style="display: none;">
			<legend><h3>"Tarifications" contient</h3></legend>
			
			Qui &eacute;tait &agrave; la caisse <br>
			Le patient concern&eacute;          <br>
			Les codes CT1-CT2                   <br>
			Le statut des transactions          <br>
			Le solde pay&eacute;                <br>
			Le solde restant d&ucirc;           <br>
			<font align=right><a onclick='hide("bulle_tarifications");'><img src='../images/16x16/cog_delete.png' alt='Fermer les d&eacute;tails' title='Fermer les d&eacute;tails' border='0'/></a></font>
		</div>
		</hr></td></tr>
		
<tr><td><input type=checkbox id="tarifications_detail" name="tarifications_detail" onclick="if(document.getElementById('tarifications_detail').checked==true) document.getElementById('tarifications').checked=true;"></td><td>Tarifications d&eacute;tails</td>
	<td></td><td></td><td></td><td></td>
	<td><a onclick="affiche('', 'bulle_tarifications_detail')">D&eacute;tails</a></td>
	<td></td><td></td><td></td><td></td>
	<td><hr>
		<div id="bulle_tarifications_detail" style="display: none;">
			<legend><h3>"Tarifications d&eacute;tails" contient</h3></legend>
			
			L'id des tarifications                         <br>
			Le code cecodi utilis&eacute par tarification  <br>
			La propri&eacute;t&eacute; d'une tarification  <br>
			Les diff&eacute;rents types de co&ucirc;ts     <br>
			<font align=right><a onclick='hide("bulle_tarifications_detail");'><img src='../images/16x16/cog_delete.png' alt='Fermer les d&eacute;tails' title='Fermer les d&eacute;tails' border='0'/></a></font>
		</div>
		</hr></td></tr>		
</table>

<input type="submit" value="suivant">

</form>

</body>

</html>