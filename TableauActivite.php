<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $file='JSON/Reservation.json';
    $file2='JSON/Activite.json';
    $file_activite=json_decode(file_get_contents($file2),true);
    $n=$_POST['nb_personnes'];
    $capacite=$_POST['capacite'];
    if ( $n<$capacite){
        echo("Activite complète") ;
        exit();
    }
    else{
        $capacite=$capacite-$n;
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Tableau des activités</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="TableauActivite.js"></script>
</head>
<body>
<h1>Liste des réservations</h1>
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
    </tbody>
</table>
</body>
</html>