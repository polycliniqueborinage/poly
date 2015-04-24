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
class prevention
{
    public $mylog;

    /**
     * Konstruktor
     * Initialisiert den Eventlog
     **/
    function __construct()
    {
        $this->mylog = new mylog;
    }
	
    /**
     * Get a contact
     *
     * @param int $idPatient
     * @param int $idMotif
     */
    function getContact($idPatient, $idMotif) {
        
    	$idPatient = (int) $idPatient;
    	$idMotif = (int) $idMotif;
    	
    	$sql = "SELECT id_patient, id_motif, date_derniere_modification, statut FROM mp_pile WHERE `id_motif`   = '$idMotif' AND `id_patient` = '$idPatient' AND statut != 'termine'";
    	
    	$sel = mysql_query($sql);
        $contact = mysql_fetch_array($sel);
    	
        if (!empty($contact)) {
            return $contact;
        } else {
            return false;
        }
        
    }
    
    function getMotifsAContacter($idPatient) {
    
    	$idPatient = (int) $idPatient;
    	 
    	$sql = "SELECT id_patient, id_motif, date_derniere_modification, statut FROM mp_pile WHERE `id_patient` = '$idPatient' AND `statut` = 'a_contacter'";

    	$res = mysql_query($sql);   	
    	 
    	$motifs = array();
    	
    	while ($motif = mysql_fetch_array($res)) {
    		$motif["id_patient"] 					= stripslashes($motif["id_patient"]);
    		$motif["id_motif"] 						= stripslashes($motif["id_motif"]);
    		$motif["date_derniere_modification"]	= stripslashes($motif["date_derniere_modification"]);
    		$motif["statut"]						= stripslashes($motif["statut"]);
    		
    		array_push($motifs, $motif);
    		
    	}
    	
    	if (!empty($motifs)) {
    		return $motifs;
    	} else {
    		return false;
    	}
    
    }    
    
    /**
     * Delete a contact
     *
     * @param int $idPatient
     * @param int $idMotif
     */
	function deleteContact($idPatient,$idMotif) {
    	
    	$idPatient = (int) $idPatient;
    	$idMotif = (int) $idMotif;
    	        
        $sql = "DELETE FROM mp_pile WHERE `id_motif`   = '$idMotif' AND `id_patient` = '$idPatient'";
        
        $del = mysql_query($sql);
        
        if ($del) {
            return true;
        } else {
            return false;
        }
    }

     /**
     * Change status for a CONTACT
     *
     * @param int $idPatient
     * @param int $idMotif
     * @param string $status
     */
    function changeContactStatus($idPatient, $idMotif, $status) {
        
    	$idPatient = (int) $idPatient;
    	$idMotif = (int) $idMotif;
    	
		$sql = "UPDATE `mp_pile` SET `date_derniere_modification` = now(), `statut` = '$status' WHERE `id_motif`   = '$idMotif' AND `id_patient` = '$idPatient'";
				            
        $upd = mysql_query($sql);

        if ($upd) {
            return true;
        } else {
            return false;
        }
        
    }
    
         /**
     * Change status for a CONTACT
     *
     * @param int $idPatient
     * @param int $idMotif
     * @param string $status
     */
    function getContactStatus($idPatient, $idMotif) {
        
    	$idPatient = (int) $idPatient;
    	$idMotif = (int) $idMotif;
    	
		$sql = "SELECT `statut` FROM `mp_pile` WHERE `id_motif`   = '$idMotif' AND `id_patient` = '$idPatient'";
				            
        $sel = mysql_query($sql);
        
        $status = mysql_fetch_array($sel);

        if ($sel) {
            return $status["statut"] ;
        } else {
            return false;
        }
        
    }
    
     /**
     * Change executeQuery
     *
     * @param string $sql
     * @return  $sel
     */
    function executeQuery($sql) {
        
    	$sel = mysql_query($sql);
        
        if (!empty($sel)) {
            return $sel;
        } else {
            return false;
        }
    }

    /**
     * Get a motif
     *
     * @param int $id
     * @return array $motif 
     */
    function getMotif($id) {
        
    	$id = (int) $id;
    	
    	$sql = "SELECT * FROM medecine_preventive WHERE motif_ID = '$id'";
    	
    	$sel = mysql_query($sql);
        
        $motif = mysql_fetch_array($sel);
        
        if (!empty($motif)) {
        	
        	$motif["ID"] = stripcslashes($motif["motif_ID"]);
        	$motif["description"] = stripcslashes($motif["description"]);
        	$motif["period"] = stripcslashes($motif["periode_nb"]);
          	$motif["period_unit"] = stripcslashes($motif["periode_base"]);
        	$motif["main_text"] = stripcslashes($motif["texte_principal"]);
        	$motif["request"] = stripcslashes($motif["requete"]);
        	$motif["frequency"] = stripcslashes($motif["recurrence"]);
        	$motif["sender_name"] = stripcslashes($motif["nom_expediteur"]);
          	$motif["sender_address1"] = stripcslashes($motif["adr_exp_ligne1"]);
        	$motif["sender_zip1city1"] = stripcslashes($motif["adr_exp_ligne2"]);
        	$motif["sender_mail"] = stripcslashes($motif["mail_expediteur"]);
          	$motif["sender_reply"] = stripcslashes($motif["mail_reply"]);
          	
          	return $motif;
        } else {
            return false;
        }
    }
    
	/**
     * Get a motif
     *
     * @param
     * @return 
     */
    function addMotif($description, $period, $period_unit, $main_text, $rappel, $request, $frequency, $sender_name, $sender_address1, $sender_zip1city1, $sender_mail, $sender_reply) {
    	
        $description = mysql_real_escape_string(htmlentities($description, ENT_NOQUOTES, "UTF-8"));
        $period = mysql_real_escape_string($period);
        $period_unit = mysql_real_escape_string($period_unit);
        $main_text = mysql_real_escape_string($main_text);
        $rappel = mysql_real_escape_string($rappel);
        $request = mysql_real_escape_string(addslashes($request));
        $frequency = mysql_real_escape_string($frequency);
        $sender_name = mysql_real_escape_string($sender_name);
        $sender_address1 = mysql_real_escape_string($sender_address1);
        $sender_zip1city1 = mysql_real_escape_string($sender_zip1city1);
        $sender_mail = mysql_real_escape_string($sender_mail);
        $sender_reply = mysql_real_escape_string($sender_reply);

		$sql = "INSERT INTO `medecine_preventive` ( `description` , `periode_nb` , `periode_base` , `texte_principal` , `rappel` , `recurrence` , `requete`, `nom_expediteur`, `adr_exp_ligne1`, `adr_exp_ligne2`, `mail_expediteur`,`mail_reply` )
				VALUES ( '$description',  '$period', '$period_unit', '$main_text', '$rappel', '$frequency', '$request', '$sender_name', '$sender_address1', '$sender_zip1city1', '$sender_mail', '$sender_reply' )";
		$ins = mysql_query($sql);

        // get current ID
        $insid = mysql_insert_id();
				
		$sql2 = "INSERT INTO `mp_activation_motifs` ( `id_motif` , `actif` ) VALUES ( '$insid', '0' )";
		$ins2 = mysql_query($sql2);
		
        if ($ins && $ins2) {
            return true;
        } else {
            return false;
        }
    	
    }
    
	/**
     * UPDATE a motif
     *
     * @param 
     * @return 
     */
    function updateMotif($description, $period, $period_unit, $main_text, $rappel, $frequency, $sender_name, $sender_address1, $sender_zip1city1, $sender_mail, $sender_reply, $id) {
        
        $id = (int) $id;
    	
        $description = mysql_real_escape_string($description);
        $period = mysql_real_escape_string($period);
        $period_unit = mysql_real_escape_string($period_unit);
        $main_text = mysql_real_escape_string($main_text);
        $rappel = mysql_real_escape_string($rappel);
        $frequency = mysql_real_escape_string($frequency);
        $sender_name = mysql_real_escape_string($sender_name);
        $sender_address1 = mysql_real_escape_string($sender_address1);
        $sender_zip1city1 = mysql_real_escape_string($sender_zip1city1);
        $sender_mail = mysql_real_escape_string($sender_mail);
        $sender_reply = mysql_real_escape_string($sender_reply);

        $sql = "UPDATE medecine_preventive set description='$description' , periode_nb='$period', periode_base='$period_unit', texte_principal='$main_text', rappel='$rappel', recurrence='$frequency', adr_exp_ligne1='$sender_address1', adr_exp_ligne2='$sender_zip1city1', nom_expediteur='$sender_name', mail_expediteur='$sender_mail', mail_reply='$sender_reply' WHERE motif_ID='$id'";
        
        $upd = mysql_query($sql);
        if ($upd) {
            return true;
        } else {
            return false;
        }
				        
    }
    
    /**
     * Get all motifs
     *
     * @return array $motif 
     */
    function getAllMotif() {
        
        $sql = "SELECT mp.motif_ID as ID, mp.description as description, mp.time_avg as time_avg, mp_a.actif as actif FROM mp_activation_motifs mp_a, medecine_preventive mp WHERE mp.motif_ID = mp_a.id_motif";
		
        $sel = mysql_query($sql);

        $motifs = array();
        
        while ($motif = mysql_fetch_array($sel)) {
        	
        	
        	//check max date
        	$sql2 = "SELECT `date` , first_insertion, to_call_back, init_contact, still_exist, deleted
					FROM mp_statistique
					WHERE motif_ID ='".$motif["ID"]."'
					AND `date` = ( select MAX( `date` ) FROM mp_statistique WHERE motif_ID ='".$motif["ID"]."' )";
        	$sel2 = mysql_query($sql2);
        	$motifStat = mysql_fetch_assoc($sel2);

        	$motif["lasteddate"] = $motifStat['date'];
        	$motif["first_insertion"] = $motifStat['first_insertion'];
        	$motif["to_call_back"] = $motifStat['to_call_back'];
        	$motif["init_contact"] = $motifStat['init_contact'];
        	$motif["still_exist"] = $motifStat['still_exist'];
        	$motif["deleted"] = $motifStat['deleted'];
        	        	
        	$motif["description"] = stripslashes($motif["description"]);
        	if ($motif["actif"]) $motif["actif"] = "checked"; else $motif["actif"] = "";
            array_push($motifs, $motif);
            
        }

        if (!empty($motifs)) {	
            return $motifs;
        } else {
            return false;
        }

    }
    
    /**
     * Delete a MOTIF
     *
     * @param int $idPatient
     * @param int $idMotif
     * @param string $status
     */
	function deleteMotif($id) {
    	
    	$id = (int) $id;
		    	        
        $sql = "DELETE FROM mp_pile WHERE `id_motif`   = '$id'";
        $del = mysql_query($sql);

        $sql = "DELETE FROM mp_activation_motifs WHERE `id_motif`   = '$id'";
        $del = mysql_query($sql);
                        
        $sql = "DELETE FROM medecine_preventive WHERE `motif_ID`   = '$id'";
        $del = mysql_query($sql);
        
        if ($del) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Change activation for a motif
     *
     * @param int $id
     * @param int $value
     */
    function changeMotifActivation($id, $value) {
        
    	$id = (int) $id;
    	$value = "".$value;
    	if ($value!="true") $value="0"; else $value ="1";
    	
		$sql = "UPDATE `mp_activation_motifs` SET `actif` = '$value' WHERE `id_motif`   = '$id'";
        $upd = mysql_query($sql);

        if ($upd) {
            return true;
        } else {
            return false;
        }
    	        
    }
	
    /**
     * Change average time for a motif
     *
     * @param int $id
     * @param int $value
     */
    function changeMotifTimeAgv($id, $value) {
        
    	$id = (int) $id;
    	$value = (int) $value;
    	
		$sql = "UPDATE `medecine_preventive` SET `time_avg` = '$value' WHERE `motif_ID`   = '$id'";
				            
        $upd = mysql_query($sql);

        if ($upd) {
            return true;
        } else {
            return false;
        }
        
    }
    
    /**
     * saveMotifBatch
     *
     */
    function saveMotifBatch($id,$firstInsertion,$toCallBack,$initContact,$stillExist,$deleted,$contacted) {
        
    	$id = (int) $id;
    	$firstInsertion = (int) $firstInsertion;
    	$toCallBack = (int) $toCallBack;
    	$initContact = (int) $initContact;
    	$stillExist = (int) $stillExist;
    	$deleted = (int) $deleted;
    	$contacted = (int) $contacted;
    	
    	$today = date("Y-m-d");
    	
		$sql = "INSERT INTO `mp_statistique` (`motif_ID` , `first_insertion`, `to_call_back`, `init_contact`, `still_exist`, `deleted` , `contacted` , `date` ) 
				VALUES ( '$id', '$firstInsertion', '$toCallBack', '$initContact', '$stillExist', '$deleted', '$contacted', '$today' );";

        $ins = mysql_query($sql);

        if (ins) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Get all infos on prevention
     *
     * @return array $status
     */
	function getStatus() {
    	
    	$status = array();
        
        $sql = "SELECT COUNT(*) as num_contact FROM mp_pile WHERE `statut`   = 'a_contacter'";
        $sel = mysql_query($sql);
        $result = mysql_fetch_array($sel);
        
        $status["to_contact"] = $result['num_contact'];

        $sql = "SELECT COUNT(*) as num_contact FROM mp_pile WHERE `statut`   = 'contacte'";
        $sel = mysql_query($sql);
        $result = mysql_fetch_array($sel);
        
        $status["contacted"] = $result['num_contact'];
        
        $sql = "SELECT COUNT(*) as num_contact FROM mp_pile WHERE `statut`   = 'a_rappeler'";
        $sel = mysql_query($sql);
        $result = mysql_fetch_array($sel);
        
        $status["call_back"] = $result['num_contact'];
        
        $sql = "SELECT COUNT(*) as num_contact FROM mp_pile WHERE `statut`   = 'termine'";
        $sel = mysql_query($sql);
        $result = mysql_fetch_array($sel);
        
        $status["deleted"] = $result['num_contact'];
        
        $sql = "SELECT COUNT(*) as num_motif FROM mp_activation_motifs";
        $sel = mysql_query($sql);
        $result = mysql_fetch_array($sel);

        $status["number_motif"] = $result['num_motif'];
        
        
        return $status;
    }

    /**
     * Get all infos on prevention
     *
     * @return string
     */
	function getTimeplotData($id) {
    		
		$sql = "SELECT first_insertion, to_call_back, init_contact, still_exist, deleted, contacted, date FROM mp_statistique WHERE motif_ID = '$id' ORDER BY date ASC";
		$sel = mysql_query($sql);

        while ($stat = mysql_fetch_array($sel)) {
        	
			$current = $stat['to_call_back'] + $stat['init_contact'] + $stat['still_exist'] + $stat['first_insertion'];
            $inserted = $stat['first_insertion'];
            $deleted = $stat['deleted'];
            $date = $stat['date'];
            $contacted = $stat['contacted'];
            
            echo "$date,$current,$inserted,$deleted,$contacted\n";
            
            
        }

    }
    
    function getDiffDay($debut, $fin) {
	  $tDeb = explode("-", $debut);
	  $tFin = explode("-", $fin);
	  $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) - mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);
	  return(($diff / 86400)+1);

	}
	
	function countGeneral($filter){
		
		$sel = mysql_query("SELECT count(id_patient) AS total FROM `mp_pile` WHERE statut!='termine '.$filter");
		
        $count = mysql_fetch_array($sel);
        
        if (!empty($count)) {
            return $count['total'];
        } else {
            return 0;
        }
	}
	
	function countTraite($filter){
		
		$sel = mysql_query("SELECT count(id_patient) AS total FROM `mp_pile` WHERE statut='termine '.$filter");
		
        $count = mysql_fetch_array($sel);
        
        if (!empty($count)) {
            return $count['total'];
        } else {
            return 0;
        }
	}
	
   	function get_jsonGeneral($sql,$langfile,$url) {
   		
		$permission[0] = $langfile["dico_admin_people_user_no_login"];
		$permission[1] = $langfile["dico_admin_people_user_user"];
		$permission[3] = $langfile["dico_admin_people_user_manager"];
		$permission[4] = $langfile["dico_admin_people_user_manager_advanced"];
		$permission[5] = $langfile["dico_admin_people_user_admin"];
   		
		$checkbox1 = "<input type='checkbox' name='cases' value='";
		$checkbox2 = "' onclick=javascript:controle('";
		$checkbox3 = "') id='check";
		$checkbox4 = "' />";
		
		$status1 = $langfile["dico_management_prevention_to_contact"];
		$status2 = $langfile["dico_management_prevention_contacted"];
		$status3 = $langfile["dico_management_prevention_presented"];
		$status4 = $langfile["dico_management_prevention_call_back"];
		$status5 = $langfile["dico_management_prevention_close"];
		
		$i = 0;
		$rows = array();
		
        $sel = mysql_query($sql);
        
        while ($mp = mysql_fetch_array($sel)) {        	
        	$rows[$i]['id']=$mp["id_patient"]."_".$mp["id_motif"];
        	switch($mp["statut"]){
        		case "a_contacter":
        			$mp["statut"] = $status1;
        			break;
        		case "contacte":
        			$mp["statut"] = $status2;
        			break;
        		case "rdv_pris":
        			$mp["statut"] = $status3;
        			break;
        		case "a_rappeler":
        			$mp["statut"] = $status4;
        			break;
        		case "termine":
        			$mp["statut"] = $statut5;
        			break;				
        	}
        	$mp["select"] = $checkbox1.$mp["id_motif"]."_".$mp["id_patient"].$checkbox2.$mp["id_motif"]."_".$mp["id_patient"].$checkbox3.$mp["id_motif"]."_".$mp["id_patient"].$checkbox4;
        	$tmp = htmlentities($mp["description"], ENT_NOQUOTES, "UTF-8");// = mysql_real_escape_string(stripcslashes($mp["description"]));
			$rows[$i]['cell']=array(
				$mp["nom"],
			    $mp["prenom"],
			    $mp["address"],
				$mp["telephone"],
			    $mp["gsm"],
			    $mp["mail"],
			    //stripcslashes($mp["description"]),
			    //$mp["description"],
			    html_entity_decode($tmp),
			    substr($mp["date_derniere_modification"], 8, 2)."/".substr($mp["date_derniere_modification"], 5, 2)."/".substr($mp["date_derniere_modification"], 0, 4),
			    $mp["statut"],
			    $mp["select"],
			);
			$i++;
        }
        
        if (!empty($rows)) {
            return $rows;
        } else {
            return false;
        }
        
    }
    
	function get_jsonTraite($sql,$langfile,$url) {
   		
		$permission[0] = $langfile["dico_admin_people_user_no_login"];
		$permission[1] = $langfile["dico_admin_people_user_user"];
		$permission[3] = $langfile["dico_admin_people_user_manager"];
		$permission[4] = $langfile["dico_admin_people_user_manager_advanced"];
		$permission[5] = $langfile["dico_admin_people_user_admin"];
   		
		$checkbox1 = "<input type='checkbox' name='cases' value='";
		$checkbox2 = "' onclick=javascript:controle('";
		$checkbox3 = "') id='check";
		$checkbox4 = "' />";
		
		$status1 = $langfile["dico_management_prevention_to_contact"];
		$status2 = $langfile["dico_management_prevention_contacted"];
		$status3 = $langfile["dico_management_prevention_presented"];
		$status4 = $langfile["dico_management_prevention_call_back"];
		$status5 = $langfile["dico_management_prevention_close"];
		
		$i = 0;
		$rows = array();
		
        $sel = mysql_query($sql);
        
        while ($mp = mysql_fetch_array($sel)) {        	
        	$rows[$i]['id']=$mp["id_patient"]."-".$mp["id_motif"];
        	switch($mp["statut"]){
        		case "a_contacter":
        			$mp["statut"] = $status1;
        			break;
        		case "contacte":
        			$mp["statut"] = $status2;
        			break;
        		case "rdv_pris":
        			$mp["statut"] = $status3;
        			break;
        		case "a_rappeler":
        			$mp["statut"] = $status4;
        			break;
        		case "termine":
        			$mp["statut"] = $statut5;
        			break;				
        	}
        	$mp["select"] = $checkbox1.$mp["id_motif"]."_".$mp["id_patient"].$checkbox2.$mp["id_motif"]."_".$mp["id_patient"].$checkbox3.$mp["id_motif"]."_".$mp["id_patient"].$checkbox4;
        	$tmp = htmlentities($mp["description"], ENT_NOQUOTES, "UTF-8");// = mysql_real_escape_string(stripcslashes($mp["description"]));
			$rows[$i]['cell']=array(
				$mp["nom"],
			    $mp["prenom"],
			    $mp["address"],
				$mp["telephone"],
			    $mp["gsm"],
			    $mp["mail"],
			    //stripcslashes($mp["description"]),
			    //$mp["description"],
			    html_entity_decode($tmp),
			    substr($mp["date_derniere_modification"], 8, 2)."/".substr($mp["date_derniere_modification"], 5, 2)."/".substr($mp["date_derniere_modification"], 0, 4),
			);
			$i++;
        }
        
        if (!empty($rows)) {
            return $rows;
        } else {
            return false;
        }
        
    }
}

?>