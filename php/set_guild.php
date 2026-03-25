<?php
    $dbu=realpath(__DIR__).'/../database/leu_guilds.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("DELETE FROM Users WHERE upper(username) = upper(:username)");
        $stmt->bindValue(":username",$data["username"], PDO::PARAM_STR);
        $stmt->execute();

        $stmt=$dbnu->prepare("INSERT INTO Users (username, gilda, data_creazione) VALUES (:username, :gilda, datetime(CURRENT_TIMESTAMP, 'localtime'))");
        $stmt->bindValue(":username",$data["username"], PDO::PARAM_STR);
        $stmt->bindValue(":gilda",$data["gilda"], PDO::PARAM_STR);
        $stmt->execute();
    }
?>