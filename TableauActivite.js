let isAdmin = false;
//Inspiré de Reservation.js dans le fonctionnement
$(document).ready(function() {
    console.log("JS Tableau chargé");
    initTableau();

    $(document).on('click', '#btn_connexion_admin', function() {
        const mail = $('#admin_email_input').val();
        const mot_de_passe=$('#admin_mdp_input').val() ;
        if (mail === "emailadmin@gmail.com" && mot_de_passe==="motdepasse") {
            isAdmin = true;
            $('#admin_zone').html('<div class="alert alert-success m-0">Accès Admin Accordé</div>');

            setTimeout(function() {
                initTableau();
            }, 500);
        } else {
            alert("Email incorrect.");
        }
    });

    $(document).on('click', '.btn-supprimer', function() {
        const index = $(this).data('index');
        if (confirm("Supprimer définitivement cette réservation ?")) {
            $.ajax({
                url: 'SupprimerReservation.php',
                type: 'POST',
                data: {
                    index: index,
                    admin_email: "emailadmin@gmail.com"
                },
                success: function(res) {
                    alert(res);
                    initTableau();
                },
                error: function() {
                    alert("Erreur lors de la suppression");
                }
            });
        }
    });
});

function initTableau() {
    $.ajax({
        method: 'GET',
        url: 'getReservations.php',
        dataType: "json",
        success: function(reserv) {
            console.log("Réservations chargées:", reserv);
            const corps = $("#corps_tableau");
            corps.empty(); // S'assurer que des informations ne soient pas stockés en double

            if (reserv && reserv.length > 0) {
                $.each(reserv, function(index, res) {
                    let boutonSuppr = "";
                    if (isAdmin) {
                        boutonSuppr = `<td><button class="btn btn-danger btn-sm btn-supprimer" data-index="${index}">Supprimer</button></td>`;
                    }

                    corps.append(`
                        <tr>
                            <td>${res.nom}</td>
                            <td>${res.prenom}</td>
                            <td>${res.activite}</td>
                            <td>${res.debut}</td>
                            <td>${res.fin}</td>
                            ${boutonSuppr} // Bouton présent que si l'ultisateur est un admin
                        </tr>
                    `);
                });
            } else {
                const colspan = isAdmin ? 6 : 5;
                corps.append(`<tr><td colspan="${colspan}" style="text-align: center;">Aucune réservation trouvée</td></tr>`);
            }
        },
        error: function(status, error) {
            console.error("Erreur chargement:", error);
            $("#corps_tableau").html("<tr><td colspan='5' style='text-align: center; color: red;'>Erreur de chargement des données.</td></tr>");
        }
    });
}