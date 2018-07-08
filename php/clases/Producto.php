<?php
    class Producto{
        public $id;
        public $nombre;
        public $precioCompra;
        public $precioVenta;
        public $foto;
        public $tipo;
        public $stock;
        
        public function __construct(
            $pId=NULL, $pNombre=NULL, $pPrecioCompra=NULL, $pPecioVenta=NULL, $pFoto=NULL, 
            $pTipo=NULL, $pStock=NULL)
        {
            if($pId != NULL){
                $this->id = $pId;
                $this->nombre = $pNombre;
                $this->precioCompra = $pPrecioCompra;
                $this->precioVenta = $pPecioVenta;
                $this->foto = $pFoto;
                $this->tipo = $pTipo;
                $this->stock = $pStock;
            }
        }

        public function TraerTodosLosProductos(){            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "SELECT 
                    id, nombre, precioCompra, precioVenta, foto, tipo, stock
                FROM productos"
            );       
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");                
        }

        public function TraerProductoPorID($pId){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "SELECT 
                    id, nombre, precioCompra, precioVenta, foto, tipo, stock
                FROM productos
                WHERE id = $pId"
                
            );       
            $consulta->execute();
            $miProducto = $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");                
            return json_encode($miProducto);
        }

        public function ModificarProducto($pParam){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $Id = $pParam["Id"];
            $Nombre = $pParam["Nombre"];            
            $Precio = $pParam["Precio"];
            $Tipo = $pParam["Tipo"];

            $consulta = $objetoAccesoDato->RetornarConsulta(
                "UPDATE productos
                SET 
                    nombre = '$Nombre',
                    precioVenta = '$Precio',
                    tipo = '$Tipo'
                WHERE id = '$Id'"
                
            );       
            return $consulta->execute();
        }

        public function ProductosHTML($pProductos){
            $cont = 0;
            $string = array();
            foreach ($pProductos as $key) {
                $string[$cont] =
                <<<E01
                    <tr class='td-br item' onclick="MenuProducto('$key->id')">
                        <td><img class='btn-icon' src='resources/IconsL2/$key->foto.jpg'></td>
                        <td>$key->nombre</td>
                        <td>$key->precioCompra</td>
                        <td>$key->precioVenta</td>
                        <td>$key->tipo</td>
                    </tr>
E01;
                $cont++;
            }
            return $string;
        }





    }//------- FIN CLASE PRODUCTO
    //<td><img src='resources/IconsL2/$key->foto.jpg></td>

    

?>