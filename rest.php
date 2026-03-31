<?php
try {
    $maConnexion = new PDO("mysql:host=localhost;port=3306;dbname=cirpark", "root", "");
} catch (PDOException $e) {
    echo("ERREUR DB \r\n");
}
$req_methode = $_SERVER['REQUEST_METHOD'];
if(isset($_SERVER['PATH_INFO'])){
    $req_path=$_SERVER['PATH_INFO'];
    $req_data=explode('/',$req_path);
}


if ($req_methode == 'GET') {
    if (count($req_data) == 2 && $req_data[1] == 'capteur') {
        $requete= "SELECT * FROM capteur";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($resultat);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'etat') {
        $requete= "SELECT * FROM etat";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $json_data=json_encode($resultat);
        print_r($json_data);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'configuration') {
        $requete= 'SELECT * FROM configuration';
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $json_data=json_encode($resultat);
        print_r($json_data);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'etat') {
        $numero = (int)$req_data[3];
        $requete = "SELECT * FROM etat WHERE id_capteur = ( SELECT id FROM capteur WHERE id = :id )";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':id', $numero, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $json_data=json_encode($resultat);
        print_r($json_data);
    }

    if (count($req_data) == 3 && $req_data[1] == 'capteur' && $req_data[2] == 'configuration') {
        $numero = (int)$req_data[3];
        $requete = "SELECT * FROM configuration WHERE id_capteur IN ( SELECT id FROM capteur WHERE id = :id)";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->bindValue(':id', $numero, PDO::PARAM_INT);
        $req_prep->execute();
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $json_data=json_encode($resultat);
        print_r($json_data);
      
    }
}
?>

Failed to load resource: net::ERR_FAILEDUnderstand this error