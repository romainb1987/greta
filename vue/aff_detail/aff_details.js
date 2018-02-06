//tableau de la liste des details selectionnés
var tabcbox = [];
//initialisation du httprequest
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
	//recuperation de l'id theme
	var idTheme = oSelect.options[oSelect.selectedIndex].value;
	//recuperation des checkbox selectionnée
	recupCBox();
	
	var xhr = getXMLHttpRequest();
		//met en attente de reponse read data qui sera executé a reception d'information de refreshmod
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
				readData(xhr.responseXML);
			}
		};
	//lance refreshmod avec l'id du theme
	xhr.open("POST","refreshmod.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idTheme="+idTheme);
}

function readData(sData){
	//supprime les element du bloc module
	var module_block = document.getElementById('details');
	while (module_block.hasChildNodes()){
		module_block.removeChild(module_block.firstChild);
	}
	//recupere une liste des noeud de detail
	var nodes = sData.getElementsByTagName('detail');
	var text = nodes[1].getAttribute("name");
	//crée un tr et l'affect au blocmodule
	var tr = document.createElement('tr');
	module_block.appendChild(tr);
	//pour chaque noeud de detail on crée un td>lb>input/textnode
	for (var i = 0; i < nodes.length; i++){
		
		var td = document.createElement('td');
		var lb = document.createElement('label');
		var input = document.createElement('input')
		input.id= nodes[i].getAttribute("id");
		input.name= 'detail';
		input.setAttribute('type','checkbox');
		//si la checkboxest est dans le tableau alors on la coche d'office
		for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
			
			if (input.id == tabcbox[itab]) {
				input.checked = true;
				break;
			}else{
				input.checked = false;
			}

		}
		var text = nodes[i].getAttribute("name");
		lb.appendChild(document.createTextNode(text));
		lb.appendChild(input);
		td.appendChild(lb);
		tr.appendChild(td);
		
		//toutes les 5 colonne on crée une nouvelle ligne
		if( i % 5 == 0 && i != 0){
		tr = document.createElement('tr');
		module_block.appendChild(tr);

		}
	}
}

function insertContenu(oSelect){
	
		var idMod = oSelect.id;
		//on recupere les dernier cbox cochée 
		recupCBox();
		var i = 0
		//mise en place de l'url (&det0=id&det1=id...) avec un icrement automatique
		var url = '&det'+i+'='+tabcbox[i];
	for (var i = 1, c = tabcbox.length;i < c; i++){ 
		if (i == c - 1){
		url += '&det'+i+'='+tabcbox[i];
	}else{
		url += '&det'+i+'='+tabcbox[i];
	}
	}
	
	var xhr = getXMLHttpRequest();
	//en attente de reponse de datagiver on met en attente update data
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
			updateData(xhr.responseText);
		}
	};
	//on lance datagiver avecl'id module et l'url des details 
	xhr.open("POST","dataGiver.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idMod="+idMod+url);
	
}
	
function updateData(sdata){
	//on retourne le retour de datagiver
	alert(sdata);
	
}

function recupCBox(){
	
	var table = document.getElementById('details');
	if (table){
		//recuperation de toutes les cbox en cours 
		var cbox = document.querySelectorAll('input[name="detail"]');
		var trouve = false;
		//si le tableau est vide on insere toutes les cbox checkée
		if (tabcbox.length == 0){
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				if(cbox[icb].checked){
					tabcbox.push(cbox[icb].getAttribute('id'));
				}
			}
		}else{
			//sinon on verifie quelles ne sont pas dans le tableau et on les check
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
					if (cbox[icb].getAttribute('id') == tabcbox[itab]){
						trouve = true;
						break;
					}
				}//si elles sont uncheck mais dans le tableau on le retire du tableau
				if (cbox[icb].checked == false && trouve == true){
					tabcbox.splice((itab),1);
					trouve = false;					
					}//si elles sont check et pas dans le tableau on les ajoutes
				if (cbox[icb].checked == true && trouve == false){
					tabcbox.push(cbox[icb].getAttribute('id'));		
				}
			}
			
		}
	}
}	

