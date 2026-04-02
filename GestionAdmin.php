<?php
$file = 'JSON/Demande.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = intval($_POST['index']);
    $action = $_POST['action'];

    if (file_exists($file)) {
        $demandes = json_decode(file_get_contents($file), true);

        if (isset($demandes[$index])) {
            if ($action === 'accepter') {
                $demandes[$index]['statut'] = 'accepte';
                $msg = "Demande acceptée.";
            } elseif ($action === 'refuser') {
                array_splice($demandes, $index, 1);
                $msg = "Demande supprimée.";
            }
            file_put_contents($file, json_encode($demandes, JSON_PRETTY_PRINT));
            echo $msg;
        }
    }
    exit();
}