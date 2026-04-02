$(document).ready(function() {
    chargerTableau();
    chargerChambres_prises();

    function chargerTableau() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="6" class="text-center">Aucune demande en attente.</td></tr>';
            }

            $.each(data, function(index, d) {
                let badgeClass = d.statut === 'accepte' ? 'bg-success' : 'bg-warning text-dark';
                let boutons = d.statut === 'accepte' ?
                    '<span class="text-muted">Traitée</span>' :
                    `<button class="btn btn-sm btn-success me-1" onclick="valider(${index})">Accepter</button>
                     <button class="btn btn-sm btn-danger" onclick="refuser(${index})">Refuser</button>`;

                html += `
                <tr>
                    <td>${d.nom} ${d.prenom}</td>
                    <td>Chambre ${d.id_chambre}</td>
                    <td>${d.debut} au ${d.fin}</td>
                    <td>${d.nb_personnes}</td>
                    <td><span class="badge ${badgeClass}">${d.statut}</span></td>
                    <td>${boutons}</td>
                </tr>`;
            });
            $('#table-demandes tbody').html(html);
        });
    }

    // Fonction pour les chambres prises avec bouton Libérer
    function chargerChambres_prises() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';
            let count = 0;

            $.each(data, function(index, d) {
                // On affiche uniquement si le statut est "accepte"
                if (d.statut === 'accepte') {
                    count++;
                    // Le bouton "Libérer" appelle la fonction refuser pour supprimer l'entrée
                    let boutonLibere = `<button class="btn btn-sm btn-outline-primary" onclick="refuser(${index}, 'liberer')">Libérer</button>`;

                    html += `
                    <tr>
                        <td><strong>${d.nom}</strong> ${d.prenom}</td>
                        <td><span class="badge bg-primary">Chambre ${d.id_chambre}</span></td>
                        <td>Du ${d.debut} au ${d.fin}</td>
                        <td>${d.nb_personnes} pers.</td>
                        <td>${boutonLibere}</td>
                    </tr>`;
                }
            });

            if (count === 0) {
                html = '<tr><td colspan="5" class="text-center">Aucune chambre occupée pour le moment.</td></tr>';
            }

            $('#table-chambres-prises tbody').html(html);
        });
    }

    window.valider = function(index) {
        $.post('GestionAdmin.php', { index: index, action: 'accepter' }, function(response) {
            alert(response);
            chargerTableau();
            chargerChambres_prises();
        });
    };

    // La fonction refuser gère maintenant la confirmation pour "Refuser" ou "Libérer"
    window.refuser = function(index, type = 'refuser') {
        let message = type === 'liberer' ? "Voulez-vous libérer cette chambre (supprimer la réservation) ?" : "Refuser cette demande ?";

        if(confirm(message)) {
            $.post('GestionAdmin.php', { index: index, action: 'refuser' }, function(response) {
                // Si c'est une libération, on peut personnaliser le message de retour
                let msgTableau = type === 'liberer' ? "Chambre libérée avec succès." : response;
                alert(msgTableau);
                chargerTableau();
                chargerChambres_prises();
            });
        }
    };
});