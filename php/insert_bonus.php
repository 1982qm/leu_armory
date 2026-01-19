<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("DELETE FROM bonus" .
                             " WHERE upper(nome) = upper(:nome)"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->execute();

        $stmt=$dbnu->prepare("INSERT INTO bonus (" .
                                                 "nome," .
                                                 "percorso," .
                                                 "potere_2p_nome," .
                                                 "potere_2p_valore," .
                                                 "potere_4p_nome," .
                                                 "potere_4p_valore" .
                                              ")" .
                            "VALUES (" .
                                                 "upper(substr(:nome,1,1))||substr(:nome,2)," .
                                                 ":percorso," .
                                                 ":potere_2p_nome," .
                                                 ":potere_2p_valore," .
                                                 ":potere_4p_nome," .
                                                 ":potere_4p_valore".
                              ")"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":percorso",$data["percorso"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_2p_nome",$data["potere_2p_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_2p_valore",$data["potere_2p_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_4p_nome",$data["potere_4p_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_4p_valore",$data["potere_4p_valore"], PDO::PARAM_STR);

        $stmt->execute();
    }
?>