<?php
    $dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    // Salvo sul DB
    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("SELECT * FROM v_players where upper(nome) = upper(:nome) LIMIT 1");
        $stmt->bindValue(":nome",$data['nome'], PDO::PARAM_STR);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($row);
    }
?>