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

	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");

	// Fonction de connexion à la base de données
	connexion_DB('poly');

	// On fait la requête
	$champscomplet = $_GET['pseudo'];
	$champscomplet = strtolower($test->convert($champscomplet));
	
	
	$id =  "";
	$nom = "";
	$prenom = "";
	$mutuelleCode = "";
	$mutuelleNom = "";
	$ct1 = "";
	$ct2 = "";
	$tiersPayant = "";
	$type = "";
	$typeLabel = "";
	
	$sql = "SELECT p.id as patient_id, p.nom as patient_nom, p.prenom as patient_prenom, p.niss as patient_niss, p.titulaire_id as patient_titulaire_id, p.ct1 as patient_ct1, p.ct2 as patient_ct2, p.tiers_payant as patient_tiers_payant, p.mutuelle_code as patient_mutuelle_code,	c.type as ct_type, c.label as ct_label, m.nom as patient_mutuelle_nom FROM patients p, cts c, mutuelles m WHERE (p.mutuelle_code = m.code) AND (p.ct1 = c.ct1) AND (p.ct2 = c.ct2) AND p.id = p.titulaire_id AND ((lower(concat(p.nom, ' ' ,p.prenom))) regexp '$champscomplet' OR (lower(concat(p.prenom, ' ' ,p.nom))) regexp '$champscomplet')";
	
	// VERIFICATION
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)==1) {
	
		$data = mysql_fetch_assoc($result);
		
		$id =  $data['patient_id'];
		$nom = htmlentities($data['patient_nom']);
		$prenom = htmlentities($data['patient_prenom']);
		$mutuelleCode = $data['patient_mutuelle_code'];
		$mutuelleNom = htmlentities($data['patient_mutuelle_nom']);
		$ct1 = $data['patient_ct1'];
		$ct2 = $data['patient_ct2'];
		$tiersPayant = $data['patient_tiers_payant'];
		$type = $data['ct_type'];
		$typeLabel = htmlentities($data['ct_label']);
		
	}

	// Fonction de deconnexion à la base de données
	deconnexion_DB();

	$datas = array(
    'root' => array(
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'mutuelle_code' => $mutuelleCode,
        'mutuelle_nom' => $mutuelleNom,
        'ct1' => $ct1,
        'ct2' => $ct2,
        'tiers_payant' => $tiersPayant,
        'type' => $type,
        'type_label' => $typeLabel
	)
);
		
header("X-JSON: " . json_encode($datas));

?>