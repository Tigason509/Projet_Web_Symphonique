<?php
header('Content-Type: application/json');

$file = 'JSON/Reservation.json';

if (file_exists($file)) {
    $data = file_get_contents($file);
    // on renvoie un tableau vide,si on a pas de fichier
    if (trim($data) === "") {
        echo json_encode([]);
    } else {
        echo $data;
    }
} else {
    //on renvoie un tableau vide,si on a pas de fichier
    echo json_encode([]);
}
exit();
?>