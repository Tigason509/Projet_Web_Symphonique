<?php

$file = 'JSON/Client.json';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_saisi = $_POST['email'];
    $mdp_saisi = $_POST['mdp'];

    // Charger les données du fichier JSON
    if (file_exists($file)) {
        $json_data = file_get_contents($file);
        $utilisateurs = json_decode($json_data, true);

        $auth_reussie = false;
        $user_info = null;

        // Verifier si il est déjà inscrit
        foreach ($utilisateurs as $user) {
            if ($user['email'] === $email_saisi && $user['mdp'] === $mdp_saisi) {
                $auth_reussie = true;
                $user_info = $user;
                break;
            }
        }

        if ($auth_reussie) {
            echo "Bienvenue " . htmlspecialchars($user_info['prenom']) . " ! Connexion réussie.";
        } else {
            echo "Erreur : Email ou mot de passe incorrect.";
        }
    } else {
        echo "Erreur : Le fichier de base de données JSON est introuvable.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion </title>
</head>
<body>
<link rel="stylesheet" href="/css/Connexion.css" />
<form id="connexion" method="POST">
    <h2>Connexion</h2>

    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="mdp" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
    <a href="Inscription.php">S'incrire<a/>
</form>
</body>
</html>
