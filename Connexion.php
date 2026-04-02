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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Connexion.js"></script>
    <title>Connexion</title>
</head>
<body>

<form id="connexion" method="POST">
    <h2>Connexion</h2>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
    <div id="resultat"></div>
    <button type="submit">Se connecter</button>
    <button type="button" onclick="document.location='Inscription.php'">S'inscrire</button>
</form>
</body>
</html>