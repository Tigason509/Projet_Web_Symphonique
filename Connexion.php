<?php
$file = 'JSON/Client.json';
$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email_saisi = $_POST['email'];
    $mdp_saisi = $_POST['mdp'];

    if (file_exists($file)) {
        $json_data = file_get_contents($file);
        $utilisateurs = json_decode($json_data, true);

        if (!is_array($utilisateurs)) {
            $erreur = "Erreur serveur.";
        } else {
            $trouve = false;
            foreach ($utilisateurs as $user) {
                if ($user['email'] === $email_saisi && $user['mdp'] === $mdp_saisi) {
                    $trouve = true;
                    if ($email_saisi === "emailadmin@gmail.com") {
                        header('Location: Tableaudebord.html');
                    } else {
                        header('Location: index.php');
                    }
                    exit();
                }
            }
            if (!$trouve) {
                $erreur = "Email ou mot de passe incorrect.";
            }
        }
    } else {
        $erreur = "Erreur : fichier introuvable.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/Connexion.css" />
    <title>Connexion</title>
</head>
<body>

<form id="connexion" method="POST">
    <h2>Connexion</h2>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>

<button type="button" onclick="window.location.href='Inscription.html'">S'inscrire</button>

</body>
</html>