<?php
    $dbu=realpath(__DIR__).'/../database/leu_items.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("SELECT i.* " .
                             "  FROM percorsi i" .
                             " WHERE upper(i.nome) = upper(:nome)" .
                             " LIMIT 1"
                             );
        $stmt->bindValue(":nome",$data["nome"], PDO::PARAM_STR);
        $stmt->execute();

        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }

        echo json_encode($output);
    }
?>