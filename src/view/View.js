"use strict";

function init() {
    let detailButtons = document.querySelectorAll(".detail-btn");
    detailButtons.forEach(button => {
        button.addEventListener("click", jsonPageRequest);
    });
}

function jsonPageRequest(event){
    var animalID = event.currentTarget.getAttribute("data-animal-id");
    event.preventDefault();
    let requete = new XMLHttpRequest();
    requete.open("GET","site.php?animal="+animalID+"&action=json");
    requete.responseType = "json";
    requete.send();
    requete.addEventListener("load",traitementReponse.bind(null, animalID));
}

function traitementReponse(animalID, event) {
    let req = event.currentTarget;

    console.log(req.response['Nom'] + " est animal de l'espèce " + req.response['Espece'] + " de " + req.response['Age'] + " ans");

    let resultat = document.getElementById('resultat-' + animalID);
    let btnDetail = document.getElementById('btnDetail-' + animalID);

    if (resultat.childNodes.length > 0) {
        btnDetail.textContent = "Détails";
        while (resultat.firstChild) {
            resultat.removeChild(resultat.firstChild);
        }
    }else{
        btnDetail.textContent = "Cacher les détails";
        let p = document.createElement("p");
        var texte = document.createTextNode(req.response['Nom'] + " est animal de l'espèce " + req.response['Espece'] + " de " + req.response['Age'] + " ans");
        p.appendChild(texte);
        resultat.appendChild(p);
    }
}
