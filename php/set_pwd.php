<?php
    $dbu=realpath(__DIR__).'/../database/login.db'; //database location

    $data = json_decode(file_get_contents('php://input'), true);

    if($data){
        $dbnu = new PDO('sqlite:'.$dbu);
        $stmt=$dbnu->prepare("UPDATE users" .
                             "   SET password = :pwd " .
                             " WHERE upper(user_name) = upper(:user_name)"
                             );
        $stmt->bindValue(":user_name",$data["user"], PDO::PARAM_STR);
        $stmt->bindValue(":pwd",hash("sha512",$data["pwd"]), PDO::PARAM_STR);
        $stmt->execute();
    }
?>