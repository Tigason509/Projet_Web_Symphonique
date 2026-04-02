$(document).ready(function() {
    console.log("Système de réservation de chambre prêt.");

    const today = new Date().toISOString().split("T")[0];
    if($('#debut').length > 0) {
        const inputDebut = document.getElementById("debut");
        const inputFin = document.getElementById("fin");

        inputDebut.min = today;
        inputDebut.addEventListener("change", () => { inputFin.min = inputDebut.value; });
        inputFin.addEventListener("change", () => { inputDebut.max = inputFin.value; });
    }

    // Clic sur le bouton d'envoi
    $(document).on('click', '#envoi_reservation', function(e) {
        e.preventDefault();

        // Vérification locale des dates
        if (!verifierDatesLogique()) return;

        // Préparation des données
        const formData = {
            nom: $('#nom').val(),
            prenom: $('#prenom').val(),
            email: $('#email').val(),
            nb_personnes: $('#nb_personnes').val(),
            debut: $('#debut').val(),
            fin: $('#fin').val(),
            chambre: $('#chambre').val()
        };

        // Envoi via AJAX
        $.ajax({
            url: 'Demande.php',
            type: 'POST',
            data: formData,
            success: function(reponse) {
                console.log("Serveur dit :", reponse);

                // Déterminer la couleur (Erreur = Rouge, Succès = Vert)
                const estErreur = reponse.includes("Erreur");
                const maCouleur = estErreur ? "#d9534f" : "#5cb85c";

                // Mise à jour de la div résultat
                $('#resultat')
                    .css({
                        "background-color": maCouleur,
                        "color": "white",
                        "padding": "10px",
                        "border-radius": "4px",
                        "display": "block"
                    })
                    .html(reponse);

                // Si c'est un succès, on vide les champs après 2 secondes
                if (!estErreur) {
                    setTimeout(() => {
                        $('.reservation input').val('');
                        $('#resultat').fadeOut();
                    }, 2000);
                }
            },
            error: function() {
                alert("Erreur réseau : Impossible de joindre le serveur.");
            }
        });
    });
});

function verifierDatesLogique() {
    const d = $('#debut').val();
    const f = $('#fin').val();
    if (!d || !f) {
        alert("Veuillez renseigner les dates de séjour.");
        return false;
    }
    if (d > f) {
        alert("La date de début ne peut pas être après la fin !");
        return false;
    }
    return true;
}