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
        $("#TabZone-1").html("");
        $("#TabZone-2").html("");
        $("#principal").html("");
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

{//---------------------- DEBUG --------------------------------------//
    function btnAdmin(){        
        $("#txtUsuario").attr("value", "admin");
        $("#txtClave").attr("value", "admin");
        //$("#txtUsuario").attr("placeholder", "admin");
        //$("#txtClave").attr("placeholder", "admin");        
    }

    function NexoMesa(){
        NexoP("Mesas_Tab", "#TabZone-1");        
        $.ajax({
            url: "Mesas",
            type: "GET"
        }).done(function(datos){
            datos = JSON.parse(datos);
            tablaTodos = ""; tablaPreparacion=""; tablaCerradas=""; tablaComiendo="";
            //TablaPreparacion = "";

            for (let index = 0; index < datos.length; index++) {
                tablaTodos = tablaTodos+datos[index]['string'];
                
                switch (datos[index]['estado']) {
                    case 0:
                    tablaCerradas = tablaCerradas+datos[index]['string'];
                        break;    
                    case 1:
                        tablaPreparacion = tablaPreparacion+datos[index]['string'];
                        break; 
                    case 2:
                        tablaComiendo    = tablaComiendo+datos[index]['string'];
                        break;
                }
                            
            }
            $("#HTML_Mesas_Todas").html(tablaTodos);
            $("#HTML_Mesas_EnPreparacion").html(tablaPreparacion);
            $("#HTML_Mesas_Cerradas").html(tablaCerradas);
            $("#HTML_Mesas_Comiendo").html(tablaComiendo);

            openCity(event, 'Mesas_Todas');
        })    
    }

}

{//-------------------------------------------------------------------//
    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;
    
        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
    
        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
    
        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    } 
}
