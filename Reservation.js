$.ajax({
    method: 'GET',
    dataType :json,
    url : 'Reservation.php', //Script Vise
    data : {"nom":nom}
}).done(function (activite) {
    $activite=$_GET["activite"]

});