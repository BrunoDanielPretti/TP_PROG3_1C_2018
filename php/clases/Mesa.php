<?php
    class Mesa{
        public $id;
        public $pedido;
        public $estado;

        public function __construct($pId =NULL, $pPedido=NULL, $pEstado =NULL){
            if($pId != NULL){
                $this->id = $pId;
                $this->pedido = $pPedido;
                $this->estado = $pEstado;
            }            
        }

        public function TraerTodasLasMesas(){            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "SELECT 
                    idmesa AS id, 
                    idpedido AS pedido, 
                    estado 
                FROM mesas"
            );       
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");                
        }


        function MesasHTML($pMesas){
           
            $string = "";
            foreach ($pMesas as $key) {

               $string = $string.
               <<<E01
            <div class="panel panel-info col-xs-12 col-md-6">
                <div class="panel-heading">Mesa:   <spam class='btn btn-success'>$key->id</spam></div>
                <div class="panel-body" id="menuBotones">                                  
                    <spam>Estado: $key->estado</spam><br>                    
                    <spam>Pedido: $key->pedido</spam>
                </div>
            </div>
E01;
            }
            return $string;
           
        }








    }



?>