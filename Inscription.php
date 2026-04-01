<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fichier = 'JSON/Client.json';

    $nom = $_POST['nom'] ;
    $prenom = $_POST['prenom'] ;
    $email = $_POST['email'] ;
    $mdp = $_POST['mdp'] ;

    // Initialisation du tableau
    $utilisateurs = [];

    if (file_exists($fichier)) {
        $contenuActuel = file_get_contents($fichier);
        // On décode, et si c'est vide ou invalide, on utilise un tableau vide []
        $utilisateurs = json_decode($contenuActuel, true) ?: [];
    }

    // ... reste de ton code (vérification doublon et push) ...

    $utilisateurs[] = [
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "mdp" => $mdp
    ];

    if (file_put_contents($fichier, json_encode($utilisateurs, JSON_PRETTY_PRINT))) {
        echo json_encode(["success" => true, "message" => "Utilisateur enregistré !"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur d'écriture"]);
    }
    exit();
}