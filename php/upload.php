<?php
if (!isset($_FILES['image'])) {
    exit('Nessun file ricevuto');
}

$file = $_FILES['image'];
$maxSize = 5000 * 1024;

// Errore upload
if ($file['error'] !== UPLOAD_ERR_OK) {
    exit('Errore nel caricamento');
}

// Controllo dimensione
if ($file['size'] > $maxSize) {
    exit('Il file supera i 5 MB');
}

// Controllo estensione
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'png') {
    exit('Solo PNG consentiti');
}

// Controllo immagine
$imageInfo = getimagesize($file['tmp_name']);
if ($imageInfo === false) {
    exit('File non valido');
}

$width = $imageInfo[0];
$height = $imageInfo[1];

$ratio = $width / $height;
$expectedRatio = 9 / 16;

if (abs($ratio - $expectedRatio) > 0.01) {
    exit('L’immagine non è in formato 9:16');
}

// Upload
$uploadDir = realpath(__DIR__).'/../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Calcolo l'md5
$md5 = md5_file($file['tmp_name']);

// Connessione al db
$dbu=realpath(__DIR__).'/../database/leu_armory.db'; //database location
$dbnu = new PDO('sqlite:'.$dbu);

// Controllo se c'è una stessa immagine sul db e ricavo l'id
$id_image_db = null;
$path = null;

$stmt = $dbnu->prepare("SELECT id, path FROM custom_image WHERE checksum = :md5 LIMIT 1");
$stmt->bindValue(':md5', $md5, PDO::PARAM_STR);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!empty($row)) {
    $id_image_db = (int)$row['id'];
    $path = $row['path'];
}

// Se non ho trovato niente carico l'immagine e creo un nuovo id
if ($id_image_db == null) {
    $id = uniqid();
    $filename = $id . '.png';
    $destination = $uploadDir . $filename;
    move_uploaded_file($file['tmp_name'], $destination);

    $path = "uploads\\" . $filename;    

    // Inserimento nuova immagine custom
    $stmt=$dbnu->prepare("INSERT INTO custom_image (path, checksum, data_caricamento, created_by) VALUES (:path, :checksum, datetime(CURRENT_TIMESTAMP, 'localtime'), :created_by)");
    $stmt->bindValue(":path",$path, PDO::PARAM_STR);
    $stmt->bindValue(":checksum",$md5, PDO::PARAM_STR);
    $stmt->bindValue(":created_by",$_POST['user'], PDO::PARAM_STR);
    $stmt->execute();

    $id_image_db = $dbnu->lastInsertId();
} else {
    // Controllo se il file esiste, in caso lo ricarico
    $destination = $uploadDir.str_replace("uploads\\","",$path);
    if (!file_exists($destination)) {
        move_uploaded_file($file['tmp_name'], $destination);
    }
}

// Invalido le immagini precedenti
$stmt=$dbnu->prepare("UPDATE players_custom_images SET valid = 0 WHERE UPPER(nome_player) = UPPER(:nome_player)");
$stmt->bindValue(":nome_player",$_POST['pg'], PDO::PARAM_STR);
$stmt->execute();

// Inserimento nuovo collegamento
$stmt=$dbnu->prepare("INSERT INTO players_custom_images (nome_player, id_custom_image, data_caricamento, created_by, valid) VALUES (:nome_player, :id_custom_image, datetime(CURRENT_TIMESTAMP, 'localtime'), :created_by, 1)");
$stmt->bindValue(":nome_player",$_POST['pg'], PDO::PARAM_STR);
$stmt->bindValue(":id_custom_image",$id_image_db, PDO::PARAM_STR);
$stmt->bindValue(":created_by",$_POST['user'], PDO::PARAM_STR);
$stmt->execute();

echo json_encode($path);

?>