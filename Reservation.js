// Toutes les fonctions d'initialisation
function init() {
    console.log("getA")
    $.ajax({

        method: 'GET',
        dataType :"json",
        url : 'getActivites.php', //Script Vise
        data : {"nmax":2}
    }).done(function (activites) {
        console.log(activites);
        for(i in activites){
            $("#activ").append("<option>"+activites[i].nom+"</option>");
        }
    }).fail(function (e) {
        console.log(e)
    });

    console.log("getA")
    $.ajax({

        method: 'GET',
        dataType :"json",
        url : 'getReservations.php', //Script Vise
        data : {"nmax":100}
    }).done(function (reserv) {
        console.log(reserv);
        for(i in reserv){
            $("#reserv").append("<option>"+reserv[i].nom+"</option>");
        }
    }).fail(function (e) {
        console.log(e)
    });

    console.log()
    $.ajax({
        method:'GET',
        dataType: "json"
    })
}

