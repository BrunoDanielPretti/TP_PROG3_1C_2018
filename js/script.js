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
        if(destino != "#myModal"){
            Zonas_Refresh();
        }
        Nexo("partes/"+param, destino);        
    }

    function Zonas_Refresh(){
        $("#TabZone-1").html("");
        $("#TabZone-2").html("");
        $("#principal").html("");
    }

    function Modal_Mostrar(){               
        $("#myModal").attr("style", "display: block");
    }

    function Modal_Cerrar(){
        console.log("Modal_Cerrar()");
        $("#myModal").html("");             
        $("#myModal").attr("style", "display: none");
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
                localStorage.setItem("TokenRestauranteChinchilla", datos['token']);
                $("#nav-1").html(datos['nav']);
                //Refresh_Nav();
                Modal_Cerrar();                
            }        
        })
    }

    function btnSesion(){
        console.log("%cbntSesion()", azul);        
        NexoP("menuSesion", "#myModal");
        Modal_Mostrar();
    }
    
}

{//------------------------  MESAS  ---------------------------------//
    function NexoMesa(){
        console.log("%cNexoMesa()", azul);
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

    function Tarjeta_Show(pParam){
        var target = $("[target='"+pParam+"']");
        if(target.attr("style") == "display: none;"){
            $(".panel-footer").hide();                        
            //target.show();            
            target.slideDown("fast");            
        }else{
            //target.hide();            
            target.slideUp("fast");
        }                            
    }
}

{//-------------------------- coso de los paises-----------------------------------//
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

{//------------------------  PODUCTOS  ---------------------------------//
    function NexoProductos(){
        console.log("%cNexoProductios()", azul);        
        $.ajax({
            url: "nexo.php/Productos",
            type: "GET",
            dataType: "text"
        }).done(function(datos){
            datos = JSON.parse(datos);                         
            //alert(datos["productos"]);
            
            var StringTabla = "";            
                     
            for (let index = 0; index < datos['productos'].length; index++){
                StringTabla = StringTabla+datos['productos'][index];
            }
            Zonas_Refresh();
            $("#principal").html(datos['tabla']);            
            Tabla_ArmarHead( ["Img", "Producto", "Compra", "Venta", "Tipo"] );            
            $("#Tabla_Body").html(StringTabla);
            $("#TabZone-1").html("<button  class='btn btn-success' id='btnAgregar' '>Agregar</button>");
            
            
        })    
    }

    function Tabla_ArmarHead(pArray){
        var string = "";
        var cont = 1;
        pArray.forEach(element => {
            string = string+"<th onclick=\"w3.sortHTML('#Tabla_General','.item', 'td:nth-child("+cont+")')\">"+element+"</th>";
            cont++;
        });        
        $("#Tabla_Head").html(string);
    }

    function MenuProducto(pId){
        console.log("%cMenuProducto("+pId+")",azul);
        //NexoP("menu_producto", "#myModal");

        pagina = pNexo+"Productos/"+pId; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET",
            dataType: "text"
        }).done(function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);
            var producto = JSON.parse( datos.producto ) ;
            producto = producto[0];
            $("#myModal").html(datos['menu']);                       
            $("#head_spam").html("    "+producto.nombre);
            $("#head_icon").attr("src", "./resources/IconsL2/"+producto.foto+".jpg")
            $("#txtNombre").attr("value", producto.nombre);
            $("#txtCompra").attr("value", producto.precioVenta);
            $("[target='"+producto.tipo+"']").attr("selected", "selected")
            $("#btn_MenuProducto_Aceptar").attr("onclick", "ModificarProducto('"+ producto.id +"')")
            
            Modal_Mostrar();
            
            //console.log(producto.foto);            
        })            
    }

    function ModificarProducto(pId){
        console.log("%cModificarProducto("+pId+")" ,azul);         
        
        var enviar = {
            Nombre: $("#txtNombre").val(),
            Precio: $("#txtCompra").val(),
            Tipo:   $("#select_tipo").val(),
            Id: pId    
        };
        //console.log(enviar, verde);
        $.ajax({
            url: pNexo+"Productos/Modificar",            
            method: "POST",
            data: enviar,
            dataType: "text"                        
        }).done(function(datos){
            console.log(datos);
            datos = JSON.parse(datos);
            Modal_Cerrar();
            NexoProductos();
            //console.log(datos["Nombre"]);
        }) 
             
    }
}

{//---------------------- DEBUG --------------------------------------//
    //---------------------------colores-----------------------
    var verde = "color: greenyellow";
    var rojo  = "color: #fc504a";
    var azul  = "color: rgb(66, 199, 252)";
    var gris  = "color: #cccccc";
    // console.log("%c()", azul);
    //---------------------------------------------------------
    function btnAdmin(){
        console.log("%cbtnAdmin()", azul);        
        $("#txtUsuario").attr("value", "admin");
        $("#txtClave").attr("value", "admin");
        //$("#txtUsuario").attr("placeholder", "admin");
        //$("#txtClave").attr("placeholder", "admin");        
    }
                    
    function Prueba(){ 
        console.log("%cPrueba",verde);              
        NexoP("menu_producto", "#myModal");
        Modal_Mostrar();
    }
   
    function borrarToken(){
        console.log("%cToken Borrado", verde);
        localStorage.setItem("TokenRestauranteChinchilla", undefined);
    }



    
}


$(document).ready(function(){

    console.log("Inicio la pagina!!");

    window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        if (event.target == modal) {
            Modal_Cerrar();
        }
    } 
   

});

