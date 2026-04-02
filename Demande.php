<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file_chambres = 'JSON/Chambre.json';
    $file_clients = 'JSON/Client.json';
    $file_demandes = 'JSON/Demande.json'; // Chemin vers vos demandes

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $nb = intval($_POST['nb_personnes']);
    $debut = $_POST['debut'];
    $fin = $_POST['fin'];
    $chambre_id = intval($_POST['chambre']);

    // 1. Validation (Email/Prénom client)
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

    // 2. Vérification des dates
    if ($debut > $fin) {
        echo "Erreur : La date de début est après la fin.";
        exit();
    }

    // 3. MISE À JOUR DE LA CAPACITÉ (Stock réel)
    if (file_exists($file_chambres)) {
        $chambres = json_decode(file_get_contents($file_chambres), true);
        foreach ($chambres as $key => $c) {
            if ($c['id'] === $chambre_id) {
                if ($c['capacite'] >= $nb) {
                    $chambres[$key]['capacite'] -= $nb;
                } else {
                    echo "Erreur : Plus assez de place.";
                    exit();
                }
            }
        }
        file_put_contents($file_chambres, json_encode($chambres, JSON_PRETTY_PRINT));
    }

    // 4. ENREGISTREMENT DANS DEMANDE.JSON (Pour l'affichage admin)
    $nouvelle_demande = [
        "nom" => $nom,
        "prenom" => $prenom,
        "debut" => $debut,
        "fin" => $fin,
        "id_chambre" => $chambre_id,
        "nb_personnes" => $nb,
        "statut" => "en attente" // Crucial pour l'affichage
    ];

    $demandes_existantes = file_exists($file_demandes) ? json_decode(file_get_contents($file_demandes), true) : [];
    $demandes_existantes[] = $nouvelle_demande;

    file_put_contents($file_demandes, json_encode($demandes_existantes, JSON_PRETTY_PRINT));

    echo "Réservation envoyée ! En attente de validation.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration des Réservations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/Reservation.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4">Tableau de bord Administrateur</h2>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <label for="adminEmail">Email de session :</label>
            <input type="email" id="adminEmail" class="form-control d-inline-block w-auto" placeholder="admin@hotel.com">
            <p class="text-muted small mt-2">Les actions ne seront autorisées que si l'email correspond à l'admin.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <div id="resultat" class="mb-3"></div>

            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="table-demandes">
            <table class="table table-hover align-middle mb-0" id="table-demandes">
                <thead class="table-dark">
                    <tr>
                        <th>Client</th>
                        <th>Chambre</th>
                        <th>Dates</th>
                        <th>Voyageurs</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="Demande.js"></script>
</body>
</html>