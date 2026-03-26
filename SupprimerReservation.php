<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'JSON/Reservation.json';
    $index = $_POST['index'];
    $admin_email = $_POST['admin_email'];
    if ($admin_email !== "emailadmin@gmail.com") {
        echo "Erreur : Non autorisé.";
        exit();
    }

    if (file_exists($file)) {
        $reservations = json_decode(file_get_contents($file), true);

        if (isset($reservations[$index])) {
            array_splice($reservations, $index, 1);

            // Sauvegarder le fichier mis à jour
            file_put_contents($file, json_encode($reservations, JSON_PRETTY_PRINT));
            echo "Réservation supprimée.";
        } else {
            echo "Erreur : Réservation introuvable.";
        }
    }
    exit();
}
?>