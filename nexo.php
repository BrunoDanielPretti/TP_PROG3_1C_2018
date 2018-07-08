<?php
//---------------------------------  Configuracion  -------------------------------------------//
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

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
            $datos= array('usuario' => $usuario, 'clave' => $clave, 'tipo' => $resultado);
            $token = AutentificadorJWT::CrearToken($datos);

            $navMenu = MANEJO_NAV_MENU($resultado, $usuario);
            
            $envio = array('token' => $token, 'nav' => $navMenu);
            echo json_encode($envio);
        }else{
            echo "error";
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
        $datos = array(
            'usuario'=>$parametros['usuario'],
            'clave'=>$parametros['clave'],
            'nombre'=>$parametros['nombre'],
            'apellido'=>$parametros['apellido'],
            'telefono'=>$parametros['telefono'],
            'dni'=>$parametros['dni'],
            'tipo'=>$parametros['tipo'],
            'comentario'=>$parametros['comentario']
        );
        
        echo Usuario::AgregarUsuario($datos);
        

        /*
        if(Usuario::AgregarUsuario($ArrayDeParametros) == 1){
            echo json_encode("ASDASD");
        }
        */
        //echo json_encode($parametros);              
        //return $response->withJson("error", 406);
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

    $app->get('/Mesas[/]', function(Request $request, Response $response){                
        $resultado = Mesa::TraerTodasLasMesas();              
        if($resultado != false){
            $HTMLMesas = Mesa::MesasHTML($resultado);
            return json_encode($HTMLMesas);            
            //return $HTMLMesas;
        }else{
            echo "ERROR";
        }
    });

    


//---------------------------------------------------------------------------------
$app->run();



//$string = file_get_contents('partes/TablaUsuarios.php',TRUE);


?>


