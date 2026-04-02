$(document).ready(function() {
    $(document).on('click', 'button[type="submit"]', function(e) {
        e.preventDefault(); // Ne pas recharger inutilement

        const data = {
            nom: $('#nom').val(),
            prenom: $('#prenom').val(),
            email: $('#email').val(),
            mdp: $('#mdp').val()
        };

        $.ajax({
            url: 'Inscription.php',
            type: 'POST',
            data: data,
            success: function(res) {
                console.log("Réponse du serveur:", res);

                const msg = $('#message');
                msg.text(res.message);
                msg.css('color', res.success ? "green" : "red");

                if (res.success) {
                    $('#signupForm')[0].reset();
                }
            },
            error: function(status, error) {
                console.error("Erreur AJAX:", error);
                $('#message').text("Erreur de connexion au serveur.").css('color', 'red');
            }
        });
    });
});