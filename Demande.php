<?php
// On définit les chemins des fichiers
$file_chambres = 'JSON/Chambre.json';
$file_demandes = 'JSON/Demande.json';
$file_clients = 'JSON/Client.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération sécurisée des données
    $nom = htmlspecialchars($_POST['nom'] );
    $prenom = htmlspecialchars($_POST['prenom'] );
    $email = $_POST['email'] ;
    $nb = intval($_POST['nb_personnes'] );
    $debut = $_POST['debut'] ;
    $fin = $_POST['fin'] ;
    $chambre_id = intval($_POST['chambre'] );

    // 1. Validation de sécurité
    if (empty($nom) || empty($prenom) || empty($email) || $chambre_id === 0 || $nb <= 0) {
        echo "Erreur : Tous les champs sont obligatoires.";
        exit();
    }

    // 2. Vérification du client dans Client.json
    if (file_exists($file_clients)) {
        $clients = json_decode(file_get_contents($file_clients), true);
        $client_valide = false;
        foreach ($clients as $c) {
            if ($c['email'] === $email && $c['prenom'] === $prenom) {
                $client_valide = true;
                break;
            }
        }
        if (!$client_valide) {
            echo "Erreur : Aucun compte trouvé. Veuillez vous inscrire.";
            exit();
        }
    }

    // 3. Mise à jour de la capacité dans Chambre.json
    if (file_exists($file_chambres)) {
        $chambres = json_decode(file_get_contents($file_chambres), true);
        $chambre_trouvee = false;

        foreach ($chambres as &$ch) {
            if (intval($ch['id']) === $chambre_id) {
                $chambre_trouvee = true;
                if ($ch['capacite'] >= $nb) {
                    $ch['capacite'] -= $nb;
                } else {
                    echo "Erreur : Plus assez de places (Reste : " . $ch['capacite'] . ").";
                    exit();
                }
                break;
            }
        }
        if (!$chambre_trouvee) {
            echo "Erreur : Chambre ID $chambre_id introuvable.";
            exit();
        }
        // On enregistre la nouvelle capacité
        file_put_contents($file_chambres, json_encode($chambres, JSON_PRETTY_PRINT));
    }

    // 4. Écriture de la nouvelle ligne dans Demande.json
    $nouvelle_demande = [
        "nom" => $nom,
        "prenom" => $prenom,
        "debut" => $debut,
        "fin" => $fin,
        "id_chambre" => $chambre_id,
        "nb_personnes" => $nb,
        "statut" => "en attente"
    ];

    $demandes_actuelles = [];
    if (file_exists($file_demandes)) {
        $demandes_actuelles = json_decode(file_get_contents($file_demandes), true) ;
    }

    $demandes_actuelles[] = $nouvelle_demande;

    if (file_put_contents($file_demandes, json_encode($demandes_actuelles, JSON_PRETTY_PRINT))) {
        echo "Succès : Votre réservation est enregistrée.";
    } else {
        echo "Erreur : Impossible d'écrire dans le fichier Demande.json.";
    }
    exit();
}