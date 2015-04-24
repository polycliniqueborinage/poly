<?php
/**
 * Provides methods to interact with users
 *
 * @author Open Dynamics <info@o-dyn.de>
 * @name user
 * @version 0.4.7
 * @package Collabtive
 * @link http://www.o-dyn.de
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or laterg
 */
class patient
{
    public $mylog;

    function __construct()
    {
        $this->mylog = new mylog;
    }
	
    function add($titulaireID, $firstname, $familyname, $birthday, $gender, $nationality, $niss, $address1, $zip1city1, $state1, $country1, $workphone, $privatephone, $mobilephone, $fax, $email, $receiveMail, $mutuelCode, $mutuelMatricule, $sis, $ct1ct2,  $tiersPayant, $doctor, $tiers_payant_info , $vipo_info , $mutuelle_info , $interdit_info , $rating_rendez_vous_info , $rating_frequentation_info , $rating_preference_info , $commentaire , $photo , $textcomment, $fumeur, $obese) {
    	
        $titulaireID = (int) mysql_real_escape_string($titulaireID);
        
        $familyname = mysql_real_escape_string($familyname);
        $firstname = mysql_real_escape_string($firstname);
        //$birthday = mysql_real_escape_string($birthday);
        //$birthday = date("Y-m-d", strtotime(mysql_real_escape_string($birthday)));
        $birthday = mysql_real_escape_string($birthday);
		$birthdayDay = strtok($birthday,"/");
		$birthdayMonth = strtok("/");
		$birthdayYear = strtok("/");
		$birthday = $birthdayYear."-".$birthdayMonth."-".$birthdayDay;
        $gender = mysql_real_escape_string($gender);
        $nationality = mysql_real_escape_string($nationality);
        $niss = (int)mysql_real_escape_string($niss);
                        
        $address1 = mysql_real_escape_string($address1);
		$zip1city1 = mysql_real_escape_string($zip1city1);
        $zip1 = substr($zip1city1,0,4);
		$city1 = trim(substr($zip1city1,4));
        $city1 = mysql_real_escape_string($city1);
        $state1 = mysql_real_escape_string($state1);
        $country1 = mysql_real_escape_string($country1);
        
        $workphone = mysql_real_escape_string($workphone);
        $privatephone = mysql_real_escape_string($privatephone);
        $mobilephone = mysql_real_escape_string($mobilephone);
        $fax = mysql_real_escape_string($fax);
        $email = mysql_real_escape_string($email);
        $receiveMail = mysql_real_escape_string($receiveMail);
        
        $mutuelCode = mysql_real_escape_string($mutuelCode);
        $mutuelMatricule = mysql_real_escape_string($mutuelMatricule);
        $sis = mysql_real_escape_string($sis);
        $ct1ct2 = mysql_real_escape_string($ct1ct2);
        $ct1 = substr(mysql_real_escape_string($ct1ct2), 0, 3);
        $ct2 = substr(mysql_real_escape_string($ct1ct2), 4, 3);
        $tiersPayant = mysql_real_escape_string($tiersPayant);
        $doctor = mysql_real_escape_string($doctor);
        $tiers_payant_info = mysql_real_escape_string($tiers_payant_info); 
        $vipo_info = mysql_real_escape_string($vipo_info); 
        $mutuelle_info = mysql_real_escape_string($mutuelle_info);
        $interdit_info = mysql_real_escape_string($interdit_info);
        $rating_rendez_vous_info = mysql_real_escape_string($rating_rendez_vous_info);
        $rating_frequentation_info = mysql_real_escape_string($rating_frequentation_info);
        $rating_preference_info = mysql_real_escape_string($rating_preference_info);
        $commentaire = mysql_real_escape_string($commentaire);
        $textcomment = mysql_real_escape_string($textcomment);
        
        $fumeur = mysql_real_escape_string($fumeur);
        $obese  = mysql_real_escape_string($obese);
        
        $sql = "INSERT `patients` ( `nom` , `prenom` , `date_naissance` , `sexe` , `rue` , `code_postal` , `commune` ,
        		 `niss` , `titulaire_id` , `mutuelle_code` , `mutuelle_matricule` ,
				`sis` , `telephone` , `gsm` , `mail` , `nationnalite` , `prescripteur` ,
				`ct1` , `ct2` , `tiers_payant` , `type` , `tiers_payant_info` , `vipo_info` ,
				`mutuelle_info` , `interdit_info` , `rating_rendez_vous_info` , `rating_frequentation_info` , `rating_preference_info` ,
				`commentaire` , `photo` , `textcomment`, `fumeur`, `obese` )
				VALUES ( '$familyname', '$firstname', '$birthday', '$gender', '$address1', '$zip1', '$city1', 
				'$niss', '$titulaireID', '$mutuelCode', '$mutuelMatricule', 
				'$sis', '$privatephone', '$mobilephone', '$email', '$nationality', '$doctor',
				'$ct1', '$ct2', '$tiersPayant', '', '$tiers_payant_info', '$vipo_info',
				'$mutuelle_info', '$interdit_info', '$rating_rendez_vous_info', '$rating_frequentation_info', 
				'$rating_preference_info', '$commentaire', '', '$textcomment', '$fumeur', '$obese');";

		$ins = mysql_query($sql);
		$insid = mysql_insert_id();
        
		$sql = "UPDATE `patients` set titulaire_id=id where titulaire_id = 0";
		$upd = mysql_query($sql);
		
        if ($ins) {
            return $insid;
        } else {
            return false;
        }
        
    }
    
    /**
     * UPDATE patient
     *
     */
    function update($titulaireID, $firstname, $familyname, $birthday, $gender, $nationality, $niss, $address1, $zip1city1, $state1, $country1, $workphone, $privatephone, $mobilephone, $fax, $email, $receiveMail, $mutuelCode, $mutuelMatricule, $sis, $ct1ct2,  $tiersPayant, $doctor, $tiers_payant_info, $vipo_info, $mutuelle_info, $interdit_info, $rating_rendez_vous_info, $rating_frequentation_info, $rating_preference_info, $commentaire, $textcomment, $fumeur, $obese, $ID) {
    	
        $titulaireID = (int) mysql_real_escape_string($titulaireID);
        
        $familyname = mysql_real_escape_string($familyname);
        $firstname = mysql_real_escape_string($firstname);
        //$birthday = mysql_real_escape_string($birthday);
        //$birthday = date("Y-m-d", strtotime(mysql_real_escape_string($birthday)));
        $birthday = mysql_real_escape_string($birthday);
		$birthdayDay = strtok($birthday,"/");
		$birthdayMonth = strtok("/");
		$birthdayYear = strtok("/");
		$birthday = $birthdayYear."-".$birthdayMonth."-".$birthdayDay;
        $gender = mysql_real_escape_string($gender);
        $nationality = mysql_real_escape_string($nationality);
        $niss = (int)mysql_real_escape_string($niss);
                        
        $address1 = mysql_real_escape_string($address1);
		$zip1city1 = mysql_real_escape_string($zip1city1);
        $zip1 = substr($zip1city1,0,4);
		$city1 = trim(substr($zip1city1,4));
        $city1 = mysql_real_escape_string($city1);
        $state1 = mysql_real_escape_string($state1);
        $country1 = mysql_real_escape_string($country1);
        
        $privatephone = mysql_real_escape_string($privatephone);
        $mobilephone = mysql_real_escape_string($mobilephone);
        $fax = mysql_real_escape_string($fax);
        $email = mysql_real_escape_string($email);
        $receiveMail = mysql_real_escape_string($receiveMail);
        
        $mutuelCode = mysql_real_escape_string($mutuelCode);
        $mutuelMatricule = mysql_real_escape_string($mutuelMatricule);
        $sis = mysql_real_escape_string($sis);
        $ct1 = substr(mysql_real_escape_string($ct1ct2), 0, 3);
        $ct2 = substr(mysql_real_escape_string($ct1ct2), 4, 3);
        $tiersPayant = mysql_real_escape_string($tiersPayant);
        $doctor = mysql_real_escape_string($doctor);
        
        $tiers_payant_info = mysql_real_escape_string($tiers_payant_info); 
        $vipo_info = mysql_real_escape_string($vipo_info); 
        $mutuelle_info = mysql_real_escape_string($mutuelle_info);
        $interdit_info = mysql_real_escape_string($interdit_info);
        $rating_rendez_vous_info = mysql_real_escape_string($rating_rendez_vous_info);
        $rating_frequentation_info = mysql_real_escape_string($rating_frequentation_info);
        $rating_preference_info = mysql_real_escape_string($rating_preference_info);
        $commentaire = mysql_real_escape_string($commentaire);
        $textcomment = mysql_real_escape_string($textcomment); 
        
        $fumeur = mysql_real_escape_string($fumeur);
        $obese  = mysql_real_escape_string($obese); 
        
        $id = mysql_real_escape_string($id);
        
        $id = (int) $id;
        
        $sql = "UPDATE patients SET nom='$familyname', prenom='$firstname', date_naissance='$birthday', sexe='$gender', rue='$address1', code_postal='$zip1', commune='$city1', telephone='$privatephone', gsm='$mobilephone', mail='$email', mutuelle_code='$mutuelCode', mutuelle_matricule='$mutuelMatricule', sis='$sis',
        		ct1='$ct1', ct2='$ct2', tiers_payant='$tiersPayant', prescripteur='$doctor', tiers_payant_info='$tiers_payant_info', vipo_info='$vipo_info', mutuelle_info='$mutuelle_info', interdit_info='$interdit_info', rating_rendez_vous_info='$rating_rendez_vous_info', rating_frequentation_info='$rating_frequentation_info',
        		rating_preference_info='$rating_preference_info', commentaire='$commentaire', textcomment='$textcomment', fumeur='$fumeur', obese='$obese' WHERE id='$ID'";

        $upd = mysql_query($sql);
        if ($upd) {
            return true;
        } else {
            return false;
        }
    }
    
/**
     * Get a user profile
     *
     * @param int $id User ID
     * @return array $profile Profile
     */
    function get($id) {
        $id = (int) $id;
        $sql = "SELECT 
			p.id as patient_id,
			p.nom as patient_nom, 
			p.prenom as patient_prenom, 
			p.date_naissance as patient_birthdate,
			date_format(p.date_naissance,'%d/%m/%Y') as patient_date_naissance,
			p.sexe as patient_sexe,
			p.rue as patient_rue,
			p.code_postal as patient_code_postal,
            p.commune as patient_localite,
            p.nationnalite as patient_nationnalite, 
			p.niss as patient_niss, 
			p.sis as patient_sis,
			p.telephone as patient_telephone, 
			p.gsm as patient_gsm, 
			p.mail as patient_mail, 
			p.mutuelle_code as patient_mutuelle_code, 
			p.mutuelle_matricule as patient_mutuelle_matricule, 
			p.ct1 as patient_ct1, 
			p.ct2 as patient_ct2, 
			p.tiers_payant as patient_tiers_payant, 
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
			p.textcomment as patient_textcomment,
			p.photo as patient_photo,
			p.fumeur as patient_fumeur,
			p.obese as patient_obese,
			concat(t.nom,' ',t.prenom) as titulaire,
			t.id as titulaire_id 
			FROM patients p, patients t WHERE p.id ='$id' AND p.titulaire_id = t.id";
			
			//echo $sql;
			
	  	$sel = mysql_query($sql);
	  	$patient = mysql_fetch_array($sel);
	  	if (!empty($patient)) {
	  		if (isset($patient["patient_id"])) {
	  			$patient["ID"] = stripcslashes($patient["patient_id"]);
	  			$patient["familyname"] = stripcslashes($patient["patient_nom"]);
	  			$patient["firstname"] = stripcslashes($patient["patient_prenom"]);
	  			$patient["birthday"] = stripcslashes($patient["patient_date_naissance"]);
	  			$patient["gender"] = stripcslashes($patient["patient_sexe"]);
	  			
	  			$patient["nationality"] = stripcslashes($patient["patient_nationnalite"]);
	  			$patient["niss"] = stripcslashes($patient["patient_niss"]);
	  			$patient["address1"] = stripcslashes($patient["patient_rue"]);
	  			$patient["zip1"] = stripcslashes($patient["patient_code_postal"]);
	  			$patient["city1"] = stripcslashes($patient["patient_localite"]);
	  			
	  			$patient["privatephone"] = stripcslashes($patient["patient_telephone"]);
	  			$patient["mobilephone"] = stripcslashes($patient["patient_gsm"]);
	  			$patient["email"] = stripcslashes($patient["patient_mail"]);

	  			$patient["mutuel_code"] = (int) $patient["patient_mutuelle_code"];
	  			$patient["mutuel_matricule"] = stripcslashes($patient["patient_mutuelle_matricule"]);
	  			$patient["ct1ct2"] = $patient["patient_ct1"]."-".$patient["patient_ct2"];
	  			$patient["tiers_payant"] = stripcslashes($patient["patient_tiers_payant"]);
	  			$patient["sis"] = stripcslashes($patient["patient_sis"]);

	  			$patient["doctor"] = stripcslashes($patient["patient_prescipteur"]);
	  			$patient["commentaire"] = stripcslashes($patient["patient_commentaire"]);
	  			$patient["textcomment"] = stripcslashes($patient["patient_textcomment"]);
	  			
	  			$patient["tiers_payant_info"] = stripcslashes($patient["patient_tiers_payant_info"]);
	  			$patient["vipo_info"] = stripcslashes($patient["patient_vipo_info"]);
	  			$patient["mutuelle_info"] = stripcslashes($patient["patient_mutuelle_info"]);
	  			$patient["interdit_info"] = stripcslashes($patient["patient_interdit_info"]);
	  			$patient["rating_rendez_vous_info"] = stripcslashes($patient["patient_rating_rendez_vous_info"]);
	  			$patient["rating_frequentation_info"] = stripcslashes($patient["patient_rating_frequentation_info"]);
	  			$patient["rating_preference_info"] = stripcslashes($patient["patient_rating_preference_info"]);
	  			
	  			$patient["fumeur"] = stripcslashes($patient["patient_fumeur"]);
	  			$patient["obese"] = stripcslashes($patient["patient_obese"]);
	  				
	  			$patient["titulaire_name"] = stripcslashes($patient["titulaire"]);
	  			$patient["titulaire_ID"] = stripcslashes($patient["titulaire_id"]);
	  		}
	  		return $patient;
	        } else {
            return false;
        }
    	
    }
    
	 /* Make a search
     *
     * @param value
     * @return array
     */
    function modulesearch($id,$value,$limit) {

    	if ($id!='undefined' && $id!='undefined' && $id!= null)
    		$sql = "SELECT p.id as patient_id, p.nom as patient_nom, p.prenom as patient_prenom, date_format(p.date_naissance, '%d/%m/%Y') as patient_date_naissance, p.sexe as patient_sexe, p.rue as patient_rue, p.code_postal as patient_code_postal, p.commune as patient_commune,	p.telephone as patient_telephone,	p.mail as patient_mail, p.mutuelle_code as patient_mutuelle_code, p.tiers_payant as patient_tiers_payant, p.ct1 as patient_ct1, p.ct2 as patient_ct2, p.gsm as patient_gsm, t.nom as titulaire_nom, t.prenom as titulaire_prenom, p.fumeur as patient_fumeur, p.obese as patient_obese FROM patients p, patients t WHERE (p.titulaire_id = t.id) AND p.id='$id' AND p.active=1";
		else 
    		$sql = "SELECT p.id as patient_id, p.nom as patient_nom, p.prenom as patient_prenom, date_format(p.date_naissance, '%d/%m/%Y') as patient_date_naissance, p.sexe as patient_sexe, p.rue as patient_rue, p.code_postal as patient_code_postal, p.commune as patient_commune,	p.telephone as patient_telephone,	p.mail as patient_mail, p.mutuelle_code as patient_mutuelle_code, p.tiers_payant as patient_tiers_payant, p.ct1 as patient_ct1, p.ct2 as patient_ct2, p.gsm as patient_gsm, t.nom as titulaire_nom, t.prenom as titulaire_prenom, p.fumeur as patient_fumeur, p.obese as patient_obese FROM patients p, patients t WHERE (p.titulaire_id = t.id) AND ((lower(concat(p.nom, ' ' ,p.prenom))) regexp '$value' OR (lower(concat(p.prenom, ' ' ,p.nom))) regexp '$value' OR (lower(concat(t.nom, ' ' ,t.prenom))) regexp '$value' OR (lower(concat(t.prenom, ' ' ,t.nom))) regexp '$value') AND p.active=1 ORDER BY patient_nom, patient_prenom Limit $limit";
		
        $sel = mysql_query($sql); 

        $patients = array();

        while ($patient = mysql_fetch_array($sel)) {
        	
            $patient["ID"] = stripslashes($patient["patient_id"]);
            $patient["nom"] = stripslashes($patient["patient_nom"]);
            $patient["prenom"] = stripslashes($patient["patient_prenom"]);
            $patient["patient"] = stripslashes($patient["patient_prenom"])." ".stripslashes($patient["patient_nom"]);
            $patient["date_naissance"] = stripslashes($patient["patient_date_naissance"]);
            $patient["sexe"] = stripslashes($patient["patient_sexe"]);
            $patient["rue"] = stripslashes($patient["patient_rue"]);
            $patient["code_postal"] = stripslashes($patient["patient_code_postal"]);
            $patient["commune"] = stripslashes($patient["patient_commune"]);
            $patient["mutuelle_code"] = stripslashes($patient["patient_mutuelle_code"]);
            $patient["ct1"] = stripslashes($patient["patient_ct1"]);
            $patient["ct2"] = stripslashes($patient["patient_ct2"]);
            $patient["tiers_payant"] = stripslashes($patient["patient_tiers_payant"]);
            $patient["telephone"] = stripslashes($patient["patient_telephone"]);
            $patient["gsm"] = stripslashes($patient["patient_gsm"]);
            $patient["mail"] = stripslashes($patient["patient_mail"]);
            $patient["fumeur"] = stripslashes($patient["patient_fumeur"]);
            $patient["obese"] = stripslashes($patient["patient_obese"]);
            $patient["titulaire"] = stripslashes($patient["titulaire_nom"]." ".$patient["titulaire_prenom"]);
            
            array_push($patients, $patient);
        }
        if (!empty($patients))  {	
            return $patients;
        }
        else  {
            return false;
        }

    }
    
   	 /* Make a autocomplete
     *
     * @param value
     * @return array
     */
    function autocomplete($id,$value) {
    
	    if ($id!='undefined' && $id!='undefined' && $id!= null)
			$sql = "SELECT p.ID, p.nom, p.prenom, p.date_naissance, t.nom as titulaire_nom, t.prenom as titulaire_prenom, p.sexe, p.rue, p.code_postal, p.commune, p.niss, p.titulaire_id, p.mutuelle_code, p.mutuelle_matricule, p.sis, p.telephone, p.gsm, p.mail, p.ct1, p.ct2, p.tiers_payant, p.fumeur, p.obese FROM patients p, patients t WHERE p.id='$id' AND t.id = p.titulaire_id AND p.active=1";
		else
			$sql = "SELECT p.ID, p.nom, p.prenom, p.date_naissance, t.nom as titulaire_nom, t.prenom as titulaire_prenom, p.sexe, p.rue, p.code_postal, p.commune, p.niss, p.titulaire_id, p.mutuelle_code, p.mutuelle_matricule, p.sis, p.telephone, p.gsm, p.mail, p.ct1, p.ct2, p.tiers_payant, p.fumeur, p.obese FROM patients p, patients t WHERE ((lower(concat(p.nom, ' ' ,p.prenom))) regexp '$value' OR (lower(concat(p.prenom, ' ' ,p.nom))) regexp '$value') Limit 2  AND t.id = p.titulaire_id AND p.active=1";
			
		$result = mysql_query($sql);
	
		if(mysql_num_rows($result)==1) {
		
			$data = mysql_fetch_assoc($result);
			$ID = $data['ID'];
			$patient = $data['nom']." ".$data['prenom'];
			$familyname = $data['nom'];
			$firstname = $data['prenom'];
			$titulaire = $data['titulaire_nom'].' '.$data['titulaire_prenom'];
			$mutuel_code = $data['mutuel_code'];
			$mutuel_matricule = $data['mutuel_matricule'];
			$date_naissance = $data['date_naissance'];
			$sexe = $data['sexe']; 
			$rue = $data['rue']; 
			$code_postal = $data['code_postal'];
			$commune = $data['commune'];
			$niss = $data['niss'];
			$titulaire_id = $data['titulaire_id']; 
			$mutuelle_code = $data['mutuelle_code'];
			$mutuelle_matricule = $data['mutuelle_matricule']; 
			$sis = $data['sis']; 
			$telephone = $data['telephone'];
			$gsm = $data['gsm']; 
			$mail = $data['mail']; 
			$tiers_payant = $data['tiers_payant'];
			$ct1ct2 = $data['ct1'].$data['ct2'];
			$fumeur = $data['fumeur'];
			$fumeur = $data['obese'];
		}
	
		$reponse['ID'] = $ID;
		$reponse['firstname'] = utf8_encode($firstname);
		$reponse['familyname'] = utf8_encode($familyname);
		$reponse["patient"] = utf8_encode($firstname)." ".utf8_encode($familyname);
		$reponse['titulaire'] = utf8_encode($titulaire);
		$reponse['mutuel_code'] = utf8_encode($mutuel_code);
		$reponse['mutuel_matricule'] = utf8_encode($mutuel_matricule);
		$reponse['ct1ct2'] = utf8_encode($ct1ct2);
		$reponse['date_naissance'] = utf8_encode($date_naissance);
		$reponse['sexe'] = utf8_encode($sexe);
		$reponse['rue'] = utf8_encode($rue);
		$reponse['code_postal'] = utf8_encode($code_postal);
		$reponse['commune'] = utf8_encode($commune);
		$reponse['niss'] = utf8_encode($niss);
		$reponse['sexe'] = utf8_encode($sexe);
		$reponse['titulaire_id'] = utf8_encode($titulaire_id);
		$reponse['sis'] = utf8_encode($sis);
		$reponse['telephone'] = utf8_encode($telephone);
		$reponse['gsm'] = utf8_encode($gsm);
		$reponse['mail'] = utf8_encode($mail);
		$reponse['tiers_payant'] = utf8_encode($tiers_payant);
		$reponse['fumeur'] = utf8_encode($fumeur);
		$reponse['obese'] = utf8_encode($obese);
		
		header('Content-Type: application/json');
		echo json_encode($reponse);

    }
    
    function delete($id) {
    	
        $id = (int) $id;
        
        //$sql1 = "DELETE FROM patients WHERE ID = $id LIMIT 1";
        $sql1 = "UPDATE patients SET active=0 WHERE id='$id'";
        $del1 = mysql_query($sql1);
        
        if ($del1) {
            return true;
        } else {
            return false;
        }
        
    }
    
    function createFolder($id){
    	$location = "/Applications/xampp/xamppfiles/htdocs/Polygone/Polygone_Fusion/files/";
    	$map = $location.$id."/";
    	return (mkdir($map));	
    }
    
    function getSpecific($patientNom, $patientPrenom, $patientSexe, $patientBirthday){
        $sql = "SELECT 
			p.id as patient_id,
			p.nom as patient_nom, 
			p.prenom as patient_prenom, 
			p.date_naissance as patient_birthdate,
			date_format(p.date_naissance,'%d/%m/%Y') as patient_date_naissance,
			p.sexe as patient_sexe,
			p.rue as patient_rue,
			p.code_postal as patient_code_postal,
            p.commune as patient_localite,
            p.nationnalite as patient_nationnalite, 
			p.niss as patient_niss, 
			p.sis as patient_sis,
			p.telephone as patient_telephone, 
			p.gsm as patient_gsm, 
			p.mail as patient_mail, 
			p.mutuelle_code as patient_mutuelle_code, 
			p.mutuelle_matricule as patient_mutuelle_matricule, 
			p.ct1 as patient_ct1, 
			p.ct2 as patient_ct2, 
			p.tiers_payant as patient_tiers_payant, 
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
			p.textcomment as patient_textcomment,
			p.photo as patient_photo,
			p.fumeur as patient_fumeur,
			p.obese as patient_obese,
			concat(t.nom,' ',t.prenom) as titulaire,
			t.id as titulaire_id 
			FROM patients p, patients t WHERE lower(p.nom) regexp '$patientNom' AND lower(p.prenom) regexp '$patientPrenom' AND p.sexe = '$patientSexe' AND p.date_naissance = '$patientBirthday' AND p.active=1";
			
			//echo $sql;
			
	  	$sel = mysql_query($sql);
	  	$patient = mysql_fetch_array($sel);
	  	if (!empty($patient)) {
	  		if (isset($patient["patient_id"])) {
	  			$patient["ID"] = stripcslashes($patient["patient_id"]);
	  			$patient["familyname"] = stripcslashes($patient["patient_nom"]);
	  			$patient["firstname"] = stripcslashes($patient["patient_prenom"]);
	  			$patient["birthday"] = stripcslashes($patient["patient_date_naissance"]);
	  			$patient["gender"] = stripcslashes($patient["patient_sexe"]);
	  			
	  			$patient["nationality"] = stripcslashes($patient["patient_nationnalite"]);
	  			$patient["niss"] = stripcslashes($patient["patient_niss"]);
	  			$patient["address1"] = stripcslashes($patient["patient_rue"]);
	  			$patient["zip1"] = stripcslashes($patient["patient_code_postal"]);
	  			$patient["city1"] = stripcslashes($patient["patient_localite"]);
	  			
	  			$patient["privatephone"] = stripcslashes($patient["patient_telephone"]);
	  			$patient["mobilephone"] = stripcslashes($patient["patient_gsm"]);
	  			$patient["email"] = stripcslashes($patient["patient_mail"]);

	  			$patient["mutuel_code"] = (int) $patient["patient_mutuelle_code"];
	  			$patient["mutuel_matricule"] = stripcslashes($patient["patient_mutuelle_matricule"]);
	  			$patient["ct1ct2"] = $patient["patient_ct1"]."-".$patient["patient_ct2"];
	  			$patient["tiers_payant"] = stripcslashes($patient["patient_tiers_payant"]);
	  			$patient["sis"] = stripcslashes($patient["patient_sis"]);

	  			$patient["doctor"] = stripcslashes($patient["patient_prescipteur"]);
	  			$patient["commentaire"] = stripcslashes($patient["patient_commentaire"]);
	  			$patient["textcomment"] = stripcslashes($patient["patient_textcomment"]);
	  			
	  			$patient["tiers_payant_info"] = stripcslashes($patient["patient_tiers_payant_info"]);
	  			$patient["vipo_info"] = stripcslashes($patient["patient_vipo_info"]);
	  			$patient["mutuelle_info"] = stripcslashes($patient["patient_mutuelle_info"]);
	  			$patient["interdit_info"] = stripcslashes($patient["patient_interdit_info"]);
	  			$patient["rating_rendez_vous_info"] = stripcslashes($patient["patient_rating_rendez_vous_info"]);
	  			$patient["rating_frequentation_info"] = stripcslashes($patient["patient_rating_frequentation_info"]);
	  			$patient["rating_preference_info"] = stripcslashes($patient["patient_rating_preference_info"]);
	  			
	  			$patient["fumeur"] = stripcslashes($patient["patient_fumeur"]);
	  			$patient["obese"] = stripcslashes($patient["patient_obese"]);
	  				
	  			$patient["titulaire_name"] = stripcslashes($patient["titulaire"]);
	  			$patient["titulaire_ID"] = stripcslashes($patient["titulaire_id"]);
	  		}
	  		return $patient;
	        } else {
            return false;
        }
    	
    }
}



?>
