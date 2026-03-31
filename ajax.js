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
    xhttp.open("GET", "plan.html");
    xhttp.send();
}

function AfficherListeHTML(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var reponse = this.responseText;
            var reponseListe = JSON.parse(reponse);
            var section = document.getElementById("section");
            section.innerHTML = "";
            for(var i = 0; i < reponseListe.length; i++){
                var item = reponseListe[i];
                var nom = item.nom;
                var description = item.description;
                var numero = item.numero;
                var type = item.type;
                console.log("ID: "+i+" Nom: "+nom+" Description: "+description+" Numero: "+numero+" Type: "+type);
                section.innerHTML += "<div class='capteur-table'><table><tr><th>Nom</th><th>Description</th><th>Numéro</th><th>Type</th></tr><tr><td>"+nom+"</td><td>"+description+"</td><td>"+numero+"</td><td>"+type+"</td></tr></table></div>";
            }
        }
    };
    xhttp.open("GET", "http://172.20.21.51/M06/rest.php/capteur");
    xhttp.send();
}