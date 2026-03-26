let isAdmin = false;

$(document).ready(function() {
    // Gestion de la connexion
    $('#btn_connexion_admin').on('click', function() {
        const mail = $('#admin_email_input').val();
        if (mail === "emailadmin@gmail.com") {
            isAdmin = true;
            alert("Mode administrateur activé");
            $('#admin_zone').hide(); // On cache le formulaire de connexion
            init(); // On recharge le tableau pour afficher les boutons
        } else {
            alert("Accès refusé");
        }
    });


    $(document).on('click', '.btn-supprimer', function() {
        const index = $(this).data('index');
        if (confirm("Supprimer cette réservation ?")) {
            supprimerReservation(index);
        }
    });
});

function init() {
    $.ajax({
        url: 'getReservations.php',
        method: 'GET',
        dataType: 'json'
    }).done(function(reserv) {
        $("#corps_tableau").empty();

        reserv.forEach((res, index) => {
            let boutonSuppr = "";
            // SI ADMIN : On ajoute le bouton
            if (isAdmin) {
                boutonSuppr = `<td><button class="btn-supprimer" data-index="${index}" style="background: #e74c3c; color: white; padding: 5px 10px;">Supprimer</button></td>`;
            }

            $("#corps_tableau").append(`
                <tr>
                    <td>${res.nom}</td>
                    <td>${res.prenom}</td>
                    <td>${res.activite}</td>
                    <td>${res.debut}</td>
                    <td>${res.fin}</td>
                    ${boutonSuppr}
                </tr>
            `);
        });
    });
}

function supprimerReservation(index) {
    $.ajax({
        url: 'SupprimerReservation.php',
        type: 'POST',
        data: { index: index, admin_email: "emailadmin@gmail.com" },
        success: function(res) {
            alert(res);
            init();
        }
    });
}