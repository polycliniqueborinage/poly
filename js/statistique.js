function loadStatistique (type,value){
	
	new Ajax.Updater('generalinfo', '../statistiques/pie/pie_info.php?'+type+'='+value, {
		method: 'get'
	});

	/*new Ajax.Request('../statistiques/pie_info.php',
		{
			method:'get',
			parameters: {type: value},
	  		onSuccess: function(transport){
				$('generalinfo').innerHTML = transport.responseText;
		 	},
		});*/

	new Ajax.Updater('informationtable', '../statistiques/pie/pie_table.php?'+type+'='+value, {
		method: 'get'
	});

	new Ajax.Updater('informationinfo', '../statistiques/pie/pie_info.php?'+type+'='+value, {
		method: 'get'
	});

	new Ajax.Updater('generalimage', '../statistiques/pie_image.php', {
	method: 'get',
	parameters: {type: type, value: value}
	});

}

function loadBarStatistique (type,value){
	$('general').innerHTML = "<img class='centerimage' src='../images/attente.gif'/>";
	
	new Ajax.Updater('general', '../statistiques/bar_image.php', {
	method: 'get',
	parameters: {type: type, value: value}
	});
	
	$('information').innerHTML = "<img class='centerimage' src='../images/attente.gif'/>";
	new Ajax.Updater('information', '../statistiques/bar_table.php?'+type+'='+value, {
	method: 'get'
	});
}


function loadLineStatistique (type,value){
	$('general').innerHTML = "<img class='centerimage' src='../images/attente.gif'/>";
	
	new Ajax.Updater('general', '../statistiques/line_image.php', {
	method: 'get',
	parameters: {type: type, value: value}
	});
	
	$('information').innerHTML = "<img class='centerimage' src='../images/attente.gif'/>";
	new Ajax.Updater('information', '../statistiques/line_table.php?'+type+'='+value, {
	method: 'get'
	});
}
