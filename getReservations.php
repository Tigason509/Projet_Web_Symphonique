<?php
header('Content-Type: application/json');

$file = 'JSON/Reservation.json';

if (file_exists($file)) {
    $data = file_get_contents($file);
    // Si le fichier est vide, on renvoie un tableau vide
    if (trim($data) === "") {
        echo json_encode([]);
    } else {
        echo $data;
    }
} else {
    // Si le fichier n'existe pas encore, on renvoie un tableau vide
    echo json_encode([]);
}
exit();
?>