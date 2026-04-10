<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=cirpark", "root", "" );
}catch(PDOException $e) {
    echo "BDD : ECHEC\n";
    die();
}
echo "Base de données : OK\n";

while(1){
    $requete= "SELECT id, numero FROM capteur";
    $req_prep = $pdo->prepare($requete);
    $req_prep->execute();
    $resultat = $req_prep->fetchAll(PDO::FETCH_ASSOC);

    for($i=0; $i<count($resultat); $i++){
        $capteur=str_split($resultat[$i]['numero'],2);
        $adrh=$capteur[0];
        $adrl=$capteur[1];
        $codeFonction="10";
        $bcc=dechex(hexdec($adrh)+hexdec($adrl)+hexdec($codeFonction));
        $ipServeur = "172.20.21.249";
        $port = "10001";
        $message=hex2bin($adrh.$adrl.$codeFonction.$bcc);
        echo "message envoyé : ".$adrh.$adrl.$codeFonction.$bcc."\r\n";
        $sock = socket_create(AF_INET, SOCK_DGRAM, 0);
        socket_sendto($sock, $message , strlen($message) , 0 , $ipServeur , $port);
        socket_recvfrom($sock, $reponse, 2045, 0, $ipServeur, $port);
        echo "La réponse est : ". bin2hex($reponse)."\r\n";
        socket_close($sock); 
        $tableauData=str_split(bin2hex($reponse), 2);
        $etat=$tableauData[2];
        if($etat=="00") {
            $etatt = "Libre";
            echo "La place est libre ! \r\n";
        }
        if($etat=="01") {
            $etatt = "Occupee";
            echo "La place est occupée ! \r\n";
        }
        $req_dernier = $pdo->prepare("SELECT etat FROM etat WHERE id_capteur = ? ORDER BY id DESC LIMIT 1");
        $req_dernier->bindParam(1, $resultat[$i]['id']);
        $req_dernier->execute();
        $donnees = $req_dernier->fetch(PDO::FETCH_ASSOC);
        
        $dernier_etat_enregistre = "";
        if ($donnees != false) {
            $dernier_etat_enregistre = $donnees['etat'];
        }
        if ($etatt != $dernier_etat_enregistre) {
            $insert = "INSERT INTO etat (etat, date_heure, id_capteur) VALUES (?, NOW(), ?)";
            $req_prep_insert = $pdo->prepare($insert);
            $req_prep_insert->bindParam(1, $etatt);
            $req_prep_insert->bindParam(2, $resultat[$i]['id']);
            $req_prep_insert->execute();
            echo "-> SAUVEGARDE EN BDD : on enregistre le nouvel état.\r\n";
        } else {
            echo "-> PAS DE SAUVEGARDE : la place est toujours dans le même état.\r\n";
        }        
        print_r("\r\n------------------------------------------------------------------------------------------------\r\n\r\n");
    }
    sleep(60);
}
?>  