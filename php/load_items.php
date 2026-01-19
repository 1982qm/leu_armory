<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("SELECT i.* " .
                             "      , b.nome as bonus_nome " .
                             "      , b.potere_2p_nome as bonus_2p_nome " .
                             "      , b.potere_2p_valore as bonus_2p_valore " .
                             "      , b.potere_4p_nome  as bonus_4p_nome " .
                             "      , b.potere_4p_valore as bonus_4p_valore " .
                             "      , p.limiti " .
                             "  FROM items i" .
                             "  LEFT JOIN bonus b on i.bonus = b.nome" .
                             "  LEFT JOIN percorsi p on i.percorso = p.nome" .
                             " WHERE (length(:nome) = 0 OR instr(upper(i.nome),upper(:nome)) > 0)" .
                             "   AND (length(:percorso) = 0 OR instr(upper(:percorso)||',',upper(i.percorso)||',') > 0)" .
                             "   AND (length(:slot) = 0 OR instr(upper(:slot)||',',upper(i.slot)||',') > 0)" .
                             "   AND ( " .
                             "       length(:potere) = 0" .
                             "    OR instr(upper(i.potere_1_nome),upper(:potere)) > 0" .
                             "    OR instr(upper(i.potere_2_nome),upper(:potere)) > 0" .
                             "    OR instr(upper(i.potere_3_nome),upper(:potere)) > 0" .
                             "    OR instr(upper(i.potere_4_nome),upper(:potere)) > 0" .
                             "    OR instr(upper(i.potere_5_nome),upper(:potere)) > 0" .
                             "    OR instr(upper(i.potere_6_nome),upper(:potere)) > 0" .
                             "   ) "
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->bindValue(":percorso",$data["percorso"], PDO::PARAM_STR);
        $stmt->bindValue(":slot",$data["slot"], PDO::PARAM_STR);
        $stmt->bindValue(":potere",$data["potere"], PDO::PARAM_STR);

        $stmt->execute();

        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }

        echo json_encode($output);
    }
?>