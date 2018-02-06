var tabcbox = [];

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

	var idTheme = oSelect.options[oSelect.selectedIndex].value;
	var xhr = getXMLHttpRequest();
	
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
				readData(xhr.responseXML);
			}
		};
	
	xhr.open("POST","refreshmod.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idTheme="+idTheme);
}

function insertContenu(oSelect){
		var idForm = oSelect.id;
		recupCBox();
		var i = 0
		var url = '&mod'+i+'='+tabcbox[i];
	for (var i = 1, c = tabcbox.length;i < c; i++){ 
		if (i == c - 1){
		url += '&mod'+i+'='+tabcbox[i];
	}else{
		url += '&mod'+i+'='+tabcbox[i];
	}
	}
	alert(url);
	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && (xhr.status == 200 || xhr.status ==0) ){
			updateData(xhr.responseText);
		}
	};
	xhr.open("POST","dataGiver.php",true);
	xhr.setRequestHeader("content-type","application/x-www-form-urlencoded");
	xhr.send("idform="+idForm+url);
	
}
	
function updateData(sdata){

	alert(sdata);
	
}

function readData(sData){

	var module_block = document.getElementById('modules');
	while (module_block.hasChildNodes()){
		module_block.removeChild(module_block.firstChild);
	}
		
	var nodes = sData.getElementsByTagName('module');
	var text = nodes[1].getAttribute("name");
	var tr = document.createElement('tr');
	module_block.appendChild(tr);
	
	for (var i = 0; i < nodes.length; i++){
	
		var td = document.createElement('td');
		var lb = document.createElement('label');
		var input = document.createElement('input')
		input.id= nodes[i].getAttribute("id");
		input.name= 'module';
		input.setAttribute('type','checkbox');
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
		
		
		if( i % 5 == 0 && i != 0){
		tr = document.createElement('tr');
		module_block.appendChild(tr);

		}
	}
}

function recupCBox(){
	
	var table = document.getElementById('modules');
	if (table){
		var cbox = document.querySelectorAll('input[name="module"]');
		var trouve = false;
		if (tabcbox.length == 0){
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				if(cbox[icb].checked){
					tabcbox.push(cbox[icb].getAttribute('id'));
				}
			}
		}else{
			for (var icb = 0, ccb = cbox.length; icb < ccb; icb ++){
				for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
					if (cbox[icb].getAttribute('id') == tabcbox[itab]){
						trouve = true;
						break;
					}
				}
				if (cbox[icb].checked == false && trouve == true){
					tabcbox.splice((itab),1);
					trouve = false;					
					}
				if (cbox[icb].checked == true && trouve == false){
					tabcbox.push(cbox[icb].getAttribute('id'));		
				}
			}
			
		}
	}
	var id = '';
	for (var itab = 0, ctab = tabcbox.length; itab < ctab; itab ++){
		id = id +' '+ tabcbox[itab];
	}	
}	

