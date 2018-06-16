{   //------------------------- NEXO BASE  --------------//
    pNexo = "nexo.php/";

    function Nexo(param, destino="#principal", metodo="GET"){
        pagina = pNexo+param; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: metodo
        }).done(function(datos){
            $(destino).html(datos);
        })    
    }

    function NexoP(param, destino="#principal"){
        Nexo("partes/"+param, destino);
    }
}
{   //------------------------- SESION ------------------//
    function Refresh_Nav(){          //Ni puta idea de para q era esto
        
        //$("#btnSesion").html("Sesion Iniciada");
        $.ajax({
            url: "partes/navMenus.php",
            method: "POST",        
            dataType: "text"
        }).done(function(dato){
            $("#nav-1").html(dato);
            //NexoP("home");
        })
    }

    function Sesion_Aceptar(){        
        var enviar = {usuario: $("#txtUsuario").val(), clave: $("#txtClave").val()}
        $.ajax({
            url: pNexo+"php/iniciarUsuario",
            //url: "php/validarUsuario.php",
            method: "POST",
            data: enviar,
            dataType: "text"                        
        }).done(function(datos){
            if(datos == "error"){
                alert("HOLA");
                $("#frmTxtUsuario").addClass("has-error");
                $("#frmTxtClave").addClass("has-error");
                $("#spanTxtClave").removeClass("hidden");            
            }
            else{
                datos = JSON.parse(datos);
                localStorage.setItem("token", datos['token']);
                $("#nav-1").html(datos['nav']);
                //Refresh_Nav();                
            }        
        })
    }

    function Prueba(){
        var miParam = "Prueba/";
        miParam += localStorage.getItem("token");
        
        
        Nexo(miParam);
    }
}