
function traer_menu_principal(acceso) {
    const url_link  = document.getElementById('url_link').value;

    $("#traer_productos_categoria").html('');
    $('#traer_productos_categoria').load(url_link+"app/recursos/img/loader.svg");
    $('#traer_productos_categoria').load(url_link+"app/vistas/viajes/php/validador.php", {accion:acceso});
}

function traer_menu(acceso) {
    const url_link  = document.getElementById('url_link').value;

    $("#traer_productos_categoria").html('');
    $('#traer_productos_categoria').load(url_link+"app/recursos/img/loader.svg");
    $('#traer_productos_categoria').load(url_link+"app/vistas/viajes/php/validador.php", {accion:acceso});
}

function asignar_productos_cotizacion() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "asignar_productos_cotizacion";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_merma").html('');
        $('#resultado_merma').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_merma').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, productos:productos});
    }
}


function semirremolque() {
    const inputRemolque = document.getElementById('inputRemolque').value;

    if (inputRemolque == 1) {
        $("#semirremolque").show(50);
    } else if (inputRemolque == 0) {
        $("#semirremolque").hide(50);
    }
}

function estadia() {
    const inputEstadia = document.getElementById('inputEstadia').value;

    if (inputEstadia == 1) {
        $("#estadia").show(50);
    } else if (inputEstadia == 0) {
        $("#estadia").hide(50);
    }
}

function grabar_flete() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_flete";

    var idServicio         = document.getElementById('correlativo').value;
    var inputFlete         = document.getElementById('inputFlete').value;
    var inputOrigen        = document.getElementById('inputOrigen').value;
    var inputDestino       = document.getElementById('inputDestino').value;
    var inputCarga         = document.getElementById('inputCarga').value;
    var inputArribo        = document.getElementById('inputArribo').value;
    var inputDescarga      = document.getElementById('inputDescarga').value;
    var inputTrabajador    = document.getElementById('inputTrabajador').value;
    var inputRampla        = document.getElementById('inputProducto').value;
    var inputMontoEstadia  = document.getElementById('inputMontoEstadia').value;
    var inputGlosa         = document.getElementById('inputGlosa').value;
    var inputDescuento         = document.getElementById('inputDescuento').value;

    var tipos_estados_pagos         = document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago         = document.getElementById('inputFechaPago').value;
    var clientes         = document.getElementById('clientes').value;


    var inputOrigen_items  = new Array();
    $('#inputOrigen option:selected').each(function(){
        inputOrigen_items.push($(this).val());
    });

    var inputDestino_items  = new Array();
    $('#inputDestino option:selected').each(function(){
        inputDestino_items.push($(this).val());
    });

    var inputAcompanante_items  = new Array();
    $('#inputAcompanante option:selected').each(function(){
        inputAcompanante_items.push($(this).val());
    });

    var inputGuia_items = []; // Creamos un array vacío

    // Recorremos todos los inputs de texto con name="inputGuia[]"
    $('input[name="inputGuia[]"]').each(function () {
        // Obtenemos el valor del input y lo añadimos al array
        var valor = $(this).val().trim(); // .trim() elimina espacios en blanco
        if (valor !== "") { // Verificamos que no esté vacío
            inputGuia_items.push(valor);
        }
    });

    var idProducto_items = []; // Creamos un array vacío

    // Recorremos todos los inputs de texto con name="idProducto[]"
    $('input[name="idProducto[]"]').each(function () {
        // Obtenemos el valor del input y lo añadimos al array
        var valor1 = $(this).val().trim(); // .trim() elimina espacios en blanco
        if (valor1 !== "") { // Verificamos que no esté vacío
            idProducto_items.push(valor1);
        }
    });

    if (inputFlete.length == 0) {
        $("#inputFlete").focus();
        Swal.fire("Alerta", "** Ingresar monto Flete **", "warning");
    } else if(inputOrigen.length == 0) {
        $("#inputOrigen").focus();
        Swal.fire("Alerta", "** Seleccionar Origen **", "warning");
    } else if(inputDestino.length == 0) {
        $("#inputDestino").focus();
        Swal.fire("Alerta", "** Seleccionar Destino **", "warning");
    } else if(inputCarga.length == 0) {
        $("#inputCarga").focus();
        Swal.fire("Alerta", "** Ingresar fecha Carga **", "warning");
    } else if(inputArribo.length == 0) {
        $("#inputArribo").focus();
        Swal.fire("Alerta", "** Ingresar fecha Arribo **", "warning");
    } else if(inputTrabajador == 0) {
        $("#inputTrabajador").focus();
        Swal.fire("Alerta", "** Seleccionar Trabajador **", "warning");
    } else if(inputGlosa.length == 0) {
        $("#inputGlosa").focus();
        Swal.fire("Alerta", "** Ingresar Glosa **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea Crear Viaje ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idServicio', idServicio);
                formData.append('idProducto', idProducto_items);
                formData.append('inputFlete', inputFlete);
                formData.append('inputOrigen', inputOrigen_items);
                formData.append('inputDestino', inputDestino_items);
                formData.append('inputDescarga', inputDescarga);
                formData.append('inputCarga', inputCarga);
                formData.append('inputArribo', inputArribo);
                formData.append('inputTrabajador', inputTrabajador);
                formData.append('inputAcompanante_items', inputAcompanante_items);
                formData.append('inputRampla', inputRampla);
                formData.append('inputMontoEstadia', inputMontoEstadia);
                formData.append('inputGlosa', inputGlosa);
                formData.append('inputGuia_items', inputGuia_items);
                formData.append('inputDescuento', inputDescuento);
                formData.append('tipos_estados_pagos', tipos_estados_pagos);
                formData.append('inputFechaPago', inputFechaPago);
                formData.append('clientes', clientes);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                    console.log(sec);
                  //location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function editar_flete(idFlete) {
    const url_link         = document.getElementById('url_link').value;
    var accion             = "editar_flete";

    var inputFlete         = document.getElementById('inputFlete').value;
    var inputOrigen        = document.getElementById('inputOrigen').value;
    var inputDestino       = document.getElementById('inputDestino').value;
    var inputCarga         = document.getElementById('inputCarga').value;
    var inputArribo        = document.getElementById('inputArribo').value;
    var inputDescarga      = document.getElementById('inputDescarga').value;
    var inputTrabajador    = document.getElementById('inputTrabajador').value;
    var inputRampla        = document.getElementById('inputProducto').value;
    var inputMontoEstadia  = document.getElementById('inputMontoEstadia').value;
    var inputGlosa         = document.getElementById('inputGlosa').value;
    var inputDescuento         = document.getElementById('inputDescuento').value;

    var tipos_estados_pagos         = document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago         = document.getElementById('inputFechaPago').value;
    var clientes         = document.getElementById('clientes').value;
    var inputGuia         = document.getElementById('inputGuia').value;


    var inputOrigen_items  = new Array();
    $('#inputOrigen option:selected').each(function(){
        inputOrigen_items.push($(this).val());
    });

    var inputDestino_items  = new Array();
    $('#inputDestino option:selected').each(function(){
        inputDestino_items.push($(this).val());
    });

    var inputAcompanante_items  = new Array();
    $('#inputAcompanante option:selected').each(function(){
        inputAcompanante_items.push($(this).val());
    });

    // var inputGuia_items = []; // Creamos un array vacío

    // // Recorremos todos los inputs de texto con name="inputGuia[]"
    // $('input[name="inputGuia[]"]').each(function () {
    //     // Obtenemos el valor del input y lo añadimos al array
    //     var valor = $(this).val().trim(); // .trim() elimina espacios en blanco
    //     if (valor !== "") { // Verificamos que no esté vacío
    //         inputGuia_items.push(valor);
    //     }
    // });

    var idProducto_items = []; // Creamos un array vacío

    // Recorremos todos los inputs de texto con name="idProducto[]"
    $('input[name="idProducto[]"]').each(function () {
        // Obtenemos el valor del input y lo añadimos al array
        var valor1 = $(this).val().trim(); // .trim() elimina espacios en blanco
        if (valor1 !== "") { // Verificamos que no esté vacío
            idProducto_items.push(valor1);
        }
    });

    if (inputFlete.length == 0) {
        $("#inputFlete").focus();
        Swal.fire("Alerta", "** Ingresar monto Flete **", "warning");
    } else if(inputOrigen.length == 0) {
        $("#inputOrigen").focus();
        Swal.fire("Alerta", "** Seleccionar Origen **", "warning");
    } else if(inputDestino.length == 0) {
        $("#inputDestino").focus();
        Swal.fire("Alerta", "** Seleccionar Destino **", "warning");
    } else if(inputCarga.length == 0) {
        $("#inputCarga").focus();
        Swal.fire("Alerta", "** Ingresar fecha Carga **", "warning");
    } else if(inputArribo.length == 0) {
        $("#inputArribo").focus();
        Swal.fire("Alerta", "** Ingresar fecha Arribo **", "warning");
    } else if(inputTrabajador == 0) {
        $("#inputTrabajador").focus();
        Swal.fire("Alerta", "** Seleccionar Trabajador **", "warning");
    } else if(inputGlosa.length == 0) {
        $("#inputGlosa").focus();
        Swal.fire("Alerta", "** Ingresar Glosa **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea editar Viaje ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('idProducto', idProducto_items);
                formData.append('inputFlete', inputFlete);
                formData.append('inputOrigen', inputOrigen_items);
                formData.append('inputDestino', inputDestino_items);
                formData.append('inputDescarga', inputDescarga);
                formData.append('inputCarga', inputCarga);
                formData.append('inputArribo', inputArribo);
                formData.append('inputTrabajador', inputTrabajador);
                formData.append('inputAcompanante_items', inputAcompanante_items);
                formData.append('inputRampla', inputRampla);
                formData.append('inputMontoEstadia', inputMontoEstadia);
                formData.append('inputGlosa', inputGlosa);
                formData.append('inputGuia_items', inputGuia);
                formData.append('inputDescuento', inputDescuento);
                formData.append('tipos_estados_pagos', tipos_estados_pagos);
                formData.append('inputFechaPago', inputFechaPago);
                formData.append('clientes', clientes);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  cargar_editar_flete(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function quitar_flete(idFlete) {
    const url_link         = document.getElementById('url_link').value;
    var accion             = "quitar_flete";

    Swal.fire({
          title:              'Desea quitar Flete ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  parent.location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}

function facturas_proveedores() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "facturas_proveedores";

    var idServicio  = document.getElementById('idServicio').value;

    $("#traer_menu").html('');
    $('#traer_menu').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_menu').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idServicio:idServicio});
}

function gastos_empresa() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "gastos_empresa";

    var idServicio  = document.getElementById('idServicio').value;

    $("#traer_menu").html('');
    $('#traer_menu').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_menu').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idServicio:idServicio});
}

function quitar_gasto(idGasto) {
    const url_link         = document.getElementById('url_link').value;
    var accion             = "quitar_gasto";

    Swal.fire({
          title:              'Desea quitar Gasto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idGasto', idGasto);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}

function obtener_informe(idServicio){
    const url_link  = document.getElementById('url_link').value;
    var accion      = "obtener_informe";

    window.open(url_link+"app/vistas/viajes/php/validador.php?accion="+accion+"&idServicio="+idServicio, '_BLANK');
}

function obtener_informe_edp(idEstadoPago){
    const url_link  = document.getElementById('url_link').value;
    var accion      = "obtener_informe_edp";

    window.open(url_link+"app/vistas/viajes/php/validador.php?accion="+accion+"&idEstadoPago="+idEstadoPago, '_BLANK');
}

function crear_servicio() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "crear_servicio";

    var codigo_servicio     = document.getElementById('codigo_servicio').value;
    var fecha_inicio        = document.getElementById('fecha_inicio').value;
    var fecha_termino       = document.getElementById('fecha_termino').value;
    var comentario_servicio = document.getElementById('comentario_servicio').value;
    var clientes            = document.getElementById('cotizaciones').value;

    if (clientes == 0) {
        $("#clientes").focus();
        Swal.fire("Alerta", "** Seleccionar Cotizacion **", "warning");
    } else if (comentario_servicio.length == 0) {
        $("#comentario_servicio").focus();
        Swal.fire("Alerta", "** Ingresar Comentario **", "warning");
    } else {

        Swal.fire({
          title:              'Desea Crear Servicio ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('codigo_servicio', codigo_servicio);
                formData.append('fecha_inicio', fecha_inicio);
                formData.append('fecha_termino', fecha_termino);
                formData.append('comentario_servicio', comentario_servicio);
                formData.append('clientes', clientes);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  parent.location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function mostrar_servicios_asignados() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "mostrar_servicios_asignados";

    var inputServicio  = new Array();
    $('#inputServicio option:selected').each(function(){
        inputServicio.push($(this).val());
    });

    if(inputServicio.length > 0){
        $("#resultado").html('');
        $('#resultado').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, inputServicio:inputServicio});
        
        $("#procesar").fadeIn(500);
    }
}

function procesar_edp() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "procesar_edp";

    var codigo_edp = document.getElementById('codigo_edp').value;
    var glosa      = document.getElementById('glosa').value;
    var fecha_pago = document.getElementById('fecha_pago').value;

    var inputServicio  = new Array();
    $('#inputServicio option:selected').each(function(){
        inputServicio.push($(this).val());
    });

    $("#procesar_edp").html('');
    $("#progressbar").hide();
    $('#procesar_edp').load(url_link+"/app/recursos/img/loader.svg");
    $('#procesar_edp').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, codigo_edp:codigo_edp, glosa:glosa, inputServicio:inputServicio, fecha_pago:fecha_pago});
}

function finalizar_edp() {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "finalizar_edp";

    var idEstadoPago        = document.getElementById('idEstadoPago').value;
    var fecha_pago          = document.getElementById('fecha_pago').value;
    var glosa               = document.getElementById('glosa').value;
    var neto                = document.getElementById('neto').value;
    var iva                 = document.getElementById('iva').value;
    var total_pagar         = document.getElementById('total_pagar').value;

    if (fecha_pago.length == 0) {
        $("#fecha_pago").focus();
        Swal.fire("Alerta", "** Ingresar Fecha Pagado **", "warning");
    } else if (glosa.length == 0) {
        $("#glosa").focus();
        Swal.fire("Alerta", "** Ingresar Glosa **", "warning");
    } else {
        Swal.fire({
          title:              'Desea realizar pago?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idEstadoPago', idEstadoPago);
                formData.append('fecha_pago', fecha_pago);
                formData.append('glosa', glosa);
                formData.append('neto', neto);
                formData.append('iva', iva);
                formData.append('total_pagar', total_pagar);
                formData.append('accion', accion);
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  parent.location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}


function nuevo_cliente_control() {
   const url_link  = document.getElementById('url_link').value;
    var accion      = "nuevo_cliente_control";

    $("#panel_caja").html('');
    $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion});
}

function grabar_nuevo_cliente_control(){
  var inputRazonSocial  = document.getElementById('inputRazonSocial').value;
  var inputGiro         = document.getElementById('inputGiro').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputTelefono     = document.getElementById('inputTelefono').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var inputDireccion    = document.getElementById('inputDireccion').value;
  var inputLocalidad    = document.getElementById('inputLocalidad').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_nuevo_cliente_control";

  if(inputRazonSocial.length == 0){
   $("#inputRazonSocial").focus();
    Swal.fire("Alerta", "** Ingresar Razon Social **", "warning");
  } else if(inputGiro.length == 0){
   $("#inputGiro").focus();
    Swal.fire("Alerta", "** Ingresar Giro **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputTelefono == 0) {
    $("#inputTelefono").focus();
    Swal.fire("Alerta", "** Ingresar Teléfono **", "warning");
  } else if(inputEmail.length == 0) {
    $("#inputEmail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  } else if(inputDireccion.length == 0) {
    $("#inputDireccion").focus();
    Swal.fire("Alerta", "** Ingresar Dirección **", "warning");
  } else if(inputLocalidad.length == 0) {
    $("#inputLocalidad").focus();
    Swal.fire("Alerta", "** Ingresar Localidad **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Crear cliente ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#panel_caja").html('');
          $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
          $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, inputRazonSocial:inputRazonSocial, inputGiro:inputGiro, inputRut:inputRut, inputTelefono:inputTelefono, inputEmail:inputEmail, inputDireccion:inputDireccion, inputLocalidad:inputLocalidad});
        }
    })
  } 
}

function traer_editar_cliente(idCliente) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_cliente";

  $("#editar_trabajador").html('');
  $('#editar_trabajador').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_trabajador').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCliente:idCliente});
}

function grabar_editar_cliente_control(idCliente){
  var inputRazonSocial  = document.getElementById('inputRazonSocial').value;
  var inputGiro         = document.getElementById('inputGiro').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputTelefono     = document.getElementById('inputTelefono').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var inputDireccion    = document.getElementById('inputDireccion').value;
  var inputLocalidad    = document.getElementById('inputLocalidad').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_editar_cliente_control";

  if(inputRazonSocial.length == 0){
   $("#inputRazonSocial").focus();
    Swal.fire("Alerta", "** Ingresar Razon Social **", "warning");
  } else if(inputGiro.length == 0){
   $("#inputGiro").focus();
    Swal.fire("Alerta", "** Ingresar Giro **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputTelefono == 0) {
    $("#inputTelefono").focus();
    Swal.fire("Alerta", "** Ingresar Teléfono **", "warning");
  } else if(inputEmail.length == 0) {
    $("#inputEmail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  } else if(inputDireccion.length == 0) {
    $("#inputDireccion").focus();
    Swal.fire("Alerta", "** Ingresar Dirección **", "warning");
  } else if(inputLocalidad.length == 0) {
    $("#inputLocalidad").focus();
    Swal.fire("Alerta", "** Ingresar Localidad **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Editar cliente ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#editar_trabajador").html('');
          $('#editar_trabajador').load(url_link+"/app/recursos/img/loader.svg");
          $('#editar_trabajador').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCliente:idCliente, inputRazonSocial:inputRazonSocial, inputGiro:inputGiro, inputRut:inputRut, inputTelefono:inputTelefono, inputEmail:inputEmail, inputDireccion:inputDireccion, inputLocalidad:inputLocalidad});
        }
    })
  } 
}

function quitar_cliente(idCliente){
    const url_link        = document.getElementById('url_link').value;
    var accion            = "quitar_cliente";

    Swal.fire({
          title:              'Desea quitar cliente ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#editar_trabajador").html('');
          $('#editar_trabajador').load(url_link+"/app/recursos/img/loader.svg");
          $('#editar_trabajador').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCliente:idCliente});
        }
    }) 
}

function crear_cotizacion() {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "crear_cotizacion";

    var codigo_servicio     = document.getElementById('codigo_servicio').value;
    var fecha_inicio        = document.getElementById('fecha_inicio').value;
    var fecha_termino       = document.getElementById('fecha_termino').value;
    var comentario_servicio = document.getElementById('comentario_servicio').value;
    var clientes            = document.getElementById('clientes').value;
    var descuentos          = document.getElementById('descuentos').value;

    var titulo              = document.getElementsByName('titulo[]');
    var unidad              = document.getElementsByName('unidad[]');
    var exento              = document.getElementsByName('exento[]');
    var monto               = document.getElementsByName('monto[]');

    var titulo_items        = "";
    var unidad_items        = "";
    var monto_items         = "";
    var exento_items        = "";
    var tot_monto           = 0;

    for (var loop   = 0; loop < monto.length; loop++) {
        var asssoc  = monto[loop];
        var corte   = exento[loop];
        const valor = asssoc.value;
        tot_monto   = parseInt(tot_monto)+parseInt(valor);
        monto_items = monto_items + "" + valor + ";";
    }

    for (var loop2   = 0; loop2 < titulo.length; loop2++) {
        var asssoc2  = titulo[loop2];
        titulo_items = titulo_items + "" + asssoc2.value + ";";
    }

    for (var loop3   = 0; loop3 < unidad.length; loop3++) {
        var asssoc3  = unidad[loop3];
        unidad_items = unidad_items + "" + asssoc3.value + ";";
    }

    for (var loop4   = 0; loop4 < unidad.length; loop4++) {
        var asssoc4  = exento[loop4];
        exento_items = exento_items + "" + asssoc4.value + ";";
    }

    if(clientes == 0){
        Swal.fire("Alerta", "** Debes seleccionar 1 cliente **", "warning");
    } else if(number_format(tot_monto) == 0){
        Swal.fire("Alerta", "** Debes ingresar almenos 1 Item **", "warning");
    }  else {
        Swal.fire({
              title:              'Atenci&oacute;n!',
              text:               'Estas realizando la cotizacion N°: '+ codigo_servicio +', Desea Continuar ?',
              showDenyButton:     false,
              showCancelButton:   true,
              confirmButtonText:  'SI',
              cancelButtonText:   'NO',
              icon:               'question',
        }).then((result) => {
            if (result.isConfirmed) {
              $("#panel_caja").html('');
              $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
              $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, codigo_servicio:codigo_servicio, fecha_inicio:fecha_inicio, fecha_termino:fecha_termino, comentario_servicio:comentario_servicio, clientes:clientes, titulo_items:titulo_items, unidad_items:unidad_items, monto_items:monto_items, exento_items:exento_items, descuentos:descuentos});
            }
        }) 
    }      
}

function agregar_items_cotizacion() {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "agregar_items_cotizacion";

    var codigo_cotizacion   = document.getElementById('codigo_cotizacion').value;

    var titulo              = document.getElementsByName('titulo[]');
    var unidad              = document.getElementsByName('unidad[]');
    var exento              = document.getElementsByName('exento[]');
    var monto               = document.getElementsByName('monto[]');

    var titulo_items        = "";
    var unidad_items        = "";
    var monto_items         = "";
    var exento_items        = "";
    var tot_monto           = 0;

    for (var loop   = 0; loop < monto.length; loop++) {
        var asssoc  = monto[loop];
        const valor = asssoc.value;
        tot_monto   = parseInt(tot_monto)+parseInt(valor);
        monto_items = monto_items + "" + valor + ";";
    }

    for (var loop2   = 0; loop2 < titulo.length; loop2++) {
        var asssoc2  = titulo[loop2];
        titulo_items = titulo_items + "" + asssoc2.value + ";";
    }

    for (var loop3   = 0; loop3 < unidad.length; loop3++) {
        var asssoc3  = unidad[loop3];
        unidad_items = unidad_items + "" + asssoc3.value + ";";
    }

    for (var loop4   = 0; loop4 < unidad.length; loop4++) {
        var asssoc4  = exento[loop4];
        exento_items = exento_items + "" + asssoc4.value + ";";
    }

    if(number_format(tot_monto) == 0){
        Swal.fire("Alerta", "** Debes ingresar almenos 1 Item **", "warning");
    }  else {
        Swal.fire({
              title:              'Atenci&oacute;n!',
              text:               'Desea grabar items a cotización ?',
              showDenyButton:     false,
              showCancelButton:   true,
              confirmButtonText:  'SI',
              cancelButtonText:   'NO',
              icon:               'question',
        }).then((result) => {
            if (result.isConfirmed) {
              $("#panel_caja").html('');
              $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
              $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, codigo_cotizacion:codigo_cotizacion, titulo_items:titulo_items, unidad_items:unidad_items, monto_items:monto_items, exento_items:exento_items});
            }
        }) 
    }      
}

function quitar_items_cotizacion(idCotizacion) {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "quitar_items_cotizacion";
    
    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea quitar items a cotización ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#panel_caja").html('');
          $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
          $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion});
        }
    })      
}

function aceptar_cotizacion(idCotizacion) {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "aceptar_cotizacion";
    
    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea Aceptar cotización ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#panel_caja").html('');
          $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
          $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion});
        }
    })      
}

function rechazar_cotizacion(idCotizacion) {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "rechazar_cotizacion";
    
    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea Rechazar cotización ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
          $("#panel_caja").html('');
          $('#panel_caja').load(url_link+"/app/recursos/img/loader.svg");
          $('#panel_caja').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion});
        }
    })      
}

function traer_editar_cotizacion(idCotizacion){
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_editar_cotizacion";
    
    $("#editar_cliente").html('');
    $('#editar_cliente').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_cliente').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion});  
}

function grabar_editar_cotizacion(idCotizacion) {
    const url_link          = document.getElementById('url_link').value;
    var accion              = "grabar_editar_cotizacion";

    var fecha_inicio        = document.getElementById('fecha_inicio').value;
    var fecha_termino       = document.getElementById('fecha_termino').value;
    var comentario_servicio = document.getElementById('comentario_servicio').value;
    var clientes            = document.getElementById('clientes').value;
    var descuentos          = document.getElementById('descuentos').value;

    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea editar cotización ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
            $("#editar_cliente").html('');
            $('#editar_cliente').load(url_link+"/app/recursos/img/loader.svg");
            $('#editar_cliente').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion, fecha_inicio:fecha_inicio, fecha_termino:fecha_termino, comentario_servicio:comentario_servicio, clientes:clientes, descuentos:descuentos});
        }
    })       
}

function traer_editar_items_cotizacion(idItems){
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_editar_items_cotizacion";
    
    $("#editar_items").html('');
    $('#editar_items').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_items').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idItems:idItems});  
}

function grabar_editar_items_cotizacion(idItems) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "grabar_editar_items_cotizacion";

    var titulo      = document.getElementById('titulo').value;
    var unidad      = document.getElementById('unidad').value;
    var monto       = document.getElementById('monto').value;
    var exento      = document.getElementById('exento').value;

    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea editar items ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
            $("#editar_cliente").html('');
            $('#editar_cliente').load(url_link+"/app/recursos/img/loader.svg");
            $('#editar_cliente').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idItems:idItems, titulo:titulo, unidad:unidad, monto:monto, exento:exento});
        }
    })       
}

function calcular_monto_valor(id) {
    var unidad      = document.getElementById('unidad'+id+'').value;
    var monto       = document.getElementById('monto'+id+'').value;
    

    if(unidad > 0 && monto > 0){
        var calculo = (unidad*monto);

        $("#total"+id+"").html(money_format(calculo));
    } else {
        $("#total"+id+"").html(money_format(0));
    }
}


function editar_edp(idEdp) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "editar_edp";

    $("#editar_edp").html('');
    $('#editar_edp').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_edp').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idEdp:idEdp}); 
}

function grabar_editar_edp(idEdp){
    const url_link  = document.getElementById('url_link').value;
    var accion      = "grabar_editar_edp";

    var codigo_edp  = document.getElementById('codigo_edp2').value;
    var fecha_pago  = document.getElementById('fecha_pago').value;
    var glosa       = document.getElementById('glosa').value;

    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea editar EDP ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
            $("#editar_edp").html('');
            $('#editar_edp').load(url_link+"/app/recursos/img/loader.svg");
            $('#editar_edp').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idEdp:idEdp, codigo_edp:codigo_edp, fecha_pago:fecha_pago, glosa:glosa});
        }
    }) 
}

function eliminar_edp(idEdp) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "eliminar_edp";

    Swal.fire({
        title:              'Atenci&oacute;n!',
        text:               'Desea eliminar EDP ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
            $("#editar_edp").html('');
            $('#editar_edp').load(url_link+"/app/recursos/img/loader.svg");
            $('#editar_edp').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idEdp:idEdp});
        }
    }) 
}

function ver_hijo(id) {
    $("#hijo"+id+"").toggle(100);
}

function mostrar_clientes() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "mostrar_clientes";

    var cliente_id  = document.getElementById('inputClienteId').value;


    $("#traer_productos_categoria").html('');
    $('#traer_productos_categoria').load(url_link+"app/recursos/img/loader.svg");
    $('#traer_productos_categoria').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, cliente_id:cliente_id});
}

function nuevo_documento_edp(idEstadoPago) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "nuevo_documento_edp";

  $("#panel_documentos").html('');
  $('#panel_documentos').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_documentos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idEstadoPago:idEstadoPago});
}

function subir_documento_servicios() {
  const url_link      = document.getElementById('url_link').value;
  var inputTitulo     = document.getElementById('inputTitulo').value;
  var idFlete         = document.getElementById('idFlete').value;
  var idTipoServicio  = document.getElementById('idTipoServicio').value;

  var foto            = ($('input[type="file"]'))[0].files[0]; 
  var archivo         = document.getElementById('input-b8').value;
  var accion          = "subir_documento_servicios";

  if(inputTitulo.length == 0){
   $("#inputTitulo").focus();
    Swal.fire("Alerta", "** Ingresar Titulo **", "warning");
  } else {
      Swal.fire({
        title:              'Desea subir documento ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
      }).then((result) => {

        if (result.isConfirmed) {

          if (archivo.length>0) {
            var tamano = foto.size > 5000000;

            if (tamano) {
                Swal.fire("Alerta", "Debes Cargar un archivo menor a 5 mb", "warning");
                return;
            }

            var data = new FormData();
                data.append("file", foto);
                data.append("accion", accion);
                data.append("archivo", archivo);
                data.append("inputTitulo", inputTitulo);
                data.append("idFlete", idFlete);
                data.append("idTipoServicio", idTipoServicio);

            $("#panel_documentos").html('');
            $('#panel_documentos').load(url_link+"/app/recursos/img/loader.svg");

            $.ajax({
                url:                    "validador.php",
                type:                   "POST",
                data :                  data,
                processData:            false,
                contentType:            false,

                success:   function(sec) {
                   Swal.fire({
                    title:              'Grabado Correctamente',
                    showDenyButton:     false,
                    showCancelButton:   false,
                    confirmButtonText:  'OK',
                    icon:               'success',
                  }).then((result) => {
                      location.reload();
                  })
                },

                error:     function(sec) {
                   Swal.fire({
                    title:              'Error Archivo',
                    showDenyButton:     false,
                    showCancelButton:   false,
                    confirmButtonText:  'OK',
                    icon:               'error',
                  }).then((result) => {
                      location.reload();
                  })
                }

            });
          } else {
            Swal.fire("Alerta", "Debes Cargar un archivo", "warning");
          }
        }
      })
  }
}

function quitar_documento_servicios(idDocu){
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_documento_servicios";

  Swal.fire({
          title:              'Quieres Quitar documento ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('idDocu', idDocu);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                    Swal.fire({
                      title:              'Realizado correctamente',
                      icon:               'success',
                      showDenyButton:     false,
                      showCancelButton:   false,
                      confirmButtonText:  'OK',
                      cancelButtonText:   'NO',
                    }).then((result) => {
                      location.reload();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function agregar_imagen_cotizacion(idCotizacion) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "agregar_imagen_cotizacion";

  $("#imagen_cotizacion").html('');
  $('#imagen_cotizacion').load(url_link+"/app/recursos/img/loader.svg");
  $('#imagen_cotizacion').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idCotizacion:idCotizacion});
}

function subir_documento_cotizacion() {
  const url_link      = document.getElementById('url_link').value;
  var inputTitulo     = document.getElementById('inputTitulo').value;
  var inputCotizacion = document.getElementById('inputCotizacion').value;

  var foto            = ($('input[type="file"]'))[0].files[0]; 
  var archivo         = document.getElementById('input-b8').value;
  var accion          = "subir_documento_cotizacion";

  if(inputTitulo.length == 0){
   $("#inputTitulo").focus();
    Swal.fire("Alerta", "** Ingresar Titulo **", "warning");
  } else {
      Swal.fire({
        title:              'Desea subir documento a EDP ?',
        showDenyButton:     false,
        showCancelButton:   true,
        confirmButtonText:  'SI',
        cancelButtonText:   'NO',
        icon:               'question',
      }).then((result) => {

        if (result.isConfirmed) {

          if (archivo.length>0) {
            var tamano = foto.size > 5000000;

            if (tamano) {
                Swal.fire("Alerta", "Debes Cargar un archivo menor a 5 mb", "warning");
                return;
            }

            var data = new FormData();
                data.append("file", foto);
                data.append("accion", accion);
                data.append("archivo", archivo);
                data.append("inputTitulo", inputTitulo);
                data.append("inputCotizacion", inputCotizacion);

            $("#imagen_cotizacion").html('');
            $('#imagen_cotizacion').load(url_link+"/app/recursos/img/loader.svg");

            $.ajax({
                url:                    "validador.php",
                type:                   "POST",
                data :                  data,
                processData:            false,
                contentType:            false,

                success:   function(sec) {
                   Swal.fire({
                    title:              'Grabado Correctamente',
                    showDenyButton:     false,
                    showCancelButton:   false,
                    confirmButtonText:  'OK',
                    icon:               'success',
                  }).then((result) => {
                      location.reload();
                  })
                },

                error:     function(sec) {
                   Swal.fire({
                    title:              'Error Archivo',
                    showDenyButton:     false,
                    showCancelButton:   false,
                    confirmButtonText:  'OK',
                    icon:               'error',
                  }).then((result) => {
                      location.reload();
                  })
                }

            });
          } else {
            Swal.fire("Alerta", "Debes Cargar un archivo", "warning");
          }
        }
      })
  }

}

function asignar_traslados() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "asignar_traslados";

    var idServicio  = '';

    $("#traer_traslados").html('');
    $('#traer_traslados').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_traslados').load(url_link+"app/vistas/viajes/php/nuevo_traslados.php", {accion:accion, idServicio:idServicio});
}

function asignar_arriendo() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "asignar_arriendo";

    var idServicio  = "";

    $("#traer_arriendos").html('');
    $('#traer_arriendos').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_arriendos').load(url_link+"app/vistas/viajes/php/nuevo_arriendo.php", {accion:accion, idServicio:idServicio});
}

function agregar_fechas() {
    var inputCantidad  = document.getElementById('inputCantidad').value;

    if (inputCantidad > 0) {
         $('#cantidad_fechas').html("");
        for (var i = 1; i <= inputCantidad; i++) {
            $('#cantidad_fechas').append('<div class="col-6 p-2 border" id="row'+i+'"><input type="date" name="inputFecha[]" placeholder="Fecha" class="form-control name_list" /></div>');
        }
    } else {
        
    }
}

function agregar_fechas_edit() {
    var inputCantidad  = document.getElementById('inputCantidad').value;
    var inputFecha     = document.getElementsByName('inputFecha[]');

    total = (inputCantidad-inputFecha.length);

    if (inputCantidad > 0) {
        for (var i = 1; i <= total; i++) {
            $('#cantidad_fechas').append('<div class="col-6 p-2 border" id="row'+i+'"><input type="date" name="inputFecha[]" placeholder="Fecha" class="form-control name_list" /></div>');
        }
    } else {
        
    }
}

function calcular_valor_item_arriendo(item) {
    var hrs_realizadas    = document.getElementById('hrs_realizadas'+item).value;
    var valor_hora        = document.getElementById('valor_hora'+item).value;

    if (hrs_realizadas > 0 || valor_hora > 0) {
        var calculo = (hrs_realizadas*valor_hora);

        $("#total_item"+item).html(money_format(calculo));
    }
}

function grabar_nuevo_arriendo(idServicio) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_nuevo_arriendo";

    var inputTipoServicio   = document.getElementById('inputTipoServicio').value;
    var inputProyecto       = document.getElementById('inputProyecto').value;
    var inputContacto       = document.getElementById('inputContacto').value;
    var mes                 = document.getElementById('mes').value;
    var inputDescripcion    = document.getElementById('inputDescripcion').value;

    var tipos_estados_pagos = document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago      = document.getElementById('inputFechaPago').value;
    var clientes            = document.getElementById('clientes').value;


    var camion              = document.getElementsByName('camion[]');
    var hors_contratadas    = document.getElementsByName('hors_contratadas[]');
    var valor_hora          = document.getElementsByName('valor_hora[]');
    var hrs_realizadas      = document.getElementsByName('hrs_realizadas[]');

    var camion_items        = "";
    var hors_contrata_items = "";
    var valor_items         = "";
    var hr_realizada_items  = "";

    for (var loop   = 0; loop < camion.length; loop++) {
        var asssoc  = camion[loop];
        const valor = asssoc.value;

        camion_items = camion_items + "" + valor + ";";
    }

    for (var loop2   = 0; loop2 < hors_contratadas.length; loop2++) {
        var asssoc2  = hors_contratadas[loop2];
        const valor2 = asssoc2.value;

        hors_contrata_items = hors_contrata_items + "" + valor2 + ";";
    }

    for (var loop3   = 0; loop3 < valor_hora.length; loop3++) {
        var asssoc3  = valor_hora[loop3];
        const valor3 = asssoc3.value;

        valor_items  = valor_items + "" + valor3 + ";";
    }

    for (var loop4   = 0; loop4 < hrs_realizadas.length; loop4++) {
        var asssoc4  = hrs_realizadas[loop4];
        const valor4 = asssoc4.value;

        hr_realizada_items  = hr_realizada_items + "" + valor4 + ";";
    }

    if (inputTipoServicio.length == 0) {
        $("#inputTipoServicio").focus();
        Swal.fire("Alerta", "** Ingresar Tipo Servicio **", "warning");
    } else if(inputProyecto.length == 0) {
        $("#inputProyecto").focus();
        Swal.fire("Alerta", "** Ingresar Proyecto **", "warning");
    } else if(inputContacto.length == 0) {
        $("#inputContacto").focus();
        Swal.fire("Alerta", "** Ingresar Contacto **", "warning");
    } else if(mes == 0) {
        $("#mes").focus();
        Swal.fire("Alerta", "** Seleccionar mes **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea Crear Arriendo ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI', 
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idServicio', idServicio);
                formData.append('inputTipoServicio', inputTipoServicio);
                formData.append('inputProyecto', inputProyecto);
                formData.append('inputContacto', inputContacto);
                formData.append('mes', mes);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('camion_items', camion_items);
                formData.append('hors_contrata_items', hors_contrata_items);
                formData.append('valor_items', valor_items);
                formData.append('hr_realizada_items', hr_realizada_items);

                formData.append('tipos_estados_pagos', tipos_estados_pagos);
                formData.append('inputFechaPago', inputFechaPago);
                formData.append('clientes', clientes);

                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  parent.location.reload();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function agregar_arriendo() {
    const url_link = document.getElementById('url_link').value;

    var camion              = document.getElementsByName('camion[]');

    var resultado    =  $.ajax({
                                url:       url_link+"app/vistas/viajes/php/validador.php",
                                type:      'POST', // o 'POST',
                                async:     false,    
                                cache:     false, 
                                data:      { accion: "traer_listado_camion"},
                                dataType:  'json',
                                success: function(datos) {
                                    return datos;
                                }
                            });

    i = (camion.length)+1;
    $('#listar_productos').append('<tr id="row'+i+'"><td>'+resultado.responseText+'</td><td><input type="number" name="hors_contratadas[]" placeholder="Horas Contratadas" class="form-control titulo_list" /></td><td><input type="number" name="valor_hora[]" placeholder="Valor horas" class="form-control titulo_list" id="valor_hora'+i+'" onchange="calcular_valor_item_arriendo('+i+')" /></td><td><input type="number" name="hrs_realizadas[]" placeholder="Horas realizadas" class="form-control titulo_list" id="hrs_realizadas'+i+'"  onchange="calcular_valor_item_arriendo('+i+')"/></td><td><span id="total_item'+i+'" class="text-dark"></span></td><td><span class="fas fa-trash text-danger cursor btn_remove" name="remove" id="'+i+'" onClick="quitar_arriendo('+i+')"></span></td></tr>');
}

function quitar_arriendo(id) {
    $('#row'+id+'').remove();
}

function editar_arriendo(idArriendo) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "editar_arriendo";

    var inputTipoServicio   = document.getElementById('inputTipoServicio').value;
    var inputProyecto       = document.getElementById('inputProyecto').value;
    var inputContacto       = document.getElementById('inputContacto').value;
    var mes                 = document.getElementById('mes').value;
    var inputDescripcion    = document.getElementById('inputDescripcion').value;

    var camion              = document.getElementsByName('camion[]');
    var hors_contratadas    = document.getElementsByName('hors_contratadas[]');
    var valor_hora          = document.getElementsByName('valor_hora[]');
    var hrs_realizadas      = document.getElementsByName('hrs_realizadas[]');

    var camion_items        = "";
    var hors_contrata_items = "";
    var valor_items         = "";
    var hr_realizada_items  = "";

    for (var loop   = 0; loop < camion.length; loop++) {
        var asssoc  = camion[loop];
        const valor = asssoc.value;

        camion_items = camion_items + "" + valor + ";";
    }

    for (var loop2   = 0; loop2 < hors_contratadas.length; loop2++) {
        var asssoc2  = hors_contratadas[loop2];
        const valor2 = asssoc2.value;

        hors_contrata_items = hors_contrata_items + "" + valor2 + ";";
    }

    for (var loop3   = 0; loop3 < valor_hora.length; loop3++) {
        var asssoc3  = valor_hora[loop3];
        const valor3 = asssoc3.value;

        valor_items  = valor_items + "" + valor3 + ";";
    }

    for (var loop4   = 0; loop4 < hrs_realizadas.length; loop4++) {
        var asssoc4  = hrs_realizadas[loop4];
        const valor4 = asssoc4.value;

        hr_realizada_items  = hr_realizada_items + "" + valor4 + ";";
    }

    if (inputTipoServicio.length == 0) {
        $("#inputTipoServicio").focus();
        Swal.fire("Alerta", "** Ingresar Tipo Servicio **", "warning");
    } else if(inputProyecto.length == 0) {
        $("#inputProyecto").focus();
        Swal.fire("Alerta", "** Ingresar Proyecto **", "warning");
    } else if(inputContacto.length == 0) {
        $("#inputContacto").focus();
        Swal.fire("Alerta", "** Ingresar Contacto **", "warning");
    } else if(mes == 0) {
        $("#mes").focus();
        Swal.fire("Alerta", "** Seleccionar mes **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea Editar Arriendo ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI', 
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idArriendo', idArriendo);
                formData.append('inputTipoServicio', inputTipoServicio);
                formData.append('inputProyecto', inputProyecto);
                formData.append('inputContacto', inputContacto);
                formData.append('mes', mes);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('camion_items', camion_items);
                formData.append('hors_contrata_items', hors_contrata_items);
                formData.append('valor_items', valor_items);
                formData.append('hr_realizada_items', hr_realizada_items);
            
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  location.reload();
                  parent.asignar_arriendo();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}




function facturas_clientes() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "facturas_clientes";

    var idServicio  = document.getElementById('idServicio').value;

    $("#traer_menu").html('');
    $('#traer_menu').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_menu').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idServicio:idServicio});
}


function agregarInputGuia() {
  // Obtenemos el contenedor principal donde se agregarán los inputs
  const contenedorInputs = document.getElementById("contenedorInputs");

  // Creamos el contenedor de la fila (row)
  const row = document.createElement("div");
  row.className = "row mb-2"; // Usamos 'row' y margen inferior para separación

  // Columna para el input
  const colInput = document.createElement("div");
  colInput.className = "col";

  const inputGuia = document.createElement("input");
  inputGuia.type = "text";
  inputGuia.className = "form-control";
  inputGuia.name = "inputGuia[]";
  inputGuia.placeholder = "N° Guia";
  inputGuia.autocomplete = "off";

  // Columna para el ícono de eliminar
  const colIcono = document.createElement("div");
  colIcono.className = "col-1 pt-2";

  const iconoEliminar = document.createElement("i");
  iconoEliminar.className = "bi bi-x-circle-fill cursor text-danger";
  iconoEliminar.style.cursor = "pointer";

  // Evento para eliminar la fila completa
  iconoEliminar.addEventListener("click", function () {
    row.remove(); // Elimina la fila completa
  });

  // Estructura: añadimos input y el ícono dentro del row
  colInput.appendChild(inputGuia);
  colIcono.appendChild(iconoEliminar);
  row.appendChild(colInput);
  row.appendChild(colIcono);

  // Agregamos la fila directamente al contenedor principal
  contenedorInputs.appendChild(row);
}

function calcular_valor_viaje(){
    var inputFlete      = document.getElementById('inputFlete').value;
    var inputDescuento  = document.getElementById('inputDescuento').value;
    var inputMontoEstadia = document.getElementById('inputMontoEstadia').value;

    if (parseInt(inputFlete) > 0 && parseInt(inputDescuento) <= parseInt(inputFlete)) {
        total = (parseInt(inputFlete)+parseInt(inputMontoEstadia))-parseInt(inputDescuento);
        $("#total-viaje").html(money_format(total));
    }
}

function calcular_fecha_pago(){
    var estados_pagos  = document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago = document.getElementById('inputFechaPago').value;

    if (estados_pagos > 0 && estados_pagos != 1) {

        if (estados_pagos == 2) {
            dias = 15;
        } else if (estados_pagos == 3) {
            dias = 30;
        } else if (estados_pagos == 4) {
            dias = 60;
        } else if (estados_pagos == 5) {
            dias = 90;
        }

        const nuevaFecha = new Date(inputFechaPago); // Crea una nueva instancia de Date
        nuevaFecha.setDate(nuevaFecha.getDate() + dias); // Suma los días
        $("#respuesta-pago").html("Fecha Próxima de pago: "+nuevaFecha.toLocaleDateString());

    } else {
        $("#respuesta-pago").html("");
    }
}


function traer_nuevo_documento(idTrabajador) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_nuevo_documento";

  $("#panel_documentos").html('');
  $('#panel_documentos').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_documentos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idTrabajador:idTrabajador});
}

function nueva_bitacora(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_bitacora";

    $("#panel_bitacora").html('');
    $('#panel_bitacora').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_bitacora').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_bitacora(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_bitacora";

    var inputTitulo       = document.getElementById('inputTitulo').value;
    var inputDescripcion  = document.getElementById('inputDescripcion').value;
    var inputFecha        = document.getElementById('inputFecha').value;

    if (inputTitulo.length == 0) {
        $("#inputTitulo").focus();
        Swal.fire("Alerta", "** Ingresar Título **", "warning");
    } else if(inputDescripcion.length == 0) {
        $("#inputDescripcion").focus();
        Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea agregar nota ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputTitulo', inputTitulo);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha', inputFecha);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  cargar_bitacora(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function cargar_bitacora(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "cargar_bitacora";

    $("#panel_bitacora").html('');
    $('#panel_bitacora').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_bitacora').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function cargar_editar_flete(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "cargar_editar_flete";

    $("#panel_editar").html('');
    $('#panel_editar').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_editar').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_panel_pagos(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_panel_pagos";

    $("#panel_de_pagos").html('');
    $('#panel_de_pagos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_de_pagos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_nuevo_abono(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_nuevo_abono";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_abono(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_abono";

    var inputFecha       = document.getElementById('inputFecha').value;
    var inputDescripcion = document.getElementById('inputDescripcion').value;
    var inputAbono       = document.getElementById('inputAbono').value;
    var tipo_dte         = document.getElementById('tipo_dte').value;
    var nuevo_total      = document.getElementById('nuevo_total').value;

    if (inputAbono == 0) {
        $("#inputAbono").focus();
        Swal.fire("Alerta", "** Ingresar Abono **", "warning");
    } else if(inputDescripcion.length == 0) {
        $("#inputDescripcion").focus();
        Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
    }  else if(parseInt(nuevo_total) < parseInt(inputAbono)) {
        $("#inputAbono").focus();
        Swal.fire("Alerta", "** Ingresar Abono Menor al monto Total **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea agregar Abono ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputAbono', inputAbono);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha', inputFecha);
                formData.append('tipo_dte', tipo_dte);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_panel_pagos(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function quitar_abono(idAbono, idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "quitar_abono";

    Swal.fire({
          title:              '¿ Desea quitar Abono ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idAbono', idAbono);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_panel_pagos(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}

function traer_procesar_pago(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_procesar_pago";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function quitar_bitacora(idBitacora, idServicio, tipo_servicio) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "quitar_bitacora";

    Swal.fire({
          title:              '¿ Desea quitar nota ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idBitacora', idBitacora);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                    if (tipo_servicio == 1) {
                        cargar_bitacora(idServicio);
                    } else if (tipo_servicio == 2) {
                        cargar_bitacora_traslados(idServicio);
                    }
                  
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}

function grabar_pago(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_pago";

    var inputFecha       = document.getElementById('inputFecha').value;
    var inputMonto       = document.getElementById('inputMonto').value;
    var tipo_dte         = document.getElementById('tipo_dte').value;
    var nuevo_total      = document.getElementById('nuevo_total').value;

    if (inputMonto == 0) {
        $("#inputMonto").focus();
        Swal.fire("Alerta", "** Ingresar Monto **", "warning");
    } else if(parseInt(nuevo_total) < parseInt(inputMonto)) {
        $("#inputMonto").focus();
        Swal.fire("Alerta", "** Ingresar Abono Menor al monto Total **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea procesar Pago ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputMonto', inputMonto);
                formData.append('inputFecha', inputFecha);
                formData.append('tipo_dte', tipo_dte);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                    $("#panel_montos_up").hide();
                    $("#traer_nuevo_abono").hide();
                    $("#traer_procesar_pago").hide();
                  traer_finalizar_pagos(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function traer_finalizar_pagos(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_finalizar_pagos";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_traslados() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_traslados";

    $("#traer_traslados").html('');
    $('#traer_traslados').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_traslados').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion});
}


function grabar_nuevo_traslado(idServicio) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_nuevo_traslado";

    var inputOrigen        = document.getElementById('inputOrigen').value;
    var inputDestino       = document.getElementById('inputDestino').value;
    var inputRegreso       = document.getElementById('inputRegreso').value;
    var inputValor         = document.getElementById('inputValor').value;
    var inputCantidad      = document.getElementById('inputCantidad').value;
    var inputDescripcion   = document.getElementById('inputDescripcion').value;

    var inputTrabajador    = document.getElementById('inputTrabajador').value;
    var tipos_estados_pagos= document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago     = document.getElementById('inputFechaPago').value;
    var clientes           = document.getElementById('clientes').value;
    var productos           = document.getElementById('productos').value;

    var inputFecha         = document.getElementsByName('inputFecha[]');
    var inputFecha_items   = "";

    for (var loop   = 0; loop < inputFecha.length; loop++) {
        var asssoc  = inputFecha[loop];
        const valor = asssoc.value;

        inputFecha_items = inputFecha_items + "" + valor + ";";
    }

    var inputAcompanante_items  = new Array();
    $('#inputAcompanante option:selected').each(function(){
        inputAcompanante_items.push($(this).val());
    });

    if (inputOrigen == 0) {
        $("#inputOrigen").focus();
        Swal.fire("Alerta", "** Ingresar Origen **", "warning");
    } else if(inputDestino == 0) {
        $("#inputGuia").focus();
        Swal.fire("Alerta", "** Ingresar Destino **", "warning");
    } else if(inputValor == 0) {
        $("#inputValor").focus();
        Swal.fire("Alerta", "** Ingresar Valor **", "warning");
    } else if(inputCantidad == 0) {
        $("#inputCantidad").focus();
        Swal.fire("Alerta", "** ingresar Cantidad **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea Crear Traslado ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idServicio', idServicio);
                formData.append('inputOrigen', inputOrigen);
                formData.append('inputDestino', inputDestino);
                formData.append('inputRegreso', inputRegreso);
                formData.append('inputValor', inputValor);
                formData.append('inputCantidad', inputCantidad);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha_items', inputFecha_items);
                formData.append('inputTrabajador', inputTrabajador);
                formData.append('tipos_estados_pagos', tipos_estados_pagos);
                formData.append('inputFechaPago', inputFechaPago);
                formData.append('clientes', clientes);
                formData.append('inputAcompanante', inputAcompanante_items);
                formData.append('productos', productos);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_traslados();
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function editar_traslado(idTraslado) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "editar_traslado";

    var inputOrigen        = document.getElementById('inputOrigen').value;
    var inputDestino       = document.getElementById('inputDestino').value;
    var inputRegreso       = document.getElementById('inputRegreso').value;
    var inputValor         = document.getElementById('inputValor').value;
    var inputCantidad      = document.getElementById('inputCantidad').value;
    var inputDescripcion   = document.getElementById('inputDescripcion').value;
    var productos           = document.getElementById('productos').value;

    var inputFecha         = document.getElementsByName('inputFecha[]');

    var inputFecha_items   = "";

    for (var loop   = 0; loop < inputFecha.length; loop++) {
        var asssoc  = inputFecha[loop];
        const valor = asssoc.value;

        inputFecha_items = inputFecha_items + "" + valor + ";";
    }

    var inputTrabajador         = document.getElementById('inputTrabajador').value;
    var tipos_estados_pagos     = document.getElementById('tipos_estados_pagos').value;
    var inputFechaPago          = document.getElementById('inputFechaPago').value;
    var clientes                = document.getElementById('clientes').value;
    var inputAcompanante_items  = new Array();

    $('#inputAcompanante option:selected').each(function(){
        inputAcompanante_items.push($(this).val());
    });

    if (inputOrigen == 0) {
        $("#inputOrigen").focus();
        Swal.fire("Alerta", "** Ingresar Origen **", "warning");
    } else if(inputDestino == 0) {
        $("#inputGuia").focus();
        Swal.fire("Alerta", "** Ingresar Destino **", "warning");
    } else if(inputValor == 0) {
        $("#inputValor").focus();
        Swal.fire("Alerta", "** Ingresar Valor **", "warning");
    } else if(inputCantidad == 0) {
        $("#inputCantidad").focus();
        Swal.fire("Alerta", "** ingresar Cantidad **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea Editar Traslado ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idTraslado', idTraslado);
                formData.append('inputOrigen', inputOrigen);
                formData.append('inputDestino', inputDestino);
                formData.append('inputRegreso', inputRegreso);
                formData.append('inputValor', inputValor);
                formData.append('inputCantidad', inputCantidad);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha_items', inputFecha_items);

                formData.append('inputTrabajador', inputTrabajador);
                formData.append('tipos_estados_pagos', tipos_estados_pagos);
                formData.append('inputFechaPago', inputFechaPago);
                formData.append('clientes', clientes);
                formData.append('inputAcompanante', inputAcompanante_items);
                formData.append('productos', productos);
                
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_traslados_editar(idTraslado);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function anular_traslado(idTraslado) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "anular_traslado";

    Swal.fire({
          title:              '¿ Desea Anular Traslado ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idTraslado', idTraslado);                
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_traslados_editar(idTraslado);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}


function traer_traslados_editar(idTraslado) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_traslados";

    $("#panel_editar").html('');
    $('#panel_editar').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_editar').load(url_link+"app/vistas/viajes/php/editar_traslados.php", {accion:accion, idTraslado:idTraslado});
}

function nueva_bitacora_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_bitacora_traslados";

    $("#panel_bitacora").html('');
    $('#panel_bitacora').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_bitacora').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_bitacora_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_bitacora_traslados";

    var inputTitulo       = document.getElementById('inputTitulo').value;
    var inputDescripcion  = document.getElementById('inputDescripcion').value;
    var inputFecha        = document.getElementById('inputFecha').value;

    if (inputTitulo.length == 0) {
        $("#inputTitulo").focus();
        Swal.fire("Alerta", "** Ingresar Título **", "warning");
    } else if(inputDescripcion.length == 0) {
        $("#inputDescripcion").focus();
        Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea agregar nota ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputTitulo', inputTitulo);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha', inputFecha);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  cargar_bitacora_traslados(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function cargar_bitacora_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "cargar_bitacora_traslados";

    $("#panel_bitacora").html('');
    $('#panel_bitacora').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_bitacora').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_nuevo_abono_traslado(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_nuevo_abono_traslado";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_abono_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_abono_traslados";

    var inputFecha       = document.getElementById('inputFecha').value;
    var inputDescripcion = document.getElementById('inputDescripcion').value;
    var inputAbono       = document.getElementById('inputAbono').value;
    var tipo_dte         = document.getElementById('tipo_dte').value;
    var nuevo_total      = document.getElementById('nuevo_total').value;

    if (inputAbono == 0) {
        $("#inputAbono").focus();
        Swal.fire("Alerta", "** Ingresar Abono **", "warning");
    } else if(inputDescripcion.length == 0) {
        $("#inputDescripcion").focus();
        Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
    }  else if(parseInt(nuevo_total) < parseInt(inputAbono)) {
        $("#inputAbono").focus();
        Swal.fire("Alerta", "** Ingresar Abono Menor al monto Total **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea agregar Abono ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputAbono', inputAbono);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha', inputFecha);
                formData.append('tipo_dte', tipo_dte);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_panel_pagos_traslados(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function quitar_abono_traslados(idAbono, idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "quitar_abono";

    Swal.fire({
          title:              '¿ Desea quitar Abono ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idAbono', idAbono);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  traer_panel_pagos_traslados(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
}

function traer_panel_pagos_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_panel_pagos_traslados";

    $("#panel_de_pagos").html('');
    $('#panel_de_pagos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_de_pagos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_procesar_pago_traslado(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_procesar_pago_traslado";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_pago_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_pago_traslados";

    var inputFecha       = document.getElementById('inputFecha').value;
    var inputMonto       = document.getElementById('inputMonto').value;
    var tipo_dte         = document.getElementById('tipo_dte').value;
    var nuevo_total      = document.getElementById('nuevo_total').value;

    if (inputMonto == 0) {
        $("#inputMonto").focus();
        Swal.fire("Alerta", "** Ingresar Monto **", "warning");
    } else if(parseInt(nuevo_total) < parseInt(inputMonto)) {
        $("#inputMonto").focus();
        Swal.fire("Alerta", "** Ingresar Abono Menor al monto Total **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea procesar Pago ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputMonto', inputMonto);
                formData.append('inputFecha', inputFecha);
                formData.append('tipo_dte', tipo_dte);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                    $("#panel_montos_up").hide();
                    $("#traer_nuevo_abono").hide();
                    $("#traer_procesar_pago").hide();
                  traer_finalizar_pagos_traslados(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}

function traer_finalizar_pagos_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_finalizar_pagos_traslados";

    $("#panel_montos").html('');
    $('#panel_montos').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_montos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function traer_arriendos() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_arriendos";

    $("#traer_arriendos").html('');
    $('#traer_arriendos').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_arriendos').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion});
}

function traer_arriendos_editar(idTraslado) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "traer_traslados";

    $("#panel_editar").html('');
    $('#panel_editar').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_editar').load(url_link+"app/vistas/viajes/php/editar_arriendo.php", {accion:accion, idArriendo:idTraslado});
}

function nueva_bitacora_traslados(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "nueva_bitacora_traslados";

    $("#panel_bitacora").html('');
    $('#panel_bitacora').load(url_link+"/app/recursos/img/loader.svg");
    $('#panel_bitacora').load(url_link+"app/vistas/viajes/php/validador.php", {accion:accion, idFlete:idFlete});
}

function grabar_bitacora_arriendos(idFlete) {
    const url_link = document.getElementById('url_link').value;
    var accion     = "grabar_bitacora_arriendos";

    var inputTitulo       = document.getElementById('inputTitulo').value;
    var inputDescripcion  = document.getElementById('inputDescripcion').value;
    var inputFecha        = document.getElementById('inputFecha').value;

    if (inputTitulo.length == 0) {
        $("#inputTitulo").focus();
        Swal.fire("Alerta", "** Ingresar Título **", "warning");
    } else if(inputDescripcion.length == 0) {
        $("#inputDescripcion").focus();
        Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
    } else if(inputFecha.length == 0) {
        $("#inputFecha").focus();
        Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
    } else {

        Swal.fire({
          title:              '¿ Desea agregar nota ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
        }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idFlete', idFlete);
                formData.append('inputTitulo', inputTitulo);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('inputFecha', inputFecha);
                formData.append('accion', accion);
              
            $.ajax({
              url:         url_link+"app/vistas/viajes/php/validador.php",
              type:        "POST",
              data :       formData,
              processData: false,
              contentType: false,
              success:     function(sec) {
                Swal.fire({
                  title:              'Registro Realizado correctamente',
                  icon:               'success',
                  showDenyButton:     false,
                  showCancelButton:   false,
                  confirmButtonText:  'OK',
                  cancelButtonText:   'NO',
                }).then((result) => {
                  cargar_bitacora_traslados(idFlete);
                })  
              },
              error:       function(sec) {
                Swal.fire("Error", "Error", "error");
              }
            });
          }
        })
    }
}