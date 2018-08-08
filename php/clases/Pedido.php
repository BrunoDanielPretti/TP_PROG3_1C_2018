<?php
    class Pedido{   
        public $id;        
        public $tipo;
        public $empleados;        
        public $time_creacion;
        public $time_terminado;
        public $time_estimado;
        public $productos;
        public $precio;
        
        public function __construct(
            $pId=NULL, $pTipo=NULL, $pEmpleados=NULL, $pTime_creacion=NULL, $pTime_terminado=NULL,
            $pTime_estimado=NULL, $pProductos=NULL, $pPrecio=NULL
        ){
            if($pId != NULL){
                $this->id = $pId;
                $this->tipo = $pTipo;
                $this->empleados = $pEmpleados;
                $this->time_creacion = $pTime_creacion;
                $this->time_terminado = $pTime_terminado;
                $this->time_estimado = $pTime_estimado;
                $this->productos = $pProductos;
                $this->precio = $pPrecio;
            }            
        }

    }//----  FIN Clase Pedido
?>