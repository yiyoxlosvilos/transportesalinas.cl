$(document).ready(function() {
    $('#productos_list').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 20
       });
});

function gastos_empresa() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "gastos_empresa";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}

function buscar_gastos_empresa() {
    const url_link  = document.getElementById('url_link').value;
    var mes         = document.getElementById('mes').value;
    var ano         = document.getElementById('ano').value;
    var accion      = "buscar_gastos_empresa";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, mes:mes, ano:ano});
}

function facturas_proveedores() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "facturas_proveedores";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}

function buscar_facturas_proveedores() {
    const url_link  = document.getElementById('url_link').value;
    var mes         = document.getElementById('mes').value;
    var ano         = document.getElementById('ano').value;
    var accion      = "buscar_facturas_proveedores";

    $("#traer_facturas").html('');
    $('#traer_facturas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_facturas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, mes:mes, ano:ano});
}

function buscar_pagos_pendientes() {
	const url_link 	= document.getElementById('url_link').value;
    var mes  		= document.getElementById('mes').value;
    var ano 		= document.getElementById('ano').value;
    var accion      = "buscar_pagos_pendientes";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, mes:mes, ano:ano});
}

function detalles_pagos_pendientes(boleta) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "detalles_pagos_pendientes";

    $("#traer_productos_boleta").html('');
    $('#traer_productos_boleta').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_productos_boleta').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, boleta:boleta});
}

function nueva_categoria(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nueva_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}

function crear_categoria() {
  var inputNombre = document.getElementById('inputNombre').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "crear_categoria";

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear Categoria ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('inputNombre', inputNombre);
                formData.append('accion', accion);
              
            $.ajax({
              url:         "../../finanzas/php/validador_finanzas.php",
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
}

function editar_categoria(idCategoria){
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idCategoria:idCategoria});
}

function grabar_editar_categoria(idCategoria) {
  var inputNombre = document.getElementById('inputNombre').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_editar_categoria";

  if(inputNombre.length == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else{

    Swal.fire({
      title:              'Desea Editar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('inputNombre', inputNombre);
            formData.append('idCategoria', idCategoria);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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
}

function desactivar_categoria(idCategoria) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "desactivar_categoria";

   Swal.fire({
      title:              'Desea Desactivar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idCategoria', idCategoria);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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

function nuevo_tipo_categoria(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nuevo_tipo_categoria";

  $("#nueva_marca").html('');
  $('#nueva_marca').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_marca').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}

function crear_tipo_categoria() {
  var inputNombre = document.getElementById('inputNombre').value;
  var tipo_gastos = document.getElementById('tipo_gastos').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "crear_tipo_categoria";

  if(inputNombre.length == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear tipo Categoria ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('inputNombre', inputNombre);
                formData.append('tipo_gastos', tipo_gastos);
                formData.append('accion', accion);
              
            $.ajax({
              url:         "../../finanzas/php/validador_finanzas.php",
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
}

function editar_categoria_tipo(tipo_gastos){
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_categoria_tipo";

  $("#nueva_marca").html('');
  $('#nueva_marca').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_marca').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, tipo_gastos:tipo_gastos});
}


function grabar_editar_categoria_tipo(idTipo) {
  var inputNombre = document.getElementById('inputNombre').value;
  var tipo_gastos = document.getElementById('tipo_gastos').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_editar_categoria_tipo";

  if(inputNombre.length == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }if(tipo_gastos == 0){
    $("#tipo_gastos").focus();
    Swal.fire("Alerta", "** Elegir Categoria **", "warning");
  }else{

    Swal.fire({
      title:              'Desea Editar tipo ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('inputNombre', inputNombre);
            formData.append('tipo_gastos', tipo_gastos);
            formData.append('idTipo', idTipo);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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
}

function desactivar_categoria_tipo(idCategoria) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "desactivar_categoria_tipo";

   Swal.fire({
      title:              'Desea Desactivar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idCategoria', idCategoria);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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

function combo_select_categoria() {
  var tipo_gastos = document.getElementById('tipo_gastos').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "combo_select_categoria";

  $("#tipo_gastos_ver").html('');
  $('#tipo_gastos_ver').load(url_link+"/app/recursos/img/loader.svg");
  $('#tipo_gastos_ver').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, tipo_gastos:tipo_gastos});
}

function grabar_nuevo_gasto(idServicio) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_nuevo_gasto";

  var inputNombre             = document.getElementById('inputNombre').value;
  var inputPrecio             = document.getElementById('inputPrecio').value;
  var tipo_gastos             = document.getElementById('tipo_gastos').value;
  var tipo_gastos_categorias  = document.getElementById('tipo_gastos_categorias').value;
  var inputSucursal           = document.getElementById('inputSucursal').value;
  var inputDescripcion        = document.getElementById('inputDescripcion').value;
  var inputFecha              = document.getElementById('inputFecha').value;

  var tipo_servicio           = document.getElementById('tipo_servicio').value;
  var servicio_cliente        = document.getElementById('servicio_cliente').value;
  var servicio_prestado       = document.getElementById('servicio_prestado').value;


  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputPrecio == 0){
    $("#inputPrecio").focus();
    Swal.fire("Alerta", "** Seleccionar Precio **", "warning");
  }else if(tipo_gastos == 0){
    $("#tipo_gastos").focus();
    Swal.fire("Alerta", "** Seleccionar Categoria **", "warning");
  }else if(tipo_gastos_categorias == 0){
    $("#tipo_gastos_categorias").focus();
    Swal.fire("Alerta", "** Ingresar Tipo **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear Gasto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idServicio', idServicio);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputPrecio', inputPrecio);
                  formData.append('tipo_gastos', tipo_gastos);
                  formData.append('tipo_gastos_categorias', tipo_gastos_categorias);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputDescripcion', inputDescripcion);
                  formData.append('inputFecha', inputFecha);

                  formData.append('tipo_servicio', tipo_servicio);
                  formData.append('servicio_cliente', servicio_cliente);
                  formData.append('servicio_prestado', servicio_prestado);

                  formData.append('accion', accion);
              
              $.ajax({
                  url:         url_link+"app/vistas/finanzas/php/validador_finanzas.php",
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

function nuevo_proveedor(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nuevo_proveedor";

  $("#nuevo_proveedor").html('');
  $('#nuevo_proveedor').load(url_link+"/app/recursos/img/loader.svg");
  $('#nuevo_proveedor').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
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

function grabar_nuevo_proveedor() {
  const url_link    = document.getElementById('url_link').value;
  var accion        = "grabar_nuevo_proveedor";

  var inputNombre   = document.getElementById('inputNombre').value;
  var inputRut      = document.getElementById('inputRut').value;
  var inputTelefono = document.getElementById('inputTelefono').value;
  var inputMail     = document.getElementById('inputMail').value;

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputRut.length == 0){
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut **", "warning");
  }else if(inputTelefono.length == 0){
    $("#inputTelefono").focus();
    Swal.fire("Alerta", "** Ingresar Telefono **", "warning");
  }else if(inputMail.length == 0){
    $("#inputMail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  }else{

    Swal.fire({
          title:              'Desea crear proveedor ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('inputNombre', inputNombre);
              formData.append('inputRut', inputRut);
              formData.append('inputTelefono', inputTelefono);
              formData.append('inputMail', inputMail);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../finanzas/php/validador_finanzas.php",
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
}

function grabar_editar_proveedor(idProveedor) {
  const url_link    = document.getElementById('url_link').value;
  var accion        = "grabar_editar_proveedor";

  var inputNombre   = document.getElementById('inputNombre').value;
  var inputRut      = document.getElementById('inputRut').value;
  var inputTelefono = document.getElementById('inputTelefono').value;
  var inputMail     = document.getElementById('inputMail').value;

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputRut.length == 0){
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut **", "warning");
  }else if(inputTelefono.length == 0){
    $("#inputTelefono").focus();
    Swal.fire("Alerta", "** Ingresar Telefono **", "warning");
  }else if(inputMail.length == 0){
    $("#inputMail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  }else{

    Swal.fire({
          title:              'Desea editar proveedor ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('idProveedor', idProveedor);
              formData.append('inputNombre', inputNombre);
              formData.append('inputRut', inputRut);
              formData.append('inputTelefono', inputTelefono);
              formData.append('inputMail', inputMail);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../finanzas/php/validador_finanzas.php",
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
}

function mostrar_fecha_pago(){
  var inputEstadoFactura = document.getElementById('inputEstadoFactura').value;

  if(inputEstadoFactura == 2){
    $("#mostrar_fecha_pago").show();
  } else if(inputEstadoFactura == 1) {
    $("#mostrar_fecha_pago").hide();
  } else {
    $("#mostrar_fecha_pago").hide();
  }
}

function grabar_nueva_factura(idServicio) {
  const url_link            = document.getElementById('url_link').value;
  var accion                = "grabar_nueva_factura";

  var inputNumero           = document.getElementById('inputNumero').value;
  var inputProveedor        = document.getElementById('inputProveedor').value;
  var inputMonto            = document.getElementById('inputMonto').value;
  var inputFechaFactura     = document.getElementById('inputFechaFactura').value;
  var inputEstadoFactura    = document.getElementById('inputEstadoFactura').value;
  var inputFechaPagoFactura = document.getElementById('inputFechaPagoFactura').value;
  var inputSucursal         = document.getElementById('inputSucursal').value;
  var inputDescripcion      = document.getElementById('inputDescripcion').value;

  if(inputNumero == 0){
    $("#inputNumero").focus();
    Swal.fire("Alerta", "** Ingresar numero Factura **", "warning");
  }else if(inputProveedor == 0){
    $("#inputProveedor").focus();
    Swal.fire("Alerta", "** Seleccionar Proveedor **", "warning");
  }else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  }else if(inputEstadoFactura == 0){
    $("#inputEstadoFactura").focus();
    Swal.fire("Alerta", "** Seleccionar Estado **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea crear factura ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('inputNumero', inputNumero);
              formData.append('inputProveedor', inputProveedor);
              formData.append('inputMonto', inputMonto);
              formData.append('inputFechaFactura', inputFechaFactura);
              formData.append('inputEstadoFactura', inputEstadoFactura);
              formData.append('inputFechaPagoFactura', inputFechaPagoFactura);
              formData.append('inputSucursal', inputSucursal);
              formData.append('inputDescripcion', inputDescripcion);
              formData.append('idServicio', idServicio);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         url_link+"app/vistas/finanzas/php/validador_finanzas.php",
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
}

function traer_editar_factura(idFactura) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "traer_editar_factura";

    $("#traer_editar_factura").html('');
    $('#traer_editar_factura').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_editar_factura').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idFactura:idFactura});
}

function desactivar_factura(idFactura) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "desactivar_factura";

   Swal.fire({
      title:              'Desea Desactivar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idFactura', idFactura);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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

function grabar_editar_factura(idFactura) {
  const url_link            = document.getElementById('url_link').value;
  var accion                = "grabar_editar_factura";

  var inputNumero           = document.getElementById('inputNumero').value;
  var inputProveedor        = document.getElementById('inputProveedor').value;
  var inputMonto            = document.getElementById('inputMonto').value;
  var inputFechaFactura     = document.getElementById('inputFechaFactura').value;
  var inputEstadoFactura    = document.getElementById('inputEstadoFactura').value;
  var inputFechaPagoFactura = document.getElementById('inputFechaPagoFactura').value;
  var inputSucursal         = document.getElementById('inputSucursal').value;
  var inputDescripcion      = document.getElementById('inputDescripcion').value;

  if(inputNumero == 0){
    $("#inputNumero").focus();
    Swal.fire("Alerta", "** Ingresar numero Factura **", "warning");
  }else if(inputProveedor == 0){
    $("#inputProveedor").focus();
    Swal.fire("Alerta", "** Seleccionar Proveedor **", "warning");
  }else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  }else if(inputEstadoFactura == 0){
    $("#inputEstadoFactura").focus();
    Swal.fire("Alerta", "** Seleccionar Estado **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea editar factura ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('inputNumero', inputNumero);
              formData.append('inputProveedor', inputProveedor);
              formData.append('inputMonto', inputMonto);
              formData.append('inputFechaFactura', inputFechaFactura);
              formData.append('inputEstadoFactura', inputEstadoFactura);
              formData.append('inputFechaPagoFactura', inputFechaPagoFactura);
              formData.append('inputSucursal', inputSucursal);
              formData.append('inputDescripcion', inputDescripcion);
              formData.append('idFactura', idFactura);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../finanzas/php/validador_finanzas.php",
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
}

function pagar_factura(idFactura) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "pagar_factura";

   Swal.fire({
      title:              'Desea dejar como pagada ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idFactura', idFactura);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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

function editar_proveedores(idProveedor) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "editar_proveedores";

    $("#nuevo_proveedor").html('');
    $('#nuevo_proveedor').load(url_link+"/app/recursos/img/loader.svg");
    $('#nuevo_proveedor').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idProveedor:idProveedor});
}

function metas_ventas() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "metas_ventas";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}

function grabar_nueva_meta(idUser) {
  var meta_mes         = document.getElementById('meta_mes').value;
  var inputMonto       = document.getElementById('inputMonto').value;
  var inputDescripcion = document.getElementById('inputDescripcion').value;

  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_nueva_meta";

  if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear nueva meta ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
            var formData = new FormData();
                formData.append('idUser', idUser);
                formData.append('meta_mes', meta_mes);
                formData.append('inputMonto', inputMonto);
                formData.append('inputDescripcion', inputDescripcion);
                formData.append('accion', accion);
              
            $.ajax({
              url:         "../../finanzas/php/validador_finanzas.php",
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
                  parent.metas_ventas();
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
}

function anular_metas(idMeta) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "anular_metas";

    Swal.fire({
          title:              'Desea Quitar meta?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Ingresar Motivo de anulación',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                showLoaderOnConfirm: true,
            }).then((motivo) => {
                var motivo_texto = motivo.value;
                if (motivo_texto.length > 0) {
                    $("#traer_finanzas").html('');
                    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
                    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idMeta:idMeta, motivo_texto:motivo_texto});
                } else {
                    Swal.fire("Alerta", "** Debes ingresar Motivo de anulación **", "warning");
                }
            })
        }
    })
}

function consultar_meta(ano) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "consultar_meta";

  var meta_mes    = document.getElementById('meta_mes').value;

  $("#resultado_meta").html("<p class='text-info'>Consultando Mes...</p>");
  //$('#codigo_existe').load(url_link+"/app/recursos/img/loader.svg");
  $('#resultado_meta').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, meta_mes:meta_mes, ano:ano});
}


function grabar_nueva_factura_cliente(idServicio) {
  const url_link            = document.getElementById('url_link').value;
  var accion                = "grabar_nueva_factura_cliente";

  var inputNumero           = document.getElementById('inputNumero').value;
  var inputMonto            = document.getElementById('inputMonto').value;
  var inputFechaFactura     = document.getElementById('inputFechaFactura').value;
  var inputEstadoFactura    = document.getElementById('inputEstadoFactura').value;
  var inputFechaPagoFactura = document.getElementById('inputFechaPagoFactura').value;
  var inputDescripcion      = document.getElementById('inputDescripcion').value;

  var foto                  = ($('input[type="file"]'))[0].files[0]; 
  var archivo               = document.getElementById('input-b8').value;

  if(inputNumero == 0){
    $("#inputNumero").focus();
    Swal.fire("Alerta", "** Ingresar numero Factura **", "warning");
  }else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  }else if(inputEstadoFactura == 0){
    $("#inputEstadoFactura").focus();
    Swal.fire("Alerta", "** Seleccionar Estado **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea crear factura ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('inputNumero', inputNumero);
              formData.append('inputMonto', inputMonto);
              formData.append('inputFechaFactura', inputFechaFactura);
              formData.append('inputEstadoFactura', inputEstadoFactura);
              formData.append('inputFechaPagoFactura', inputFechaPagoFactura);
              formData.append('inputDescripcion', inputDescripcion);
              formData.append('idServicio', idServicio);
              formData.append('file', foto);
              formData.append('archivo', archivo);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         url_link+"app/vistas/finanzas/php/validador_finanzas.php",
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
}



function traer_editar_factura_cliente(idFactura) {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "traer_editar_factura_cliente";

    $("#traer_editar_factura").html('');
    $('#traer_editar_factura').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_editar_factura').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion, idFactura:idFactura});
}

function desactivar_factura_cliente(idFactura) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "desactivar_factura_cliente";

   Swal.fire({
      title:              'Desea Desactivar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idFactura', idFactura);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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


function grabar_editar_factura_cliente(idFactura) {
  const url_link            = document.getElementById('url_link').value;
  var accion                = "grabar_editar_factura_cliente";

  var inputNumero           = document.getElementById('inputNumero').value;
  var inputMonto            = document.getElementById('inputMonto').value;
  var inputFechaFactura     = document.getElementById('inputFechaFactura').value;
  var inputEstadoFactura    = document.getElementById('inputEstadoFactura').value;
  var inputFechaPagoFactura = document.getElementById('inputFechaPagoFactura').value;
  var inputDescripcion      = document.getElementById('inputDescripcion').value;

  if(inputNumero == 0){
    $("#inputNumero").focus();
    Swal.fire("Alerta", "** Ingresar numero Factura **", "warning");
  }else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  }else if(inputEstadoFactura == 0){
    $("#inputEstadoFactura").focus();
    Swal.fire("Alerta", "** Seleccionar Estado **", "warning");
  }else if(inputDescripcion.length == 0){
    $("#inputDescripcion").focus();
    Swal.fire("Alerta", "** Ingresar Descripción **", "warning");
  }else{

    Swal.fire({
          title:              'Desea editar factura ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
              formData.append('inputNumero', inputNumero);
              formData.append('inputMonto', inputMonto);
              formData.append('inputFechaFactura', inputFechaFactura);
              formData.append('inputEstadoFactura', inputEstadoFactura);
              formData.append('inputFechaPagoFactura', inputFechaPagoFactura);
              formData.append('inputDescripcion', inputDescripcion);
              formData.append('idFactura', idFactura);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../finanzas/php/validador_finanzas.php",
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
}

function pagar_factura_cliente(idFactura) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "pagar_factura_cliente";

   Swal.fire({
      title:              'Desea dejar como pagada ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idFactura', idFactura);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../finanzas/php/validador_finanzas.php",
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


function facturas_clientes_panel() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "facturas_clientes_panel";

    $("#traer_finanzas").html('');
    $('#traer_finanzas').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_finanzas').load(url_link+"app/vistas/finanzas/php/validador_finanzas.php", {accion:accion});
}