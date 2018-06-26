window.onload = function(){    
    NexoP("navbar", "#NavbarZone");

    var miToken = localStorage.getItem("TokenRestauranteChinchilla");

    if(miToken != null){
                
    }else{
        alert("No existe el token");
    }

    PruebaToken();    
}

function PruebaToken(){    
        $.ajax({
            url: "nexo.php/PruebaToken",
            type: "GET",
            headers: localStorage.getItem("TokenRestauranteChinchilla")
        }).done(function(datos){
            $("#principal").html(datos);
        })    
}