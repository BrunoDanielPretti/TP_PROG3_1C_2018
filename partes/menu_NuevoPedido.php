<div class="col-sm-offset-2 col-sm-8" style=" margin-top: -90px">
    <div class="panel contentBruno"> 

        <div class="panel-heading" >
            <i class="glyphicon glyphicon-user"></i>    
            <spam id="head_spam"> Nuevo Pedido</spam>
            <spam class="modal-close" onclick="Modal_Cerrar()">&times;</spam>
        </div>

        <div class="panel-body">
            <div class="form" autocomplete="off">
                <div class="form-group col-xs-10 col-sm-6" target="Alta">
                    <label for="">Nombre Cliente</label>                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="Usuario_txt" placeholder="Nombre del Cliente"> 
                    </div>  
                </div>                

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Mesa</label>
                    <select class="form-control" id="select_mesa">
                        <!-- <option target="2">Bartender</option> -->                        
                    </select>
                </div>
               
                <div class="col-xs-10 col-sm-12" style="margin-bottom: 16px">
                    <button class="btn btn-success col-xs-12" id="btn_Agregar_Producto"> Agregar Producto </button>                    
                    <div class="clearfix"></div>
                </div>

                <table class='table' id='Tabla_Lista' >
                    <thead  >
                        <tr id='Tabla_Pedido_Head'>

                        </tr>
                    </thead>
                    <tbody id='Tabla_Pedido_Body'>
                        
                    </tbody>    
                </table>
                <div class="form-group col-xs-12">
                    <label class="text-precio col-xs-12" id="Labet_Total"></label>
                    
                </div>
                <div class="col-xs-10 col-sm-12">
                    <button class="btn btn-success" id="btn_usuario_alta" onclick="usuario_alta()">Alta</button>
                    <button class="btn btn-success" onclick="Modal_Cerrar()" style="float: right">Cancelar</button>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>          
        </div>
    </div>                
</div>    
