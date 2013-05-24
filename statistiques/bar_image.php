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
	
	$type = isset($_GET['type']) ? $_GET['type'] : "";
	$value = isset($_GET['value']) ? $_GET['value'] : "";
	
	function image($file) {
	echo "<td>
	<a href='".$file."'><img src='".$file."' style='border: 0px'/></a>
	</td>";
	}
	
	image("bar/bar.php?$type=$value");
?>						
