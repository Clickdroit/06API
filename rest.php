<?php
try {
    $maConnexion = new PDO("mysql:host=localhost;port=3306;dbname=cirpark", "root", "");

}catch(PDOException $e) {
    echo json_encode(array('erreur' => 'Connexion BDD impossible'));
    die();
}
$req_methode = $_SERVER['REQUEST_METHOD'];
if(isset($_SERVER['PATH_INFO'])){
    $req_path=$_SERVER['PATH_INFO'];
    $req_data=explode('/',$req_path);
}

if ($req_methode == 'GET') {
    if (count($req_data) == 1 && $req_data[0] == 'capteur') {
        $requete= "SELECT * FROM capteur";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json=json_encode($resultat);
        print_r($data_json);
    }

    if (count($req_data) == 2 && $req_data[0] == 'capteur' && $req_data[1] == 'etat') {
        $requete= "SELECT * FROM etat";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json=json_encode($resultat);
        print_r($data_json);
    }

    if (count($req_data) == 2 && $req_data[0] == 'capteur' && $req_data[1] == 'configuration') {
        $requete= 'SELECT * FROM configuration';
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json=json_encode($resultat);
        print_r($data_json);
    }

    if (count($req_data) == 3 && $req_data[0] == 'capteur' && $req_data[1] == 'etat') {
        $numero = (int)$req_data[2];
        $requete = "SELECT e.* FROM etat e INNER JOIN capteur c ON c.id = e.id_capteur WHERE c.numero = :numero";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':numero', $numero, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json=json_encode($resultat);
        print_r($data_json);
    }

    if (count($req_data) == 3 && $req_data[0] == 'capteur' && $req_data[1] == 'configuration') {
        $numero = (int)$req_data[2];
        $requete = "SELECT cfg.* FROM configuration cfg INNER JOIN capteur c ON c.id = cfg.id_capteur WHERE c.numero = :numero";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':numero', $numero, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json=json_encode($resultat);
        print_r($data_json);
    }
}
?>