<?php
    $dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location

    $dbnu = new PDO('sqlite:'.$dbu);
    $stmt=$dbnu->prepare("DELETE FROM players");
    $stmt->execute();
?>