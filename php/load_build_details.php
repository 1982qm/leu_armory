<?php
    $dbu=realpath(__DIR__).'/../database/leu_builds.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    // Salvo sul DB
    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("SELECT json FROM builds WHERE upper(nome) = upper(:nome) AND upper(account) = upper(:account) LIMIT 1");
        $stmt->bindValue(":nome",$data['nome'], PDO::PARAM_STR);
        $stmt->bindValue(":account",$data['account'], PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($row);
    }
?>