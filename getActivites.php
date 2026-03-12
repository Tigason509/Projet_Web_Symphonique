<?php
$file='JSON/Activite.json' ;
$donnes=json_decode(file_get_contents($file),true);
// ici filtrer si besoin
$donnes = array_slice($donnes, 0, $_GET['nmax']) ;
echo json_encode($donnes);
//var_dump( $donnes ); #affichage des données présentes dans le fichier JSON
?><?php
