<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = 'JSON/Reservation.json';
    $file_activite = 'JSON/Activite.json';

    $nom = $_POST['nom'] ;
    $prenom = $_POST['prenom'];
    $email = $_POST['email'] ;
    $nb = intval($_POST['nb_personnes']); // AJOUT : Conversion en entier pour le calcul
    $debut = $_POST['debut'];
    $fin = $_POST['fin'] ;
    $activite_nom = $_POST['activite'] ;

    // Vérification
    if ($nom === '' || $prenom === '' || $email === '') {
        echo "Champs obligatoires manquants";
        exit();
    }

    // --- DEBUT DE LA MISE À JOUR DE LA CAPACITÉ (AJOUT) ---
    if (file_exists($file_activite)) {
        $activites_data = json_decode(file_get_contents($file_activite), true);
        $trouve = false;

        foreach ($activites_data as $key => $act) {
            if ($act['nom'] === $activite_nom) {
                $trouve = true;

                // On vérifie s'il reste assez de place
                if ($act['capacite'] >= $nb) {
                    $activites_data[$key]['capacite'] -= $nb; // SOUSTRACTION DYNAMIQUE
                } else {
                    echo "Erreur : Plus assez de places disponibles (reste : " . $act['capacite'] . ")";
                    exit();
                }
                break;
            }
        }

        if (!$trouve) {
            echo "Erreur : L'activité choisie n'existe pas dans le système.";
            exit();
        }

        // Sauvegarder la nouvelle capacité AVANT d'enregistrer la réservation
        file_put_contents($file_activite, json_encode($activites_data, JSON_PRETTY_PRINT));
    } else {
        echo "Erreur : Fichier des activités introuvable.";
        exit();
    }
    // --- FIN DE LA MISE À JOUR DE LA CAPACITÉ ---

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
    <title>Titre de la page</title>
    <link rel="stylesheet" href="/css/Reservation.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Reservation.js"></script>
</head>
<body onload="init()">

<section id="reclamation" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 style="font-family: 'Georgia', serif; color: #b89241;">Vous souhaitez explorer notre grand catalogue de séjour ?</h2>
                <p class="text-muted">Nous avons un grand panel d'activités à vous proposer, n'hésitez à découvrir de nouvelles activités!</p>
                <div class="p-3 border-start border-4" style="border-color: #b89241 !important; background: #f9f9f9;">
                    <small>Demandes </small>
                </div>
            </div>

            <div class="reservation">

                <p>Votre nom</p>
                <input id="nom">

                <p>Votre prénom</p>
                <input id="prenom">

                <p>Email</p>
                <input type="email" id="email">

                <p>Nombre de personnes</p>
                <input type="number" id="nb_personnes">

                <p>Date début</p>
                <input type="date" id="debut">

                <p>Date fin</p>
                <input type="date" id="fin">

                <p>Choisir une activité</p>
                <select id="activ"></select>

                <p>Choisir une réservation</p>
                <select id="reserv"></select>

                <button id="envoi_reservation" onclick="document.location='TableauActivite.php'">Envoyer</button>

            </div>

            </body>
            <h3>
                Activité
            </h3>
            </div>
        </div>
    </div>
</section>

</body>
</html>
