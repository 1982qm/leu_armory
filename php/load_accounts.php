<?php
   $dbu=realpath(__DIR__).'/../database/login.db'; //database location

   $dbnu = new PDO('sqlite:'.$dbu);
   $stmt=$dbnu->prepare("SELECT user_name FROM users ORDER BY 1");

   $stmt->execute();

   $output = array();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       array_push($output, $row);
   }

   echo json_encode($output);
?>