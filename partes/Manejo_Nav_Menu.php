<?php
    function MANEJO_NAV_MENU($pTipo, $pUsuario=NULL){    
        //$pUsuario = $_POST["usuario"];
        if($pTipo == 2)
        {return 
<<<EO1
            <ul class="nav navbar-nav">
                <li><a href="#" onclick="entrada()">Entrada</a></li>
                <li><a href="#" onclick="salida()">Salida</a></li>                                        
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <li><a href="#" onclick="NexoP('menuSesion')" class="navbar-brand" id="">$pUsuario</a></li>
            </ul>
EO1;
        }
        elseif($pTipo == 1)
        {return <<<EO2
            <ul class="nav navbar-nav">
                <li><a href="#" onclick="Nexo('Mesas')">Mesas</a></li>
                <li><a href="#" onclick="salida()">Salida</a></li>  
                <li><a href="#" onclick="administrar()">Administrar</a></li>                                              
                <li><a href="#" onclick="borrarToken()">Borrar Token</a></li>                                              
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <li><a href="#" onclick="NexoP('menuAdmin')" class="navbar-brand" id="">$pUsuario</a></li>
            </ul>
EO2;
       }
        elseif($pTipo == "cerrar")
        {return <<<EO3
            <nav class="navbar navbar-default navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-1" aria-expanded="false">                    
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                        
                        <a class="navbar-brand" href="#" onclick="window.location.reload()" >Home</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="nav-1">
                        <ul class="nav navbar-nav navbar-left">           
                            <li><a href="#" onclick="NexoMesa()" class="navbar-brand" id="">Mesas</a></li>                            
                        </ul>    
                        <ul class="nav navbar-nav navbar-left">                                                                                         
                            <li><a href="#" onclick="NexoP('TablaUsuarios')" class="navbar-brand" id="">Personal</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-left">           
                            <li><a href="#" onclick="NexoProductos()" class="navbar-brand" id="">Productos</a></li>                            
                        </ul>
                        <ul class="nav navbar-nav navbar-left">           
                            <li><a href="#" onclick="Prueba()" class="navbar-brand" id="">Prueba</a></li>                            
                        </ul>                                                              
                        <ul class="nav navbar-nav navbar-right">                            
                            <li><a href="#" onclick="btnSesion()" class="navbar-brand" id="">Usuario</a></li>
                        </ul>
                        
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
EO3;
        }   
    }
?>