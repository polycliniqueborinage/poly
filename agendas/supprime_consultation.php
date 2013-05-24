<?

	session_start();

	include_once '../lib/fonctions.php';

	$dateCurrent = isset($_SESSION['dateCurrent']) ? $_SESSION['dateCurrent'] : "";

	$medecinCurrent = isset($_SESSION['medecinCurrent']) ? $_SESSION['medecinCurrent'] : "";

	$id = isset($_GET['id']) ? $_GET['id'] : "";
	
	connexion_DB('poly');
	//morning
	$sql = "select id, length, tri, midday  FROM`".$medecinCurrent."` WHERE `date` = '".$dateCurrent."' AND `id` = '".$id."'";
	
	$result = mysql_query($sql);
	
	if(mysql_num_rows($result)!=0) {
		// un seul resultat
		$data = mysql_fetch_assoc($result);
		$tri = $data['tri'];
		$length = $data['length'];
		$midday = $data['midday'];
	}
		
	$sql = "DELETE FROM `".$medecinCurrent."` WHERE `date` = '".$dateCurrent."' AND `id` = '".$id."' LIMIT 1";
	$result = mysql_query($sql);
		
	$sql = "UPDATE `".$medecinCurrent."` SET top  = top + ".$length." WHERE `date` = '".$dateCurrent."' AND midday ='".$midday."' AND tri > ".$tri;
	$result = mysql_query($sql);
	
	// delete in new agenda
	$sql = "SELECT ID FROM user WHERE inami = '".$medecinCurrent."' LIMIT 0,1";
	$result = requete_SQL($sql);
	if(mysql_num_rows($result)==1) {
			
		$data = mysql_fetch_assoc($result);
		$userID = $data['ID'];
				
		$sql = "DELETE FROM `agenda_".$userID."` WHERE `ID` = ".$tri;
		echo $sql;
		$result = requete_SQL($sql);
		
	}
	
	deconnexion_DB();
	
	
?>