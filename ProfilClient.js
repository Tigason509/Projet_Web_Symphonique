$(document).ready(function() {
    const emailClient = $('#clientEmail').text().trim();
    chargerFacture();

    $('#formResa').submit(function(e) {
        e.preventDefault();
        $.post('ProfilClient_Action.php', $(this).serialize(), function(response) {
            alert(response);
            $('#formResa')[0].reset();
            chargerFacture();
        });
    });

    function chargerFacture() {
        $.getJSON('JSON/Demande.json', function(data) {
            let html = '';
            let totalGeneral = 0;
            let count = 0;

            $.each(data, function(index, d) {
                if (d.email === emailClient && d.statut === 'accepte') {
                    let dateDep = new Date(d.debut);
                    let dateRet = new Date(d.fin);
                    let diffTime = dateRet - dateDep;

                    let msParJour = 1000 * 60 * 60 * 24;
                    let nbNuits = (diffTime / msParJour) | 0;

                    if (diffTime % msParJour > 0) {
                        nbNuits = nbNuits + 1;
                    }

                    if (nbNuits <= 0) nbNuits = 1;

                    let estUneChambre = d.id_chambre !== undefined && d.id_chambre !== null;
                    let tarifUnitaire = estUneChambre ? 50 : 40;

                    let prixLigne = d.nb_personnes * tarifUnitaire * nbNuits;
                    totalGeneral += prixLigne;
                    count++;

                    let nomObjet = estUneChambre ? `Chambre ${d.id_chambre}` : d.activite;

                    html += `
                    <tr>
                        <td><strong>${nomObjet}</strong></td>
                        <td>Du ${d.debut} au ${d.fin} (${nbNuits} n.)</td>
                        <td>${d.nb_personnes} pers.</td>
                        <td>${prixLigne} € <br><small style="color: #777;">(${tarifUnitaire}€/n)</small></td>
                    </tr>`;
                }
            });

            if (count === 0) {
                html = '<tr><td colspan="4" style="text-align: center; color: #777; font-style: italic;">Aucune activité ou chambre validée pour le moment.</td></tr>';
            }

            $('#table-facture tbody').html(html);
            $('#totalFacture').text(totalGeneral);
        });
    }
});