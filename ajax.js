document.getElementById('planNAV').addEventListener('click',AfficherPlanHTML);
document.getElementById('capteursNAV').addEventListener('click',AfficherListeHTML);


function AfficherPlanHTML(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var reponse = this.responseText;
            var reponsePlan = JSON.parse(reponse);
            var div = document.getElementsByClassName("place");
            for(var i = 0; i < reponsePlan.length; i++){
                var item = reponsePlan[i];
                var nom = item.nom;
                var etat = item.etat;
                console.log("ID: "+i+" Nom: "+nom+" Etat: "+etat);
                console.log("Ambre")
                if(etat == "Libre"){
                    div[i].classList.add("libre");
                    div[i].classList.remove("occupee");
                    div = "<div id='vert' class='place'></div>"
                }
                else if(etat == "Occupee"){
                    div[i].classList.add("occupee");
                    div[i].classList.remove("libre");
                    div = "<div id='rouge' class='place'></div>"
                }
                window.location.href = "plan/plan.html";
            }
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
                if(etat == "Libre"){
                    capteur = capteur + "<tbody><tr><td>"+nom+"</td><td>"+type+"</td><td>"+numero+"</td><td class='vert'>"+etat+"</td><td>"+hauteur+"</td><td>"+eclairage+"</td></tr></tbody>";
                }
                else if(etat == "Occupee"){
                    capteur = capteur + "<tbody><tr><td>"+nom+"</td><td>"+type+"</td><td>"+numero+"</td><td class='rouge'>"+etat+"</td><td>"+hauteur+"</td><td>"+eclairage+"</td></tr></tbody>";
                }
            }
            section.innerHTML = capteur + "</table></div>";
        }
        
    };
    xhttp.open("GET", "http://172.20.21.51/M06/rest.php/capteur");
    xhttp.send();
}