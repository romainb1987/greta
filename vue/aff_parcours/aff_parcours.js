var tabmod = [];
var tabdet = [];

//fontion permettant de se brancher via javascript à la base de données -> en fait cela permet d'ouvrir un page php choisie avec des variable en url (caché ou pas)
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

function select_Det(oSelect){

	//recup id du module 
	var idModule = oSelect.id;
	//ouvre la connexion au httprequest
	var xhr = getXMLHttpRequest();
	
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
				//teste la reponse du serveur quand le statut passe a 4 on fera la fonction readData avec en parametre la reponse attendue (assynchrone)
				readData(xhr.responseXML,oSelect);
			}
		};
	//ouvre la page php true = assynchrone c'est a dire que le programme continue son parcours en attendant que la requete revienne 
	xhr.open("POST","refreshmod.php",true);
	//programation de la methode post pour encoded les informations envoyées
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	// envoie en variable a la page php l'idmodule
	xhr.send("idModule="+idModule);
}

function insertContenu(oSelect){
		//initilisation d'un compteur
		var i = 0
		//construction de l'url d'envoie pour HTTPRequest 'mod0=idmodule&det0=iddetail&mod1=idmodule...'
		var url = 'mod'+i+'='+tabmod[i];
		url += '&det'+i+'='+tabdet[i];
		for (var i = 1, c = tabmod.length;i < c; i++){ 
			if (i == c - 1){
				url += '&mod'+i+'='+tabmod[i];
				url += '&det'+i+'='+tabdet[i];
			}else{
				url += '&mod'+i+'='+tabmod[i];
				url += '&det'+i+'='+tabdet[i];
			}
		}
		//ouvre la connexion au httprequest
		var xhr = getXMLHttpRequest();
	
		xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
			//lance la fonction suivante a reception de la requete serveur
			updateData(xhr.responseText);
		}
	};
	//ouvre dataInsert avec l'url en variable
	xhr.open("POST","dataInsert.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send(url);
	
}
	
function updateData(sdata){
		//retourne le xml en reponse
	alert(sdata);
	
}

function readData(sData,oSelect){
	var list = document.querySelector('table[id="list_det"]');
		var butt = document.querySelector('input[id="valid_det"]');
		//suppression des listes dèja injectée pour eviter d'avoir des doublon si on clic plusieurs fois 
	if (list){
		var parent = list.parentNode;
	
			parent.removeChild(list);
	}
		//suppression de butt deja injectés
		if (butt){
		var parent = butt.parentNode;
			parent.removeChild(butt);

	} 
	//recup dans le xml de retour de la section module et ensuite de son attribut id (donc de son id)
	var module = sData.getElementsByTagName('module');
	var idModule = module[0].getAttribute('id');
	//on cible la cellule du module en cours
	var module_select = document.getElementById('detail'+idModule);
	//si il n'y a pas d'élément suivant (si il y en a un c'est que l'on a recliqué sur le mm module)
		if (!oSelect.nextElementSibling){
			//creation d'un tableau dans le tableau
		var tab_det = document.createElement('table');
		tab_det.id = 'list_det';
		tab_det.name = 'list_det';
		module_select.appendChild(tab_det);
		//on recupere sous forme de tableau tous les details du xml
		var details = sData.getElementsByTagName('detail');
		//on parcours le tableau 
		for (var i = 0, c = details.length; i < c; i++){
			//pour chaque detail on crée un tr puis un lb puis un input type checkbox
			var tr = document.createElement('tr');
			tr.name = 'detail'
			var lb = document.createElement('label');
			lb.name = details[i].getAttribute("name");
			var input = document.createElement('input');
			input.id = details[i].getAttribute('id');
			input.name = 'detail';
			input.setAttribute('type','checkbox');
			//ensuite on recupere les information dans les tableau modules et details
			//si l'id module et l'id detail sont au mm increment d'un tableau alors c'est que ce detail a déjà été coché
			//du coup on check auto la checkbox 
			for (var j = 0; j < tabmod.length; j++ ){
				if (idModule == tabmod[j]){
					if (input.id == tabdet[j]){
						input.checked = true;
						break;
					}
				}
			}
			//pour finir on construit rajoute les element tour a tour au DOM
			var text = details[i].getAttribute("name");
			lb.appendChild(document.createTextNode(text));
			lb.appendChild(input);
			tr.appendChild(lb);
			tab_det.appendChild(tr);
		}
		//on rajoute un bouton avec un lecteur d'event pour qu'il valide les CBox cochées a chaque fois qu'il est cliqué
		var valid = document.createElement('input');
		valid.id = 'valid_det'; 
		valid.type = 'button';
		valid.value ='valider';
		valid.appendChild(document.createTextNode('valider'));
		module_select.appendChild(tab_det);
		module_select.appendChild(valid);
		valid.addEventListener('click',function(){
			//l'event lance la fonction suivante :
			recupDet(oSelect);
			return false;
		
			});
		}
	}

function recupDet(){
	//on recupere dans l'élément table (aprés l'élément <a>) tout les input nommé detail qui sont cochés
	var cboxs = document.querySelectorAll('input[name="detail"]:checked');
	//recuperation dans list du noeud table et butt du noeud input rajouté avec l'ancre en cours
	var list = document.querySelector('table[id="list_det"]');
	var butt = document.querySelector('input[id="valid_det"]');
	// on recupère l'id du module en cours stocké dans id de <a>
	var idModule = list.previousElementSibling.id;
	//on cherche l'id du module dans les entrées du tableau pour RAZ le contenu du module (évite les doublons)
		for (var i = tabmod.length - 1 ; i >= 0 ; i--){
			//si on retrouve une ligne avec l'id du module en cours on la supprime dans tabmod et tabdet
			//on part de la fin pour pas louper des ligne dans la suppression 
			if(tabmod[i] == idModule){
				tabmod.splice(i,1);
				tabdet.splice(i,1);
			}
		}
	//si il y a des detail coché
	if(cboxs[0]){
		
	//on parcours ensuite le fichier des cbox cochée 
	//on rajoute à tabmod idmodule et à tabdet les id detail 
		for (var i = 0, c = cboxs.length;i < c; i++){
			tabmod.push(idModule);
			tabdet.push(cboxs[i].getAttribute('id'));
		}
	
	}
	
	var list = document.querySelector('table[id="list_det"]');
	var butt = document.querySelector('input[id="valid_det"]');
	//suppression de list
	if (list){
		var parent = list.parentNode;	
			parent.removeChild(list);
	}
	//suppression de butt
	if (butt){
		var parent = butt.parentNode;
			parent.removeChild(butt);

	}	
	//retourne false pour que le valider ne fasse pas le submit du formualire
	return false;
}

