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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="/css/Inscription.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Inscription.js"></script>
</head>
<body>
<div class="signup-container">
    <h2>Créer un compte</h2>
    <form id="signupForm">
        <div class="input-group">
            <input type="text" id="nom" placeholder="Nom" required>
            <input type="text" id="prenom" placeholder="Prénom" required>
        </div>
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="mdp" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
    <p id="message"></p>
</div>
<script src="script.js"></script>
</body>
</html>

