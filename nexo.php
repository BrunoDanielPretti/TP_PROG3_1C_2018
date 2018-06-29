<?php
//---------------------------------  Configuracion  -------------------------------------------//
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require 'vendor/autoload.php';
    require 'php/clases/AutentificadorJWT.php';
    require 'php/clases/AccesoDatos.php';
    require 'php/clases/Usuario.php';
    require 'php/clases/Mesa.php';
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
?>
