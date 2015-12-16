
<script type="text/javascript" charset="utf-8">
//<script type="text/javascript" charset="iso-8859-1">

function descendreLigneIngredient(pbouton){

	var btn = pbouton;

	// Si c'était un clic, on récupère le bouton correspondant
	if(typeof pbouton.target != "undefined"){
		btn = pbouton.target;
	}

  var ligne_tr = btn.parentNode.parentNode;
  var ligne_tr_suivant = btn.parentNode.parentNode.nextElementSibling;

//	var table = document.getElementById('tableIngredientBody');

    var valeur_ingredient = ligne_tr.cells[0].firstChild.selectedIndex;
    ligne_tr.cells[0].firstChild.selectedIndex = ligne_tr_suivant.cells[0].firstChild.selectedIndex;
    ligne_tr_suivant.cells[0].firstChild.selectedIndex = valeur_ingredient;

    var valeur_quantite = ligne_tr.cells[1].firstChild.value;
    ligne_tr.cells[1].firstChild.value = ligne_tr_suivant.cells[1].firstChild.value;
    ligne_tr_suivant.cells[1].firstChild.value = valeur_quantite;

    var valeur_unite = ligne_tr.cells[2].firstChild.selectedIndex;
    ligne_tr.cells[2].firstChild.selectedIndex = ligne_tr_suivant.cells[2].firstChild.selectedIndex;
    ligne_tr_suivant.cells[2].firstChild.selectedIndex = valeur_unite;
}


function monterLigneIngredient(pbouton){

	var btn = pbouton;

	if(typeof pbouton.target != "undefined"){
		btn = pbouton.target;
	}

  var ligne_tr = btn.parentNode.parentNode;
  var ligne_tr_precedent = btn.parentNode.parentNode.previousElementSibling;

    var valeur_ingredient = ligne_tr.cells[0].firstChild.selectedIndex;
    ligne_tr.cells[0].firstChild.selectedIndex = ligne_tr_precedent.cells[0].firstChild.selectedIndex;
    ligne_tr_precedent.cells[0].firstChild.selectedIndex = valeur_ingredient;

    var valeur_quantite = ligne_tr.cells[1].firstChild.value;
    ligne_tr.cells[1].firstChild.value = ligne_tr_precedent.cells[1].firstChild.value;
    ligne_tr_precedent.cells[1].firstChild.value = valeur_quantite;

    var valeur_unite = ligne_tr.cells[2].firstChild.selectedIndex;
    ligne_tr.cells[2].firstChild.selectedIndex = ligne_tr_precedent.cells[2].firstChild.selectedIndex;
    ligne_tr_precedent.cells[2].firstChild.selectedIndex = valeur_unite;

}

function creer_bouton_deplacement(value){
	var bouton = document.createElement('INPUT');
	bouton.type = "button";
	bouton.value = value;
//	bouton.style.width = '15px';
	bouton.className = "contenuBoutonForm";

	return bouton;
}

function creer_bouton(value){
	//alert("Je suis dans la fonction creer_bouton");
	var bouton = document.createElement('INPUT');
	bouton.type = "button";
	bouton.value = value;
	bouton.style.width = '15px';
	bouton.className = "contenuBoutonForm";

	return bouton;
}

function creer_textfield(name){
	//alert("Je suis dans la fonction creer_textfield");
	var td = document.createElement('td');

	var input = document.createElement('INPUT');
	input.name = name;
	input.className = "contenuTextForm maxWidth";

	td.appendChild(input);
	return td;
}

function premierenfant(objet){
	var resultat;

	resultat = objet.rows[1];
	return resultat;
}

function dernierenfant(objet){
	var resultat;

	resultat = objet.rows[objet.rows.length-1];
	return resultat;
}

function avantdernierenfant(objet){
	var resultat;

	resultat = objet.rows[objet.rows.length-2];
	return resultat;
}


function creerSelectClassement(){
	//alert("Je suis dans la fonction creerSelectClassement");

	var td = document.createElement('td');

	var input = document.createElement('SELECT');
	input.className = "contenuBoutonForm maxWidth";
	input.style.width = "100%";
	input.name = "new_classement[]";
	td.appendChild(input);

	var classement;
	var option;

	classement = document.getElementById("classementsCaches").options;
	
	for(var i=0; i< classement.length; i++){
		option = document.createElement('OPTION');
		option.value = classement[i].value;
		option.text = classement[i].text;
		input.appendChild(option);
		
    if(option.text == "Inconnu"){
      input.selectedIndex = i;
    }
	}

	return td;
}

function verifierBoutonPremiereLigne(){
  var tableau = document.getElementById("tableIngredientBody");

  if (tableau.children[1]!=null){
    if (tableau.children[1].cells[4].firstChild != null){
    tableau.children[1].cells[4].removeChild(tableau.children[1].cells[4].firstChild);
    }  
  }
}


function supprimerLigneClassement(e){
	var btn = e;
	if(typeof e.target != "undefined"){
		btn = e.target;
	}

	var ligne = btn.parentNode.parentNode;
	var table = document.getElementById('tableClassementBody');

	table.removeChild(ligne);
}

function ajoutLigneClassement(e){
	//alert("Je suis dans la fonction ajout_ligne");
	var btn = e;

	// Si c'était un clic, on récupère le bouton correspondant
	if(typeof e.target != "undefined"){
		btn = e.target;
	}

	var table = document.getElementById('tableClassementBody');

	var last_line = btn.parentNode.parentNode == dernierenfant(table);
	var tr = document.createElement('tr');

	table.appendChild(tr);

	var classement = creerSelectClassement();
	tr.appendChild(classement);

	var td = document.createElement('td');
	tr.appendChild(td);
	
	var button = creer_bouton(last_line ? '+' : '-');

	if(last_line){
		button.onclick = function(){ajoutLigneClassement(button);};
	}
	else{
		button.onclick = function(){supprimerLigneClassement(button);};
	}
	td.appendChild(button);

	btn.value = '-';
	btn.onclick = function(){supprimerLigneClassement(btn);};
}

function supprimerLigneIngredient(e){
	var btn = e;
	if(typeof e.target != "undefined"){
		btn = e.target;
	}

	var ligne = btn.parentNode.parentNode;
	var table = document.getElementById('tableIngredientBody');

	table.removeChild(ligne);
	
	verifierBoutonPremiereLigne();

}

function creerSelectIngredient(){

	var td = document.createElement('td');

	var input = document.createElement('SELECT');
	input.className = "contenuBoutonForm maxWidth";
	input.name = "new_ingredient[]";
	td.appendChild(input);

	var ingredient;
	var option;

	ingredient = document.getElementById("ingredientsCaches").options;
	
	for(var i=0; i< ingredient.length; i++){
		option = document.createElement('OPTION');
		option.value = ingredient[i].value;
		option.text = ingredient[i].text;
		input.appendChild(option);
	}

	input.selectedIndex = 0;

	return td;
}

function creerSelectUnite(){

	var td = document.createElement('td');
	var input = document.createElement('SELECT');

	input.className = "contenuBoutonForm maxWidth";
	input.name = "new_unite[]";
	td.appendChild(input);

	var unite;
	var option;

	unite = document.getElementById("unitesCachees").options;
	
	for(var i=0; i< unite.length; i++){
		option = document.createElement('OPTION');
		option.value = unite[i].value;
		option.text = unite[i].text;
		input.appendChild(option);
		
    if(option.text == "inconnu"){
      input.selectedIndex = i;
    }
		
	}
	return td;
}

function gererAvantDerniereLigne(btn){
 	var table = document.getElementById('tableIngredientBody');
  var derniereligne = avantdernierenfant(table);

  if (derniereligne.cells[4] == null){
    	var td_down = document.createElement('td');
    	derniereligne.appendChild(td_down);
  }
    if (derniereligne.cells[5] == null){
    	var td_down = document.createElement('td');
    	derniereligne.appendChild(td_down);
    }
    
    var coucou = derniereligne.cells[5].firstChild; 
    
    if (derniereligne.cells[5].firstChild != null){
      derniereligne.cells[5].removeChild(derniereligne.cells[5].firstChild);
    }
    var button_down = creer_bouton_deplacement('vers le bas');
    button_down.onclick = function(){descendreLigneIngredient(button_down)};
    derniereligne.cells[5].appendChild(button_down);
}  


function gererBouton(){

 	var table = document.getElementById('tableIngredientBody');

	var premiereLigne = premierenfant(table);
	var derniereLigne = dernierenfant(table);

  if (premiereLigne!=null){
    if (premiereLigne.cells[4] == null){
    	var td_down = document.createElement('td');
    	premiereLigne.appendChild(td_down);
    } 
    if (premiereLigne.cells[4].firstChild != null){
    premiereLigne.cells[4].removeChild(premiereLigne.cells[4].firstChild);
    }
    
    if (premiereLigne.cells[5] == null){
    	var td_down = document.createElement('td');
    	premiereLigne.appendChild(td_down);
    }
    
    if (premiereLigne.cells[5].firstChild == null){
      var button_down = creer_bouton_deplacement('vers le bas');
      button_down.onclick = function(){descendreLigneIngredient(button_down);};
	    premiereLigne.cells[5].appendChild(button_down);
    } 
  }
  
  if (derniereLigne!=null){
    if (derniereLigne.cells[4] == null){
    	var td_up = document.createElement('td');
    	derniereLigne.appendChild(td_up);
    } 
    if (derniereLigne.cells[4].firstChild == null){
      var button_up = creer_bouton_deplacement('vers le haut');
      button_up.onclick = function(){monterLigneIngredient(button_up);};
	    derniereLigne.cells[4].appendChild(button_up);
    }
    
    if (derniereLigne.cells[5] == null){
    	var td_down = document.createElement('td');
    	derniereLigne.appendChild(td_down);
    }
    
    if (derniereLigne.cells[5].firstChild != null){
    derniereLigne.cells[5].removeChild(derniereLigne.cells[5].firstChild);
    } 
  }
}

function ajoutLigneIngredient(e){
	var btn = e;

	// Si c'était un clic, on récupère le bouton correspondant
	if(typeof e.target != "undefined"){
		btn = e.target;
	}

	// On récupère le tbody conteneur
	var table = document.getElementById('tableIngredientBody');

	var last_line = btn.parentNode.parentNode == dernierenfant(table);
	var tr = document.createElement('tr');

	table.appendChild(tr);

	var classement = creerSelectIngredient();
	tr.appendChild(classement);

	var new_quantite = creer_textfield("new_quantite[]");
	tr.appendChild(new_quantite);
	
	var unite = creerSelectUnite();
	tr.appendChild(unite);
	
	var td = document.createElement('td');
	tr.appendChild(td);
	
	var button = creer_bouton(last_line ? '+' : '-');

	if(last_line){
		button.onclick = function(){ajoutLigneIngredient(button);};
	}
	else{
		button.onclick = function(){supprimerLigneIngredient(button);};
	}
	td.appendChild(button);

  gererAvantDerniereLigne(btn);  

  gererBouton();

	btn.value = '-';
	btn.onclick = function(){supprimerLigneIngredient(btn);};
}

</script>
