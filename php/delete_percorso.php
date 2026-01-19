<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("DELETE FROM percorsi" .
                             " WHERE upper(nome) = upper(:nome)"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->execute();
    }
?>