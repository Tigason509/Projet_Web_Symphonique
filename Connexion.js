$('#connexion').on('submit', function(e) {
    e.preventDefault();
    Connection();
});

function Connection() {

    const donnees = {
        email: $('#email').val(),
        mdp: $('#password').val()
    };

    $.ajax({
        url: 'Connexion.php',
        type: 'POST',
        data: donnees,

        success: function(reponse) {

            $('#resultat').html(reponse);

            if (reponse.includes("réussie")) {
                window.location = 'index.php';
            }
        },

        error: function() {
            $('#resultat').html("Erreur serveur.");
        }
    });
}