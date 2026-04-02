$(document).ready(function() {
    chargerTableau();

    function chargerTableau() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';
            $.each(data, function(index, d) {
                // On définit la couleur selon le statut
                let badgeClass = d.statut === 'accepte' ? 'bg-success' : 'bg-warning text-dark';

                html += `
                <tr>
                    <td>${d.nom} ${d.prenom}</td>
                    <td>Chambre ${d.id_chambre}</td>
                    <td>${d.debut} au ${d.fin}</td>
                    <td>${d.nb_personnes}</td>
                    <td><span class="badge ${badgeClass}">${d.statut}</span></td>
                    <td>
                        <button class="btn btn-sm btn-success" onclick="valider(${index})">Accepter</button>
                        <button class="btn btn-sm btn-danger" onclick="refuser(${index})">Refuser</button>
                    </td>
                </tr>`;
            });
            $('#table-demandes tbody').html(html);
        });
    }
});