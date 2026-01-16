<?php
    $dbu=realpath(__DIR__).'/../database/leu_builds.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("DELETE FROM builds" .
                             " WHERE upper(nome) = upper(:nome)" .
                             " AND upper(account) = upper(:account)"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":account",$data["account"], PDO::PARAM_STR);
        $stmt->execute();

        $stmt=$dbnu->prepare("INSERT INTO builds (" .
                                                 "account," .
                                                 "nome," .
                                                 "classe," .
                                                 "note," .
                                                 "json," .
                                                 "data_caricamento," .
                                                 "pubblica" .
                                              ")" .
                            "VALUES (" .
                                                 ":account," .
                                                 ":nome," .
                                                 ":classe," .
                                                 ":note," .
                                                 ":json," .
                                                 "datetime(CURRENT_TIMESTAMP, 'localtime')," .
                                                 ":pubblica" .
                              ")"
                             );
        $stmt->bindValue(":account",$data["account"], PDO::PARAM_STR);
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":classe",$data["classe"], PDO::PARAM_STR);
        $stmt->bindValue(":note",$data["note"], PDO::PARAM_STR);
        $stmt->bindValue(":json",$data["json"], PDO::PARAM_STR);
        $stmt->bindValue(":pubblica",$data["pubblica"], PDO::PARAM_STR);
        $stmt->execute();
    }
?>