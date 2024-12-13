<?php 
    require_once __dir__."/../controlador/utilidadesControlador.php";
    require_once __dir__."/../controlador/recursosControlador.php";

    $recursos = new Recursos();

    if($_SESSION['TIPOUSER'] == 1){
        $display = '';
    }if($_SESSION['TIPOUSER'] == 2){
        $display = ' style="display:none;"';
    }
?>
<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    <div class="header_img dropdown"> <?= $recursos->imagen_empresa() ?>
        <div class="dropdown-content">
            <ul>
                <a class="btn-danger m-2 border" href="cerrar">&nbsp;<i class='bi bi-x-square h5 text-white'></i></a>
            </ul>
        </div>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo"> <i class='bi bi-globe2 nav_logo-icon'></i>
                <span class="nav_logo-name">Centro Comercio</span>
            </a>
                <div class="nav_list">
                    <!-- <a href="centro_costo" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'centro_costo'); ?>" >
                        <i class="bi bi-badge-cc nav_icon"></i>
                        <span class="nav_name">Centro Costo</span>
                    </a> -->
                    <a href="dashboard" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'dashboard'); ?>" <?= $display ?>>
                        <i class="bi bi-graph-up-arrow nav_icon"></i>
                        <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="viajes" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'bitacora'); ?>" <?= $display ?>>
                        <i class="bi bi-calendar2-week nav_icon"></i>
                        <span class="nav_name">Viajes</span>
                    </a>
                    <a href="bitacora" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'bitacora'); ?>" <?= $display ?>>
                        <i class="bi bi-calendar2-week nav_icon"></i>
                        <span class="nav_name">Bitacora</span>
                    </a>
                    <a href="productos" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'productos'); ?>" <?= $display ?>>
                        <i class='bi bi-truck nav_icon'></i><span class="nav_name">Maquinaria</span>
                    </a>
                    <a href="bodega" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'bodega'); ?>" <?= $display ?>>
                        <i class='fas fa-warehouse nav_icon'></i><span class="nav_name">Bodega</span>
                    </a>
                    <a href="reporteria" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'reporteria'); ?>" <?= $display ?>>
                        <i class='bi bi-card-checklist nav_icon'></i><span class="nav_name">Reporteria</span>
                    </a>
                    <a href="finanzas" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'finanzas'); ?>" <?= $display ?>>
                        <i class='bi bi-coin nav_icon'></i> <span class="nav_name">Finanzas</span>
                    </a>
                    <a href="rrhh" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'rrhh'); ?>" <?= $display ?>>
                        <i class='bi bi-person-rolodex nav_icon'></i> <span class="nav_name">RR.HH</span>
                    </a>
                    <a href="parametros" class="nav_link <?= Utilidades::activo_get($_GET["action"], 'parametros'); ?>" <?= $display ?>>
                        <i class='bi bi-wrench-adjustable-circle nav_icon'></i> <span class="nav_name">Parámetros</span> 
                    </a>
                </div>
            </div>
    </nav>
</div>