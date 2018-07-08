<div class=" col-sm-offset-3 col-sm-6">
    <div class="panel contentBruno"> 

        <div class="panel-heading" >
            <img class='btn-icon' id="head_icon" src='./resources/IconsL2/etc_adena_i00.jpg'>    
            <spam id="head_spam">   Producto</spam>
            <spam class="modal-close" onclick="Modal_Cerrar()">&times;</spam>
        </div>

        <div class="panel-body">
            <form class="form-horizontal col-xs-12 col-md-offset-2 col-md-8 ">
                <div class="form-group" id="frmTxtNombre">
                    <label for="txtNombre" class="col-sm-2 control-label">Nombre:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="txtNombre" autocomplete="off">                
                    </div>                        
                </div>

            <div class="form-group col-md-offset-2">
                <label for="select_tipo" class="col-sm-2 control-label" style:"padding-left: 200px">Tipo:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="select_tipo">
                        <option target="Plato">Plato</option>  
                        <option target="Bebida">Bebida</option>
                        <option target="Trago">Trago</option>
                        <option target="Postre">Postre</option>
                    </select>
                </div>                
            </div> 

            <div class="form-group" id="frmTxtPrecio"> 
                <label for="txtCompra" class="col-sm-2 control-label">Precio:</label>

                <div class="input-group col-sm-6">
                    
                    <input type="text" class="form-control" id="txtCompra" style="margin-left: 15px" autocomplete="off"> 
                    <span class="input-group-addon">
                        <img src='./resources/IconsL2/etc_adena_i00.jpg' height="20" width="20" style="margin-left: 15px">
                    </span>                   
                </div>
                
            </div>
            
            
                <!--<div class="checkbox">
                    <label>
                    <input type="checkbox"> Check me out
                    </label>
                </div>-->
            <div class="form-group col-md-offset-2">
                <button type="button" class="btn btn-success" id="btn_MenuProducto_Aceptar" onclick="">Aceptar</button>
                <button class="btn btn-success" style="float: right" onclick="Modal_Cerrar()">Cancelar</button>
            </div>
                
            <!-- <div class="col-md-offset-2">   
                <div class="form-group">
                    <button class="btn btn-success" onclick="" >Coso</button>
                    <button class="btn btn-success" onclick="" >Admin</button>
                    <button class="btn btn-success" onclick="Modal_Cerrar()">Cancelar</button>
                </div>
            </div>         -->
            </form>
        </div>
    </div>                
</div>    
