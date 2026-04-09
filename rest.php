<?php
try {
    $maConnexion = new PDO("mysql:host=localhost;port=3306;dbname=cirpark", "root", "");
} catch (PDOException $e) {
    echo("ERREUR DB \r\n");
}
$req_methode = $_SERVER['REQUEST_METHOD'];
$req_data = [];

if (isset($_SERVER['PATH_INFO'])) {
    $req_path = $_SERVER['PATH_INFO'];
    $req_data = explode('/', $req_path);
}

if ($req_methode == 'GET') {
    if (count($req_data) == 2 && $req_data[1] == 'capteur') {
        $requete = "SELECT capteur.nom, capteur.type, capteur.numero, etat.etat, configuration.hauteur, configuration.eclairage FROM capteur, etat, configuration WHERE capteur.id = etat.id_capteur AND capteur.id = configuration.id_capteur GROUP BY capteur.numero ORDER BY etat.date_heure DESC";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'etat') {
        $requete = "SELECT * FROM etat";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }

    if (count($req_data) == 4 && $req_data[1] == 'capteur' && $req_data[2] == 'etat') {
        $id = (int)$req_data[3];
        $requete = "SELECT * FROM etat WHERE id_capteur = :id";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':id', $id, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'configuration') {
        $requete = "SELECT * FROM configuration";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }
    if (count($req_data) == 4 && $req_data[1] == 'capteur' && $req_data[2] == 'configuration') {
        $id = (int)$req_data[3];
        $requete = "SELECT * FROM configuration WHERE id_capteur = :id";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':id', $id, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }
}


?>