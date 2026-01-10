<?php
  $dbu=realpath(__DIR__).'/../database/login.db'; //database location

  $dbnu = new PDO('sqlite:'.$dbu);
  //$dbnu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt=$dbnu->prepare("delete from active_users where connection_ts < date();");

  $stmt->execute();
?>