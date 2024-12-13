$(document).ready(function() {
    $('#productos_list').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 20
       });
});

$(document).ready(function() {
    $('.counter').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    var multipleCancelButton = new Choices('#productos', {
        removeItemButton: true,
    }); 
});

function buscar_flujo_diario() {
	const url_link 	= document.getElementById('url_link').value;
    var mes  		= document.getElementById('mes').value;
    var ano 		= document.getElementById('ano').value;
    var accion      = "buscar_flujo_diario";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion, mes:mes, ano:ano});
}

function flujo_mensual() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "flujo_mensual";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion});
}

function buscar_flujo_mensual() {
    const url_link  = document.getElementById('url_link').value;
    var ano         = document.getElementById('ano').value;
    var accion      = "buscar_flujo_mensual";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion, ano:ano});
}

function informe_ventas() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "informe_ventas";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion});
}

function reporte_financiero() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "reporte_financiero";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion});
}

function buscar_informe_ventas(argument) {
    const url_link  = document.getElementById('url_link').value;
    var mes         = document.getElementById('mes').value;
    var ano         = document.getElementById('ano').value;
    var accion      = "buscar_informe_ventas";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion, mes:mes, ano:ano});
}

function reporte_financiero() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "reporte_financiero";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion});
}

function buscar_reporte_financiero(argument) {
    const url_link  = document.getElementById('url_link').value;
    var mes         = document.getElementById('mes').value;
    var ano         = document.getElementById('ano').value;
    var accion      = "buscar_reporte_financiero";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion, mes:mes, ano:ano});
}

function estado_pago() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "estado_pago";

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/reporteria/php/validador_reporteria.php", {accion:accion});
}