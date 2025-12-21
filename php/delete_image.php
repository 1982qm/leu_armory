<?php

// delete file
//$uploadDir = '../uploads/';
//$filename = $_POST['user'] . '_' . $_POST['pg'] . '.png';
//$destination = $uploadDir . $filename;

//unlink($destination);

// Connessione al db
$dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location
$dbnu = new PDO('sqlite:'.$dbu);

// Invalido le immagini precedenti
$stmt=$dbnu->prepare("UPDATE players_custom_images SET valid = 0 WHERE UPPER(nome_player) = UPPER(:nome_player)");
$stmt->bindValue(":nome_player",$_POST['pg'], PDO::PARAM_STR);
$stmt->execute();

?>