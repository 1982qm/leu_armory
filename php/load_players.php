<?php
   $dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location

   $dbnu = new PDO('sqlite:'.$dbu);
   $stmt=$dbnu->prepare("SELECT nome, ifnull(nullif(titolo,''), nome) as titolo, classe, avg_eq_level, data_caricamento FROM players ORDER BY 3,1");

   $stmt->execute();

   $output = array();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       array_push($output, $row);
   }

   echo json_encode($output);
?>