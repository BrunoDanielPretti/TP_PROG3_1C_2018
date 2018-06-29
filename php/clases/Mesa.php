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

        public function EstadoToString(){
            switch ($this->estado) {
                case '0':
                    return "Cerrada";
                    break;
                case '1':
                    return "Esperando Pedido";
                    break;
                case '2':
                    return "Con Clientes Comiendo";
                    break;
                case '3':
                    return "Con Clientes Pagando";
                    break;
                case '4':
                    return "Caso 4";
                    break;
                
                default:                    
                    break;
            }
        }


        function MesasHTML($pMesas){
            $cont = 0;
            $string = array();
            foreach ($pMesas as $key) {
                $estado = $key->EstadoToString() ;
                $string[$cont]['string'] =
               <<<E01
            <div class="panel tarjeta col-xs-12 col-sm-6 col-md-4" onclick="alert('$key->id')">
                <div class="panel-heading">Mesa:   <spam>$key->id</spam></div>
                <div class="panel-body" id="menuBotones">                                  
                    <spam>Estado: $estado</spam><br>                    
                    <spam>Pedido: $key->pedido</spam>
                </div>
            </div>
E01;
            $string[$cont]['estado'] = $key->estado;
                $cont++;
            }
            return $string;
           
        }








    } //---------- FIN CLASE MESA -----------//

/*
       function MesasHTML($pMesas){
           
            $string = "";
            foreach ($pMesas as $key) {
               $estado = Mesa::EstadoToString($key->estado) ;
               $string = $string.
               <<<E01
            <div class="panel col-xs-12 col-sm-6 col-md-4">
                <div class="panel-heading">Mesa:   <spam class='btn btn-success'>$key->id</spam></div>
                <div class="panel-body" id="menuBotones">                                  
                    <spam>Estado: $estado</spam><br>                    
                    <spam>Pedido: $key->pedido</spam>
                </div>
            </div>
E01;
            }
            return $string;
           
        }
*/

?>

