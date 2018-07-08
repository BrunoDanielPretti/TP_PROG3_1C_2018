<div class="col-sm-offset-2 col-sm-8" style=" margin-top: -90px">
    <div class="panel contentBruno"> 

        <div class="panel-heading" >
            <i class="glyphicon glyphicon-user"></i>    
            <spam id="head_spam">   Usuario</spam>
            <spam class="modal-close" onclick="Modal_Cerrar()">&times;</spam>
        </div>

        <div class="panel-body">
            <form class="form">
                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Usuario</label>                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="" placeholder="usuario"> 
                    </div>  
                </div>
                <spam class="form-group col-xs-10 col-sm-6"></spam>
                <div class="clearfix"></div>

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Contraseña</label>
                    
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="" placeholder="Contraseña">                       
                    </div>
                </div>

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Repetir Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="" placeholder="Contraseña">                       
                    </div>
                </div>

                <div class="form-group col-xs-10 col-sm-6 col-md-6 col-lg-6">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" id="" placeholder="nombre">
                </div>                

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Apellido</label>
                    <input type="text" class="form-control" id="" placeholder="apellido">
                </div>

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Telefono</label>
                    <input type="text" class="form-control" id="" placeholder="telefono">
                </div>

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">DNI</label>
                    <input type="text" class="form-control" id="" placeholder="DNI">
                </div>

                <div class="form-group col-xs-10 col-sm-6">
                    <label for="">Puesto</label>
                    <select class="form-control" id="select_puesto">
                        <option target="Bartender">Bartender</option>  
                        <option target="Cervecero">Cervecero</option>
                        <option target="Cosinero">Cosinero</option>
                        <option target="Mozo">Mozo</option>
                    </select>
                </div>
                
                <div class="form-group col-xs-12">
                    <label for="comment">Comentario:</label>
                    <textarea class="form-control" rows="4" id="comment"></textarea>
                </div> 
                                                      
                <div class="col-xs-10 col-sm-12">
                    <button class="btn btn-success" onclick="">Alta</button>
                    <button class="btn btn-success" onclick="">Modificar</button>
                    <button class="btn btn-success" onclick="">Dar de Baja</button>
                    <button class="btn btn-success" onclick="">Dar de Alta</button>
                    <button class="btn btn-success" onclick="Modal_Cerrar()" style="float: right">Cancelar</button>
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="clearfix"></div>

           <!-- <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10"> -->
        </div>
    </div>                
</div>    
