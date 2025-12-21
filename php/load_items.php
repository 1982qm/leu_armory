<?php
   $dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location

   $dbnu = new PDO('sqlite:'.$dbu);
   $stmt=$dbnu->prepare("SELECT name, level FROM items ORDER BY 1,2");

   $stmt->execute();

   $output = array();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       array_push($output, $row);
   }
   echo json_encode($output);
?>