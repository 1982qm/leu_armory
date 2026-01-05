<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);

        $stmt=$dbnu->prepare("DELETE FROM items" .
                             " WHERE upper(nome) = upper(:nome)"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->execute();

        $stmt=$dbnu->prepare("INSERT INTO items (" .
                                                 "nome," .
                                                 "slot," .
                                                 "rarita," .
                                                 "percorso," .
                                                 "livello_percorso," .
                                                 "livello_percorso_max," .
                                                 "limitato," .
                                                 "bonus," .
                                                 "ac," .
                                                 "dadi," .
                                                 "tipo_danno," .
                                                 "perc_fisico," .
                                                 "perc_magico," .
                                                 "potere_1_tipo," .
                                                 "potere_1_nome," .
                                                 "potere_1_valore," .
                                                 "potere_2_tipo," .
                                                 "potere_2_nome," .
                                                 "potere_2_valore," .
                                                 "potere_3_tipo," .
                                                 "potere_3_nome," .
                                                 "potere_3_valore," .
                                                 "potere_4_tipo," .
                                                 "potere_4_nome," .
                                                 "potere_4_valore," .
                                                 "potere_5_tipo," .
                                                 "potere_5_nome," .
                                                 "potere_5_valore," .
                                                 "potere_6_tipo," .
                                                 "potere_6_nome," .
                                                 "potere_6_valore" .
                                              ")" .
                            "VALUES (" .
                                                 "upper(substr(:nome,1,1))||substr(:nome,2)," .
                                                 ":slot," .
                                                 ":rarita," .
                                                 ":percorso," .
                                                 ":livello_percorso," .
                                                 ":livello_percorso_max," .
                                                 ":limitato," .
                                                 ":bonus," .
                                                 ":ac," .
                                                 ":dadi," .
                                                 ":tipo_danno," .
                                                 ":perc_fisico," .
                                                 ":perc_magico," .
                                                 ":potere_1_tipo," .
                                                 ":potere_1_nome," .
                                                 ":potere_1_valore," .
                                                 ":potere_2_tipo," .
                                                 ":potere_2_nome," .
                                                 ":potere_2_valore," .
                                                 ":potere_3_tipo," .
                                                 ":potere_3_nome," .
                                                 ":potere_3_valore," .
                                                 ":potere_4_tipo," .
                                                 ":potere_4_nome," .
                                                 ":potere_4_valore," .
                                                 ":potere_5_tipo," .
                                                 ":potere_5_nome," .
                                                 ":potere_5_valore," .
                                                 ":potere_6_tipo," .
                                                 ":potere_6_nome," .
                                                 ":potere_6_valore" .
                              ")"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":slot",$data["slot"], PDO::PARAM_STR);
        $stmt->bindValue(":rarita",$data["rarita"], PDO::PARAM_STR);
        $stmt->bindValue(":percorso",$data["percorso"], PDO::PARAM_STR);
        $stmt->bindValue(":livello_percorso",$data["livello_percorso"], PDO::PARAM_STR);
        $stmt->bindValue(":livello_percorso_max",$data["livello_percorso_max"], PDO::PARAM_STR);
        $stmt->bindValue(":limitato",$data["limitato"], PDO::PARAM_STR);
        $stmt->bindValue(":bonus",$data["bonus"], PDO::PARAM_STR);
        $stmt->bindValue(":ac",$data["ac"], PDO::PARAM_STR);
        $stmt->bindValue(":dadi",$data["dadi"], PDO::PARAM_STR);
        $stmt->bindValue(":tipo_danno",$data["tipo_danno"], PDO::PARAM_STR);
        $stmt->bindValue(":perc_fisico",$data["perc_fisico"], PDO::PARAM_STR);
        $stmt->bindValue(":perc_magico",$data["perc_magico"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_1_tipo",$data["potere_1_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_1_nome",$data["potere_1_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_1_valore",$data["potere_1_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_2_tipo",$data["potere_2_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_2_nome",$data["potere_2_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_2_valore",$data["potere_2_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_3_tipo",$data["potere_3_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_3_nome",$data["potere_3_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_3_valore",$data["potere_3_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_4_tipo",$data["potere_4_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_4_nome",$data["potere_4_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_4_valore",$data["potere_4_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_5_tipo",$data["potere_5_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_5_nome",$data["potere_5_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_5_valore",$data["potere_5_valore"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_6_tipo",$data["potere_6_tipo"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_6_nome",$data["potere_6_nome"], PDO::PARAM_STR);
        $stmt->bindValue(":potere_6_valore",$data["potere_6_valore"], PDO::PARAM_STR);

        $stmt->execute();
    }
?>