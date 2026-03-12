function getActivites() {
    console.log("getA")
    $.ajax({

        method: 'GET',
        dataType :"json",
        url : 'getActivites.php', //Script Vise
        data : {"nmax":1}
    }).done(function (activites) {
        console.log(activites);
        for(i in activites){
            $("#activ").append("<option>"+activites[i].nom+"</option>");
        }
    }).fail(function (e) {
        console.log(e)
    });
}
function verifEmail(){
    console.log()
    $.ajax({
        method:'GET'
        dataType: "json"
    })
}

