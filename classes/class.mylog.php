<?php
/*
 * This class provides methods to realize the logging of different activities
 *
 * @author Open Dynamics <info@o-dyn.de>
 * @name mylog
 * @version 0.4.5
 * @package Collabtive
 * @link http://www.o-dyn.de
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
 */
class mylog
{
    /*
    * Constructor
    */
    function __construct()
    {
    	$this->userid = $_SESSION["userid"];
    	$this->uname = $_SESSION["username"];
        //$this->userid = getArrayVal($_SESSION,"userid");
        //$this->uname = getArrayVal($_SESSION,"username");
    }

    /*
     * Add an event log entry
     *
     * @param string $object
     * @param string $type Type of the affected object
     * @param int $action
     * @return bool
     */
    function add($object, $type, $action) {
        $userid = $this->userid;
        $uname = $this->uname;

        $object = mysql_real_escape_string($object);
        $type = mysql_real_escape_string($type);
        $action = mysql_real_escape_string($action);

        $now = time();

        $sql = "INSERT INTO log (user_ID,user_name,object,type,action,date) VALUES ('$userid','$uname','$object','$type','$action',now())";
        $ins = mysql_query($sql);
        
        $upd = mysql_query("UPDATE user SET lastlogin = '$now' WHERE ID = $userid");
        
        if ($ins) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Delete an event log entry
     *
     * @param int $id Log entry ID
     * @return bool
     */
    function del($id)
    {
        $id = (int) $id;

        $del = mysql_query("DELETE FROM log WHERE ID = $id LIMIT 1");
        if ($del)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function get($date) {

		$sql = "SELECT `date`, date_format( `date` , '%d/%m/%Y %H:%m:%s' ) AS date_format, user_name, object, type, action FROM log WHERE `date` > '$date' ORDER BY `date` DESC";
		
		$sel = mysql_query($sql);

        $logs = array();

        while ($log = mysql_fetch_array($sel)) {
        	
            $log["date"] = stripslashes($log["date_format"]);
            $log["user_name"] = stripslashes($log["user_name"]);
            $log["object"] = stripslashes($log["object"]);
            $log["type"] = stripslashes($log["type"]);
            $log["action"] = stripslashes($log["action"]);
            
            array_push($logs, $log);
            
        }

        if (!empty($logs))  {
            return $logs;
        } else  {
            return false;
        }

    }
    /*
     * Format the date of an entry
     *
     * @param int $log Log entry ID
     * @param string $format Wanted format
     * @return array $log Entry with the formatted time
     */
    function formatdate($log, $format = "d.m.y (H:i:s)")
    {
        $cou = 0;

        if ($log)
        {
            foreach($log as $thelog)
            {
                $datetime = date($format, $thelog[7]);
                $log[$cou]["datum"] = $datetime;
                $cou = $cou + 1;
            }
        }

        if (!empty($log))
        {
            return $log;
        }
        else
        {
            return false;
        }
    }
}
?>