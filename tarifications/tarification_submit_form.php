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
	include_once '../lib/calcul_honoraire.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';

	// Fonction de connexion a la base de donnees
	connexion_DB('poly');
	
	$content = "";
    $dataAPayer ="";
    $dataPaye = ""; 
    $dataRestePayer = ""; 
		
	$sessTarificationID = $_SESSION['tarification_id'];
	$sessTarificationPatientType = $_SESSION['tarification_type'];
	$sessTarificationPatientChildren = $_SESSION['tarification_children'];
	$sessTarificationPatientSexe = $_SESSION['tarification_sex'];
	$sessTarificationPatientAge = $_SESSION['tarification_age'];
	$sessMedecinTauxConsul = $_SESSION['taux_consultation'];
	$sessMedecinTauxActe = $_SESSION['taux_acte'];
	$sessCaisse = $_SESSION['login'];
	
	$formCecodi = isset($_GET['cecodi_input']) ? $_GET['cecodi_input'] : '';
	$formCecodiNumber = isset($_GET['cecodi_number']) ? $_GET['cecodi_number'] : '';
	$formCecodiCheck = isset($_GET['cecodi_input_check']) ? $_GET['cecodi_input_check'] : '';
	$formActe = isset($_GET['acte_input']) ? $_GET['acte_input'] : '';
	$formActeNumber = isset($_GET['acte_number']) ? $_GET['acte_number'] : '';
	$formDelCecodi = isset($_GET['del_cecodi']) ? $_GET['del_cecodi'] : '';
	
	// Si prestation INAMI
	if ($formDelCecodi != '') {
		$sql = "Select cecodi, caisse FROM tarifications_detail WHERE ( id = $formDelCecodi) LIMIT 1";
		$result = requete_SQL ($sql);
		$data = mysql_fetch_assoc($result);
		if ($data['cecodi']=='0') {$temp = "Acte interne";} else {$temp = $data['cecodi'];}
		$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." supprime une prestation (".$temp." - ".$data['caisse']." euro)</b><br/><br/>";
		$sql = "DELETE FROM tarifications_detail WHERE ( id = '$formDelCecodi') LIMIT 1";
		$result = requete_SQL ($sql);
	}
	
	// Si prestation INAMI
	if (strlen($formCecodi) == 6) {

		$sql = "SELECT cecodi, propriete, description, kdb, bc, hono_travailleur, a_vipo, b_tiers_payant, classe, prix_vp, prix_tp, prix_tr, age, tpfortr FROM cecodis2 WHERE ( cecodi = '$formCecodi') AND ( age like '%|$sessTarificationPatientAge|%' ) order by id Desc";
		
		// VERIFICATION
		$result = requete_SQL ($sql);
	
		if(mysql_num_rows($result)!=0) {
			
			if ($formCecodiNumber > 1) {
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute $formCecodiNumber prestations ($formCecodi)</b><br/>";
			} else {
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute une prestation ($formCecodi)</b><br/>";
			}
			
			$data = mysql_fetch_assoc($result);
		
			// variables from DB
			$test = new testTools("info");
			$dataCecodi = $data['cecodi'];
			$dataPropriete = $data['propriete'];
			$dataDescription = $data['description'];
			$dataDescription = $test->convert($dataDescription);
			$dataKdb = $data['kdb'];
			$dataBc = $data['bc'];
			$dataHono = $data['hono_travailleur'];
			$dataA= $data['a_vipo'];
			$dataB = $data['b_tiers_payant'];
			$dataPrixVP = $data['prix_vp'];
			$dataPrixTP = $data['prix_tp'];
			$dataPrixTR = $data['prix_tr'];
			$dataTpfortr = $data['tpfortr'];
			
			/*
			$content .= "Propri&eacute;t&eacute; :".$dataPropriete."<br/>";
			if ($dataPropriete =='acte') {
				$content .= "Kdb :".$dataKdb."<br/>";
				$content .= "BC :".$dataBc."<br/>";
			} else {
				$content .= "Honoraire : ".$dataHono."<br/>";
				$content .= "Intervention b&eacute;n&eacute;ficiaires avec r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataA."<br/>";
				$content .= "Intervention b&eacute;n&eacute;ficiaires sans r&eacute;gime pr&eacute;f&eacute;rentiel : ".$dataB."<br/>";
			}
			*/
				
			// SPECIAL POLYCLINIQUE BORINAGE --> take bc in place of kdb to calculate the cost
			if ($formCecodiCheck == 'true' && $dataPropriete =='acte') {				
				$dataDescription = "Err. Med. ".$dataDescription;
				$dataKdb = $data['bc'];
				$infoCalcul = "cout = bc";
				$content .= "<b>Code INAMI non signal&eacute; par le m&eacute;decin</b><br/>";
 			}

 			
 			// Accorder le tp pour le tr dans le cadre d'une consultation
 			if ($dataTpfortr == 'checked' && $sessTarificationPatientType =='tr') {			
				$content .= "<b>Accorder le tiers payant pour le travailleur</b><br/>";
				$sessTarificationPatientType = 'tp';
 			}
			
			// Calcul Honoraire officielle
			$dataCout = calcul_cout($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
			$content .= "Honoraire officielle : ".$dataCout."<br/>";
			
			// Calcul Honoraire caisse
			$dataCaise = calcul_caisse($sessTarificationPatientType,$dataCout,$dataPrixVP,$dataPrixTP,$dataPrixTR);
			$content .= "Honoraire caisse : ".$dataCaise."<br/>";
			
			// SPECIAL POLYCLINIQUE BORINAGE --> take bc in place of kdb to calculate the cost
			if ($formCecodiCheck == 'true' && $dataPropriete =='acte') {				
				$dataCaise = 0;
 			}
			
			// Calcul Honoraire mutuelle
			$dataMutuelle = calcul_mutuelle($sessTarificationPatientType,$dataPropriete,$dataKdb,$dataBc,$dataHono,$dataA,$dataB);
			$content .= "Remboursement mutuelle : ".round(($dataMutuelle-$dataCout),2)."<br/>";
			
			// Calcul Honoraire medecin
			$dataCoutMedecin = calcul_cout_medecin($dataPropriete,$dataKdb,$dataHono,$sessMedecinTauxActe,$sessMedecinTauxConsul);
			$content .= "Revenu m&eacute;decin : ".$dataCoutMedecin."<br/>";
			
			// Calcul Honoraire poly
			$dataCoutPoly = calcul_cout_poly($dataPropriete,$formPatientType,$dataKdb,$dataHono,$dataCout,$dataCoutMedecin);
			$content .= "Revenu polyclinique : ".$dataCoutPoly."<br/><br/>";
			
			// SPECIAL POLYCLINIQUE BORINAGE --> take bc in place of kdb to calculate the cost
			$dataKdb = $data['kdb'];
				
			// Ajout dans la DB
			for($c=0;$c<$formCecodiNumber;$c++) {
				$q = requete_SQL ("INSERT INTO tarifications_detail ( tarification_id , cecodi , propriete, description, kdb , bc , hono_travailleur , a_vipo , b_tiers_payant, cout, cout_medecin, cout_poly, cout_mutuelle, caisse)
				VALUES ('$sessTarificationID', '$dataCecodi', '$dataPropriete', '$dataDescription', '$dataKdb', '$dataBc', '$dataHono', '$dataA' , '$dataB', '$dataCout', '$dataCoutMedecin', '$dataCoutPoly', '$dataMutuelle', '$dataCaise')");
				
				// SPECIAL POLYCLINIQUE BORINAGE --> take bc in place of kdb to calculate the cost
				if ($formCecodiCheck == 'true' && $dataPropriete =='acte') {			
					$q = requete_SQL ("INSERT INTO erreurs (tarification_id, type, a_payer, caisse) VALUES ('$sessTarificationID', 'erreur_commune', '".round($dataKdb-$dataBc,2)."','$sessCaisse')");
				}
			
			}
			
			
		}
		else {
			$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." essaie un code inexistant ($formCecodi)</b><br/><br/>";
		}			
	}
		
		
	if ($formActe != "0") {
		
		$sql = "SELECT * FROM actes WHERE ( id = '$formActe')";
		
		$result = requete_SQL ($sql);
		
		if(mysql_num_rows($result)!=0) {
			
			if ($formActeNumber > 1) {
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute $formActeNumber actes internes</b><br/><br/>";
			} else {
				$content .= "<b>Le ".date('d.m.y')." &agrave; ".date('h:i:s A')." ".$sessCaisse." ajoute un acte interne</b><br/><br/>";
			}
			
			$data = mysql_fetch_assoc($result);
			
			$dataActe = $data['code']." ".$data['description']." ".$data['cecodis'];
			$dataCoutTR = $data['cout_tr'];
			$dataCoutTP = $data['cout_tp'];
			$dataCoutVP = $data['cout_vp'];
			$dataCoutSM = $data['cout_sm'];
			
			switch($sessTarificationPatientType) {
				
				case "vp" :
					$dataCout = $dataCoutVP;
					break;
				case "as" :
					$dataCout = $dataCoutSM;
					break;
				case "tr" :
					$dataCout = $dataCoutTR;
					break;
				case "tp" :
					$dataCout = $dataCoutTP;
					break;
				case "sm" :
					$dataCout = $dataCoutSM;
					break;
				default :
					$dataCout = $dataCoutTP;
				break;
			}
			
			// BUG MSQL
			$dataCout = round($dataCout,2);
		
			// Ajout dans la DB
			for($c=0;$c<$formActeNumber;$c++) {
				$sql = "INSERT INTO tarifications_detail ( tarification_id , cecodi , propriete, description, kdb , bc , hono_travailleur , a_vipo , b_tiers_payant, cout, cout_medecin, cout_poly, cout_mutuelle, caisse) VALUES ('$sessTarificationID', '0', 'prepay', '$dataActe', '', '', '', '' , '', '', '', '','', '$dataCout')";
				$q = requete_SQL ($sql);
			}

		} else {
				
		}

	}
	
	
	// UPDATE STATUS
	$sql = "SELECT distinct propriete FROM tarifications_detail WHERE ( tarification_id = $sessTarificationID)";
	$etat = requete_SQL ($sql);
	$labelEtat = 'start';
	while($data = mysql_fetch_assoc($etat)) 	{
		$labelEtat .= $data['propriete'];
		//$labelEtat = remo
	}
	$sql = "UPDATE tarifications set etat ='$labelEtat' WHERE ( id = '$sessTarificationID') AND (etat !='close')";
	$setetat = requete_SQL ($sql);
	
	if($labelEtat != 'start' && $labelEtat != 'close'){
	//bmarique - add send file pour tarification-numerisation
	$sqlTarif = "SELECT * FROM tarifications where id = '$sessTarificationID'";
	$resultTarif = requete_SQL ($sqlTarif);
	$dataTarif = mysql_fetch_assoc($resultTarif);
	$dataPatientTarifId    = $dataTarif['patient_id'];
	$dataMedecinTarifInami = $dataTarif['medecin_inami'];
	$sqlMedecin    = "SELECT * FROM medecins where inami = '$dataMedecinTarifInami'";
	$resultMedecin = requete_SQL ($sqlMedecin);
	$dataMedecin   = mysql_fetch_assoc($resultMedecin);
	$dataMedecinNom    = $dataMedecin['nom'];
	$dataMedecinPrenom = $dataMedecin['prenom'];
	
	$sql = "SELECT p.nom as patient_nom, p.prenom as patient_prenom, DATE_FORMAT(p.date_naissance, GET_FORMAT(DATE, 'EUR')) as patient_date_naissance, p.date_naissance as patient_date_naissance_standart, p.sexe as patient_sexe, p.rue as patient_rue, p.code_postal as patient_code_postal, p.commune as patient_commune, p.nationnalite as patient_nationnalite, p.telephone as patient_telephone, p.gsm as patient_gsm, p.mail as patient_mail, p.mutuelle_code as patient_mutuelle_code, p.mutuelle_matricule as patient_matricule, p.sis as patient_sis, p.ct1 as patient_ct1, p.ct2 as patient_ct2, p.tiers_payant as patient_tiers_payant, p.niss as patient_niss, p.titulaire_id as patient_titulaire_id, p.prescripteur as patient_prescipteur, t.nom as patient_titulaire_nom, t.prenom as patient_titulaire_prenom, t.mutuelle_matricule as patient_titulaire_matricule FROM patients p, patients t WHERE p.id ='$dataPatientTarifId' and p.titulaire_id=t.id";
		
	$result = requete_SQL ($sql);
			
	// On trouve un patient
	if(mysql_num_rows($result)>=1) {
			
		$data = mysql_fetch_assoc($result);
			
		$dataPatientTitulaireID= $data['patient_titulaire_id'];
		$dataPatientTitulaireNom= $data['patient_titulaire_nom'];
		$dataPatientTitulairePrenom= $data['patient_titulaire_prenom'];
		$dataPatientTitulaireMatricule= $data['patient_titulaire_matricule'];
		$dataPatientNom = $data['patient_nom'];
		$dataPatientPrenom = $data['patient_prenom']; 
		$dataPatientDateNaissance = $data['patient_date_naissance'];
		$dataPatientRue = $data['patient_rue'];
		$dataPatientCodePostal = $data['patient_code_postal'];
		$dataPatientCommune = $data['patient_commune'];
		$dataPatientNiss = $data['patient_niss'];
		$dataPatientSis = $data['patient_sis'];
		$dataPatientMatricule = $data['patient_matricule'];
		$dataPatientCt1 = $data['patient_ct1'];
		$dataPatientCt2 = $data['patient_ct2'];
		$dataPatientTiersPayant = $data['patient_tiers_payant'];
		$dataPatientMutuelleCode = $data['patient_mutuelle_code'];
		$dataPatientPrescripteur = $data['patient_prescipteur'];
		$dataPatientSexe = $data['patient_sexe'];
		$datetools = str_replace('-', '', $data['patient_date_naissance_standart']);
		//$datetools = $data['patient_date_naissance_standart'];
		//$dataPatientAge = $datetools->getAge();

		$share_location = "../files2transfer/";

		if ($formActe != "0"){
		
		$code_exam = $sessTarificationID;
		$File = $share_location.$code_exam.".txt";
		//$File = $code_exam.".txt";
		$Handle = fopen($File, 'w+');
		if($Handle == false){ } else{ 
		//Header data
		$DataFile = "[MESSAGE]\n"; 
		fwrite($Handle, $DataFile);
		$DataFile = "Type=Add\n"; 
		fwrite($Handle, $DataFile); 

		//Patient data
		$DataFile = "[DicomData]\n"; 
		fwrite($Handle, $DataFile);

		$DataFile = "(0008,0050)=".$code_exam."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0008,0060)=CR\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0008,0080)=La Polyclinique du Borinage\n"; 
		fwrite($Handle, $DataFile); 

		$DataFile = "(0008,0090)=".$dataPatientTitulaireNom."^".$dataPatientTitulairePrenom."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0010,0010)=".$dataPatientNom."^".$dataPatientPrenom."\n"; 
		fwrite($Handle, $DataFile);
		$DataFile = "(0010,0020)=".$dataPatientNiss."\n";
		fwrite($Handle, $DataFile); 
		$DataFile = "(0010,0030)=".$datetools."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0010,0040)=".$dataPatientSexe."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0032,1032)=".$dataPatientTitulaireNom."^".$dataPatientTitulairePrenom."\n"; 
		fwrite($Handle, $DataFile);
		$DataFile = "(0032,1033)=Dr ".$dataMedecinNom."\n"; 
		fwrite($Handle, $DataFile); 
		
		if ($formActe != "0"){
		
			$sqlActe = "SELECT * FROM actes WHERE ( id = '$formActe')";
			
			$resultActe = requete_SQL ($sqlActe);
			$dataActe = mysql_fetch_assoc($resultActe);
			$dataCodeActe = $dataActe['code'];
			$dataDescActe = $dataActe['description'];
		}
		$DataFile = "(0032,1060)=".$dataCodeActe."-".$dataDescActe."\n"; 
		fwrite($Handle, $DataFile);
		$day = date("Ymd");
		$DataFile = "(0040,0002)=".$day."\n"; 
		fwrite($Handle, $DataFile);
		$time = date("His"); 
		$DataFile = "(0040,0003)=".$time."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0040,0007)=".$dataCodeActe."-".$dataDescActe."\n"; 
		fwrite($Handle, $DataFile); 
		$DataFile = "(0040,0010)=CR\n"; 
		fwrite($Handle, $DataFile);


		fclose($Handle);}

	}
	}

	//bmarique - end
	}
	// UPDate Caisse
	$sql = "SELECT sum(caisse) AS somme from tarifications_detail WHERE ( tarification_id   = '$sessTarificationID')";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$dataSomme = $data['somme'];
	$sql = "UPDATE tarifications SET a_payer = '$dataSomme' WHERE (id  = '$sessTarificationID')"	;
	$result = requete_SQL ($sql);
	
	// Get CAISSE
	$sql = "SELECT a_payer, paye, etat FROM tarifications WHERE id='$sessTarificationID'";
	$result = requete_SQL ($sql);
	$data = mysql_fetch_assoc($result);
	$dataAPayer = $data['a_payer'];
	$dataPaye = $data['paye'];
	$dataRestePayer = round($dataAPayer - $dataPaye,2);
	if ($dataRestePayer < 0)  {$dataRestePayer = 0;}
	
		
	// MISE A JOUR LOG DANS DB
	$sql = "UPDATE tarifications set log = concat('$content',log) WHERE id = $sessTarificationID";
	$result = requete_SQL ($sql);
	

$datas = array(
    'root' => array(
        'content' => $content, 
        'solde' => $solde, 
        'a_payer' => $dataAPayer, 
        'deja_paye' => $dataPaye, 
        'reste_paye' => $dataRestePayer 
)
);
		
header("X-JSON: " . json_encode($datas));

?>		
