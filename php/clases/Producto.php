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
            $consulta = $objetoAccesoDato->RetornarConsulta(
                "UPDATE productos
                SET 
                    nombre = '$pParam[Nombre]',
                    precioVenta = '$pParam[Precio]',
                    tipo = '$pParam[Tipo]'
                WHERE id = '$pParam[Id]'"
                /*
                nombre = '$Nombre',
                precioVenta = '$Precio',
                tipo = '$Tipo'
                */
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

        public function HTML_Pedidos($pProductos){
            $cont = 0;
            $string = array();
            foreach ($pProductos as $key) {
                $string[$cont] =
                <<<E02
                    <tr class='td-br item' onclick="Agregar_Producto_Al_Pedido('$key->id')">
                        <td><img class='btn-icon' height="26" width="26" src='resources/IconsL2/$key->foto.jpg'></td>
                        <td>$key->nombre</td>  
                        <td>$key->tipo</td>                      
                        <td>$key->precioVenta</td>                                                                        
                    </tr>
E02;
                $cont++;
            }
            return $string;
        }

        public function HTML_Producto_Para_Pedido($pId){
            $key = Producto::TraerProductoPorID($pId);
            $key = json_decode($key);
            $key = $key[0];
            $string =
                <<<E02
                    <tr class='td-br item'>
                        <td class="td2"><img class='btn-icon' height="30" width="30" src='resources/IconsL2/$key->foto.jpg'></td>
                        <td class="td2">$key->nombre</td> 
                        <td class="td2">$key->tipo</td>                       
                        <td name="Precio_Unidad" class="td2">$key->precioVenta</td>
                        <td name="Precio_Venta" class="td2">$key->precioVenta</td>
                        <td name="btn_Disminuir" class="td-btn"> <i class="glyphicon glyphicon-chevron-left"></i> </td>
                        <td class="td2">    <input name="txt_cant" type="text" class="form-control" cant="$key->id" value="1"> </td>                        
                        <td name="btn_Aumentar" class="td-btn"> <i class=" glyphicon glyphicon-chevron-right "></i> </td>
                        <td name="btn_Eliminar" class="td-btn"> <i class="glyphicon glyphicon-remove"></i> </td>
                        
                        
                    </tr>
E02;
             
            return $string;

            /*
            

            */
        }





        





    }//------- FIN CLASE PRODUCTO
    //<td><img src='resources/IconsL2/$key->foto.jpg></td>

    

?>