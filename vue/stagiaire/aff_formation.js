//variable d'enregistrement de la formation choisie
var checkradio = null;
//fonction de transfert de HTTPRequest
function getXMLHttpRequest(){
	var xhr = null;
	if (window.XMLHttpRequest || window.ActiveXObject){
		if(window.ActiveXOblect){
			try{
				xhr = new ActiveXOblect("msxml2.XMLHTTP");
			}catch(e){
				xhr = new ActiveXOblect("microsoft.XMLHTTP");
			}
		}else{
			xhr = new XMLHttpRequest();
		}
	}else{
		alert ("L'objet XMLHttpRequest n'a pas pu etre instancié!");
		return;
	}
	return xhr;
}

function request(oSelect){
	//recup de l'id du type de formation 
	var idTForm = oSelect.options[oSelect.selectedIndex].value;
	//enregistre dans la variable checkradio le bouton radio selectionné si il y en a un
	recupCBox();
	var xhr = getXMLHttpRequest();
	
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
				readData(xhr.responseXML);
			}
		};
	//lance refreshmod avec idform en parametre url
	xhr.open("POST","refreshmod.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idTForm="+idTForm);
}

function insertContenu(oSelect){
	//recup du bouton radio selectionné
		recupCBox();
		idForm = checkradio;
		//recuperation du nom et prenom du stagiaire dans le DOM
		var nom = document.getElementById('nom_form').value;
		var prenom = document.getElementById('prenom_stag').value;

	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
			updateData(xhr.responseText);
		}
	};
	//execute datagiver avec les variable nom prenom et idformation
	xhr.open("POST","dataGiver.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("nom=" + nom + "&prenom=" + prenom+  "&idForm=" + idForm);
	
}
	
function updateData(sdata){
//afficher le message de retour de datagiver
	alert(sdata);
	
}

function readData(sData){
	//recuperation du block des module sur le dom
	var module_block = document.getElementById('formations');
	//tant que ce block a des enfant on les surrpime evite les doublons
	while (module_block.hasChildNodes()){
		module_block.removeChild(module_block.firstChild);
	}
	//on recupere les elements formation du xml
	var nodes = sData.getElementsByTagName('formation');
	var text = nodes[1].getAttribute("name");
	//on crée une balise tr avec le premier que l'on lien avec le module en tant qu'enfant
	var tr = document.createElement('tr');
	module_block.appendChild(tr);
	//pour chaque balise formation on crée un td, un label en un input qui seront enfant les uns des autres
	for (var i = 0; i < nodes.length; i++){
	
		var td = document.createElement('td');
		var lb = document.createElement('label');
		var input = document.createElement('input')
		input.id= nodes[i].getAttribute("id");
		input.name= 'formation';
		input.setAttribute('type','radio');
			//si l'id de l'input est dans le tableau alors la radio est checkée
			if (input.id == checkradio) {
				input.checked = true;
		
			}else{
				input.checked = false;
			}

		var text = nodes[i].getAttribute("name");
		lb.appendChild(document.createTextNode(text));
		lb.appendChild(input);
		td.appendChild(lb);
		tr.appendChild(td);
		
		// tous les 5 on recrée un tr pour faire une ligne de plus
		if( i % 5 == 0 && i != 0){
		tr = document.createElement('tr');
		module_block.appendChild(tr);

		}
	}
}

function recupCBox(){
	//recuperation de la radio checkée
	var table = document.getElementById('formations');
	// si table existe 
	if (table){
		//on selection dans table tous les input du nom de formation et on les range dans cbox
		var cbox = document.querySelectorAll('input[name="formation"]');

		//pour chaque input selectionné
		for (var i = 0, c = cbox.length; i < c; i ++){
			//si l'input est check alors on met son id dans la variable (c'est une radio donc un seul possible)
			if(cbox[i].checked){
				checkradio = cbox[i].getAttribute('id');
				//on break pour eviter de prendre trop de ressources
				break;
			}
		}
	}
}	

