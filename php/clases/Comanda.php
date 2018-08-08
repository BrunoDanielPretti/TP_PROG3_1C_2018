<?php   
    class Comanda{
        public $id;
        public $idMesa;
        public $idCosina;
        public $idConcteleria;
        public $idCervezeria;
        public $date;
        public $nombreCliente;
        public $encuesta;

        public function __construct(
            $pId=NULL, $pIdMesa=NULL, $pIdCosina=NULL, $pIdCocteleria=NULL, $pIdCervezeria=NULL, $pDate=NULL,
            $pNombreCliente=NULL, $pEncuesta=NULL
        ){
            if($pId != NULL){
                $this->id = $pId;
                $this->idMesa = $pIdMesa;
                $this->idCosina = $pIdCosina;
                $this->idConcteleria = $pIdCocteleria;
                $this->idCervezeria = $pIdCervezeria;
                $this->date = $pDate;
                $this->nombreCliente = $pNombreCliente;
                $this->encuesta = $pEncuesta;
            }
        }




    }//----  FIN Clase Comanda
?>