function ajouterOnClick() { //on ajoute la fonction onclick avec l'attribut déplacer à chaque image au chargement de la page
	var images = document.getElementsByTagName("img");          
	for (var i=0; i<images.length; i++) {                    
		images[i].setAttribute("onclick","deplacer(this)");      
	}
}

function deplacer(elementImg) { //la fonction reliée à l'attribut déplacer des onclick de chaque image
    var noeudTexte;
    var elementSrc = document.getElementById("source"); //on récupère le cadre "source" (l'emplacement avant déplacement)
    var elementDest = document.getElementById("destination"); //on récupère le cadre "destination" (l'emplacement apres déplacement)
    var nbIMG = 0; 
    if(elementImg.parentNode.id=="source"){ //si l'image se trouve dans le bloc "source"
        try{ //on déplace l'image dans le bloc "destination"          
            var Img0 = document.createElement("img"); //on créer l'élément image dans le cadre
            var idImg = elementImg.getAttribute("src"); //on créer la source de l'image
            Img0.setAttribute("width", "30"); //on donne une largeur à l'image
            Img0.setAttribute("src", idImg); //on lui donne une source
            Img0.setAttribute("onclick","deplacer(this)"); //on lui donne l'attribut déplacer à la fonction onclick
            elementDest.appendChild(Img0); //on créer l'élément dans le cadre source (on le déplace)             
            var Balise = document.createElement("span"); //on créer l'emplacement pour le nom de l'album
            var l = idImg.length;
            var idAlbum = idImg.substring(4,l-4); //on récupère le nom de l'labum dans la source de l'image
            var titre = "</br> Album : "+idAlbum; //on affiche le nom de l'album
            Balise.innerHTML=titre; //on remplace le span par le titre pour l'afficher à côté de l'album
            elementDest.insertBefore(Balise,Img0);
            elementImg.remove();
            ajouteDisque(elementImg.alt);
        }
        catch(excep) { //afficher un message d'erreur
            alert("ERREUR");
        }
    }
    else { //si l'image se trouve dans le bloc "destination"
        try{ // on déplace l'image dans le bloc "source"
            var Img0 = document.createElement("img"); //même procédé que pour déplacer dans le bloc source
            var idImg = elementImg.getAttribute("src");
            Img0.setAttribute("width", "40");
            Img0.setAttribute("onclick","deplacer(this)");
            Img0.setAttribute("src", idImg);
            Img0.setAttribute("alt", idImg.substring(4,idImg.length-4));
            elementSrc.appendChild(Img0);
            var text = elementImg.previousSibling; //on récupère ce qu'il y avait juste avant l'image, c'est-à-dire le span contenant le titre de l'album
            text.remove(); //on retire le nom de l'album
            elementImg.remove(); //on retire l'image du bloc "destination"
            enleveDisque(Img0.alt);
        }
        catch(excep) { //afficher un message d'erreur
            alert("ERREUR");
        }
    }
     
    var image = document.getElementsByTagName("img"); //on récupère tous les éléments d'id Img, c'est-à-dire les images
    for (var i=0; i<image.length; i++){ //on parcoure tout le tableau
        if ( image[i].parentNode.id=="destination" ){ //si l'image est dans le bloc destination, on va mettre à jour le prix
            nbIMG=nbIMG+1;
        }
    }
    var panier = document.getElementById("panier"); // on récupère l'élément d'id panier
    var total = 0.0;
    for (var i=0; i<nbIMG; i++) {
        total = total+7.50;
    }
    panier.innerHTML=total+"€"; //on remplace l'élément d'id panier par le prix du panier
}

function ajouteDisque(nom) {
    var disq = document.getElementById("cmdisques").value;
    if (disq != ""){
        disq += "|";
    }
    disq += nom;
    document.getElementById("cmdisques").value = disq;
}

function enleveDisque(nom) {
    var i;
    var disq = document.getElementById("cmdisques").value;
    var tab = disq.split("|");
    document.getElementById("cmdisques").value = "";
    for (i=0; i<tab.length; i++) {
        if (tab[i] != nom) {
            ajouteDisque(tab[i]);
        }
    }
}


window.addEventListener('load', () => document.forms['delivery'].onsubmit = submitForm );


let messagesError = [];

function submitForm(event) {
    function addErrorMessage(el, message) {
        try {
            const element = document.createElement('p');
            element.innerText = message
            el.parentNode.appendChild(element);

            messagesError.push(element);
            el.addEventListener('focus', () => {
                messagesError.removeItem(element);
                element.remove()
            }, {once: true});
        } catch (exception) {
            console.log(exception)
        }
    }

    function checkCivility(el) {
        if (el.value == 'Mme' || el.value == 'Mlle' || el.value == 'Mr') return 0;

        const element = document.createElement('p');
        element.innerText = "Civilité : Vous devez choisir une valeur proposée"
        el[0].parentNode.appendChild(element);

        el[0].parentNode.addEventListener('focus', () => element.remove(), {once: true});
        return 1
    }
    function checkFirstname(el) {
        if (el.value == "" || el.value.match('[0-9]')) {
            addErrorMessage(el, "Prenom : Vous devez entrer un valeur valide ([a-zA-Z,-, ])");
            return 1
        }
        return 0
    }
    function checkLastname(el) {
        if (el.value == "" || !el.value.match('[A-Za-z]')) {
            addErrorMessage(el, "Nom : Vous devez entrer un valeur valide ([a-zA-Z,-, ])");
            return 1
        }
        return 0
    }
    function checkBirth(el) {
        currentYear = new Date().getFullYear();
        if (currentYear - el.value < 0 || currentYear - el.value > 150) {
            addErrorMessage(el, `Date de naissance: Vous devez entrer un valeur valide ([${currentYear - 150 } - ${currentYear}])`);
            return 1
        }
        return 0;
    }
    function checkAddr(addr, city, code) {
        error = 0;

        if (addr.value == "") {
            addErrorMessage(addr, "Adresse : Ne peut pas être vide");
            error += 1;
        }
        if (city.value == "") {
            addErrorMessage(city, "Ville : Ne peut pas être vide");
            error += 1;
        }
        if (code.value == "") {
            addErrorMessage(code, "Code postal : Ne peut pas être vide");
            error += 1;
        }


        return error;
    }
    function checkMail(el) {
        if (el.value == "") {
            addErrorMessage(el, "Mail : Ne peut pas être vide");
            return 1
        }
        return 0;
    }


    messagesError = [];

    let form = document.forms['delivery'];
    let error = 0;

    error += checkCivility(form['sexe']);
    error += checkFirstname(form['prenom']);
    error += checkLastname(form['nom']);
    error += checkBirth(form['liste_numerique']);

    error += checkAddr(form['adresseliv'], form['villeliv'], form['codepostalliv'])
    let isMailingAddrSameAsDelivery = form['facturation'];
    if (!isMailingAddrSameAsDelivery.checked) {
        error += checkAddr(form['adressefac'], form['villefac'], form['codepostalfac'])
    }

    let newsletter = form['newsletter'];
    if (newsletter.checked) {
        error += checkMail(form['newsletter-mail'])
    }
    console.log(error)
    if (error) return false;
}
