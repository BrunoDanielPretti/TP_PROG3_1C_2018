<div class=" col-sm-offset-3 col-sm-6">
<div class="panel panel-info"> 
<div class="panel-heading">Usuario</div>
    <div class="panel-body">
        <form class="form-horizontal col-xs-12 col-md-offset-2 col-md-8 ">
            <div class="form-group" id="frmTxtUsuario">
                <label for="txtUsuario" class="col-sm-2 control-label">Usuario:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="txtUsuario" placeholder="Usuario">                
                </div>
                
            </div>
        <div class="form-group" id="frmTxtClave"> 
                <label for="txtClave" class="col-sm-2 control-label">Contraseña:</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="txtClave" placeholder="Contraseña">
                    <span id="spanTxtClave" class="help-block hidden">Usuario o contraseña incorrectos</span>
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
                    <button class="btn btn-success" onclick="sesionAceptar('empleado')" >Aceptar</button>
                    <button class="btn btn-success" onclick="sesionAceptar('admin')" >Admin</button>
                    <button class="btn btn-success" onclick="sesionAceptar('cerrar')">Cancelar</button>
                </div>
            </div>        
        </form>
    </div>
</div>


</div>

