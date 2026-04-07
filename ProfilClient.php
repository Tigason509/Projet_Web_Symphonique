<?php
session_start();
if (!isset($_SESSION['email'])) { header("Location: Connexion.php"); exit(); }

$options = "";
$file_act = 'JSON/Activite.json';
if(file_exists($file_act)){
    $acts = json_decode(file_get_contents($file_act), true);
    foreach($acts as $a) {
        $options .= "<option value='{$a['id']}'>{$a['nom']}</option>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="ProfilClient.js"></script>
</head>
<body class="bg-light">

<div class="container py-5">
    <h2>Bienvenue, <span id="clientEmail"><?= $_SESSION['email'] ?></span></h2>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white">Réserver une activité</div>
        <div class="card-body">
            <form id="formResa">
                <div class="row">
                    <div class="col-md-3">
                        <label>Activité</label>
                        <select name="id_act" class="form-select" required>
                            <?= $options ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Personnes</label>
                        <input type="number" name="nb_personnes" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="col-md-3">
                        <label>Début</label>
                        <input type="date" name="debut" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label>Fin</label>
                        <input type="date" name="fin" class="form-control" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Go</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Ma Facture (Activités validées)</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="table-facture">
                <thead>
                <tr>
                    <th>Activité</th>
                    <th>Dates</th>
                    <th>Voyageurs</th>
                    <th>Montant</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="card-footer text-end">
            <strong>Total à régler : <span id="totalFacture">0</span> €</strong>
        </div>
    </div>
</div>

</body>
</html>