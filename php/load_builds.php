<?php
    $dbu=realpath(__DIR__).'/../database/leu_builds.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    // Salvo sul DB
    if($data){   
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("SELECT account, nome, note, classe, avg_eq_level, data_caricamento, CASE WHEN pubblica = 0 THEN 'Privata' ELSE 'Pubblica' END AS visibilita FROM builds WHERE (pubblica = 1 OR upper(account) = upper(:account))");
        $stmt->bindValue(":account",$data['account'], PDO::PARAM_STR);

        $stmt->execute();

        $output = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($output, $row);
        }

        echo json_encode($output);
    }
?>