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

	$sessCaisseDate = $_SESSION['caisse_date'];
	$sessCaisseLogin = $_SESSION['caisse_login'];
	$sessLogin = $_SESSION['login'];
	$sessRole = $_SESSION['role'];
	
	$cecodi = "";
        
	connexion_DB('poly');
	
	// consctruction du dico
	$sql = "SELECT * FROM caisse_code";
	$dicoGroupe = array();
	$result = requete_SQL ($sql);
	if(mysql_num_rows($result)>0) {
		while($data = mysql_fetch_assoc($result))	{
			$label = $data['type']."*".$data['code'];
			$valeur = $data['code_couleur'];
			$dicoGroupe[$label] = $valeur;
		}
	}
	
	// cecodi
	$sql = "SELECT id, caisse, date, code, description, montant, mode, heure, compte FROM caisses_transaction WHERE ( date = '$sessCaisseDate' AND caisse='$sessCaisseLogin' AND code != '5000') order by heure desc";
	$result = requete_SQL ($sql);
										
	if(mysql_num_rows($result)>0) {

		$cecodi.= "<table border='0' cellpadding='2' cellspacing='1'>";
		$cecodi.= "<th></th>";
		$cecodi.= "<th>Caisse</th>";
		$cecodi.= "<th>Date</th>";
		$cecodi.= "<th>Heure</th>";
		$cecodi.= "<th>Code</th>";
		$cecodi.= "<th>Mode</th>";
		$cecodi.= "<th>Compte</th>";
		$cecodi.= "<th>Description</th>";
		$cecodi.= "<th>Montant</th>";
		
		while($data = mysql_fetch_assoc($result))	{
			
			if ($data['montant'] > 0) {$color="008000";} else {$color="FF0000";}
			try {
				if ($data['montant'] > 0) {$label = "1*".$data['code'];} else {$label = "-1*".$data['code'];}
				$color = $dicoGroupe[$label];
			} catch(Exception $e) {}
		
			$cecodi.= "<tr>";
			$cecodi.= "<td>";
			if ($sessRole=='Administrateur') {
				$cecodi.= "<a href='#' onClick='javascript:submitForm(".$data['id'].",\"\",\"\");return false;' >";
				$cecodi.= "<img width='16' height='16' src='../images/delete_small.gif' alt='Effacer' title='Effacer' border='0' /></a>";
			}
			$cecodi.= "</td>";

			$cecodi.= "<td>".$data['caisse']."</td>";

			$datetools = new dateTools($data['date'],$data['date']);
			$temp = $datetools->transformDATE();
			$cecodi.= "<td>".$temp."</td>";
				
			$cecodi.= "<td>".$data['heure']."</td>";

			$cecodi.= "<td>".$data['code']."</td>";

			$cecodi.= "<td>".$data['mode']."</td>";

			$cecodi.= "<td>".$data['compte']."</td>";
			
			$cecodi.= "<td>".$data['description']."</td>";
			//$cecodi.= "<td>".$label.$color."</td>";
			
			$cecodi.= "<td>";
			$cecodi.="<font color='#".$color."' size='+1'>".$data['montant']."</font>";
			$cecodi.= "</td>";

			$cecodi.= "</tr>";

		}

		$cecodi.= "</table>";

	}
	
	echo $cecodi;
?>										