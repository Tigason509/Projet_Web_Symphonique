<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['email'])) {
    $file_demandes = 'JSON/Demande.json';
    $file_activites = 'JSON/Activite.json';

    $id_act = intval($_POST['id_act']);
    $nb = intval($_POST['nb_personnes']);
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];

    $nom_act = "Inconnue";
    if (file_exists($file_activites)) {
        $activites = json_decode(file_get_contents($file_activites), true);
        foreach ($activites as $a) {
            if ($a['id'] === $id_act) {
                $nom_act = $a['nom'];
                break;
            }
        }
    }

    $nouvelle_demande = [
        "nom" => $_SESSION['nom']  ,
        "prenom" => $_SESSION['prenom'] ,
        "email" => $_SESSION['email'],
        "debut" => $debut,
        "fin" => $fin,
        "nb_personnes" => $nb,
        "activite" => $nom_act,
        "statut" => "en attente"
    ];

    $demandes = file_exists($file_demandes) ? json_decode(file_get_contents($file_demandes), true) : [];
    $demandes[] = $nouvelle_demande;

    if (file_put_contents($file_demandes, json_encode($demandes, JSON_PRETTY_PRINT))) {
        echo "Demande envoyée ! En attente de validation par l'admin.";
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
    exit();
}