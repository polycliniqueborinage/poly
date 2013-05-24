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
	// SECURITE
	
	// Inclus le fichier contenant les fonctions personalisées
	include_once '../lib/fonctions.php';
	
	// Inclus le fichier contenant la gestion des erreurs
	include_once '../lib/gestionErreurs.php';
	$test = new testTools("info");
	$info_erreurs = "";
	
	$jsId = isset($_GET['id']) ? $_GET['id'] : "";
	$jsType = isset($_GET['type']) ? $_GET['type'] : "base";
	//load prevalue
	$jsCecodiId = isset($_GET['cecodi_id']) ? $_GET['cecodi_id'] : "";


	$dataAge = "0-107;";	
			
	if ($jsCecodiId != '') {

		connexion_DB('poly');
		
		$sql = "SELECT * FROM cecodis2 WHERE id ='$jsCecodiId'";
		
		$result = requete_SQL($sql);
		
		if(mysql_num_rows($result)==1) {
			
			$data = mysql_fetch_assoc($result);
			$dataCecodi = $data['cecodi'];	
			$dataPropriete = $data['propriete'];	
			$dataDescription = $data['description'];
			$dataCond = $data['cond'];	
			$dataTpfortr = $data['tpfortr'];	
			$dataKdb = $data['kdb'];
			$dataBc = $data['bc'];
			$dataHonoTravailleur = $data['hono_travailleur'];	
			$dataAVipo = $data['a_vipo'];	
			$dataBTiersPayant = $data['b_tiers_payant'];	
			$dataClasse = $data['classe'];	
			$dataChildren = $data['children'];	
			
			$dataAge = substr($data['age'], 1, (strlen($data['age'])-2));
			$tok = strtok($dataAge,"||");
			$temp = "";
			$currentAge = "";
			$oldAge = "";
			while ($tok !== false) {
				$currentAge = $tok;
				if ($currentAge != ($oldAge+1)) {
					$temp .= "-".$oldAge.";".$currentAge;
				}
				$tok = strtok("||");
  				$oldAge = $currentAge;
			}
			$temp.= "-".$currentAge.";"; 
			$temp =  substr($temp, 2);
			$dataAge = $temp;
			
			$dataPrixVp = $data['prix_vp'];	
			$dataPrixTp = $data['prix_tp'];	
			$dataPrixTr = $data['prix_tr'];	
			
		}

		deconnexion_DB();
		
	}

?>
							
	<table border='1' cellspacing='0' cellpadding='0'>
										
			<?if ($jsType =='base') {?>
				<tr>
					<th class=''>Code du CECODI</th>
					<td class='formInput'><input type='text' name='cecodi<?=$jsId?>' id='cecodi<?=$jsId?>' size='40' maxlength='6' class='txtField' title='Code du CECODI' value="<?=$dataCecodi?>" onKeyUp='javascript:valeurcecodi1 = checkNumber(this, valeurcecodi1, 6, false);cecodiRechercheDirect(this.value);extendCecodi();' onfocus="javascript:this.select();" autocomplete='off' />
					</td>
				</tr>
			<?} else {?>
				<tr>
					<th class=''>Code du CECODI</th>
					<td class='formInput'><input type='text' name='cecodi<?=$jsId?>' id='cecodi<?=$jsId?>' size='40' maxlength='6' class='txtField' title='Code du CECODI' value="<?=$dataCecodi?>" />
					</td>
				</tr>
			<?}?>
			<tr id ="cecodi<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer un code INAMI valide</td></tr>
									
									
			<!-- Age -->
			<tr>
				<th ''>Age</th>
				<td class='formInput'><input type='text' name='age<?=$jsId?>' id='age<?=$jsId?>' size='40' maxlength='100' class='txtField' title="Condition sur l'age" onKeyUp="javascript:valeurage<?=$jsId?> = checkAgeFormat(this, valeurage<?=$jsId?>);" value="<?=$dataAge?>" />
					Format (0-7;12-15)
				</td>
			</tr>
									
										
			<!-- Description -->
			<tr>
				<th class=''>Description</th>
				<td class='formInput'><input type='text' name='description<?=$jsId?>' id='classe<?=$jsId?>' size='40' maxlength='100' class='txtField' title='Description de la prestation' value="<?=htmlentities($dataDescription)?>" />
			</td>
			</tr>																				

			<!-- Condition -->
			<tr>
				<th ''>Classe</th>
				<td class='formInput'><input type='text' name='classe<?=$jsId?>' id='classe<?=$jsId?>' size='40' maxlength='100' class='txtField' title='Classe de la prestation' value="<?=htmlentities($dataClasse)?>" />
				</td>
			</tr>
										
			<!-- Classe -->
			<tr>
				<th ''>Condition</th>
				<td class='formInput'><input type='text' name='condition<?=$jsId?>' id='condition<?=$jsId?>' size='40' maxlength='100' class='txtField' title='Conditions sur la prestation' value="<?=htmlentities($dataCond)?>" />
				</td>
			</tr>
									
									
			<!-- Propriete -->
			<?if ($jsType =='base') {?>
				<tr>
					<th class=''>Type</th>
					<td class='formInput'>
						<select name='propriete<?=$jsId?>' id='propriete<?=$jsId?>' onchange="javascript:cecodiChangeType();">
							<option value='autre' <?php if($dataPropriete=='autre') echo 'selected';?>></option>
							<option value='consultation' <?php if($dataPropriete=='consultation') echo 'selected';?>>Consultation</option>
							<option value='acte' <?php if($dataPropriete=='acte') echo 'selected';?>>Acte technique</option>
						</select>
					</td>
				</tr>
			<?} else {?>
				<tr>
					<th class=''>Type</th>
						<td class='formInput'><input type='text' name='propriete<?=$jsId?>' id='propriete<?=$jsId?>' size='40' maxlength='12' class='txtField' title='Type de la prestation' value='<?=htmlentities($dataPropriete)?>' disabled='true'/>
						</td>
				</tr>
			<?}?>
			<tr id ="propriete<?=$jsId?>alert" style="display:none"><td></td><td class="info">Choisir un type de prestation</td></tr>
									
																	
			<tr id="formHonoTravailleur<?=$jsId?>" style="display: none;">
				<th class=''>hono_travailleur</th>
				<td class='formInput'><input type='text' name='hono_travailleur<?=$jsId?>' id='hono_travailleur<?=$jsId?>' size='40' maxlength='40' class='txtField' title='hono_travailleur' value='<?=$dataHonoTravailleur?>'  onKeyUp='javascript:valeurhono_travailleur<?=$jsId?> = checkAmount(this, valeurhono_travailleur<?=$jsId?>, 10, 2, false);' autocomplete='off' />
				</td>
			</tr>
			<tr id ="hono_travailleur<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer une valeur</td></tr>

									
			<tr id="formAVipo<?=$jsId?>" style="display: none;">
				<th class=''>a_vipo</th>
				<td class='formInput'><input type='text' name='a_vipo<?=$jsId?>' id='a_vipo<?=$jsId?>' size='40' maxlength='40' class='txtField' title='a_vipo' value='<?=$dataAVipo?>'  onKeyUp='javascript:valeura_vipo<?=$jsId?> = checkAmount(this, valeura_vipo<?=$jsId?>, 10, 2, false);' autocomplete='off' />
				</td>
			</tr>
			<tr id ="a_vipo<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer une valeur</td></tr>

								
			<tr id="formBTiersPayant<?=$jsId?>" style="display: none;">
				<th class=''>b_tiers_payant</th>
				<td class='formInput'><input type='text' name='b_tiers_payant<?=$jsId?>' id='b_tiers_payant<?=$jsId?>' size='40' maxlength='40' class='txtField' title='b_tiers_payant' value='<?=$dataBTiersPayant?>'  onKeyUp='javascript:valeurb_tiers_payant<?=$jsId?> = checkAmount(this, valeurb_tiers_payant<?=$jsId?>, 10, 2, false);' autocomplete='off' />
				</td>
			</tr>
			<tr id ="b_tiers_payant<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer une valeur</td></tr>

									
			<tr id="formKDB<?=$jsId?>" style="display: none;">
				<th class=''>kdb</th>
				<td class='formInput'><input type='text' name='kdb<?=$jsId?>' id='kdb<?=$jsId?>' size='40' maxlength='40' class='txtField' title='kdb' value='<?=$dataKdb?>' onKeyUp='javascript:valeurkdb<?=$jsId?> = checkAmount(this, valeurkdb<?=$jsId?>, 10, 2, false);' autocomplete='off'/>
				</td>
			</tr>
			<tr id ="kdb<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer une valeur</td></tr>

									
			<tr id="formBC<?=$jsId?>" style="display: none;">
				<th class=''>bc</th>
				<td class='formInput'><input type='text' name='bc<?=$jsId?>' id='bc<?=$jsId?>' size='40' maxlength='40' class='txtField' title='bc' value='<?=$dataBc?>' onKeyUp='javascript:valeurbc<?=$jsId?> = checkAmount(this, valeurbc<?=$jsId?>, 10, 2, false);' autocomplete='off'/>
			</td>
			</tr>
			<tr id ="bc<?=$jsId?>alert" style="display:none"><td></td><td class="info">Rentrer une valeur</td></tr>

										
			<?
				if (($_SESSION['role'] == 'Administrateur')) {
					// prix vipo
					echo "<tr>";
					echo"<th class='formLabel'><label for='prix_vipo'>Prix VIPO <br /></label>";
					echo"</th>";
					echo"<td class='formInput'><input type='text' name='prix_vipo$jsId' id='prix_vipo$jsId' size='40' maxlength='40' class='txtField' title='Prix que le VIPO va payer si on ne tient pas compte du calcul du prix prix officiel!' value='".$dataPrixVp."' onKeyUp='javascript:valeurprixvipo$jsId = checkAmount(this, valeurprixvipo$jsId, 10, 2, false);' autocomplete='off'/>";
					echo"</td>";
					echo"</tr>";
									
											// prix tiers payant
											echo "<tr>";
											echo"<th class='formLabel'><label for='prix_tp'>Prix Tiers Payant <br /></label>";
											echo"</th>";
											echo"<td class='formInput'><input type='text' name='prix_tp$jsId' id='prix_tp$jsId' size='40' maxlength='40' class='txtField' title='Prix que le Tiers Payant va payer si on ne tient pas compte du calcul du prix prix officiel!' value='".$dataPrixTp."' onKeyUp='javascript:valeurprixtp$jsId = checkAmount(this, valeurprixtp$jsId, 10, 2, false);' autocomplete='off'/>";
											echo"</td>";
											echo"</tr>";

											echo "<tr>";
											echo "<th class='formLabel'></th>";
											echo "<td class='formInput'>";
											echo "<input type='checkbox' name='tp_for_tr$jsId' id='tp_for_tr$jsId' value='checked' $dataTpfortr >Tiers payant accord&eacute; aux travailleurs";
											echo "</td>";
											echo "</tr>";
											
										}
									?>
										
																		
									<tr>
										<th class='formLabel'><label for='validation'><br /></label>
										</th>
										<td class='formInput'>
										<input type="submit" class="button" value="Valider" />
										</td>
									</tr>
										
								</table>
								
