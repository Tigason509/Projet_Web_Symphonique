$(document).ready(function() {

    console.log("JS chargé");

    // INIT fonction globale pour l'initialisation
    init();

    // CLICK bouton
    $(document).on('click', '#envoi_reservation', function() {

        console.log("CLICK OK");

        const data = {
            nom: $('#nom').val(),
            prenom: $('#prenom').val(),
            email: $('#email').val(),
            nb_personnes: $('#nb_personnes').val(),
            debut: $('#debut').val(),
            fin: $('#fin').val(),
            activite: $('#activ').val()
        };

        $.ajax({
            url: 'Reservation.php',
            type: 'POST',
            data: data,

            success: function(res) {
                console.log("REPONSE :", res);
                $('#resultat').html(res);
            },

            error: function() {
                console.log("ERREUR AJAX");
                $('#resultat').html("Erreur serveur");
            }
        });
    });

});

const debut = document.getElementById("debut");
const fin = document.getElementById("fin");

debut.addEventListener("change", () => {
    fin.min = debut.value;
});

fin.addEventListener("change", () => {
    debut.max = fin.value;
});

function verifierDates() {
    const debut = document.getElementById("debut").value;
    const fin = document.getElementById("fin").value;

    if (debut && fin && debut > fin) {
        alert("La date de début doit être antérieure à la date de fin.");
        return false;
    }
    return true;
}

// INIT
function init() {

    console.log("Chargement données...");

    $.ajax({
        method: 'GET',
        dataType: "json",
        url: 'getActivites.php',
        data: { "nmax": 2 }

    }).done(function (activites) {

        console.log("ACTIVITES :", activites);

        for (let i = 0; i < activites.length; i++) {
            $("#activ").append("<option>" + activites[i].nom + "</option>");
        }

    }).fail(function (e) {
        console.log("Erreur activites :", e);
    });



    $.ajax({
        method: 'GET',
        dataType: "json",
        url: 'getReservations.php',
        data: { "nmax": 100 }

    }).done(function (reserv) {

        console.log("RESERV :", reserv);

        for (let i = 0; i < reserv.length; i++) {
            $("#reserv").append("<option>" + reserv[i].nom + "</option>");
        }

    }).fail(function (e) {
        console.log("Erreur reservations :", e);
    });
}
