$(document).ready(function() {
    const emailClient = $('#clientEmail').text();
    chargerFacture();

    $('#formResa').submit(function(e) {
        e.preventDefault();
        $.post('ProfilClient_Action.php', $(this).serialize(), function(response) {
            alert(response);
            $('#formResa')[0].reset(); // Vide le formulaire
            chargerFacture(); // Actualise (même si c'est en attente, pour la démo)
        });
    });

    // 2. Chargement de la facture filtrée
    function chargerFacture() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';
            let total = 0;
            let count = 0;

            $.each(data, function(index, d) {
                if (d.email === emailClient && d.statut === 'accepte') {
                    let prix = d.nb_personnes * 40; // Tarif de base
                    total += prix;
                    count++;
                    html += `
                    <tr>
                        <td><strong>${d.activite}</strong></td>
                        <td>Du ${d.debut} au ${d.fin}</td>
                        <td>${d.nb_personnes} pers.</td>
                        <td>${prix} €</td>
                    </tr>`;
                }
            });

            if (count === 0) {
                html = '<tr><td colspan="4" class="text-center text-muted">Aucune activité validée pour le moment.</td></tr>';
            }

            $('#table-facture tbody').html(html);
            $('#totalFacture').text(total);
        });
    }
});