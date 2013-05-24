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
	
	//vider la redirection
	unset($_SESSION['redirect']);
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	include_once '../libphp/fpdf.php';
	
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "imprimer_lettre.php";
	
	$formNbLettres = isset($_GET['nb']) ? $_GET['nb'] : '';
	
	for($i = 0; $i < $formNbLettres; $i++){
		$id_patient = isset($_GET["patient".$i]) ? $_GET["patient".$i] : '';
		$id_motif   = isset($_GET["motif".$i])   ? $_GET["motif".$i]   : '';
		
		$requete_patient = "SELECT * FROM patients            WHERE id       = ".$id_patient;
		$requete_motif   = "SELECT * FROM medecine_preventive WHERE motif_ID = ".$id_motif;
		
		$res_patient = requete_SQL($requete_patient);
		$res_motif   = requete_SQL($requete_motif);
		
		$patient = mysql_fetch_assoc($res_patient);
		$motif   = mysql_fetch_assoc($res_motif);
	
		
		if($patient['sexe'] == 'M')
			$prefixe = 'Monsieur';
		else
			$prefixe = 'Madame';	
		 

	    $headers ='From: "'.$motif['nom_expediteur'].'"<'.$motif['mail_expediteur'].'>'."\n";
	    $headers .='Reply-To: '.$motif['mail_reply']."\n";
	    $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
	    $headers .='Content-Transfer-Encoding: 8bit';
	
		$message = '';
		$message .= '<html>';
		
		$message .= '<body>';
		$message .= '<img src="../images/entete_lettre.png"><br><br><br><br>';
		$message .= '<table ALIGN = RIGHT>';
		$message .= '<tr><td>'.$motif['nom_expediteur'].'</td></tr>';
		$message .= '<tr><td>'.$motif['adr_exp_ligne1'].'</td></tr>';
		$message .= '<tr><td>'.$motif['adr_exp_ligne2'].'</td></tr>';
		
		$message .= '</table>';
		
		$message .= '<BR><BR><BR><BR><BR><BR><BR>';
		
		$message .= $prefixe.' '.$patient['nom'].',';
		
		$message .= '<BR>';
		
		$message .= str_replace('&#039;', '\'', $motif['texte_principal']);
		
		$message .= '<BR><BR><BR>';
		
		$message .= $motif['signature'];
		
		$message .= '</body>';
		
		$message .= '</html>';
	
	    mail($patient['mail'], 'Mdecine prventive: '.$motif['description'], $message, $headers);
		 
	} 	

	deconnexion_DB();
	die();

?>

<html>
<body onload="self.close();">
</body>
</html>