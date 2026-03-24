<?php
try {
    $maConnexion = new PDO("mysql:host=localhost;port=3306;dbname=cirpark", "root", "" );
}catch(PDOException $e) {
    echo "BDD : ECHEC\n";
    die();
}
echo "Base de données : OK\n";
$req_methode = $_SERVER['REQUEST_METHOD'];
if(isset($_SERVER['PATH_INFO'])){
    $req_path=$_SERVER['PATH_INFO'];
    $req_data=explode('/',$req_path);
}
if($req_methode=='GET'){
    if(isset($req_data[1])&& $req_data[1]=='capteur'){
        $requete= "SELECT * FROM capteur";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json = json_encode($resultat);
        print_r($data_json);
    }
    if(isset($req_data[1], $req_data[2])&& $req_data[2]=='etat'){
        $requete= "SELECT * FROM etat";
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json = json_encode($resultat);
        print_r($data_json);
    }
    if(isset($req_data[1],$req_data[2])&& $req_data[2]=='configuration'){
        $requete= 'SELECT * FROM configuration';
        $req_prep = $maConnexion->prepare($requete);
        $req_prep->execute(NULL);
        $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);
        $data_json = json_encode($resultat);
        print_r($data_json);
    }
}
?>