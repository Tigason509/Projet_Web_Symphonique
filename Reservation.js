$(document).ready(function() {
    console.log("JS Réservation chargé");

    // Initialisation des dates
    const today = new Date().toISOString().split("T")[0];
    if($('#debut').length > 0) {
        document.getElementById("debut").min = today;
        const debut = document.getElementById("debut");
        const fin = document.getElementById("fin");

        debut.addEventListener("change", () => { fin.min = debut.value; });
        fin.addEventListener("change", () => { debut.max = fin.value; });
    }

    initFormulaire();

    // Envoi du formulaire
    $(document).on('click', '#envoi_reservation', function(e) {
        e.preventDefault(); // Empêcher le comportement par défaut

        if (!verifierDates()) return;

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
                console.log("Réponse du serveur:", res);

                // Afficher le résultat
                const color = res.includes("Erreur") ? "text-danger" : "text-success";

                // Créer la zone de résultat si elle n'existe pas
                if ($('#resultat').length === 0) {
                    $('.reservation').append('<div id="resultat" style="margin-top: 15px; padding: 10px; border-radius: 5px;"></div>');
                }

                $('#resultat').removeClass().addClass(color).html(res);

                if (!res.includes("Erreur")) {
                    setTimeout(() => {
                        window.location.href = 'TableauActivite.php';
                    }, 1500);
                }
            },
            error: function( status, error) {
                console.error("Erreur AJAX:", error);
                alert("Erreur lors de l'envoi de la réservation.");
            }
        });
    });
});

function initFormulaire() {
    $.ajax({
        method: 'GET',
        url: 'getActivites.php',
        dataType: "json",
        success: function(activites) {
            console.log("Activités chargées:", activites);
            $("#activ").empty().append("<option value=''>Choisir une activité</option>");

            if (activites && activites.length > 0) {
                $.each(activites, function(i, act) {
                    $("#activ").append(`<option value="${act.nom}">${act.nom} (${act.capacite} places)</option>`);
                });
            } else {
                $("#activ").append("<option value=''>Aucune activité disponible</option>");
            }
        },

    });
}

function verifierDates() {
    const d = $('#debut').val();
    const f = $('#fin').val();
    if (!d || !f) {
        alert("Merci de choisir des dates.");
        return false;
    }
    if (d > f) {
        alert("La date de début doit être avant la fin.");
        return false;
    }
    return true;
}