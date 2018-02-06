//initialisation d'un tableau qui contiendra les modules checké
var tabcbox = [];
//initialisation de l'httprequest 
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
//lancement de la request 
function request(oSelect){
	//recup idtheme
	var idTheme = oSelect.options[oSelect.selectedIndex].value;
	//va chercher les box cochées
	recupCBox();
	var xhr = getXMLHttpRequest();
		//lance readdata a reception de refreshmod
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
				readData(xhr.responseXML);
			}
		};
	//lancement refreshmod pour rafraichir les module en fonction du parametre theme
	xhr.open("POST","refreshmod.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idTheme="+idTheme);
}

function readData(sData){
	//suppression des modules dans le bloc module 
	var module_block = document.getElementById('modules');
	while (module_block.hasChildNodes()){
		module_block.removeChild(module_block.firstChild);
	}
		//recuperation des modules dans le xml de retour dans une liste de noeud
	var nodes = sData.getElementsByTagName('module');
	var text = nodes[1].getAttribute("name");
	//creation d'un tr et affectation a bloc module
	var tr = document.createElement('tr');
	module_block.appendChild(tr);
	//a chaque noeud 
	for (var i = 0; i < nodes.length; i++){
		//creation de td>label>input / nodetext
		var td = document.createElement('td');
		var lb = document.createElement('label');
		var input = document.createElement('input')
		input.id= nodes[i].getAttribute("id");
		input.name= 'module';
		input.setAttribute('type','checkbox');
		for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
			//on recheck ce qui est deja present dans le tableau
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
		
		//et toutes les 5 colonnes on recrée une ligne
		if( i % 5 == 0 && i != 0){
		tr = document.createElement('tr');
		module_block.appendChild(tr);

		}
	}
}

//insertion des données dans la bdd
function insertContenu(oSelect){
		//recuperation de l'id de la formation en cours
		var idForm = oSelect.id;
		//recuperation des derniere box cochées 
		recupCBox();
		//construction de l'url (pour chaque module (mod+increment) = idmodule) 
		var i = 0
		var url = '&mod'+i+'='+tabcbox[i];
	for (var i = 1, c = tabcbox.length;i < c; i++){ 
		if (i == c - 1){
		url += '&mod'+i+'='+tabcbox[i];
	}else{
		url += '&mod'+i+'='+tabcbox[i];
	}
	}
	//url sous forme &mod0=id&mod1=id&mod3=id
	var xhr = getXMLHttpRequest();
	//prepare le lancement de updatedata àretour de datagiver (ci dessous)
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
			updateData(xhr.responseText);
		}
	};
	//execute datagiver avec l'id formation + la liste des modules (url premonté)
	xhr.open("POST","dataGiver.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idform="+idForm+url);
	
}
	
function updateData(sdata){
	//retourne le maessage retourné par datagiver
	alert(sdata);
	
}

function recupCBox(){
	
	var table = document.getElementById('modules');
	//si la table existe 
	if (table){
		//recuperation de tte les checkbox nommée module
		var cbox = document.querySelectorAll('input[name="module"]');
		var trouve = false;
		//si le tableau est vide 
		if (tabcbox.length == 0){
			//on le remplit sans se pauser de question
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				if(cbox[icb].checked){
					tabcbox.push(cbox[icb].getAttribute('id'));
				}
			}
		}else{
			//sinon on rajoute juste les box qui ont été recochée pour eviter les doublons
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				// pour achcune des box selectionnée
				for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
					//pour chacune des entrées dans le tableau
					//on verifie si leur ids sont les mm si oui on trouve!
					if (cbox[icb].getAttribute('id') == tabcbox[itab]){
						trouve = true;
						break;
					}
				}
				//si checkbox trouvée dans le tableau et que l'element est uncheck on le vire du tableau 
				if (cbox[icb].checked == false && trouve == true){
					tabcbox.splice((itab),1);
					trouve = false;					
					}
					//si l'element est checké et qu'il n'est pas dansle tableau on le rajoute
				if (cbox[icb].checked == true && trouve == false){
					tabcbox.push(cbox[icb].getAttribute('id'));		
				}
			}
			
		}
	}

}	

