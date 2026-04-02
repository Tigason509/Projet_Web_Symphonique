<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = 'JSON/Chambre.json';
    $file_clients = 'JSON/Client.json';

    $nom = $_POST['nom']  ;
    $prenom = $_POST['prenom'] ;
    $email = $_POST['email'] ;
    $nb = intval($_POST['nb_personnes'] );
    $debut = $_POST['debut'] ;
    $fin = $_POST['fin'] ;
    $chambre_id = $_POST['chambre'] ;

    // Vérification des champs obligatoires
    if ($nom === '' || $prenom === '' || $email === '' || $chambre_id === '' || $nb <= 0) {
        echo "Erreur : Tous les champs sont obligatoires";
        exit();
    }
    if (file_exists($file_clients)) {
        $clients_data = json_decode(file_get_contents($file_clients), true) ;
        $client_existe = false;

        foreach ($clients_data as $client) {
            // On vérifie si l'email ET le prénom correspondent
            if ($client['email'] === $email && $client['prenom'] === $prenom) {
                $client_existe = true;
                break;
            }
        }

        if (!$client_existe) {
            echo "Erreur : Aucun compte trouvé avec cet email et ce prénom. Veuillez vous inscrire.";
            exit();
        }
    } else {
        echo "Erreur : Base de données clients inaccessible.";
        exit();
    }

    // Vérification des dates
    if ($debut === '' || $fin === '') {
        echo "Erreur : Les dates sont obligatoires";
        exit();
    }

    if ($debut > $fin) {
        echo "Erreur : La date de début doit être avant la date de fin";
        exit();
    }

    // --- MISE À JOUR DE LA CAPACITÉ ---
    if (file_exists($file)) {
        $chambres_data = json_decode(file_get_contents($file), true);
        $trouve = false;

        foreach ($chambres_data as $key => $c) {
            if ($c['id'] === $chambre_id) {
                $trouve = true;

                // Vérifier s'il reste assez de places
                if ($c['capacite'] >= $nb) {
                    $chambres_data[$key]['capacite'] -= $nb; // on met le nombre de personnes en faisant cette soustration
                } else {
                    echo "Erreur : Plus assez de places disponibles (reste : " . $c['capacite'] . " places)";
                    exit();
                }
                break;
            }
        }

        if (!$trouve) {
            echo "Erreur : La chambre choisie n'existe pas dans le système.";
            exit();
        }

        // Sauvegarder la nouvelle capacité
        file_put_contents($file, json_encode($chambres_data, JSON_PRETTY_PRINT));
    } else {
        echo "Erreur : Fichier des chambres introuvable.";
        exit();
    }

    // Nouvelle réservation
    $nouvelle_reservation = [
            "nom" => $nom,
            "prenom" => $prenom,
            "email" => $email,
            "nb_personnes" => $nb,
            "debut" => $debut,
            "fin" => $fin,
            "chambre_id" => $chambre_id
    ];

    // Lire le fichier existant
    if (file_exists($file)) {
        $json_data = file_get_contents($file);
        $reservations = json_decode($json_data, true);
    } else {
        $reservations = [];
    }

    if (!is_array($reservations)) {
        $reservations = [];
    }

    // Ajouter la nouvelle réservation
    $reservations[] = $nouvelle_reservation;
    file_put_contents($file, json_encode($reservations, JSON_PRETTY_PRINT));

    echo "Réservation enregistrée et capacité mise à jour avec succès !";
    exit();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Réservation de chambre</title>
    <link rel="stylesheet" href="/css/Reservation.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Chambre.js"></script>
</head>
<body>

<section id="reclamation" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 style="font-family: 'Georgia', serif; color: #b89241;">Vous souhaitez réserver une chambre ?</h2>
                <p class="text-muted">Nous vous proposons 10 chambres, choisissez celle qui vous convient !</p>
                <div class="p-3 border-start border-4" style="border-color: #b89241 !important; background: #f9f9f9;">
                    <small>Demandes</small>
                </div>
            </div>

            <div class="reservation">
                <h3>Formulaire de réservation de chambre</h3>

                <p>Votre nom</p>
                <input id="nom" type="text" required>

                <p>Votre prénom</p>
                <input id="prenom" type="text" required>

                <p>Email</p>
                <input type="email" id="email" required>

                <p>Nombre de personnes</p>
                <input type="number" id="nb_personnes" min="1" max="6" required>

                <p>Date début</p>
                <input type="date" id="debut" required>

                <p>Date fin</p>
                <input type="date" id="fin" required>

                <p>Numéro de Chambre</p>
                <input type="number" id="chambre" min="1" max="10" required>
                <button id="envoi_reservation">Envoyer la réservation</button>

                <div id="resultat" style="margin-top: 15px; padding: 10px;"></div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
