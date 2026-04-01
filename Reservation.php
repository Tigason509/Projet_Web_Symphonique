<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = 'JSON/Reservation.json';
    $file_activite = 'JSON/Activite.json';

    $nom = $_POST['nom']  ;
    $prenom = $_POST['prenom'] ;
    $email = $_POST['email'] ;
    $nb = intval($_POST['nb_personnes'] );
    $debut = $_POST['debut'] ;
    $fin = $_POST['fin'] ;
    $activite_nom = $_POST['activite'] ;

    // Vérification des champs obligatoires
    if ($nom === '' || $prenom === '' || $email === '' || $activite_nom === '' || $nb <= 0) {
        echo "Erreur : Tous les champs sont obligatoires";
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
    if (file_exists($file_activite)) {
        $activites_data = json_decode(file_get_contents($file_activite), true);
        $trouve = false;

        foreach ($activites_data as $key => $act) {
            if ($act['nom'] === $activite_nom) {
                $trouve = true;

                // Vérifier s'il reste assez de places
                if ($act['capacite'] >= $nb) {
                    $activites_data[$key]['capacite'] -= $nb; // on met le nombre de personnes en faisant cette soustration
                } else {
                    echo "Erreur : Plus assez de places disponibles (reste : " . $act['capacite'] . " places)";
                    exit();
                }
                break;
            }
        }

        if (!$trouve) {
            echo "Erreur : L'activité choisie n'existe pas dans le système.";
            exit();
        }

        // Sauvegarder la nouvelle capacité
        file_put_contents($file_activite, json_encode($activites_data, JSON_PRETTY_PRINT));
    } else {
        echo "Erreur : Fichier des activités introuvable.";
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
            "activite" => $activite_nom
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
    <title>Réservation d'activité</title>
    <link rel="stylesheet" href="/css/Reservation.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Reservation.js"></script>
</head>
<body>

<section id="reclamation" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 style="font-family: 'Georgia', serif; color: #b89241;">Vous souhaitez explorer notre grand catalogue de séjour ?</h2>
                <p class="text-muted">Nous avons un grand panel d'activités à vous proposer, n'hésitez pas à découvrir de nouvelles activités!</p>
                <div class="p-3 border-start border-4" style="border-color: #b89241 !important; background: #f9f9f9;">
                    <small>Demandes</small>
                </div>
            </div>

            <div class="reservation">
                <h3>Formulaire de réservation</h3>

                <p>Votre nom</p>
                <input id="nom" type="text" required>

                <p>Votre prénom</p>
                <input id="prenom" type="text" required>

                <p>Email</p>
                <input type="email" id="email" required>

                <p>Nombre de personnes</p>
                <input type="number" id="nb_personnes" min="1" required>

                <p>Date début</p>
                <input type="date" id="debut" required>

                <p>Date fin</p>
                <input type="date" id="fin" required>

                <p>Choisir une activité</p>
                <select id="activ" required>
                    <option value="">Chargement...</option>
                </select>
                <button id="envoi_reservation">Envoyer la réservation</button>

                <div id="resultat" style="margin-top: 15px; padding: 10px;"></div>
            </div>
        </div>
    </div>
</section>

</body>
</html>