<?

function checkForStartLine($table, $line, $numberOfLine, $numberOfColumn){
	$nonblanco = 0;
	$line = $line - 1;
	while($nonblanco != 1 && $line < $numberOfColumn-1){
		$line = $line + 1;
		for($i=0; $i<$numberOfLine; $i++){
			if($table[$i][$line] == 'on')
				$nonblanco = 1;
		}
	}
	return($line);	
}

function generer($line, $start, $end, $table, $gardefou, $valeur, $operateur){
	
	$requete = "";
	$nb_coche = 0;	
	$res="";
	for($i=$start; $i<=$end; $i++){
		if($table[$i][$line] == 'on'){
			$tablecoche[$nb_coche] = $i;
			$nb_coche ++;
		}		
	}
	for($i=0; $i<$nb_coche; $i++){
		if($i != 0){
			$res = $res.$operateur[$tablecoche[$i]];
		}
		
		if($line == $gardefou){
			$res = $res." ( ".$valeur[$tablecoche[$i]]." ) ";
		}
		else{
			if($table[$tablecoche[$i]][$line+1] == ''){
				$res = $res." ( ".$valeur[$tablecoche[$i]]." ) ";
			}
			else{
				if($i==0){
					$res = $res." ( ".generer($line+1, $start, $tablecoche[$i], $table, $gardefou, $valeur, $operateur)." ) ";
				}
				else{
					if($i == $nb_coche-1){
						$res = $res." ( ".generer($line+1, $tablecoche[$i], $end, $table, $gardefou, $valeur, $operateur)." ) ";
					}
					else{
						$res = $res." ( ".generer($line+1, $tablecoche[$i], $tablecoche[$i+1]-1, $table, $gardefou, $valeur, $operateur)." ) ";
					}
				}
			}
		}
	}
	return($res);
}

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

$formNumberOfLines = isset($_POST['number']) ? $_POST['number'] : '0';
$numberOfLine   = $formNumberOfLines;
$numberOfColumn = $formNumberOfLines;

$Champs = "";
$Table = "";
$Champs_utilise[0] = "";
$Table_utilisee[0] = "";
$tableChckbox[0]   = "";
$tableTable[0]     = "";
$tableChamps[0]    = "";
$tableOperateur[0] = "";
$tableValeur[0]    = "";
$Champs_curseur = 0;
$Table_curseur = 0;
if($numberOfLine == 0){
	$Table     = isset($_POST["table0"])              ? $_POST["table0"]              : '';
	$Champs    = isset($_POST["champs0"])             ? $_POST["champs0"]             : '';
	$Operateur = isset($_POST["operateur0"])          ? $_POST["operateur0"]          : '';
	$Valeur    = isset($_POST["valeur0"])             ? $_POST["valeur0"]             : '';
	$Choice    = isset($_POST["valeur_ou_jointure0"]) ? $_POST["valeur_ou_jointure0"] : '';
	$Table2    = isset($_POST["table1000"])           ? $_POST["table1000"]           : '';
	$Champs2   = isset($_POST["champs1000"])          ? $_POST["champs1000"]          : '';
	if($Choice == '1'){ 
		if($Table != $Table2) $Table = $Table.', '.$Table2;
		$Valeur = $Table2.'.'.$Champs2;
	}
	else{
		if($Operateur == 'NOT IN' || $Operateur == 'IN')
			$request = "SELECT distinct patients.id FROM ".$Table." WHERE ".$Champs." ".$Operateur." "." ( '".$Valeur."' )";
		else
			$request = "SELECT distinct patients.id FROM ".$Table." WHERE ".$Champs." ".$Operateur." "."'".$Valeur."'";	
	}
}
else{
	for($i=0; $i<$numberOfLine; $i++){
		for($j=1; $j<$numberOfColumn; $j++){
			$tableChckbox[$i][$j] = isset($_POST[$i.'_'.$j]) ? $_POST[$i.'_'.$j] : '';
		}
		
		$curseur = 1000 - $i;
		
		$tableTable[$i]     = isset($_POST["table".$i])              ? $_POST["table".$i]              : '';
		$tableChamps[$i]    = isset($_POST["champs".$i])             ? $_POST["champs".$i]             : '';
		$tableOperateur[$i] = isset($_POST["operateur".$i])          ? $_POST["operateur".$i]          : '';
		$tableValeur[$i]    = isset($_POST["valeur".$i])             ? $_POST["valeur".$i]             : '';
		$tableChoice[$i]    = isset($_POST["valeur_ou_jointure".$i]) ? $_POST["valeur_ou_jointure".$i] : '';
		$tableTable2[$i]    = isset($_POST["table".$curseur])        ? $_POST["table".$curseur]        : '';
		$tableChamps2[$i]   = isset($_POST["champs".$curseur])       ? $_POST["champs".$curseur]       : '';
	
		if(!in_array($tableChamps[$i], $Champs_utilise)){
			$Champs_utilise[$Champs_curseur] = $tableChamps[$i];
			$Champs = $Champs.$tableChamps[$i].", ";
			$Champs_curseur++;
		}
		if(!in_array($tableTable[$i], $Table_utilisee)){
			$Table_utilisee[$Table_curseur] = $tableTable[$i];
			if($tableTable[$i] != 'Patients')
				$Table  = $Table.$tableTable[$i].", ";
			$Table_curseur++;
		}
		if(!in_array($tableTable2[$i], $Table_utilisee)){
			$Table_utilisee[$Table_curseur] = $tableTable2[$i];
			if($tableTable2[$i] != 'Patients')
				$Table  = $Table.$tableTable2[$i].", ";
			$Table_curseur++;
		}
	
	}
	
	$Champs = substr($Champs, 0 , strlen($Champs)-2);
	$Table  = substr($Table, 0, strlen($Table)-2);
	
	for($i=1; $i<$numberOfLine; $i++){
		$tableCombinaison[$i] = isset($_POST["combinaison".$i])    ? $_POST["combinaison".$i]    : '';
	}
	
	for($i=0; $i<$numberOfLine; $i++){
		if($tableChamps2[$i] != ''){
			$valeur[$i] = $tableTable[$i].".".$tableChamps[$i]." ".$tableOperateur[$i]." ".$tableTable2[$i].".".$tableChamps2[$i];
		}
		else{
			if($tableOperateur[$i] == 'NOT IN' || $tableOperateur[$i] == 'IN')
				$valeur[$i] = $tableTable[$i].".".$tableChamps[$i]." ".$tableOperateur[$i]." ( '".$tableValeur[$i]."' )";
			else
				$valeur[$i] = $tableTable[$i].".".$tableChamps[$i]." ".$tableOperateur[$i]." '".$tableValeur[$i]."'";	
		}	 
	}
	
	

	$line = checkForStartLine($tableChckbox, 1, $numberOfLine, $numberOfColumn);
	$request = generer($line, 0, $numberOfLine-1, $tableChckbox, $numberOfLine - 1, $valeur, $tableCombinaison);
	
	if($request == "")
		$request = "SELECT distinct patients.id FROM ".$Table;
	else
		$request = "SELECT distinct patients.id FROM ".$Table." WHERE ".$request;
			
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<title>Requ&egrave;te g&eacute;n&eacute;r&eacute;e</title>

<head>

<script type="text/javascript" src="../js/bd_recherche_champs.js"></script>
<script type="text/javascript" src='../js/common.js'></script>
<script type="text/javascript" src="../scriptaculous/lib/prototype.js"></script>
<script type="text/javascript" src='../js/inputControl.js'></script>
<script type="text/javascript" src='../js/autosuggest.js'></script>
<script type="text/javascript" src='../js/suggestions.js'></script>
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

<h1>Etape 2: Choix des crit&egrave;res</h1>

<fieldset class=''>
	<legend>Aide</legend>
	Ce formulaire permet de cr&eacute;er des crit&egrave;res de s&eacute;lection de population pour vos motifs.<br>
	Cette &eacute;tape consiste à &eacute;tablir les r&egrave;gles de filtrage.<br>
	S&eacute;lectionnez les attributs des tables choisies, assignez les valeurs et couplez les crit&egrave;res de mani&egrave;re exclusive (ET) ou comme alternative (OU); les couples de crit&egrave;res pouvant &eacute;galement &ecirc;tre coupl&eacute; entre eux et ainsi de suite. 
</fieldset>

<br><br><br>

<h3>Utiliser les cri&egrave;res de s&eacute;lection suivants:</h3>

<?
//utilisation de 0000-00-00 pour la date du jour
$date_jour = date("Y-m-d");
$request_bis = $request;
for($i=0; $i<strlen($request_bis); $i++){
			if($request_bis[$i] == 0 && $request_bis[$i+4] == '-' && $request_bis[$i+7] == '-'){
				$annee_en_cours = date("Y");
				$annee_calculee = substr($request_bis, $i, 4);
				
				$mois_en_cours = date("m");
				$mois_calculee = substr($request_bis, $i+5, 2);
				
				$jour_en_cours = date("d");
				$jour_calculee = substr($request_bis, $i+8, 2);
				
				$annee     = $annee_en_cours - $annee_calculee;
				$mois      = $mois_en_cours  - $mois_calculee;
				$jour      = $jour_en_cours  - $jour_calculee;
				
				if(strlen($mois) == 1){
					$mois = '0'.$mois; 
				}
				
				if(strlen($jour) == 1){
					$jour = '0'.$jour; 
				}
				
				$request_bis = substr_replace($request_bis, $annee, $i,   4);
				$request_bis = substr_replace($request_bis, $mois,  $i+5, 2);
				$request_bis = substr_replace($request_bis, $jour,  $i+8, 2);
				
			}
		}
//$requete_bis = str_replace('0000-00-00', $date_jour, $request);
$result = requete_SQL ($request_bis);

if(mysql_num_rows($result)!=0) {
	
	echo "<table border='0' cellpadding='2' cellspacing='1'>";
	
		echo"<tr>";
		echo"<th>Id</th>";
		echo"<th>Nom</th>";
		echo"<th>Pr&eacute;nom</th>";
		echo"<th>Rue</th>";
		echo"<th>Code postal</th>";
		echo"<th>Commune</th>";
		echo"<th>T&eacute;l&eacute;phone</th>";
		echo"<th>GSM</th>";
		echo"</tr>";
	
	while($patient = mysql_fetch_row($result)){
			$req_infoPatient = "select id, nom, prenom, rue, code_postal, commune, telephone, gsm from patients WHERE id = '".$patient[0]."'";
			$res_infoPatient = requete_SQL ($req_infoPatient);
	
		
		while($row = mysql_fetch_row($res_infoPatient)){
			echo"<tr>";
				for($j=0; $j<mysql_num_fields($res_infoPatient); $j++)
					echo"<td>".$row[$j]."</td>";
			echo"</tr>";
		}
	}	
		
	echo "</table>";
}
?>

<h3>La requete ex&eacute;cut&eacute;e est:</h3>
<?echo"<br>".$request;?>
<br>

<input type="HIDDEN" id="request_value" name="request_value" value="<?=$request?>">

<br><br><br>
<center><input type='button' value='Confirmer' onclick='opener.document.creer_motif.requete.value = document.getElementById("request_value").value;self.close();'></center>

</body>

</html>