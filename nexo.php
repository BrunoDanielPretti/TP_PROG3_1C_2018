<?php
//---------------------------------  Configuracion  -------------------------------------------//
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    date_default_timezone_set('America/Argentina/Buenos_Aires');

    require 'vendor/autoload.php';
    require 'php/clases/AutentificadorJWT.php';
    require 'php/clases/AccesoDatos.php';
    require 'php/clases/Usuario.php';
    require 'php/clases/Mesa.php';
    require 'php/clases/Producto.php';
    require 'partes/Manejo_Nav_Menu.php';

    
    //\slim\Slim::registerAutoloader();
    //$app = new \Slim\App();

    $config['displayErrorDetails'] = false;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);


    $app->get('/', function(){
        echo "hola world, por GET";
    });
//---------------------------------  Partes  --------------------------------------------------//
    $app->get('/partes/{pParte}', function(Request $request, Response $response, $args){
        $p = $args['pParte'];
        include("partes/$p.php");
    });


//---------------------------------  TOKENS  --------------------------------------------------//
    $app->get('/getNewToken', function(){
        $datos = array('juan' => 'rogelio','apellido' => 'peres', 'edad' => 33);    
        $token = AutentificadorJWT::CrearToken($datos);

        //var_dump($token);
        echo $token;
    });

    $app->get('/ValidarTokenPRUEBA', function (Request $request, Response $response) {        
        //$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJQVQiOjE0OTc1Nzk2OTcsIkVYUCI6MTQ5NzU3OTc1NywiREFUQSI6eyJqdWFuIjoicm9nZWxpbyIsImFwZWxsaWRvIjoicGVyZXMiLCJlZGFkIjozM30sIkFQUCI6ImFwaXJlc3QgSldUIn0.qZ4qjHJKHouScHhUDyt_uS7KX7aJSS2HszW2smM8nfY";
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJJQVQiOjE1Mjg3NTc4ODIsIkVYUCI6MTUyODc1Nzk0MiwiREFUQSI6eyJqdWFuIjoicm9nZWxpbyIsImFwZWxsaWRvIjoicGVyZXMiLCJlZGFkIjozM30sIkFQUCI6ImFwaXJlc3QgSldUIn0.yLkJg9o63n8OjA1jJEI_rwUba0Mr0mrRTlKzwcNBWiw";
        try{
            AutentificadorJWT::VirificarToken($token);
            return "valido";
        }
        catch(Exception  $e){
            return $e->getMessage();
        }
        
        
        //$newResponse = $response->withJson($decod, 200);     
        //return $newResponse;
        //AutentificadorJWT::VirificarToken($token);
        //var_dump($decod);
    });

    $app->get('/ValidarToken', function (Request $request, Response $response) {        
        $miToken = $request->getHeader("token");
        $miToken = $miToken[0];
        $BaseDelNavMenu   = MANEJO_NAV_MENU("cerrar");
        //$variableDeCoso = include("partes/navbar.php");
        try{
            AutentificadorJWT::VirificarToken($miToken);
            
            $Decodigicado = AutentificadorJWT::DecodificarToken($miToken);
            $BaseDelNavMenu   = MANEJO_NAV_MENU("cerrar");
            $ContenidoDelMenu = MANEJO_NAV_MENU($Decodigicado->DATA->tipo, $Decodigicado->DATA->usuario);
            
            $envio = array('base'=>$BaseDelNavMenu, 'contenido'=>$ContenidoDelMenu);
            echo json_encode($envio);
        }
        catch(Exception  $e){
            $envio = array('base'=>$BaseDelNavMenu, "error"=>$e->getMessage() );
            echo json_encode($envio);
        }     
    });
    
    $app->get('/PruebaToken', function (Request $request, Response $response) {        
        $miToken = $request->getHeader("token");
        $Decodigicado = AutentificadorJWT::DecodificarToken($miToken[0]);
        echo json_encode($Decodigicado);
        echo "<br><br>IA: ".$Decodigicado->IAT;
        echo "<br><br>Data: ".$Decodigicado->DATA->usuario;
    });


//---------------------------------  USUARIO --------------------------------------------------//

    $app->post('/php/iniciarUsuario', function(Request $request, Response $response){
        $ArrayDeParametros = $request->getParsedBody();
        $usuario = $ArrayDeParametros['usuario'];
        $clave   = $ArrayDeParametros['clave'];

        $resultado = Usuario::BuscarPorSesion($usuario, $clave);        
        
        if($resultado != false){
            $resultado = $resultado[0];
            $resultado->Sesion_log_date();
            $datos= array('usuario' => $usuario, 'clave' => $clave, 'tipo' => $resultado->tipo);
            $token = AutentificadorJWT::CrearToken($datos);

            $navMenu = MANEJO_NAV_MENU($resultado->tipo, $usuario);
            
            $envio = array('token' => $token, 'nav' => $navMenu);
            echo json_encode($envio);
        }else{
            return $response->withStatus(400); //400 Bad Request
        }
        
    });

    $app->get('/Usuarios[/]', function(Request $request, Response $response){                
        $resultado = Usuario::TraerTodosLosUsuarios();              
        if($resultado != false){
            $HTML_Datos = Usuario::UsuariosTablaHTML($resultado);
            $HTML_Tabla = file_get_contents('partes/TablaUsuarios.php',TRUE);
            $HTML_Tab =   file_get_contents('partes/empleados_tab.php',TRUE);
            $envio = array('tabla'=>$HTML_Tabla, 'usuarios'=>$HTML_Datos, 'tab'=>$HTML_Tab);
            
            echo json_encode($envio);                       
        }else{
            echo "error";
        }           
    });

    $app->post('/AgregarUsuario', function(Request $request, Response $response){          
        $parametros = $request->getParsedBody();        
        echo Usuario::AgregarUsuario($parametros);                      
        //return $response->withJson("error", 406);
    });
    $app->post('/ModificarUsuario', function(Request $request, Response $response){          
        $parametros = $request->getParsedBody();        
        echo Usuario::ModificarUsuario($parametros);                              
    });

    $app->get('/Usuarios/{id}', function (Request $request, Response $response, $args) {        
        $pID = $args['id'];
        $resultado = Usuario::TraerUsuarioPorID($pID);

        if($resultado != false){
            $HTML_Menu = file_get_contents('partes/menu_usuario.php',TRUE);
            $Usuario  = $resultado;
            $envio = array('menu'=>$HTML_Menu, 'usuario'=>$Usuario);
            echo json_encode($envio);
        }else{
            echo "ERROR";
        }
    });

    $app->get('/Usuarios/desactivar/{id}', function (Request $request, Response $response, $args) {        
        $pID = $args['id'];
        echo Usuario::DesactivarUsuario($pID)." Desactivado"." $pID"." ".$args['id'];   
    });
    $app->get('/Usuarios/activar/{id}', function (Request $request, Response $response, $args) {        
        $pID = $args['id'];
        echo $args."\n";
        echo Usuario::ActivarUsuario($pID)." activado"." $pID"." ".$args['id'];           
    });

//---------------------------------  PRODUCTOS --------------------------------------------------//
    $app->get('/Productos[/]', function(Request $request, Response $response){                
        $resultado = Producto::TraerTodosLosProductos();              
        if($resultado != false){
            $HTML_Productos = Producto::ProductosHTML($resultado);
            $HTML_Tabla = file_get_contents('partes/TablaUsuarios.php',TRUE);           
            $envio = array('tabla'=>$HTML_Tabla, 'productos'=>$HTML_Productos);
            
            echo json_encode($envio);                       
        }else{
            echo "ERROR";
        }           
    });

    $app->get('/Productos/{id}', function (Request $request, Response $response, $args) {        
        $pID = $args['id'];
        $resultado = Producto::TraerProductoPorID($pID);

        if($resultado != false){
            $HTML_Menu = file_get_contents('partes/menu_producto.php',TRUE);
            $Producto  = $resultado;
            $envio = array('menu'=>$HTML_Menu, 'producto'=>$Producto);
            echo json_encode($envio);
        }else{
            echo "ERROR";
        }
    });

    $app->post('/Productos/Modificar', function(Request $request, Response $response){
        $ArrayDeParametros = $request->getParsedBody();
        
        if(Producto::ModificarProducto($ArrayDeParametros) == 1){
            echo json_encode($ArrayDeParametros);
        }
                
        

    });

//---------------------------------  PEDIDOS --------------------------------------------------//
    $app->get('/MenuPedidos[/]', function(Request $request, Response $response){                
        $LISTA_Mesas = Mesa::TraerTodasLasMesas();              
        $LISTA_Productos = Producto::TraerTodosLosProductos();
        $LISTA_Productos = Producto::HTML_Pedidos($LISTA_Productos);
        if($LISTA_Mesas != false & $LISTA_Productos != false){            
            $HTML_Menu = file_get_contents('partes/menu_NuevoPedido.php',TRUE);
            $HTML_Tabla = file_get_contents('partes/Tabla_lista_productos.php',TRUE);
            //$HTML_Tab =   file_get_contents('partes/empleados_tab.php',TRUE);
            $envio = array('mesas'=>$LISTA_Mesas, "menu"=>$HTML_Menu, "productos"=>$LISTA_Productos,
                            'tabla'=>$HTML_Tabla);
            
            echo json_encode($envio);                       
        }else{
            return $response->withStatus(400);
        }           
    });

    $app->get('/ProductoPedido/{id}', function (Request $request, Response $response, $args) {        
        $pID = $args['id'];
        $resultado = Producto::HTML_Producto_Para_Pedido($pID);
        echo $resultado;
        
    });

//---------------------------------  PRUEBAS --------------------------------------------------//
    $app->get('/Prueba/{pToken}', function (Request $request, Response $response, $args) {        
        $token = $args['pToken'];
        try{
            AutentificadorJWT::VirificarToken($token);
            return "valido";
        }
        catch(Exception  $e){
            return "no anda :V<br>".$token;
            //return $e->getMessage();
        }                        
    });

    $app->get('/Prueba', function (Request $request, Response $response, $args) {             
        $resultado = Usuario::BuscarPorSesion("admin", "admin");
        //$resultado = json_decode($resultado);
        echo "asd";
        //var_dump($resultado);
    });


    $app->get('/Mesas[/]', function(Request $request, Response $response){                
        $resultado = Mesa::TraerTodasLasMesas();              
        if($resultado != false){
            $HTMLMesas = Mesa::MesasHTML($resultado);
            
            return json_encode($HTMLMesas);            
            //return $HTMLMesas;
        }else{
            //echo "ERROR";
            return $response->withJson($resultado, 405);
        }
    });

    $app->get('/GetTime', function(){
        $file = 'data/prueba.json';
        $item = array();
        $item["usuario"] = "Usuario Random";
        $miDate =  date("o-m-d_G-i-s");       
        $item["date"] = $miDate;

        $persona = array("usuario" => $item["usuario"], "date" => $item["date"] );
                
        if(file_exists(__DIR__."/".$file)){  
            $tempArray = file_get_contents($file); 
            $tempArray = json_decode($tempArray);   
        }else{           
            $tempArray = array();
        }        
                                                            
        //array_push($tempArray, $miDate);
        array_push($tempArray, $persona);
        $json_string = json_encode($tempArray);
               
        file_put_contents($file, $json_string);

        echo $json_string;                                
    });



    //---------------------------------------------------------------------------------
$app->run();



//$string = file_get_contents('partes/TablaUsuarios.php',TRUE);


?>


