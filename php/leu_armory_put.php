<?php
    $dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    // Salvo sul DB
    if($data){
      $dbnu = new PDO('sqlite:'.$dbu);
      //$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if ($data['livello'] == '50') {
        $stmt=$dbnu->prepare("DELETE FROM players WHERE nome = :nome");
        $stmt->bindValue(":nome",$data['player'], PDO::PARAM_STR);
        $stmt->execute();

        $stmt=$dbnu->prepare("INSERT INTO players (nome, livello, classe, avg_eq_level, titolo, json, data_caricamento) VALUES (:nome, :livello, :classe, :avg_eq_level, :titolo, :json, datetime(CURRENT_TIMESTAMP, 'localtime'))");
        $stmt->bindValue(":nome",$data['player'], PDO::PARAM_STR);
        $stmt->bindValue(":livello",$data['livello'], PDO::PARAM_STR);
        $stmt->bindValue(":classe",$data['classe'], PDO::PARAM_STR);
        $stmt->bindValue(":avg_eq_level",$data['avg_eq_level'], PDO::PARAM_STR);
        $stmt->bindValue(":titolo",$data['titolo'], PDO::PARAM_STR);
        $stmt->bindValue(":json",json_encode($data['json']), PDO::PARAM_STR);
        $stmt->execute();
      }
    }
?>