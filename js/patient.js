// recherche patient complete
function patientRechercheComplete(patient) {
  	if(trim(patient)!='') {
  		new Ajax.Updater(
			'patientBox',
			'../lib/patient_recherche_complete.php',
			{
				method: 'get',
				parameters: {patient: htmlentities(patient)}
			}
		);
	} else {
	    $('patientBox').innerHTML = '';
	}
}


// recherche titulaire complete
function titulaireRechercheComplete(titulaire) {
  	if(trim(titulaire)!='') {
  		new Ajax.Updater(
			'patientBox',
			'../lib/patient_recherche_complete.php',
			{
				method: 'get',
				parameters: {titulaire: htmlentities(titulaire)}
			}
		);
	} else {
	    $('patientBox').innerHTML = '';
	}
}


function patientRechercheDirect() {
	var nom = $('nom').value;
	var prenom = $('prenom').value;
	$('findPatientInput').value=nom+" "+prenom;
 	patient_recherche_simple(nom+" "+prenom);
}

function patientRechercheDirectRecherche(patient) {
	$('findPatientInput').value=patient;
 	patient_recherche_simple(patient);
}


function patientGestionTitulaire() {
	 var titulaireNom;
	 var titulairePrenom;
	 titulaireNom = $('nom').value;
	 titulairePrenom =  $('prenom').value;
	 $('titulaire').value=titulaireNom+" "+titulairePrenom;
}


function cleanTitulaire() {
	$('titulaire_id').value = '';
	$('mutuelle_code').value = '';
	$('ct1ct2').value = '';
	$('tiers_payant').checked = false;
	try {
		$('mutuelle_nom').value = '';
	} catch(e) {}
}


function checkTitulaire(pseudo){

	if (pseudo =='') {
		cleanTitulaire();
	} else {
		$('findPatientInput').value = pseudo;
		patient_recherche_simple(pseudo);
		new Ajax.Request('../patients/patient_check_titulaire.php',
		{
			method:'get',
			parameters: {pseudo: htmlentities(pseudo)},
			asynchronous:false,
			requestHeaders: {Accept: 'application/json'},
  			onSuccess: function(transport, json){
  				var titulaire = json.root.nom+" "+json.root.prenom;
  				if (titulaire != " ") {
			      	$('titulaire_id').value = json.root.id;
			      	$('titulaire').value = html_entity_decode(json.root.nom+" "+json.root.prenom);
			      	$('mutuelle_code').value = json.root.mutuelle_code;
			      	$('ct1ct2').value = json.root.ct1 + "-" + json.root.ct2;
			      	$('tiers_payant').checked = json.root.tiers_payant;
			      	try {
						$('mutuelle_nom').value = html_entity_decode(json.root.mutuelle_code+" "+json.root.mutuelle_nom);
						$('label').value = html_entity_decode(json.root.ct1 + "-" + json.root.ct2 + " - " + json.root.type_label );
					} catch(e) {}
  				} else {
  					cleanTitulaire();
  				}
		    },
		    onFailure: function(){ alert('failure'); }
		});
	}
}

// action sur la table patient
function patientAction(type,id) {
	new Ajax.Request('../patients/patient_action.php',
		{
			method:'get',
			parameters: {type : type, id : id},
			asynchronous:false,
			requestHeaders: {Accept: 'application/json'},
	  		onSuccess: function(transport, json){
	  			$('formmodif').innerHTML=json.root.info;
  				patientRechercheComplete($('patient').value);
    	    },
		    onFailure:  function(){ alert('failure');} 
		});
}

function switchGeneral(id) {
	var all = 4;
	for(i=1;i<all;i++) {
		try{
			if (i == id) {
				$('sec_li_'+i).setAttribute("class","nodelete current");
				Element.show('table_'+i);
				Element.show('sec_li_'+(i+1));
			}
			else{
				$('sec_li_'+i).setAttribute("class","nodelete");
				Element.hide('table_'+i);
			}
		} catch(e){};
	}
}
