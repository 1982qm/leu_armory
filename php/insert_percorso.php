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

        $stmt=$dbnu->prepare("INSERT INTO percorsi (" .
                                                 "nome," .
                                                 "liv_min," .
                                                 "liv_max," .
                                                 "limiti" .
                                              ")" .
                            "VALUES (" .
                                                 "upper(substr(:nome,1,1))||substr(:nome,2)," .
                                                 ":liv_min," .
                                                 ":liv_max," .
                                                 ":limiti".
                              ")"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":liv_min",$data["liv_min"], PDO::PARAM_STR);
        $stmt->bindValue(":liv_max",$data["liv_max"], PDO::PARAM_STR);
        $stmt->bindValue(":limiti",$data["limiti"], PDO::PARAM_STR);

        $stmt->execute();
    }
?>