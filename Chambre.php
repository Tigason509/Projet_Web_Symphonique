<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file_chambres = 'JSON/Chambre.json';
    $file_clients = 'JSON/Client.json';
    $file_demandes = 'JSON/Demande.json'; // Le bon fichier de destination

    $nom = $_POST['nom'] ;
    $prenom = $_POST['prenom'] ;
    $email = $_POST['email'] ;
    $nb = intval($_POST['nb_personnes'] );
    $debut = $_POST['debut'] ;
    $fin = $_POST['fin'] ;
    $chambre_id = intval($_POST['chambre']);

    // 1. Vérifications de base
    if ($nom === '' || $prenom === '' || $email === '' || $chambre_id === 0 || $nb <= 0) {
        echo "Erreur : Tous les champs sont obligatoires";
        exit();
    }


    if (file_exists($file_clients)) {
        $clients_data = json_decode(file_get_contents($file_clients), true);
        $client_existe = false;
        foreach ($clients_data as $client) {
            if ($client['email'] === $email && $client['prenom'] === $prenom) {
                $client_existe = true;
                break;
            }
        }
        if (!$client_existe) {
            echo "Erreur : Aucun compte trouvé. Veuillez vous inscrire.";
            exit();
        }
    }

    // 3. Mise à jour de la capacité dans Chambre.json
    if (file_exists($file_chambres)) {
        $chambres_data = json_decode(file_get_contents($file_chambres), true);
        $trouve = false;
        foreach ($chambres_data as $key => $c) {
            if (intval($c['id']) === $chambre_id) {
                $trouve = true;
                if ($c['capacite'] >= $nb) {
                    $chambres_data[$key]['capacite'] -= $nb;
                } else {
                    echo "Erreur : Plus assez de places (reste : " . $c['capacite'] . ")";
                    exit();
                }
                break;
            }
        }
        if (!$trouve) {
            echo "Erreur : Chambre inexistante.";
            exit();
        }
        // Sauvegarde des chambres mises à jour
        file_put_contents($file_chambres, json_encode($chambres_data, JSON_PRETTY_PRINT));
    }

    // 4. Écriture dans Demande.json
    $nouvelle_demande = [
            "nom" => $nom,
            "prenom" => $prenom,
            "debut" => $debut,
            "fin" => $fin,
            "id_chambre" => $chambre_id,
            "nb_personnes" => $nb,
            "statut" => "en attente" // Ajout du statut par défaut
    ];

    $demandes_existantes = [];
    if (file_exists($file_demandes)) {
        $demandes_existantes = json_decode(file_get_contents($file_demandes), true);
    }

    $demandes_existantes[] = $nouvelle_demande;

    if (file_put_contents($file_demandes, json_encode($demandes_existantes, JSON_PRETTY_PRINT))) {
        echo "Demande enregistrée avec succès dans Demande.json !";
    } else {
        echo "Erreur lors de l'écriture du fichier.";
    }
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
                <button type="submit" id="envoi_reservation">Envoyer la réservation de chambre</button>

                <div id="resultat" style="margin-top: 15px; padding: 10px;"></div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
