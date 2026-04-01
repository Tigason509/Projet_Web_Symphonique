<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Tableau des activités</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="TableauActivite.js"></script>
    <link rel="stylesheet" href="/css/TableauReservation.css">
</head>
<body>
<h1>Liste des réservations</h1>

<div id="admin_zone" style="background: #252525; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #b89241;">
    <p style="margin: 0 0 10px 0; color: #d4af37;">Accès Administrateur</p>
    <input type="email" id="admin_email_input" placeholder="Email admin" style="width: auto; margin: 0;">
    <input type="password" id="admin_mdp_input" placeholder="Mot de passe associé" style="width : auto; margin: 0;" >
    <button id="btn_connexion_admin" style="width: auto; margin-left: 10px;">Se connecter</button>
</div>

<table border="1">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Activité</th>
        <th>Début</th>
        <th>Fin</th>
    </tr>
    </thead>
    <tbody id="corps_tableau">
    <tr>
        <td colspan="5" style="text-align: center;">Chargement des données...</td>
    </tr>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <a href="Reservation.php" style="padding: 10px 20px; background: #b89241; color: white; text-decoration: none; border-radius: 5px;">Nouvelle réservation</a>
</div>

</body>
</html>