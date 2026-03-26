$(document).ready(function () {
    console.log("JS chargé");

    $.ajax({
        method: 'GET',
        url: 'getPlanning.php', // Appelle le PHP qui lit le JSON
        dataType: "json"
    })
        .done(function (reservations) {
            console.log("Données reçues :", reservations);

            let htmlRows = "";
            // On boucle sur le tableau de réservations
            for (let i = 0; i < reservations.length; i++) {
                htmlRows += "<tr>" +
                    "<td>" + reservations[i].nom + "</td>" +
                    "<td>" + reservations[i].prenom + "</td>" +
                    "<td>" + (reservations[i].activite_t || reservations[i].activite) + "</td>" +
                    "<td>" + (reservations[i].debut_t || reservations[i].debut) + "</td>" +
                    "<td>" + (reservations[i].fin_t || reservations[i].fin) + "</td>" +
                    "</tr>";
            }
            // On ajoute toutes les lignes d'un coup dans le tbody
            $("#corps_tableau").html(htmlRows);
        })
        .fail(function (status, error) {
            console.log("Erreur AJAX : " + error);
            $("#corps_tableau").html("<tr><td colspan='5'>Erreur de chargement</td></tr>");
        });
});