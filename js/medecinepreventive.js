
function addcritere()
{
	var tablegeneral = document.getElementById("general").tBodies[0];
	
	var nbrCriteres = (tablegeneral.rows.length + 1) / 2;
	var curseur = 1000 - nbrCriteres;
	
	document.getElementById("number").value = nbrCriteres + 1; 
	// Ajoute une checkbox à toutes les lignes dejà presentes
	for( var i=0; i<nbrCriteres; i++){
			var ligne   = document.getElementById(i).tBodies[0];
			var newCell = ligne.rows[0].insertCell(-1);
			
			var chkbx = document.createElement("input");
			chkbx.setAttribute("type", "checkbox");
			chkbx.setAttribute("id", i+"_"+nbrCriteres);
			chkbx.setAttribute("name", i+"_"+nbrCriteres);
			newCell.appendChild(chkbx);
	}
	
	for(i=nbrCriteres-1; i>=0; i--){
		for(j=nbrCriteres-1; j>=1; j--){
			var id_j = j+1;
			if(document.getElementById(i+"_"+j).checked != ''){
				document.getElementById(i+"_"+j).checked = '';
				document.getElementById(i+"_"+id_j).checked = 'true';
			}
		}
	}

	//Ajoute la ligne pour les jointures				
	var newRow = document.getElementById("general").insertRow(-1);
	var newCell = newRow.insertCell(0);
	newCell.innerHTML = '';
	newCell = newRow.insertCell(1);
	newCell.innerHTML = "<select id=\"combinaison"+nbrCriteres+"\" name=\"combinaison"+nbrCriteres+"\"><option value=\"AND\">ET</option><option value=\"OR\">OU</option></select>";
	newCell = newRow.insertCell(2);
	newCell.innerHTML = '';
	newCell = newRow.insertCell(3);
	newCell.innerHTML = '';
	newCell = newRow.insertCell(4);
	newCell.innerHTML = '';
	
	//Ajoute une nouvelle ligne à la fin du tableau
	var newRow = document.getElementById("general").insertRow(-1);
	var newFirstCell   = document.createElement("td");
	var newSecondCell  = document.createElement("td");
	var newThirdCell   = document.createElement("td");
	var newFourthCell  = document.createElement("td");
	var newSixthCell   = document.createElement("td");
	var newSeventhCell = document.createElement("td");
	var newEightCell   = document.createElement("td");
	var newNinethCell  = document.createElement("td");
	
	newSecondCell.setAttribute("size", "40pt");
	newSeventhCell.setAttribute("size", "40pt");
	
	//Contenu de la premiere cellule
	var newTableCell      = document.createElement("table");
	newTableCell.setAttribute("id", nbrCriteres);
	var newTableCellBody  = document.createElement("tbody");
	var newTableCellRow   = document.createElement("tr");

	for(var j=1; j<=nbrCriteres; j++){
		var subCell    = document.createElement("td");
		var newSubCell = document.createElement("input");
		newSubCell.setAttribute("type", "checkbox");
		newSubCell.setAttribute("id",   nbrCriteres+"_"+j);
		newSubCell.setAttribute("name", nbrCriteres+"_"+j);
		
		subCell.appendChild(newSubCell);
		newTableCellRow.appendChild(subCell);
	}
	newTableCellBody.appendChild(newTableCellRow);
	newTableCell.appendChild(newTableCellBody);
	
	//Contenu de la troisieme cellule
	var newFieldDB    = document.createElement("select");
	newFieldDB.setAttribute("id", "table"+nbrCriteres);
	newFieldDB.setAttribute("name", "table"+nbrCriteres);
	newFieldDB.setAttribute("onclick", "javascript:searchSuggest("+nbrCriteres+")");
	
	var selected = 0;
	
	if( document.getElementById('patients').value != '' ){
		var opt1 = document.createElement("option");
		opt1.value = "patients";
		opt1.text = "Patients";
		if(selected == 0) opt1.selected = "true";
		selected = 1;
		newFieldDB.appendChild(opt1);
	}
	if( document.getElementById('medecins').value != '' ){
		var opt2 = document.createElement("option");
		opt2.value = "medecins";
		opt2.text = "Médecins";
		if(selected == 0) opt2.selected = "true";
		selected = 1;
		newFieldDB.appendChild(opt2);
	}
	if( document.getElementById('visites').value != '' ){
		var opt3 = document.createElement("option");
		opt3.value = "visites";
		opt3.text = "Visites";
		if(selected == 0) opt3.selected = "true";
		selected = 1;
		newFieldDB.appendChild(opt3);
	}
	if( document.getElementById('tarifications').value != '' ){
		var opt4 = document.createElement("option");
		opt4.value = "tarifications";
		opt4.text = "Tarifications";
		if(selected == 0) opt4.selected = "true";
		selected = 1;
		newFieldDB.appendChild(opt4);
	}
	if( document.getElementById('tarifications_detail').value != '' ){
		var opt9 = document.createElement("option");
		opt9.value = "tarifications_detail";
		opt9.text = "Tarifications détails";
		if(selected == 0) opt9.selected = "true";
		selected = 1;
		newFieldDB.appendChild(opt9);
	}
	
	//Contenu de la quatrieme cellule
	var newChamps  = document.createElement("input");
	newChamps.setAttribute("type", "text");
	newChamps.setAttribute("id", "champs"+nbrCriteres);
	newChamps.setAttribute("name", "champs"+nbrCriteres);
	newChamps.setAttribute("readonly", "true");
	newChamps.setAttribute("autocomplete", "off");
	var newDiv = document.createElement("div");
	newDiv.setAttribute("id", "search_suggest"+nbrCriteres);
	
	//Contenu de la sixieme cellule
	var newForm    = document.createElement("form");
	newForm.setAttribute("id", "formradio"+nbrCriteres);
	newForm.setAttribute("name", "formradio"+nbrCriteres);
	
	var newChoice1 = document.createElement("input");
	newChoice1.setAttribute("type", "radio");
	//newChoice1.setAttribute("id", "valeur_ou_jointure"+nbrCriteres);
	//newChoice1.setAttribute("name", "valeur_ou_jointure"+nbrCriteres);
	newChoice1.setAttribute("id", "valeur_ou_jointure");
	newChoice1.setAttribute("name", "valeur_ou_jointure");
	newChoice1.setAttribute("value", "0");
	newChoice1.setAttribute("onclick", "document.getElementById('valeur"+nbrCriteres+"').style.display=''; document.getElementById('table"+curseur+"').style.display='none'; document.getElementById('champs"+curseur+"').style.display='none';");
	newChoice1.setAttribute("checked", "true");
	var newLabel1 = document.createTextNode( '' );
	newLabel1.data = 'Valeur';
	
	var newBR = document.createElement("br");
	
	var newChoice2 = document.createElement("input");
	newChoice2.setAttribute("type", "radio");
	//newChoice2.setAttribute("id", "valeur_ou_jointure"+nbrCriteres);
	//newChoice2.setAttribute("name", "valeur_ou_jointure"+nbrCriteres);
	newChoice2.setAttribute("id", "valeur_ou_jointure");
	newChoice2.setAttribute("name", "valeur_ou_jointure");
	newChoice2.setAttribute("value", "1");
	newChoice2.setAttribute("onclick", "document.getElementById('valeur"+nbrCriteres+"').style.display='none'; document.getElementById('table"+curseur+"').style.display='';     document.getElementById('champs"+curseur+"').style.display='';");
	var newLabel2 = document.createTextNode( '' );
	newLabel2.data = 'Jointure';
	
	
	newForm.appendChild(newChoice1);
	newForm.appendChild(newLabel1);
	newForm.appendChild(newBR);
	newForm.appendChild(newChoice2);
	newForm.appendChild(newLabel2);
	
	//Contenu de la septieme cellule
	var newValeur     = document.createElement("input");
	newValeur.setAttribute("type", "text");
	newValeur.setAttribute("id", "valeur"+nbrCriteres);
	newValeur.setAttribute("name", "valeur"+nbrCriteres);
	
	//Contenu de la huitieme cellule
	var newFieldDB2   = document.createElement("select");
	newFieldDB2.setAttribute("id", "table"+curseur);
	newFieldDB2.setAttribute("name", "table"+curseur);
	newFieldDB2.setAttribute("style", "display:none");
	newFieldDB2.setAttribute("onclick", "javascript:searchSuggest("+curseur+")");
	
	selected = 0;
	
	if( document.getElementById('patients').value != '' ){
		var opt5 = document.createElement("option");
		opt5.value = "patients";
		opt5.text = "Patients";
		if(selected == 0) opt5.selected = "true";
		selected = 1;
		newFieldDB2.appendChild(opt5);
	}
	if( document.getElementById('medecins').value != '' ){
		var opt6 = document.createElement("option");
		opt6.value = "medecins";
		opt6.text = "Médecins";
		if(selected == 0) opt6.selected = "true";
		selected = 1;
		newFieldDB2.appendChild(opt6);
	}
	if( document.getElementById('visites').value != '' ){
		var opt7 = document.createElement("option");
		opt7.value = "visites";
		opt7.text = "Visites";
		if(selected == 0) opt7.selected = "true";
		selected = 1;
		newFieldDB2.appendChild(opt7);
	}
	if( document.getElementById('tarifications').value != '' ){
		var opt8 = document.createElement("option");
		opt8.value = "tarifications";
		opt8.text = "Tarifications";
		if(selected == 0) opt8.selected = "true";
		selected = 1;
		newFieldDB2.appendChild(opt8);
	}
	if( document.getElementById('tarifications_detail').value != '' ){
		var opt10 = document.createElement("option");
		opt10.value = "tarifications_detail";
		opt10.text = "Tarifications détails";
		if(selected == 0) opt10.selected = "true";
		selected = 1;
		newFieldDB2.appendChild(opt10);
	}	
	
	//Contenu de la huitième cellule
	var newChamps2  = document.createElement("input");
	newChamps2.setAttribute("type", "text");
	newChamps2.setAttribute("id", "champs"+curseur);
	newChamps2.setAttribute("name", "champs"+curseur);
	newChamps2.setAttribute("readonly", "true");
	newChamps2.setAttribute("autocomplete", "off");
	newChamps2.setAttribute("style", "display:none");
	var newDiv2 = document.createElement("div");
	newDiv2.setAttribute("id", "search_suggest"+curseur);
	
	//Contenu de la neuvième cellule
	var newIcon = document.createElement("a");
	newIcon.setAttribute("onclick", "deletecritere("+nbrCriteres+")");
	var newImg = document.createElement("img");
	newImg.setAttribute("src",    "../images/document_delete.gif");
	newImg.setAttribute("alt",    "Supprimer le crit&egrave;re");
	newImg.setAttribute("title",  "Supprimer le crit&egrave;re");
	newImg.setAttribute("border", "0");
	newImg.setAttribute("width",  "15");
	newIcon.appendChild(newImg);
	
	//On assigne le contenu au cellule
	newFirstCell.appendChild(newTableCell);
	newThirdCell.appendChild(newFieldDB);
	newFourthCell.appendChild(newChamps);
	newFourthCell.appendChild(newDiv);
	newSixthCell.appendChild(newForm);
	newSeventhCell.appendChild(newValeur);
	newSeventhCell.appendChild(newFieldDB2);
	newEightCell.appendChild(newChamps2);
	newEightCell.appendChild(newDiv2);
	newNinethCell.appendChild(newIcon);
	
	//On assigne les cellules a la table
	newRow.appendChild(newFirstCell);
	newRow.appendChild(newSecondCell);
	newRow.appendChild(newThirdCell);
	newRow.appendChild(newFourthCell);
	
	//ajout special pour les operateurs
	newCell = newRow.insertCell(4);
	newCell.innerHTML = "<select id=\"operateur"+nbrCriteres+"\" name=\"operateur"+nbrCriteres+"\"><option value=\"=\" selected>=</option><option value=\">\">&gt;</option><option value=\">=\">&ge;</option><option value=\"<\">&lt;</option><option value=\"<=\">&le;</option><option value=\"<>\"><></option><option value=\"IN\">IN</option><option value=\"NOT IN\">NOT IN</option></select>";
	
	//newRow.appendChild(newFithCell);
	newRow.appendChild(newSixthCell);
	newRow.appendChild(newSeventhCell);
	newRow.appendChild(newEightCell);
	newRow.appendChild(newNinethCell);	
}

function checkmotif(field){
		  	
	if(field.options[field.selectedIndex].value == 0)
    	document.getElementById("nouveau_motif").readOnly = false;
	else
		document.getElementById("nouveau_motif").readOnly = true;
}

function checkChangementEntree(field1, field2){
	if(field1.options[field1.selectedIndex].value == field2){
    	alert("Vous n'avez pas modifié le statut. - Vérifiez également la date.");
    	return(0);
    }
	else{
		return(1);
	}	
}

function assignValeurRetour(field1, field2){
	field1 = field2; 
}

function recupererLettresImprimer(){
	var checkboxes = document.getElementsByTagName("input");
	var j = 0;
	var buffer = "";
	var new_date = new Date();
	var jour  = new_date.getDate();
	if(jour < 10) jour = '0'+jour;
	var mois  = new_date.getMonth();
	mois += 1;
	if(mois < 10) mois = '0'+mois;
	var annee = new_date.getYear();
	annee = annee + 1900;
	for(i=0; i<checkboxes.length; i++){
		if(checkboxes[i].id.substr(0, 1) == 'L' && checkboxes[i].type == "checkbox" && checkboxes[i].checked != ''){
			var tab = checkboxes[i].id.split('_');
			if(j==0)
				buffer += "?motif"+j+"="+tab[1]+"&patient"+j+"="+tab[2];
			else
				buffer += "&motif"+j+"="+tab[1]+"&patient"+j+"="+tab[2];
			
			
			if(document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value == 'a_contacter' || document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value == 'a_rappeler')
				document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value = 'contacte';
			document.getElementById('date'+'_'+tab[1]+'_'+tab[2]).value = annee+'-'+mois+'-'+jour;
			
			j++;	
		}
	}
	if( j > 0 ){
		buffer += "&nb="+j;
		window.open('./imprimer_lettre.php'+buffer);
	}	
	else
		alert("Aucun document n'est sélectionné pour l'impression...");
}

function recupererMailAEnvoyer(){
	var checkboxes = document.getElementsByTagName("input");
	var j = 0;
	var buffer = "";
	var new_date = new Date();
	var jour  = new_date.getDate();
	if(jour < 10) jour = '0'+jour;
	var mois  = new_date.getMonth();
	mois += 1;
	if(mois < 10) mois = '0'+mois;
	var annee = new_date.getYear();
	annee = annee + 1900;
	for(i=0; i<checkboxes.length; i++){
		if(checkboxes[i].id.substr(0, 1) == 'M' && checkboxes[i].type == "checkbox" && checkboxes[i].checked != ''){
			var tab = checkboxes[i].id.split('_');
			if(j==0)
				buffer += "?motif"+j+"="+tab[1]+"&patient"+j+"="+tab[2];
			else
				buffer += "&motif"+j+"="+tab[1]+"&patient"+j+"="+tab[2];
			j++;	
			
			if(document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value == 'a_contacte' || document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value == 'a_rappeler')
				document.getElementById('statut'+'_'+tab[1]+'_'+tab[2]).value = 'contacte';
			document.getElementById('date'+'_'+tab[1]+'_'+tab[2]).value = annee+'-'+mois+'-'+jour;
		}
	}
	if( j > 0 ){
		buffer += "&nb="+j;
		window.open('./envoyer_mail.php'+buffer);
	}	
	else
		alert("Aucun document n'est sélectionné pour l'envoi...");
}

function checkCriteres(f){
	
	var tablegeneral = document.getElementById("general").tBodies[0];
	var nbrCriteres = (tablegeneral.rows.length + 1) / 2;
	var curseur = 1000 - nbrCriteres;
	
	var test1 = 0;
	var test2 = 0;
	var test3 = 0;
	var test4 = 0;
	var test5 = 0;
	var test6 = 0;
	
	//TEST 1 - S'il y a plusieurs critères, les checkbox doivent être cochées 
	var filledChkbx = 0;
	if(nbrCriteres > 1){
		for(var i=0; i<nbrCriteres; i++){
			for(var j=1; j<nbrCriteres; j++){
				if(document.getElementById(i+"_"+j).checked)
					filledChkbx++;
			}		
		}
	}
	else
		filledChkbx++;
	
	if(filledChkbx == 0)
		test1 = 1;
	
	//FIN TEST 1
	
	//TEST 2 - Tous les champs de la 1ère partie du critère doivent être remplis
	var unfilledChamps1 = 0;
	for(i=0; i<nbrCriteres; i++){
		if(document.getElementById("champs"+i).value == "")
			unfilledChamps1++;
	}
	if(unfilledChamps1 > 0)
		test2 = 1;
	
	//FIN TEST 2
	
	//TEST 3 & 4 - Tous les champs "valeurs" ou "champs" doivent être remplis uniquement si le critère vise une valeur ou un champs
	var unfilledChamps2 = 0;
	var unfilledValeur  = 0;
	for(i=0; i<nbrCriteres; i++){
		var curseur2 = 1000 - i;
		var formName = "formradio"+i;
		if(document.forms[i].valeur_ou_jointure[0].checked){
			if(document.getElementById("valeur"+i).value == "")
				unfilledValeur++;
		}
		else{
			if(document.getElementById("champs"+curseur2).value == "")
				unfilledChamps2++;
		}
	}
	
	if(unfilledChamps2 > 0)
		test3 = 1;
	if(unfilledValeur > 0)
		test4 = 1;
		
	//FIN TEST 3 & 4
	
	//TEST 5 - Toutes les lignes contiennent au moins 1 case cochée
	if(nbrCriteres>1){
		for(i=0; i<nbrCriteres; i++){
			var filled = 0;
			for(j=1; j<nbrCriteres; j++){
				if(document.getElementById(i+"_"+j).checked != '')
					filled++;
			}
			if(filled == 0)
				test5 = 1;
		}
	}	
	
	//FIN TEST 5
	
	//TEST 6 - Si une colonnes à une case cochée, il doit au moins y en avoir 2 sur la même colonne ET il ne peut pas y avoir une colonne vide entre 2 colonnes où des cases sont cochées
	if(nbrCriteres>1){
		empty = true;
		var curseur=1;
		while(empty && curseur<nbrCriteres){
			for(i=0; i<nbrCriteres; i++){
				if(document.getElementById(i+"_"+curseur).checked)
					empty=false;
			}
			if(empty)
				curseur++;
		}
		var previous = 0;
		for(j=curseur; j<nbrCriteres; j++){
			var filled = 0;
			for(i=0; i<nbrCriteres; i++){
				if(document.getElementById(i+"_"+j).checked)
					filled++;
			}
			if(filled < 2)
				test6 = 1;
			else
				previous = 1;	
			if(filled == 0 && previous == 1){
				test6 = 1;	
			}	
		}
	}
	
	//FIN TEST 6		
	
				
	if(test1 == 1) document.getElementById("error_message1").style.display='';
	else  document.getElementById("error_message1").style.display='none';
	if(test2 == 1) document.getElementById("error_message2").style.display='';
	else  document.getElementById("error_message2").style.display='none';
	if(test3 == 1) document.getElementById("error_message3").style.display='';
	else  document.getElementById("error_message3").style.display='none';
	if(test4 == 1) document.getElementById("error_message4").style.display='';
	else  document.getElementById("error_message4").style.display='none';
	if(test5 == 1) document.getElementById("error_message5").style.display='';
	else  document.getElementById("error_message5").style.display='none';
	if(test6 == 1) document.getElementById("error_message6").style.display='';
	else  document.getElementById("error_message6").style.display='none';
	
	if(test1 == 0 && test2 == 0 && test3 == 0 && test4 == 0 && test5 == 0 && test6 == 0)
		document.forms['form1'].submit();
}

function checkCriteresType(){
	var test7 = 0;
	if(document.getElementById("cecodi").value == '' || document.getElementById("begda").value == '' || document.getElementById("endda").value == '')
		test7 = 1;
		
	if(test7 == 1) document.getElementById("error_message7").style.display='';
	else  document.getElementById("error_message7").style.display='none';	 
}

function deletecritere(row_id){
	var tablegeneral = document.getElementById("general").tBodies[0];
	var nbrCriteres = (tablegeneral.rows.length + 1) / 2;
	document.getElementById("number").value = nbrCriteres - 1;
	
	//On décale les cases déjà cochées
	for(i=0; i<nbrCriteres; i++){
		for(j=1; j<nbrCriteres; j++){
			var id_j = j-1;
			if(id_j>0)
				document.getElementById(i+"_"+id_j).checked = document.getElementById(i+"_"+j).checked;
		}
	}
	for(i=row_id+1; i<nbrCriteres; i++){
		for(j=1; j<nbrCriteres; j++){
			var id_i = i-1;	
				document.getElementById(id_i+"_"+j).checked = document.getElementById(i+"_"+j).checked;
		}
	}
	
	for(i=row_id+1; i<nbrCriteres; i++){
		var id_i = i-1;
		var curseur1 = 1000 - i;
		var curseur2 = 1000 - id_i;	
		
		document.getElementById("table"+id_i).selectedIndex        = document.getElementById("table"+i).selectedIndex;
		document.getElementById("champs"+id_i).value               = document.getElementById("champs"+i).value;
		document.getElementById("operateur"+id_i).selectedIndex    = document.getElementById("operateur"+i).selectedIndex;	

		document.forms[id_i].valeur_ou_jointure[0].checked = document.forms[i].valeur_ou_jointure[0].checked;
		document.forms[id_i].valeur_ou_jointure[0].value   = document.forms[i].valeur_ou_jointure[0].value;
		document.forms[id_i].valeur_ou_jointure[1].checked = document.forms[i].valeur_ou_jointure[1].checked;
		document.forms[id_i].valeur_ou_jointure[1].value   = document.forms[i].valeur_ou_jointure[1].value;
		
		if(document.forms[id_i].valeur_ou_jointure[0].checked){
			document.getElementById('valeur'+id_i).style.display='';     
			document.getElementById('table'+curseur2).style.display='none'; 
			document.getElementById('champs'+curseur2).style.display='none';
		}
		else{
			document.getElementById('valeur'+id_i).style.display='none'; 
			document.getElementById('table'+curseur2).style.display='';     
			document.getElementById('champs'+curseur2).style.display='';
		}
			
		document.getElementById("valeur"+id_i).value               = document.getElementById("valeur"+i).value;
		document.getElementById("table"+curseur2).selectedIndex    = document.getElementById("table"+curseur1).selectedIndex;
		document.getElementById("champs"+curseur2).value           = document.getElementById("champs"+curseur1).value;
			
	}
	
	//On supprime la dernière colonne de la tables de checkbox
	for(var i=0; i < nbrCriteres; i++) {
        oneRow = document.getElementById(i).tBodies[0];
        oneRow.rows[0].deleteCell(nbrCriteres-2);
    }
	
	//On supprime la la dernière ligne 
	if(nbrCriteres > 1){
		document.getElementById('general').deleteRow(nbrCriteres+(nbrCriteres-1)-1);
		document.getElementById('general').deleteRow(nbrCriteres+(nbrCriteres-1)-2);
	}
	
}

function mpDisplayDetails( motif, patient ){
	var str_motif       = "tab_motif_"+motif+"_"+patient;
	var str_patient     = "tab_patient_"+motif+"_"+patient;
	var str_open_arrow  = "open_arrow_"+motif+"_"+patient;
	var str_close_arrow = "close_arrow_"+motif+"_"+patient;
	
	if( document.getElementById(str_open_arrow).style.display == 'none' ){
		document.getElementById(str_motif).style.visibility       = 'visible';
		document.getElementById(str_motif).style.display          = 'block';
		document.getElementById(str_patient).style.visibility     = 'visible';
		document.getElementById(str_patient).style.display        = 'block';
		document.getElementById(str_open_arrow).style.visibility  = 'visible';
		document.getElementById(str_open_arrow).style.display     = 'block';
		document.getElementById(str_close_arrow).style.visibility = 'hidden';
		document.getElementById(str_close_arrow).style.display    = 'none';
	}
	else{
		document.getElementById(str_motif).style.visibility       = 'hidden';
		document.getElementById(str_motif).style.display          = 'none';
		document.getElementById(str_patient).style.visibility     = 'hidden';
		document.getElementById(str_patient).style.display        = 'none';
		document.getElementById(str_open_arrow).style.visibility  = 'hidden';
		document.getElementById(str_open_arrow).style.display     = 'none';
		document.getElementById(str_close_arrow).style.visibility = 'visible';
		document.getElementById(str_close_arrow).style.display    = 'block';
	}
}	

function openMotifInfo(id) {
			var url = "../medecine_preventive/motif_details.php?id="+id;
			win0 = new Window({className: "alphacube", title: "Information motif", top:0, right:0, width:540, height:400 });  
			win0.setURL(url)
			win0.show();
}