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
                    return "Cocinero";
                    break;
                case 5:
                    return "Mozo";
                    break;                
            }
        }
//--------------------------------- PDO ---------------------------------//
        public static function TraerTodosLosUsuarios(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta(
                "SELECT usuario, nombre, apellido, tipo
                 FROM usuarios");
            $consulta->execute();   
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        }

        public static function TraerUsuarios(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuario, clave, tipo FROM usuarios");
            $consulta->execute();   
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        }

        public static function BuscarPorSesion($pUsuario, $pClave){
            $listaUsuarios = Usuario::TraerUsuarios();

            for ($i=0; $i < count($listaUsuarios); $i++) { 
                if($listaUsuarios[$i]->usuario == $pUsuario && $listaUsuarios[$i]->clave == $pClave)
                {
                    return $listaUsuarios[$i]->tipo;
                }
            }
            return false;
        }

    }



?>