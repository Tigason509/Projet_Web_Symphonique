$(document).ready(function() {
    chargerTableau();

    function chargerTableau() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';

            if (data.length === 0) {
                html = '<tr><td colspan="6" class="text-center">Aucune demande en attente.</td></tr>';
            }

            $.each(data, function(index, d) {
                let badgeClass = d.statut === 'accepte' ? 'bg-success' : 'bg-warning text-dark';

                // Masquer les boutons si déjà accepté
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
        }).fail(function() {
            $('#table-demandes tbody').html('<tr><td colspan="6" class="text-center text-danger">Erreur de chargement.</td></tr>');
        });
    }

    window.valider = function(index) {
        $.post('GestionAdmin.php', { index: index, action: 'accepter' }, function(response) {
            $('#resultat').html('<div class="alert alert-success">' + response + '</div>');
            chargerTableau();
        });
    };

    window.refuser = function(index) {
        $.post('GestionAdmin.php', { index: index, action: 'refuser' }, function(response) {
            $('#resultat').html('<div class="alert alert-danger">' + response + '</div>');
            chargerTableau();
        });
    };
});