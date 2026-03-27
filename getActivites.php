<?php
header('Content-Type: application/json');

// Log pour débogage
error_log("getActivites.php appelé");

$file = 'JSON/Activite.json';

if (file_exists($file)) {
    $data = file_get_contents($file);
    error_log("Contenu du fichier: " . $data);

    if (trim($data) === "") {
        echo json_encode([]);
    } else {
        echo $data;
    }
}
exit();
?>