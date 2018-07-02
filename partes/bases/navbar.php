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
            <ul class="nav navbar-nav navbar-right">
                <!--<li role="presentation" class="btn btn-danger btn-lg" onclick="btnSesion()" >Iniciar Sesion</li>                    -->
                <li><a href="#" onclick="NexoP('menuSesion')" class="navbar-brand" id="">Usuario</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
