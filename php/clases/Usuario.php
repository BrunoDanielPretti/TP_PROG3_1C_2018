<?php
    class Usuario{
        public $usuario;
        public $clave;
        public $tipo;
        public $estado;
        public $turno;
        public $comentario;

        public function __construct($pUsuario=NULL, $pClave=NULL, $pTipo=NULL, $pEstado=NULL, $pTurno=NULL, $pComentario=NULL){
            if($pUsuario != NULL){
                $this->usuario = $pUsuario;
                $this->clave = $pClave;
                $this->tipo = $pTipo;
                $this->estado = $pEstado;
                $this->turno = $pTurno;
                $this->comentario = $pComentario;
            }
        }

        public static function TraerTodoLosUsuarios(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT usuario, clave, tipo, estado, turno, comentario FROM usuarios");
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

        public static function EchoPrueba(){
            return "La clase Usuario anda";
        }
    }



?>