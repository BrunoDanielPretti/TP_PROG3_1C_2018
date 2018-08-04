<?php
    class Usuario{
        public $id;
        public $usuario;
        public $clave;
        public $tipo;
        public $estado;
        public $nombre;
        public $apelldio;
        public $DNI;
        public $telefono;
        public $comentario;

        public function __construct(
            $pUsuario=NULL, $pClave=NULL, $pTipo=NULL, $pEstado=NULL, $pNombre=NULL, $pApellido=NULL,
            $pDNI=NULL, $pTelefono=NULL, $pComentario=NULL, $pId=NULL 
            ){
            if($pUsuario != NULL){
                $this->usuario = $pUsuario;
                $this->clave = $pClave;
                $this->tipo = $pTipo;
                $this->estado = $pEstado;
                $this->nombre = $pNombre;
                $this->apellido = $pApellido;
                $this->DNI = $pDNI;
                $this->telefono = $pTelefono;
                $this->comentario = $pComentario;
                $this->id = $pId;                    
            }
        }

        public static function EchoPrueba(){
            return "La clase Usuario anda";
        }

        
//--------------------------------- PDO ---------------------------------//
        public static function TraerTodosLosUsuarios(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "SELECT usuario, nombre, apellido, tipo, estado, id
                 FROM usuarios");
            $consulta->execute();   
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        }

        public static function TraerUsuarios(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT id, usuario, clave, tipo FROM usuarios");
            $consulta->execute();   
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        }

        public static function BuscarPorSesion($pUsuario, $pClave){                                      
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "SELECT 
                   id, tipo
                FROM usuarios
                WHERE usuario = '$pUsuario' AND clave = '$pClave'"                
            );   
            $consulta->execute();                  
            $miProducto = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");                
            return $miProducto;            
        }

        public function Sesion_log_date(){            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();                        
            $date = date("o-m-d");
            $time = date("G:i:s");   
            
            $id = 2;                                 
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "INSERT INTO `log_login`(`id`, date, time)
                 VALUES (
                    $this->id,
                    '$date',
                    '$time'
                 )
                ");
            
            //echo $tipoInt;
            $consulta->execute();   
            
            //return $this->id." ola q ase";
        }

        public static function AgregarUsuario($pParam){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();             
            $tipoInt = Usuario::TipoToInt($pParam['tipo']);                                    
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "INSERT INTO `usuarios`(`usuario`, `clave`, `tipo`, `estado`, `nombre`, `apellido`, `DNI`, `telefono`, `comentario`)
                 VALUES (
                    '$pParam[usuario]',
                    '$pParam[clave]',
                    $tipoInt,
                    1,
                    '$pParam[nombre]',
                    '$pParam[apellido]',
                    '$pParam[dni]',
                    '$pParam[telefono]',
                    '$pParam[comentario]'
                 )
                ");
            
            //echo $tipoInt;
            return $consulta->execute();              
        }

        public static function ModificarUsuario($pParam){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();             
            $tipoInt = Usuario::TipoToInt($pParam['tipo']);                                    
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "UPDATE usuarios
                 SET
                    nombre = '$pParam[nombre]',
                    apellido = '$pParam[apellido]',
                    telefono = '$pParam[telefono]',
                    DNI = '$pParam[dni]',
                    tipo = $tipoInt,
                    comentario = '$pParam[comentario]'
                WHERE id = $pParam[id]
                ");
            
            return $consulta->execute(); 
        }

        public static function DesactivarUsuario($pId){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();                                  
            $pId = (int)$pId;
            
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "UPDATE usuarios
                 SET estado = 0
                 WHERE id = $pId
                ");                        
            return $consulta->execute();              
        }

        public static function ActivarUsuario($pId){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();                                  
            $pId = (int)$pId;
            
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "UPDATE usuarios
                 SET estado = true
                 WHERE id = $pId
                ");                        
            return $consulta->execute();              
        }

        public function TraerUsuarioPorID($pId){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "SELECT 
                   `id`, `usuario`, `clave`, `tipo`, `estado`, `nombre`, `apellido`, `DNI`, `telefono`, `comentario`
                FROM usuarios
                WHERE id = $pId"                
            );       
            $consulta->execute();
            $miProducto = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");                
            return json_encode($miProducto);
        }

        public function UsuariosTablaHTML($pUsuarios){
            $cont = 0;
            $string = array();
            
            foreach ($pUsuarios as $key) {
                $tipo = $key->TipoToString();
                $estado = $key->EstadoToString();
                $colorEstado = $estado["estilo"];
                $estado = $estado["string"];
                $string[$cont] =
                <<<E01
                    <tr class='td-br item' onclick="Usuario_MenuModificar('$key->id')">                        
                        <td>$key->nombre $key->apellido</td>                        
                        <td>$tipo</td>
                        <td $colorEstado>$estado</td>
                    </tr>
E01;
                $cont++;
            }
            return $string;
        }

        
//---------------------------------------------------------------------//    
        public function TipoToString(){
            switch ($this->tipo) {
                case 1:
                    return "Socio";
                    break;
                case 2:
                    return "Bartender";
                    break;
                case 3:
                    return "Cervecero";
                    break;
                case 4:
                    return "Cosinero";
                    break;
                case 5:
                    return "Mozo";
                    break;                
            }
        }

        public static function TipoToInt($pParam){
            switch ($pParam) {
                case 'Socio':
                    return 1;
                    break;
                case 'Bartender':
                    return 2;
                    break;
                case 'Cervecero':
                    return 3;
                    break;
                case 'Cosinero':
                    return 4;
                    break;
                case 'Mozo':
                    return 5;
                    break;                
                default:
                    # code...
                    break;
            }            
        }

        public function EstadoToString(){
            $estado = [];
            if($this->estado == 1){
                $estado['estilo'] = "style='color: green'";
                $estado['string'] = "Activo";
            }else{
                $estado['estilo'] = "style='color: red'";
                $estado['string'] = "Inactivo";
            }
            return $estado;
        }
    }//FIN de la clase Usuario

        


?>