<?php

$file = 'JSON/Client.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email_saisi = $_POST['email'];
    $mdp_saisi = $_POST['mdp'];

    if (file_exists($file)) {

        $json_data = file_get_contents($file);
        $utilisateurs = json_decode($json_data, true);

        if (!is_array($utilisateurs)) {
            echo "Erreur serveur.";
            exit();
        }

        foreach ($utilisateurs as $user) {
            if ($user['email'] === $email_saisi && $user['mdp'] === $mdp_saisi) {

                echo "Connexion réussie";
                exit();
            }

        }

        echo "Erreur : Email ou mot de passe incorrect.";
    } else {
        echo "Erreur : fichier introuvable.";
    }

}
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/Connexion.css" />
    <script src="Connexion.js"></script>
    <title>Connexion </title>
</head>
<body>

<form id="connexion" method="POST" action="index.html">
    <h2>Connexion</h2>

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="mdp" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
    <button type="submit" onclick="document.location='Inscription.html'">S'inscrire<a/>
</form>
</body>
</html>
