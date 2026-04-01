document.getElementById('planNAV').addEventListener('click',AfficherPlanHTML);
document.getElementById('capteursNAV').addEventListener('click',AfficherListeHTML);


function AfficherPlanHTML(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var reponse = this.responseText;
            var section = document.getElementById("section");
            //section.innerHTML = reponse;
        }
    };
    xhttp.open("GET", "http://172.20.21.51/M06/rest.php/capteur/etat");
    xhttp.send();
}

function AfficherListeHTML(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var reponse = this.responseText;
            var reponseListe = JSON.parse(reponse);
            var section = document.getElementById("section");
            capteur = "<div class='capteur-table'><table><tr><th>Nom</th><th>Type</th><th>Numéro</th><th>Etat</th><th>Hauteur</th><th>Éclairage</th></tr>";
            for(var i = 0; i < reponseListe.length; i++){
                var item = reponseListe[i];
                var nom = item.nom;
                var etat = item.etat;
                var numero = item.numero;
                var type = item.type;
                var hauteur = item.hauteur;
                var eclairage = item.eclairage;

                console.log("ID: "+i+" Nom: "+nom+" Type: "+type+" Numero: "+numero+" Etat: "+etat+" Hauteur: "+hauteur+" Éclairage: "+eclairage);
                capteur = capteur + "<tbody><tr><td>"+nom+"</td><td>"+type+"</td><td>"+numero+"</td><td>"+etat+"</td><td>"+hauteur+"</td><td>"+eclairage+"</td></tr></tbody>";
            }
            section.innerHTML = capteur + "</table></div>";
        }
    };
    xhttp.open("GET", "http://172.20.21.51/M06/rest.php/capteur");
    xhttp.send();
}