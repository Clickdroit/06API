function ajax() {
  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var reponse = this.responseText;
      var reponseMeteo = JSON.parse(reponse);

      var temp = reponseMeteo.main.temp + " °C";
      document.getElementById("temperature").innerHTML = temp;
      var ville = "Ville: " + reponseMeteo.name;
      document.getElementById("ville_meteo").innerHTML = ville;
      var icone = reponseMeteo.weather[0].icon;
      document.getElementById("icone_meteo").src =
        "https://openweathermap.org/img/wn/" + icone + "@2x.png";

      console.log(icone);
      console.log(temp);
      console.log(ville);
    }
  };
  xhttp.open(
    "GET",
    "https://api.openweathermap.org/data/2.5/weather?units=metric&lat=48.8575&lon=2.3514&exclude=hourly,daily&appid=d85e295dccdc11e63077777de976518f"
  );
  xhttp.send();
}
ajax();

var lumiereNav = document.getElementById("lumiereNAV");
lumiereNav.addEventListener("click", AfficherLumiere);

function AfficherLumiere() {
  FermerMenu();
  const xhttpAL = new XMLHttpRequest();
  xhttpAL.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var reponseAL = this.responseText;
      var lumieres = JSON.parse(reponseAL);

      console.log(reponseAL);
      var section = document.getElementById("section");
      section.innerHTML = "";
      var lumiere = '';
      for (var num in lumieres) {
        var item = lumieres[num];
        let type = item.type;
        let etat = item.state.on; 
        let uniqueid = item.uniqueid;
        console.log("ID: " + num + " Type: " + type + " Etat: " + etat + " UniqueID: " + uniqueid);
        if (item.type && item.type.toLowerCase().includes("light")) {
          lumiere = lumiere + '<div class="lumiere-card">';
          lumiere = lumiere + "<h3>" + item.name + "</h3>";
          lumiere = lumiere + '<img src="images/lightbulb.png" alt="lumiere">';
          lumiere = lumiere + '<button class="btn-on" onclick="AllumerLumiere(' + num + ')">ON</button>';           
          lumiere = lumiere + '<button class="btn-off" onclick="EteindreLumiere(' + num + ')">OFF</button>';
          lumiere = lumiere + "</div>";
        }
      }
      section.innerHTML = lumiere;
    }
  };
  xhttpAL.open("GET", "http://172.20.21.230/api/F163AB8D21/lights/");
  xhttpAL.send();
}
function AllumerLumiere(num) {
  const xhttpOn = new XMLHttpRequest();
  xhttpOn.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("Lumiere " + num + " allumée");
    }
  };
  xhttpOn.open("PUT", "http://172.20.21.230/api/F163AB8D21/lights/" + num + "/state");
  xhttpOn.send(JSON.stringify({"on": true}));
}

function EteindreLumiere(num) {
  const xhttpOff = new XMLHttpRequest();
  xhttpOff.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("Lumiere " + num + " éteinte");
    }
  };
  xhttpOff.open("PUT", "http://172.20.21.230/api/F163AB8D21/lights/" + num + "/state");
  xhttpOff.send(JSON.stringify({"on": false}));
}


var priseNav = document.getElementById("priseNAV");
priseNav.addEventListener("click", AfficherPrise);


function AfficherPrise() {
  FermerMenu();
  const xhttpAL = new XMLHttpRequest();
  xhttpAL.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var reponseAL = this.responseText;
      var prises = JSON.parse(reponseAL);

      console.log(reponseAL);
      var section = document.getElementById("section");
      section.innerHTML = "";
      var prise = '';
      for (var num in prises) {
        var item = prises[num];
        let name = item.name;
        let type = item.type;
        let etat = item.state.on; 
        let uniqueid = item.uniqueid;
        console.log("ID: " + num + " Type: " + type + " Etat: " + etat + " UniqueID: " + uniqueid + "name : "+name);
        if (item.type && item.type.toLowerCase().includes("ZHATemperature")) {
          prise = prise + '<div class="prise-card">';
          prise = prise + "<h3>" + item.name + "</h3>";
          prise = prise + '<img src="images/lightbulb.png" alt="prise">';
          prise = prise + '<button class="btn-on" onclick="Allumerprise(' + num + ')">ON</button>';           
          prise = prise + '<button class="btn-off" onclick="Eteindreprise(' + num + ')">OFF</button>';
          prise = prise + "</div>";
        }
      }
      section.innerHTML = prise;
    }
  };
  xhttpAL.open("GET", "http://172.20.21.230/api/F163AB8D21/sensors/");
  xhttpAL.send();
}
function Allumerprise(num) {
  const xhttpOn = new XMLHttpRequest();
  xhttpOn.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("Prise " + num + " allumée");
    }
  };
  xhttpOn.open("PUT", "http://172.20.21.230/api/F163AB8D21/sensors/" + num + "/state");
  xhttpOn.send(JSON.stringify({"on": true}));
}

function Eteindreprise(num) {
  const xhttpOff = new XMLHttpRequest();
  xhttpOff.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log("Prise " + num + " éteinte");
    }
  };
  xhttpOff.open("PUT", "http://172.20.21.230/api/F163AB8D21/sensors/" + num + "/state");
  xhttpOff.send(JSON.stringify({"on": false}));
}