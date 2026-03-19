function Connection() {
    //  Champs du formulaire.
    const donnees = {
        email: $('#email').val(),
        mdp: $('#password').val()
    };


    $.ajax({
        url: 'Connexion.php',
        type: 'POST',
        data: donnees,
        success: function(reponse) {
            // On affiche la réponse
            $('#resultat').html(reponse);


            if (reponse.includes("réussie")) {
                window.location.href='index.php'
            }
        },
        error: function() {
            $('#resultat').html("Erreur lors de la communication avec le serveur.");
        }
    });
}

