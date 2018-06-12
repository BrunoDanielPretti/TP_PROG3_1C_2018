<?php
    function MANEJO_NAV_MENU($pTipo, $pUsuario){    
        //$pUsuario = $_POST["usuario"];
        if($pTipo == "e")
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
        elseif($pTipo == 'a')
        {return <<<EO2
            <ul class="nav navbar-nav">
                <li><a href="#" onclick="entrada()">Entrada</a></li>
                <li><a href="#" onclick="salida()">Salida</a></li>  
                <li><a href="#" onclick="administrar()">Administrar</a></li>                                              
            </ul>
            <ul class="nav navbar-nav navbar-right">                
                <li><a href="#" onclick="NexoP('menuAdmin')" class="navbar-brand" id="">$pUsuario</a></li>
            </ul>
EO2;
       }
        elseif($pTipo == "cerrar")
        {return <<<EO3
            <ul class="nav navbar-nav navbar-right">                
                <li><a href="#" onclick="NexoP('menuSesion')" class="navbar-brand" id="">Iniciar Sesion</a></li>
            </ul>
EO3;
        }   
    }
?>