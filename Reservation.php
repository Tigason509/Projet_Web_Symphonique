<?php
     $file='Activite.json' ;
     $donnes=json_decode(file_get_contents($file),true);
     $activites =$donnes[0] ;# récupération des donnes
     var_dump( $donnes ); #affichage des données présentes dans le fichier JSON
?>

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
            <h3>
                Activité
            </h3>
            <input type="email" class="form-control" id="Reservation_emailInput" placeholder="nom@exemple.com">
            </div>
        </div>
    </div>
</section>