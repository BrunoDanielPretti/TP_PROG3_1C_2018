{   //------------------------- NEXO BASE  --------------//
    pNexo = "nexo.php/";

    function Nexo(param, destino="#principal", metodo="GET"){
        pagina = pNexo+param; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: metodo
        }).done(function(datos){
            $(destino).html(datos);
            //console.log(datos);
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
                datos = JSON.parse(datos);
                localStorage.setItem("TokenRestauranteChinchilla", datos['token']);
                $("#nav-1").html(datos['nav']);
                //Refresh_Nav();
                Modal_Cerrar();                            
        }).fail(function(datos, textEstatus, elError){
            if(datos.status == 400){               
                $("#frmTxtUsuario").addClass("has-error");
                $("#frmTxtClave").addClass("has-error");
                $("#spanTxtClave").removeClass("hidden");                      
            }else{
                console.log("Error desconocido: "+datos.status+" "+elError);
            }
            
           
        }) 
    }

    function btnSesion(){
        console.log("%cbntSesion()", azul);        
        NexoP("menuSesion", "#myModal");
        Modal_Mostrar();
    }
    
}

{//---------------------------  MESAS  ---------------------------------//
    function NexoMesa(){
        console.log("%cNexoMesa()", azul);
        NexoP("Mesas_Tab", "#TabZone-1");        
        $.ajax({
            url: "Mesas",
            type: "GET"
        }).done(function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);
            tablaTodos = ""; tablaPreparacion=""; tablaCerradas=""; tablaComiendo="";
            //TablaPreparacion = "";
            console.log("datos.length: "+datos.length);

            for (let index = 0; index < datos.length; index++) {
                //console.log("index: "+index+" - "+datos[index]['string']);
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
        }
        ).fail(function(data){
            console.log(data["responseText"]);
        })    
    }

    function Tarjeta_Show(pParam){
        NexoP("menu_mesa_gestion", "#myModal");        
        Modal_Mostrar();
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

{//--------------------------  PODUCTOS  ---------------------------------//
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
            $("#Tabla_Head").html( Tabla_ArmarHead( ["Img", "Producto", "Compra", "Venta", "Tipo"] ) );             
            $("#Tabla_Body").html(StringTabla);
            //$("#TabZone-1").html("<button  class='btn btn-success' id='btnAgregar' '>Agregar</button>");                        
        })    
    }

    function Tabla_ArmarHead(pArray){
        var string = "";
        var cont = 1;
        pArray.forEach(element => {
            string = string+"<th onclick=\"w3.sortHTML('#Tabla_General','.item', 'td:nth-child("+cont+")')\">"+element+"</th>";
            cont++;
        });        
        //$("#Tabla_Head").html(string);
        return string;
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

{//--------------------------  EMPLEADOS  ---------------------------------//
    function NexoEmpleados(){
        console.log("%cNexoNexoEmpleados()", azul);        
        $.ajax({
            url: "nexo.php/Usuarios",
            type: "GET",
            dataType: "text"
        }).done(function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);                         
            //alert(datos["productos"]);            
            var StringTabla = "";                                 
            for (let index = 0; index < datos['usuarios'].length; index++){
                StringTabla = StringTabla+datos['usuarios'][index];
            }            
            Zonas_Refresh();
            $("#principal").html(datos['tabla']);            
            $("#TabZone-1").html(datos['tab']);            
            $("#Tabla_Head").html( Tabla_ArmarHead( ["Nombre", "Puesto", "Estado"] ) );
            //Tabla_ArmarHead( ["Nombre", "Puesto", "Estado"] );            
            $("#Tabla_Body").html(StringTabla);
            $("#Tabla_General").attr("style", "margin-top: 20px");
            //$("#TabZone-1").html("<button  class='btn btn-success' id='btnAgregar' '>Agregar</button>");                        
        })    
    }
    //------- Botones de tab empleados ------//
    function btn_NuevoEmpleado(){
        console.log("%cbtn_NuevoEmpleado()", azul);

        pagina = pNexo+"partes/menu_usuario"; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET"
        }).done(function(datos){
            $("#myModal").html(datos);
            $("#btn_usuario_Modificar").hide();
            $("#btn_usuario_Activar").hide();
            $("#btn_usuario_Desactivar").hide();
            $("#head_spam").html("   Nuevo Usuario");
        })            
        Modal_Mostrar();
    }    
    function btn_Empleados_Activos(){
        console.log("%cbtn_Empleados_Activos()", azul);
    }
    function btn_Empleados_Inactivos(){
        console.log("%cbtn_Empleados_Inactivos()", azul);
    }
    function btn_Empleados_Todos(){
        console.log("%cbtn_Empleados_Todos", azul);
    }
    //------ Botones de menu_usuario ---------//
    function usuario_alta(){
        console.log("%cusuario_alta()", azul);
       
        if($("#Clave_txt").val() == $("#Clave2_txt").val()){
            var enviar = {
                usuario: $("#Usuario_txt").val(),
                clave: $("#Clave_txt").val(),
                nombre: $("#Nombre_txt").val(),
                apellido: $("#Apellido_txt").val(),
                telefono: $("#Telefono_txt").val(),
                dni: $("#Dni_txt").val(),
                tipo: $("#select_puesto").val(),
                comentario: $("#Comentario_txt").val()
            }           
            $.ajax({
                url: pNexo+"AgregarUsuario",                
                method: "POST",
                data: enviar,
                dataType: "text"
            }).done(function(datos){ 
                console.log(datos);
                //datos = JSON.parse(datos);
                //console.log(datos);                
            }).fail(function(datos, textEstatus, elError){
                console.log("%cEntro al Fail", rojo);
                alert("no se pudo ingresar el usuario");
            })
            Modal_Cerrar();
        }else{
            alert("las contraseñas no coinsiden");
        }                      
    }
    function usuario_Modificar(pId){
        console.log("%cusuario_Modificar("+pId+")", azul);
        
        var enviar = {
            usuario: $("#Usuario_txt").val(),
            clave: $("#Clave_txt").val(),
            nombre: $("#Nombre_txt").val(),
            apellido: $("#Apellido_txt").val(),
            telefono: $("#Telefono_txt").val(),
            dni: $("#Dni_txt").val(),
            tipo: $("#select_puesto").val(),
            comentario: $("#Comentario_txt").val(),
            id: pId
        }           
        $.ajax({
            url: pNexo+"ModificarUsuario",                
            method: "POST",
            data: enviar,
            dataType: "text"
        }).done(function(datos){ 
            console.log(datos); 
            Modal_Cerrar();  
            NexoEmpleados();                             
        }).fail(function(datos, textEstatus, elError){
            console.log("%cEntro al Fail", rojo);
            alert("no se pudo ingresar el usuario");
        })
                             
    }

    function usuario_Desactivar(pId){
        console.log("%cusuario_Desactivar()", azul);

        pagina = pNexo+"Usuarios/desactivar/"+pId; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET",
            dataType: "text"
        }).done(function(datos){             
             console.log(datos);
             Modal_Cerrar();
             NexoEmpleados();
        })            
    }
    function usuario_Activar(pId){
        console.log("%cusuario_Activar()", azul);

        pagina = pNexo+"Usuarios/activar/"+pId; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET",
            dataType: "text"
        }).done(function(datos){             
             console.log(datos);
             Modal_Cerrar();
             NexoEmpleados();
        })            
    }

    function Usuario_MenuModificar(pId){
        console.log("%cUsuario_MenuModificar("+pId+")", azul);

        pagina = pNexo+"Usuarios/"+pId; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET",
            dataType: "text"
        }).done(function(datos){
            //console.log(datos);
            datos = JSON.parse(datos);
            var usuario = JSON.parse( datos.usuario ) ;
            usuario = usuario[0];
            $("#myModal").html(datos['menu']);                                 
            $("#head_spam").html("    "+usuario.usuario);
            $("[target='Alta']").hide();
            $("#Nombre_txt").attr("value", usuario.nombre);
            $("#Apellido_txt").attr("value", usuario.apellido);
            $("#Telefono_txt").attr("value", usuario.telefono);
            $("#Dni_txt").attr("value", usuario.DNI);
            $("#Comentario_txt").html(usuario.comentario);
            $("[target='"+usuario.tipo+"']").attr("selected", "selected");
            $("[target='"+usuario.tipo+"']").attr("style", "color: green; font-weight: bold;");
            $("#btn_usuario_Desactivar").attr("onclick", "usuario_Desactivar("+usuario.id+")");
            $("#btn_usuario_Activar").attr("onclick", "usuario_Activar("+usuario.id+")");
            $("#btn_usuario_Modificar").attr("onclick", "usuario_Modificar("+usuario.id+")");          
            Modal_Mostrar();               
        })            
    }

}

{//--------------------------  Pedidos  ---------------------------------//
    function Menu_Pedido(){
        console.log("%cMenu_Pedido()", azul);
        $.ajax({
            url: "MenuPedidos",
            type: "GET"
        }).done(function(datos){            
            datos = JSON.parse(datos);        

            $("#myModal").html(datos.menu);
            $("#myModal2").html(datos.tabla);            
            $("#myModal2").find("#Tabla_Body").html(datos.productos);            
            $("#myModal2").find("#Tabla_Head").html( Tabla_ArmarHead( ["Img", "Nombre", "Tipo", "Precio"] ) );
          
            $("#btn_Agregar_Producto").click(function(){ $("#myModal2").attr("style", "display: block");}); 

            datos.mesas.forEach(key => {
                if(key.estado == 0){
                    $("#select_mesa").append("<option>"+key.id+"</option>");
                    console.log(key.id);
                }                
            });
            $("#select_mesa").change(function(){
                $("#head_spam").html("Mesa: " + $("#select_mesa").val() );
                //console.log("event Handler");
            })
            Modal_Mostrar();        
        }
        ).fail(function(data){
            console.log(data["responseText"]);
        }) 
    }

    function Agregar_Producto_Al_Pedido(pId){
        console.log("%cAgregar_Producto_Al_Pedido("+pId+")", azul);
        
        pagina = pNexo+"ProductoPedido/"+pId; // "nexo.php/partes/menuSesion"
        $.ajax({
            url: pagina,
            type: "GET",
            dataType: "text"
        }).done(function(datos){
            console.log(datos);
            $("#Tabla_Pedido_Body").append(datos);
            $("#myModal2").attr("style", "display: none");
            $("#Tabla_Pedido_Head").html( Tabla_ArmarHead( ["Img", "nombre","Tipo", "Precio", "Total"] ) );
            $("#Tabla_Pedido_Head").append("<th colspan='4' >Cantidad</th>");
            $("[class='td-btn']").unbind("click");
            $("[class='td-btn']").click( MenuPedido_Aumentar_Disminuir );
            MenuPedido_Actualizar_Precio();
        })                     
    }

    function MenuPedido_Actualizar_Precio(){        
        console.log("%cMenuPedido_Actualizar_Precio()", azul);
        total = 0;
        $("[name='Precio_Venta']").each(function(key){
            total = total + parseInt( $(this).text() );
        });
        console.log("total: "+total);
        $("#Labet_Total").html("$"+total);        
    }

    function MenuPedido_Aumentar_Disminuir(){        
        console.log("%cMenuPedido_Aumentar_Disminuir()", azul);
        TagUnidad =  $(this).parent().find("[name='Precio_Unidad']");
        TagVenta  =  $(this).parent().find("[name='Precio_Venta']");
        TagCantidad = cant = $(this).parent().find("[name='txt_cant']");
        Precio_Unidad = parseInt( TagUnidad.html() );
        Precio_venta  = parseInt( TagVenta.html() );

        switch ( $(this).attr("name") ) {
            case "btn_Aumentar":
                console.log("Aumentar "+Precio_Unidad);
                TagVenta.html( Precio_venta + Precio_Unidad);                
                TagCantidad.val( parseInt( TagCantidad.val() ) +1 );              
                break;
            case "btn_Disminuir":
                console.log("Disminuir "+Precio_Unidad);                
                TagVenta.html( Precio_venta - Precio_Unidad);               
                TagCantidad.val( parseInt( TagCantidad.val() ) -1 );
                if(TagCantidad.val() <= 0)
                    $(this).parent().remove();
                break;
            case "btn_Eliminar":             
                $(this).parent().remove();                
                break;        
            default:
                break;            
        }
        MenuPedido_Actualizar_Precio();
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
    }

    

    function Prueba__menu_usuario(){ 
        console.log("%cPrueba__menu_usuario()",verde);              
        NexoP("menu_usuario", "#myModal");
        Modal_Mostrar();
    }
   
    function borrarToken(){
        console.log("%cToken Borrado", verde);
        localStorage.setItem("TokenRestauranteChinchilla", undefined);
    }

    function asd(){
        alert("ola q ase");
        console.log("%cOla q ase consola", rojo);
    }

    
}


$(document).ready(function(){

    console.log("Inicio script.js");

    window.onclick = function(event) {
        var modal = document.getElementById('myModal');
        var modal2 = document.getElementById('myModal2');

        if (event.target == modal) {
            Modal_Cerrar();
        }
        if (event.target == modal2) {                      
            $("#myModal2").attr("style", "display: none");
        }       
    }    
});

