<?php 

	// Demarre une session
	session_start();
	
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
			
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
    $rate= new rateTool();
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
		
	// Fonction de connexion à la base de données
	connexion_DB('poly');
	
	// Nom du fichier en cours 
	$nom_fichier = "modif_patient_mutuelle.php";
	
	// Variables vides
	$formMutuelleCode = '';
	$formMutuelleMatricule = '';
	$formSIS = '';
	$formCT1 = '';
	$formCT1 = '';
	$formType = '';
	$formTiersPayant = '';
	$formLabel ='';
	$formTelephone = '';
	$formGsm = '';

	// Variables de l'url
	if (isset($_GET['id'])) {
	
		// from url
		$formID = $_GET['id'];
		
		//Récuperation des variables de la DB du patient
		$sql = "SELECT 
		p.id patient_id,
		p.nom as patient_nom, 
		p.prenom as patient_prenom, 
		p.date_naissance as patient_date_naissance,
		p.sexe as patient_sexe,
		p.rue as patient_rue,
		p.code_postal as patient_code_postal,
    	p.commune as patient_localite,
		p.nationnalite as patient_nationnalite, 
		p.telephone as patient_telephone, 
		p.gsm as patient_gsm, 
		p.mail as patient_mail, 
		p.mutuelle_code as patient_mutuelle_code, 
		p.mutuelle_matricule as patient_mutuelle_matricule, 
		p.sis as patient_sis, 
		p.ct1 as patient_ct1, 
		p.ct2 as patient_ct2, 
		p.tiers_payant as patient_tiers_payant, 
		p.niss as patient_niss, 
		p.titulaire_id as patient_titulaire_id, 
		p.prescripteur as patient_prescipteur,
		p.tiers_payant_info as patient_tiers_payant_info, 
		p.vipo_info as patient_vipo_info, 
		p.mutuelle_info as patient_mutuelle_info, 
		p.interdit_info as patient_interdit_info, 
		p.rating_rendez_vous_info as patient_rating_rendez_vous_info, 
		p.rating_frequentation_info  as patient_rating_frequentation_info, 
		p.rating_preference_info as patient_rating_preference_info, 
		p.commentaire as patient_commentaire,
		p.photo as patient_photo
		FROM patients p WHERE id ='$formID'";
			
		$q = requete_SQL ($sql);
		
		$n = mysql_num_rows($q);
			
		//on trouve un patient
		if($n==1) {
					
			$data = mysql_fetch_assoc($q);
				
			$formID = $data['patient_id'];
			$formTitulaireID = $data['patient_titulaire_id'];
			$formNom = $data['patient_nom'];
			$formPrenom = $data['patient_prenom'];
			$formDateNaissance = $data['patient_date_naissance'];
			$formMutuelleMatricule = $data['patient_mutuelle_matricule'];
			$formMutuelleCode = $data['patient_mutuelle_code'];
			$formSIS = $data['patient_sis'];
			$formCT1 = $data['patient_ct1'];
			$formCT2 = $data['patient_ct2'];
			$formTiersPayant = $data['patient_tiers_payant'];
			$formTelephone = $data['patient_telephone'];
			$formGSM = $data['patient_gsm'];
			
			// Recuperation de type
			$sql = "SELECT c.type as cts_type, c.label as cts_label FROM cts c WHERE (c.ct1 = '$formCT1') AND (c.ct2 = '$formCT2')";
			$result = requete_SQL ($sql);
		
			if(mysql_num_rows($result)==1) {
				$data = mysql_fetch_assoc($result);
				$formType = $data['cts_type'];
				$formLabel = $data['cts_label'];
			} else {
				$formType = '';
				$formLabel = '';
			}
							
		}

	}
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

<head>
	<title>Poly - Modification des informations de mutuelles du patient</title>
	<link href="../style/poly.css" media="all" rel="Stylesheet" type="text/css">
	<script type="text/javascript">
		var valeursis = '';
	</script>
</head>

<body>
	
    <div id="topcalendrier">
		
		<h1><?=htmlentities(stripcslashes($formNom),ENT_QUOTES)?> <?=htmlentities(stripcslashes($formPrenom),ENT_QUOTES)?></h1>
	</div>

	<div>
		
 	 	<div class="dojoTabPanelContainer" id="main">
        
			<div style="" id="tab_panel">
			
				<div class="pullUp">
	
					<div class="listViewPane">
					
					<div class="navigation-hight">

						<div id='modificationmodal'></div>
					        
					</div>
					

						<!-- DEBUT DU CALENDRIER -->
						<div id="secondmain" class="formBox">
							
							<form name='patientForm' id='patientForm' method='post' action='<?=$nom_fichier?>'>

								<table cellspacing='0' cellpadding='0'>


										<!-- Mutuelle -->
										<tr>
											<th class='required'>Mutuelle</th>
											<td class='formInput'>
												<select onchange="javascript:modif_champ_modal(<?=$formTitulaireID?>,'mutuelle_code',this.value)" title="Mutuelle du patient">
												<option width="365px" style="width: 365px" value=''>Choisir...</option>
												<?php
													$sql = 'SELECT nom, code FROM mutuelles order by 1';
													$result = mysql_query($sql);
													while($data = mysql_fetch_assoc($result)) 	{
														echo "<option value='".$data['code']."' ";
														if ($formMutuelleCode == $data['code']) echo "selected";
														echo " >".$data['code']." - ".htmlentities(stripcslashes($data['nom']),ENT_QUOTES)."</option>";
													}	 
												?>
												</select>
												
											</td>
										</tr>
										
						
										<!-- Matricule -->
										<tr>
											<th class='required'>Mutuelle Matricule</th>
											<td class='formInput'><input onkeyup="javascript:modif_champ_modal(<?=$formTitulaireID?>,'mutuelle_matricule',this.value)" onkeydown="javascript:modif_champ_modal(<?= $formTitulaireID?>,'mutuelle_matricule',this.value)" type='text' size='48' maxlength='20' class='txtField' title='Matricule du patient &agrave; la mutuelle'  value='<?=$formMutuelleMatricule?>' autocomplete='off' />
											</td>
										</tr>
										
	
										<!-- SIS -->
										<tr>
											<th class='required'>Carte SIS</th>
											<td class='formInput'><input onkeyup="javascript:modif_champ_modal(<?=$formTitulaireID?>,'sis',this.value)" onkeydown="javascript:modif_champ_modal(<?= $formTitulaireID?>,3,this.value)" type='text' name='sis' id='sis' size='48' maxlength='10' class='txtField' title='Num&eacute;ro de la carte SIS'  value='<?=$formSIS?>' autocomplete='off' />
											</td>
										</tr>


										<!-- TYPE -->
										<tr>
											<th class='required'>CT1/CT2</th>
											<td class='formInput'>
												<select width="249px" style="width: 249px" id='ct1ct2' name='ct1ct2' title='CT1 et CT2 du patient' onchange="modif_champ_modal(<?= $formTitulaireID?>,'ct1ct2',this.value);">
													<option value=''>Choisir</option>
													<?php
													$sql = 'SELECT distinct ct1, ct2, label FROM cts where ct1!=0 and ct2!=0';
													$result = mysql_query($sql);
												
													while($data = mysql_fetch_assoc($result)) 	{
														// on affiche les specialité
    													echo "<option value='".$data['ct1']."-".$data['ct2']."' ";
														if ($formCT1."-".$formCT2 == $data['ct1']."-".$data['ct2']) echo "selected";
														echo " >".$data['ct1']."-".$data['ct2']." - ".$data['label']."</option>";
													}	 
													?>
												</select>
												<input onclick="javascript:modif_champ_modal(<?=$formTitulaireID?>,'tiers_payant',this.checked)" type='checkbox' name='tiers_payant' id='tiers_payant' value='checked' <?=$formTiersPayant?> >R&eacute;duction du tiers payant
										</tr>
										<!-- FIN TYPE -->
										
										
										<!-- Telephone -->
										<tr>
											<th class='required'>T&eacute;l&eacute;phone</th>
											<td class='formInput'><input onkeyup="javascript:modif_champ_modal(<?=$formTitulaireID?>,'telephone',this.value)"  onkeydown='javascript:modif_champ_modal(<?=$formTitulaireID?>,6,this.value)' type='text' name='telephone' id='telephone' size='48' maxlength='32' class='txtField' title='T&eacute;l&eacute;phone du patient'  value='<?=$formTelephone?>' />
											</td>
										</tr>
										

										<!-- GSM -->
										<tr>
											<th class='required'>GSM</th>
											<td class='formInput'><input onkeyup="javascript:modif_champ_modal(<?=$formTitulaireID?>,'gsm',this.value)"  onkeydown='javascript:modif_champ_modal(<?=$formTitulaireID?>,7,this.value)' type='text' name='gsm' id='gsm' size='48' maxlength='32' class='txtField' title='GSM du patient'  value='<?=$formGSM?>' />
											</td>
										</tr>
										
								</table>

							</form>
														
						</div>
		
					</div>
					
				</div>
			
			</div>
			
		</div>
		
	</div>
	

</body>
</html>
