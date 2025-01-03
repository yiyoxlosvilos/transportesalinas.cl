<?php
  require_once __dir__."/../../controlador/dashboardControlador.php";
  require_once __dir__."/../../controlador/utilidadesControlador.php";
	require_once __dir__."/../../recursos/head.php";

  $dash        = new DashBoard();
  $utilidades  = new Utilidades();
  $mvc2        = new controlador();

	$dia         = Utilidades::fecha_dia();
	$mes         = Utilidades::fecha_mes();
  $ano         = Utilidades::fecha_ano();
  $hoy         = Utilidades::fecha_hoy();

  // MENU
  $mvc2->menu_usuarios();
?>
<input type="hidden" name="url_link" id="url_link" value="<?= controlador::$rutaAPP ?>">
<!DOCTYPE html>
<html>
<body id="body-pd">
    <div class="row paddingtop50px mt-5 mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-h-100 shadow bg-white border bg-gradient">
                <div class="card-body">
                    <div id="spark1"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-h-100 shadow bg-white border bg-gradient">
                <div class="card-body">
                    <div id="spark2"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-h-100 shadow bg-white border bg-gradient">
                <div class="card-body">
                    <div id="spark3"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card card-h-100 shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                        <h5 class="card-title me-2">Viajes Hoy</h5>
                    </div>
                    <div class="row align-items-center">
                        <?= $dash->panel_card_venta_hoy($hoy); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card card-h-100 shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                        <h5 class="card-title me-2">Pr&oacute;ximos viajes</h5>
                    </div>
                    <div class="row align-items-center">
                        <?= $dash->panel_card_venta_futuras($hoy); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
            <div class="card card-h-100 shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-4">
                        <h5 class="card-title me-2">Facturas Proveedores</h5>
                        <div class="ms-auto">
                            <?= Utilidades::select_agrupacion_cards('mostrar_facturas_compras', 'fecha_meta_compras', $ano, $mes) ?>
                        </div>
                    </div>
                    <div class="row align-items-center" id="mostrar_facturas_compras">
                        <?= $dash->panel_card_facturas_compra($ano, $mes); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-4">
          <div class="card card-h-100 shadow">
              <div class="card-body">
                  <div class="d-flex flex-wrap align-items-center mb-4">
                      <h5 class="card-title me-2">Gastos Realizados</h5>
                      <div class="ms-auto">
                          <?= Utilidades::select_agrupacion_cards('mostrar_gastos', 'pagos_gastos', $ano, $mes) ?>

                      </div>
                  </div>
                  <div class="row align-items-center" id="mostrar_gastos">
                      <?= $dash->panel_gastos_realizados($ano, $mes); ?>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-xl-15 mb-4">
            <div class="card card-h-100 shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <h5 class="card-title me-2">Metas de Venta</h5>
                        <div class="ms-auto">
                            <?= Utilidades::select_agrupacion_cards('mostrar_meta_ventas', 'fecha_meta', $ano, $mes) ?>
                        </div>
                    </div>
                    <div class="row align-items-center" id="mostrar_meta_ventas">
                        <?= $dash->contenido_metas($mes, $ano); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 mb-4">
        <div class="card card-h-100 shadow">
            <div class="card-body">
                <div id="bar"></div>
            </div>
         </div>
    </div>
    <div class="col-xl-6 mb-4">
        <div class="card card-h-100 shadow">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h5 class="card-title me-2">EDP Pendientes</h5>
        
                </div>
                <div class="row align-items-center" id="mostrar_pagos_pendientes">
                    <?= $dash->panel_pagos_pendientes($ano, $mes); ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    initCounterNumber();
    initCounterPorcent();
    
Apex.grid = {
  padding: {
    right: 0,
    left: 0
  }
}

Apex.dataLabels = {
  enabled: false
}

var randomizeArray = function (arg) {
  var array = arg.slice();
  var currentIndex = array.length, temporaryValue, randomIndex;

  while (0 !== currentIndex) {
    currentIndex        -= 1;
    temporaryValue       = array[currentIndex];
    array[currentIndex]  = array[currentIndex];
    array[randomIndex]   = temporaryValue;
  }

  return array;
}

// the default colorPalette for this dashboard
var colorPalette = ['#01BFD6', '#5564BE', '#F7A600', '#EDCD24', '#F74F58'];
//var colorPalette    = ['#00D8B6','#008FFB',  '#FEB019', '#FF4560', '#775DD0'];
var dataVentas      = [<?=  $dash->arriendos_diarios_historial_card($ano, $mes) ?>];
var dataGastos      = [<?=  $dash->gastos_diarios_historial_card($ano, $mes) ?>];
var dataIva         = [<?=  $dash->iva_diarios_historial_card($ano, $mes) ?>];
var spark1 = {
  chart: {
    id:         'sparkline1',
    group:      'sparklines',
    type:       'area',
    height:     125,
    sparkline: {
      enabled:  true
    },
  },
  stroke: {
    curve:      'straight'
  },
  fill: {
    opacity:    1,
  },
  series: [{
    name:       'EDP',
    data:       randomizeArray(dataVentas)
  }],
  labels:       [...Array(<?= date("t") ?>).keys()].map(n => `<?= date("Y") ?>-<?= date("m") ?>-0${n+1}`),
  yaxis: {
    min:        0
  },
  xaxis: {
    type:       'datetime',
  },
  colors:       ['#33A2FF'],
  title: {
    text:       '<?= $dash->arriendos_diario_card($mes, $ano) ?>',
    offsetX:    30,
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title'
    }
  },
  subtitle: {
    text: 'INGRESOS',
    offsetX: 30,
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title'
    }
  }
}

var spark2 = {
  chart: {
    id: 'sparkline2',
    group: 'sparklines',
    type: 'area',
    height: 125,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'SALIDAS',
    data: randomizeArray(dataGastos)
  }],
  labels: [...Array(<?= date("t") ?>).keys()].map(n => `<?= date("Y") ?>-<?= date("m") ?>-0${n+1}`),
  yaxis: {
    min: 0
  },
  xaxis: {
    type: 'datetime',
  },
  colors: ['#ff6600'],
  title: {
    text: '<?= $dash->total_gastos($mes, $ano) ?>',
    offsetX: 30,
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title'
    }
  },
  subtitle: {
    text: 'SALIDAS',
    offsetX: 30,
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title'
    }
  }
}

var spark3 = {
  chart: {
    id: 'sparkline3',
    group: 'sparklines',
    type: 'area',
    height: 125,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 1,
  },
  series: [{
    name: 'IVA',
    data: randomizeArray(dataIva)
  }],
  labels: [...Array(<?= date("t") ?>).keys()].map(n => `<?= date("Y") ?>-<?= date("m") ?>-0${n+1}`),
  xaxis: {
    type: 'datetime',
  },
  yaxis: {
    min: 0
  },
  colors: ['#F33000'],
  title: {
    text: '<?= $dash->iva_mensual($mes, $ano) ?>',
    offsetX: 30,
    style: {
      fontSize: '24px',
      cssClass: 'apexcharts-yaxis-title'
    }
  },
  subtitle: {
    text: 'IVA',
    offsetX: 30,
    style: {
      fontSize: '14px',
      cssClass: 'apexcharts-yaxis-title'
    }
  }
}

new ApexCharts(document.querySelector("#spark1"), spark1).render();
new ApexCharts(document.querySelector("#spark2"), spark2).render();
new ApexCharts(document.querySelector("#spark3"), spark3).render();

var optionsBar = {
  chart: {
    type: 'bar',
    height: 380,
    width: '100%',
    stacked: true,
  },
  plotOptions: {
    bar: {
      columnWidth: '60%',
    }
  },
  colors: colorPalette,
  series: [{
    name: "Pagados",
    data: [<?=  $dash->total_gastos_cards_pagados($ano) ?>],
  }, {
    name: "Pendientes",
    data: [<?=  $dash->total_gastos_cards_pendientes($ano) ?>],
  }],
  labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
  xaxis: {
    labels: {
      show: true
    },
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
  },
  yaxis: {
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    labels: {
      style: {
        colors: '#78909c'
      }
    }
  },
  title: {
    text: 'Pagos',
    align: 'left',
    style: {
      fontSize: '18px'
    }
  }

}

var chartBar = new ApexCharts(document.querySelector('#bar'), optionsBar);
chartBar.render();




// on smaller screen, change the legends position for donut
var mobileDonut = function() {
  if($(window).width() < 768) {
    donut.updateOptions({
      plotOptions: {
        pie: {
          offsetY: -15,
        }
      },
      legend: {
        position: 'bottom'
      }
    }, false, false)
  }
  else {
    donut.updateOptions({
      plotOptions: {
        pie: {
          offsetY: 20,
        }
      },
      legend: {
        position: 'left'
      }
    }, false, false)
  }
}

$(window).resize(function() {
  mobileDonut()
});

</script>