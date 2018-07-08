             
<div class=" col-sm-offset-3 col-sm-6">
    <div class="panel contentBruno"> 

        <div class="panel-heading " >Iniciar Sesion<spam class="modal-close" onclick="Modal_Cerrar()">&times;</spam></div>

        <div class="panel-body">
            <form class="form-horizontal col-xs-12 col-md-offset-2 col-md-8 ">
                <div class="form-group" id="frmTxtUsuario">
                    <label for="txtUsuario" class="col-sm-2 control-label">Usuario:</label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="txtUsuario" placeholder="Usuario"> 
                        </div>  
                    </div>                        
                </div>
            <div class="form-group" id="frmTxtClave"> 
                <label for="txtClave" class="col-sm-2 control-label">Contraseña:</label>
                <div class="col-sm-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="txtClave" placeholder="Contraseña">
                        <span id="spanTxtClave" class="help-block hidden">Usuario o contraseña incorrectos</span>
                    </div>
                </div>
            </div>
            
                <!--<div class="checkbox">
                    <label>
                    <input type="checkbox"> Check me out
                    </label>
                </div>-->
            <div class="form-group">
                <button type="button" class="col-md-offset-2 btn btn-success" onclick="Sesion_Aceptar()">Entrar</button>
            </div>
                
            <div class="col-md-offset-2">   
                <div class="form-group">
                    <button class="btn btn-success" onclick="" >Coso</button>
                    <button class="btn btn-success" onclick="btnAdmin()" >Admin</button>
                    <button class="btn btn-success" onclick="Modal_Cerrar()">Cancelar</button>
                </div>
            </div>        
            </form>
        </div>
    </div>                
</div>    
