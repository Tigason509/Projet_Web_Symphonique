<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = 'JSON/Reservation.json';

    $nom = $_POST['nom'] ;
    $prenom = $_POST['prenom'];
    $email = $_POST['email'] ;
    $nb = $_POST['nb_personnes'] ;
    $debut = $_POST['debut'];
    $fin = $_POST['fin'] ;
    $activite = $_POST['activite'] ;

    // Vérification
    if ($nom === '' || $prenom === '' || $email === '') {
        echo "Champs obligatoires manquants";
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
            "activite" => $activite
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

    echo "Réservation enregistrée avec succès";
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
                <input id="email">

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
