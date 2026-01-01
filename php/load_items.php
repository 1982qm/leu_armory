<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("SELECT * " .
                             "  FROM v_items " .
                             " WHERE (length(:nome) = 0 OR instr(upper(nome),upper(:nome)) > 0)" .
                             "   AND (length(:percorso) = 0 OR instr(upper(percorso),upper(:percorso)) > 0)" .
                             "   AND (length(:slot) = 0 OR instr(upper(:slot)||',',upper(slot)||',') > 0)" .
                             "   AND ( " .
                             "       length(:potere) = 0" .
                             "    OR instr(upper(potere_1),upper(:potere)) > 0" .
                             "    OR instr(upper(potere_2),upper(:potere)) > 0" .
                             "    OR instr(upper(potere_3),upper(:potere)) > 0" .
                             "    OR instr(upper(potere_4),upper(:potere)) > 0" .
                             "    OR instr(upper(potere_5),upper(:potere)) > 0" .
                             "    OR instr(upper(potere_6),upper(:potere)) > 0" .
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