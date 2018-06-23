window.onload = function(){
    NexoP("navbar", "#NavbarZone");

    var miToken = localStorage.getItem("TokenRestauranteChinchilla");;

    if(miToken != null){
                
    }else{
        alert("No existe el token");
    }
}