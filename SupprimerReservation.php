<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'JSON/Reservation.json';
    $file_activite = 'JSON/Activite.json';

    $index = isset($_POST['index']) ? intval($_POST['index']) : -1;
    $admin_email = $_POST['admin_email'] ;

    // Vérification admin
    if ($admin_email !== "emailadmin@gmail.com") {
        echo "Erreur : Non autorisé.";
        exit();
    }

    // Vérification index valide
    if ($index < 0) {
        echo "Erreur : Index invalide.";
        exit();
    }

    if (file_exists($file)) {
        $reservations = json_decode(file_get_contents($file), true);

        if (isset($reservations[$index])) {
            $reservation_supprimee = $reservations[$index];
            $activite_nom = $reservation_supprimee['activite'];
            $nb_personnes = $reservation_supprimee['nb_personnes'];

            // Charger le fichier des activités
            if (file_exists($file_activite)) {
                $activites_data = json_decode(file_get_contents($file_activite), true);

                // Trouver l'activité et restaurer la capacité
                foreach ($activites_data as $key => $act) {
                    if ($act['nom'] === $activite_nom) {
                        // Si capacite_max existe, on vérifie de ne pas dépasser
                        if (isset($act['capacite_max'])) {
                            $nouvelle_capacite = $act['capacite'] + $nb_personnes;

                            // Ne pas dépasser la capacité maximale
                            if ($nouvelle_capacite > $act['capacite_max']) {
                                $activites_data[$key]['capacite'] = $act['capacite_max'];
                            } else {
                                $activites_data[$key]['capacite'] = $nouvelle_capacite;
                            }
                        } else {
                            // Si pas de capacite_max, on ajoute sans limite
                            $activites_data[$key]['capacite'] += $nb_personnes;
                        }
                        break;
                    }
                }

                // Sauvegarder le fichier des activités mis à jour
                file_put_contents($file_activite, json_encode($activites_data, JSON_PRETTY_PRINT));
            }
            // --- FIN RESTAURATION ---

            // Supprimer la réservation
            array_splice($reservations, $index, 1);

            // Sauvegarder le fichier mis à jour
            file_put_contents($file, json_encode($reservations, JSON_PRETTY_PRINT));
            echo "Réservation supprimée et capacité restaurée avec succès.";
        } else {
            echo "Erreur : Réservation introuvable.";
        }
    } else {
        echo "Erreur : Fichier des réservations introuvable.";
    }
    exit();
}
?>