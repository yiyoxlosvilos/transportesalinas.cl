<?php
  require_once __dir__."/../../../controlador/controlador.php";
  require_once __dir__."/../../../controlador/centroCostoControlador.php";
  require_once __dir__."/../../../controlador/utilidadesControlador.php";
  require_once __dir__."/../../../controlador/recursosControlador.php";
  require_once __dir__."/../../../recursos/head.php";

  $centroCostos= new CentroCostos();
  $recursos    = new Recursos();
  $utilidades  = new Utilidades();
  $mvc         = new controlador();

  $idServicio  = $_REQUEST['idServicio'];
  $mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  $codigo      = "EDP_".$recursos->conteo_edp();
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" type="text/css" />

<script src="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/js/js.js?v=<?= rand() ?>"></script>
<link href="<?= controlador::$rutaAPP ?>app/vistas/centro_costo/asset/css/css.css?v=<?= rand() ?>" rel="stylesheet" type="text/css" />

<link href="<?= controlador::$rutaAPP ?>app/recursos/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
<script src="<?= controlador::$rutaAPP ?>app/recursos/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<!-- MultiStep Form -->
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-11 col-sm-9 col-md-9 col-lg-9 text-center p-0">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Estado de Pago</strong></h2>
                <div class="row">
                    <div class="col-md-12 mx-0" id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>EDP</strong></li>
                                <li id="personal"><strong>Servicios</strong></li>
                                <li id="payment"><strong>Pagos</strong></li>
                                <li id="confirm"><strong>Finalizar</strong></li>
                            </ul>
                            <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Informaci&oacute;n EDP</h2>
                                    <input type="text" name="codigo_edp" id="codigo_edp" value="<?= $codigo ?>" class="bg-white">
                                    Fecha Pago:
                                    <input type="date" name="fecha_pago" id="fecha_pago" value="<?= $hoy ?>" class="bg-white">
                                    <input type="text" name="glosa" id="glosa" placeholder="Glosa"/>
                                </div>
                              <i name="next" class="next btn btn-success fas fa-arrow-alt-circle-right h4 text-white"></i>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Asignar Servicios</h2>
                                    <?= $recursos->seleccionar_servicios_disponibles(); ?>
                                </div>
                        
                                <i name="previous" class="previous btn btn-dark fas fa-arrow-alt-circle-left h4 text-white"></i>
                                <i name="next" class="next btn btn-success fas fa-arrow-alt-circle-right h4 text-white" onclick="mostrar_servicios_asignados()"></i>
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Listado de Pago</h2>
                                    <div class="row" id="resultado"></div>
                                </div>
                                <i name="previous" class="previous btn btn-dark fas fa-arrow-alt-circle-left h4 text-white"></i>
                                <i name="next" class="next btn btn-success far fa-save h4 text-white" onclick="procesar_edp()" style="display: none;" id="procesar" > Finalizar y Grabar</i>
                            </fieldset>
                            <fieldset >
                                <div class="form-card" id="procesar_edp">
                                    
                                </div>
                            </fieldset>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    
var current_fs, next_fs, previous_fs; //fieldsets
var opacity;

$(".next").click(function(){
    
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    
    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
    
    //show the next fieldset
    next_fs.show(); 
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({'opacity': opacity});
        }, 
        duration: 600
    });
});

$(".previous").click(function(){
    
    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();
    
    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    
    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({'opacity': opacity});
        }, 
        duration: 600
    });
});

$('.radio-group .radio').click(function(){
    $(this).parent().find('.radio').removeClass('selected');
    $(this).addClass('selected');
});

$(".submit").click(function(){
    return false;
})
    
});

  $(document).ready(function() { 
    var multipleCancelButton = new Choices("#inputServicio", {
          removeItemButton: true,
      });
  });
</script>
