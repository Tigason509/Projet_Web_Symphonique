<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <link rel="stylesheet" href="/css/Reservation.css">
    <script src="Reservation.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="init()">

<section id="reclamation" class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 style="font-family: 'Georgia', serif; color: #b89241;">Explorer notre grand catalogue de Sejour ?</h2>
                <p class="text-muted">Nous avons un grand panel d'activité à vous proposer n'hésitez à découvrir de nouvelles activités</p>
                <div class="p-3 border-start border-4" style="border-color: #b89241 !important; background: #f9f9f9;">
                    <small>Demandes </small>
                </div>
            </div>
            <div class="reservation">
                <p>Reserver ici</p>
                <select id="reserv">
                    <p>Votre nom</p>
                    <input class="form-control" id="nom">
                    <p>Votre prénom</p>
                    <input class="form-control" id="prenom">
                    <p>Vous etes combien de personnes à réserver ?</p>
                    <input class="form-control" id="Reservation_n_personnes_Input" placeholder="0">
                    <p>à partir de quand ?</p>
                    <input type="date" id="debut" name="debut">
                    <p>Jusqu'à quand ?</p>
                    <input type="date" id="fin" name="fin">
                    <button type="submit" id="envoi_reserv">Reserver !</button>
            </div>
            <h3>
                Activité
            </h3>
            <input type="email" class="form-control" id="Reservation_emailInput" placeholder="nom@exemple.com">
            <select id="activ">
            </select>
            </div>
        </div>
        <button type="button" id="envoi_reservation" >Envoyer</button>
    </div>
</section>

</body>
</html>