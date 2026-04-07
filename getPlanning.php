<?php
$fichier='JSON/Reservation.json';
$donnees=json_decode(file_get_contents($fichier),true);
echo json_encode($donnees);
?>
