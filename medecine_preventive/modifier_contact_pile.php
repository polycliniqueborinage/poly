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

$formIdPatient = isset($_GET['id_patient']) ? $_GET['id_patient'] : '';
$formIdMotif   = isset($_GET['id_motif'])   ? $_GET['id_motif']   : '';

$r_patient = "SELECT * FROM patients            WHERE id         = '".$formIdPatient."'";
$r_motif   = "SELECT * FROM medecine_preventive WHERE motif_ID   = '".$formIdMotif."'";
$r_pile    = "SELECT * FROM mp_pile             WHERE id_patient = '".$formIdPatient."' AND id_motif = '".$formIdMotif."'";

$res_patient = requete_SQL($r_patient);
$res_motif   = requete_SQL($r_motif);
$res_pile    = requete_SQL($r_pile);

$patient = mysql_fetch_assoc($res_patient);
$motif   = mysql_fetch_assoc($res_motif);
$pile    = mysql_fetch_assoc($res_pile);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<title>D&eacute;tails du contact &agrave; prendre</title>

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

<table width='100%'>
<tr>
<th>Informations concernant le patient</th>
<th>Informations concernant le motif de m&eacute;decine pr&eacute;ventive</th>
</tr>
</table>

<table id='tab_patient' width='50%' align=left>

<tr>
<td>Nom</td>
<td><?echo $patient['nom'];?></td>
</tr>

<tr>
<td>Pr&eacute;nom</td>
<td><?echo $patient['prenom'];?></td>
</tr>

<tr>
<td>Date de naissance</td>
<td><?echo substr($patient['date_naissance'], 8, 2).".".substr($patient['date_naissance'], 5, 2).".".substr($patient['date_naissance'], 0, 4);?></td>
</tr>

<tr>
<td>Adresse</td>
<td><?echo $patient['rue']."<br>".$patient['code_postal'].", ".$patient['commune'];?></td>
</tr>

<tr>
<td>T&eacute;l&eacute;phone</td>
<td><?echo $patient['telephone'];?></td>
</tr>

<tr>
<td>GSM</td>
<td><?echo $patient['gsm'];?></td>
</tr>

<tr>
<td>E-mail</td>
<td><?echo $patient['mail'];?></td>
</tr>

<?
$r_titulaire   = "SELECT * FROM patients WHERE id = ".$patient['titulaire_id'];
$res_titulaire = requete_SQL($r_titulaire);

$titulaire = mysql_fetch_assoc($res_titulaire);
?>

<tr>
<td>Titulaire</td>
<td><?echo $titulaire['prenom']." ".$titulaire['nom'];?></td>
</tr>

</table>

<table id='tab_motif' width='50%' align=right>

<tr>
<td>Motif</td>
<td><?echo $motif['description'];?></td>
</tr>

<tr>
<td>R&eacute;currence</td>
<td><?echo $motif['recurrence'];?></td>
</tr>

<tr>
<td>Texte de la lettre</td>
<td><?echo $motif['texte_principal'];?></td>
</tr>

</table>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<table align=center>

<tr>

<td>
<input type=datum id='date' value="<?=$pile['date_derniere_modification']?>">
</td>

<td>
<select id=statut>
<?

	$a_contacter = '';
	$contacte    = '';
	$rdv_pris    = '';
	$a_rappeler  = '';
	$termine     = '';
	
	switch($pile['statut']){
		case 'a_contacter':
			$a_contacter = 'SELECTED';
			break;
		case 'contacte':
			$contacte    = 'SELECTED';
			break;
		case 'rdv_pris':
			$rdv_pris    = 'SELECTED';
			break;
		case 'a_rappeler':
			$a_rappeler  = 'SELECTED';
			break;
		case 'termine':
			$a_contacter = 'SELECTED';
			break;		
		default:
			$a_contacter = 'SELECTED';
			break;			
	}
	
		echo"<option value='a_contacter'".$a_contacter.">A contacter     </option>";
		echo"<option value='contacte'   ".$contacte."   >Contact&eacute; </option>";
		echo"<option value='rdv_pris'   ".$rdv_pris."   >Rendez-vous pris</option>";
		echo"<option value='a_rappeler' ".$a_rappeler." >A rappeler      </option>";
		echo"<option value='termine'    ".$termine."    >Termin&eacute;  </option>";

?>
</select>
</td>

</tr>
	
</table>

<br><br><br>

<table align=center>
<tr><td>
<input type=button value="Imprimer la lettre pour l'envoyer" onclick=window.open('./imprimer_lettre.php?motif0=<?=$formIdMotif?>&patient0=<?=$formIdPatient?>&nb=1');>
</td></tr>
</table>

<br><br><br>

<table align=center>
<tr>
<td align=center width='50%'><input type=button value="Aucun changement" onclick="self.close();"></td>
<?
$opener_date   = "opener.document.updateListe.date_".$pile['id_motif']."_".$pile['id_patient'].".value";
$opener_statut = "opener.document.updateListe.statut_".$pile['id_motif']."_".$pile['id_patient'].".value";
?>
<td align=center width='50%'>
	<input type=button value="Des changements ont &eacute;t&eacute; effectu&eacute;s" onclick="if(checkChangementEntree(document.getElementById('statut'), '<?=$pile['statut']?>') == 1) { assignValeurRetour( '<?=$opener_date?>', document.getElementById('date').value); self.close(); }"></td>
</tr>
<table>


</body>

</html>