window.onload = function(){    
 
    var miToken = localStorage.getItem("TokenRestauranteChinchilla");

    if(miToken != undefined){                
        Token_EnviarParaNavMenu();
        console.log("inicio.js: se ENVIO el Token");

    }else{
        $("#principal").html("No existe el token");
        console.log("inicio.js: No Existe el Token")
        NexoP("navbar", "#NavbarZone");
    }

    
    //PruebaToken();    
}



function Token_EnviarParaNavMenu(){
    var miToken = localStorage.getItem("TokenRestauranteChinchilla");
    $.ajax({
        url: "nexo.php/ValidarToken",
        type: "GET",
        headers: {"token" :miToken}
    }).done(function(datos){
        datos = JSON.parse(datos);
        if(datos['error'] == "Expiro"){              
            $("#NavbarZone").html(datos['base'])           
            //$("#principal").html(datos['error']);
            $("#principal").html("Expiro el Token");
        }else{           
            $("#NavbarZone").html(datos['base'])                    
            $("#nav-1").html(datos['contenido']);
            
        }
        
    })    
}









//-----------------------------------------------
function PruebaToken(){
    var miToken = localStorage.getItem("TokenRestauranteChinchilla");
    $.ajax({
        url: "nexo.php/ValidarToken",
        type: "GET",
        headers: {"token" :miToken}
    }).done(function(datos){
        $("#principal").html(datos);
    })    
}