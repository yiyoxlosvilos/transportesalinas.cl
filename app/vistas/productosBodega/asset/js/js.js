$(document).ready(function() {
    $('#productos_list').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 20
       });

    var multipleCancelButton = new Choices('#productos', {
        removeItemButton: true,
    });
});

function checkAll(bx){
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}

function productos_ver(estado) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "productos_ver";

  $("#filtro_productos").html('');
  $('#filtro_productos').load(url_link+"/app/recursos/img/loader.svg");
  $('#filtro_productos').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, estado:estado});
}

function grabar_nuevo_producto() {
  const url_link            = document.getElementById('url_link').value;
  var accion                = "productos_grabar";

  var inputCodigo           = document.getElementById('inputCodigo').value;
  var inputNombre           = document.getElementById('inputNombre').value;
  var inputCategoria        = document.getElementById('inputCategoria').value;
  var inputMarca            = document.getElementById('inputMarca').value;
  var inputPrecioCompra     = document.getElementById('inputPrecioCompra').value;
  var inputMargen           = document.getElementById('inputMargen').value;
  var inputPrecioVenta      = document.getElementById('inputPrecioVenta').value;
  var inputPrecioUtilidad   = document.getElementById('inputPrecioUtilidad').value;
  var inputSucursal         = document.getElementById('inputSucursal').value;
  var inputTipoUnidad       = document.getElementById('inputTipoUnidad').value;
  var inputStock            = document.getElementById('inputStock').value;

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputMarca == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Seleccionar Marca **", "warning");
  }else if(inputCategoria == 0){
    $("#inputCategoria").focus();
    Swal.fire("Alerta", "** Seleccionar Categoria **", "warning");
  }else if(inputPrecioCompra == 0){
    $("#inputPrecioCompra").focus();
    Swal.fire("Alerta", "** Ingresar Monto de Compra**", "warning");
  }else if(inputPrecioVenta == 0){
    $("#inputPrecioVenta").focus();
    Swal.fire("Alerta", "** Ingresar Monto de Venta**", "warning");
  }else if(inputTipoUnidad == 0){
    $("#inputTipoUnidad").focus();
    Swal.fire("Alerta", "** Seleccionar Tipo Unidad **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear Producto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
      $(".btn").prop("disabled", true);
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('inputCodigo', inputCodigo);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputCategoria', inputCategoria);
                  formData.append('inputMarca', inputMarca);
                  formData.append('inputPrecioCompra', inputPrecioCompra);
                  formData.append('inputMargen', inputMargen);
                  formData.append('inputPrecioVenta', inputPrecioVenta);
                  formData.append('inputPrecioUtilidad', inputPrecioUtilidad);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputTipoUnidad', inputTipoUnidad);
                  formData.append('inputStock', inputStock);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productosBodega/php/validador.php",
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
                      parent.productos_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
    });

  }
}

function nueva_categoria(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nueva_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion});
}

function crear_categoria() {
  var inputNombre = document.getElementById('inputNombre').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "crear_categoria";

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else {

    Swal.fire({
          title:              'Desea Crear ?',
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
              url:         "../../productosBodega/php/validador.php",
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

function nueva_marca(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nueva_marca";

  $("#nueva_marca").html('');
  $('#nueva_marca').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_marca').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion});
}

function crear_marca() {
  var inputNombre = document.getElementById('inputMarca').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "crear_marca";

  if(inputNombre.length == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear Marca ?',
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
              url:         "../../productosBodega/php/validador.php",
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

function editar_marca(idMarca){
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_marca";

  $("#nueva_marca").html('');
  $('#nueva_marca').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_marca').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, idMarca:idMarca});
}


function grabar_editar_marca(idMarca) {
  var inputNombre = document.getElementById('inputNombre').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_editar_marca";

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
            formData.append('idMarca', idMarca);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
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

function quitar_marca(idMarca) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "quitar_marca";

  Swal.fire({
      title:              'Desea quitar ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('idMarca', idMarca);
            formData.append('accion', accion);

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
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

function editar_categoria(idCategoria){
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, idCategoria:idCategoria});
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
          url:         "../../productosBodega/php/validador.php",
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

function editar_categoria_granel(idCategoria){
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_categoria_granel";

  $("#nueva_categoria_granel").html('');
  $('#nueva_categoria_granel').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria_granel').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, idCategoria:idCategoria});
}

function grabar_editar_categoria_granel(idCategoria) {
  var inputNombre = document.getElementById('inputNombre').value;

  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_editar_categoria_granel";

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
          url:         "../../productosBodega/php/validador.php",
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



function editar_producto(idProducto) {
  const url_link      = document.getElementById('url_link').value;
  var accion          = "editar_producto";

  var inputCodigo           = document.getElementById('inputCodigo').value;
  var inputNombre           = document.getElementById('inputNombre').value;
  var inputCategoria        = document.getElementById('inputCategoria').value;
  var inputPrecioCompra     = document.getElementById('inputPrecioCompra').value;
  var inputMargen           = document.getElementById('inputMargen').value;
  var inputPrecioVenta      = document.getElementById('inputPrecioVenta').value;
  var inputPrecioUtilidad   = document.getElementById('inputPrecioUtilidad').value;
  var inputSucursal         = document.getElementById('inputSucursal').value;
  var inputTipoUnidad       = document.getElementById('inputTipoUnidad').value;
  var inputMarca            = document.getElementById('inputMarca').value;


  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputMarca == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Seleccionar Marca **", "warning");
  }else if(inputCategoria == 0){
    $("#inputCategoria").focus();
    Swal.fire("Alerta", "** Seleccionar Categoria **", "warning");
  }else if(inputPrecioCompra == 0){
    $("#inputPrecioCompra").focus();
    Swal.fire("Alerta", "** Ingresar Monto de Compra **", "warning");
  }else if(inputPrecioVenta == 0){
    $("#inputPrecioVenta").focus();
    Swal.fire("Alerta", "** Ingresar Monto de Venta **", "warning");
  }else if(inputTipoUnidad == 0){
    $("#inputTipoUnidad").focus();
    Swal.fire("Alerta", "** Seleccionar Tipo Unidad **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Editar Producto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idProducto', idProducto);
                  formData.append('inputCodigo', inputCodigo);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputCategoria', inputCategoria);
                  formData.append('inputMarca', inputMarca);
                  formData.append('inputPrecioCompra', inputPrecioCompra);
                  formData.append('inputMargen', inputMargen);
                  formData.append('inputPrecioVenta', inputPrecioVenta);
                  formData.append('inputPrecioUtilidad', inputPrecioUtilidad);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputTipoUnidad', inputTipoUnidad);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productosBodega/php/validador.php",
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
                      parent.buscador_de_productos(0);
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

function desactivar_producto(idProducto) {
  const url_link      = document.getElementById('url_link').value;
  var accion          = "desactivar_producto";

  Swal.fire({
          title:              'Desea Desactivar Producto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idProducto', idProducto);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productosBodega/php/validador.php",
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

function activar_producto(idProducto) {
  const url_link      = document.getElementById('url_link').value;
  var accion          = "activar_producto";

  Swal.fire({
          title:              'Desea activar producto ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idProducto', idProducto);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productosBodega/php/validador.php",
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

function cambiar_foto_producto(idProducto) {
  const url_link      = document.getElementById('url_link').value;
  var accion          = "cambiar_foto_producto";

  $("#subir_foto_producto").html('');
  $('#subir_foto_producto').load(url_link+"/app/recursos/img/loader.svg");
  $('#subir_foto_producto').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, idProducto:idProducto});
}

function subir_foto_producto() {
  const url_link      = document.getElementById('url_link').value;
  var idProducto      = document.getElementById('idProducto').value;
  var foto            = ($('input[type="file"]'))[0].files[0]; 
  var archivo         = document.getElementById('input-b8').value;
  var accion          = "subir_foto_producto";
 
  Swal.fire({
    title:              'Desea Subir imagen a producto ?',
    showDenyButton:     false,
    showCancelButton:   true,
    confirmButtonText:  'SI',
    cancelButtonText:   'NO',
    icon:               'question',
  }).then((result) => {

    if (result.isConfirmed) {

      if (archivo.length>0) {
        var tamano = foto.size > 4000000;

        if (tamano) {
            Swal.fire("Alerta", "Debes Cargar un archivo menor a 40 mb", "warning");
            return;
        }

        var data = new FormData();
            data.append("file", foto);
            data.append("accion", accion);
            data.append("archivo", archivo);
            data.append("idProducto", idProducto);

        $("#subir_foto_producto").html('');
        $('#subir_foto_producto').load(url_link+"/app/recursos/img/loader.svg");

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

function consulta_codigo() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "consulta_codigo";

  var inputCodigo = limpiar_input(document.getElementById('inputCodigo').value);

  $("#codigo_existe").html("<span class='text-info'>Consultando código...</span>");
  //$('#codigo_existe').load(url_link+"/app/recursos/img/loader.svg");
  $('#codigo_existe').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, inputCodigo:inputCodigo});
}

function tipo_categoria() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "tipo_categoria";

  var inputTipo   = document.getElementById('tipo_categoria').value;

  if(inputTipo == 1){
    $("#ejemplo").html("Ej.: 1");
  } else if(inputTipo == 2) {
    $("#ejemplo").html("Ej. Kg.: 10.5");
  } else if(inputTipo == 3) {
    $("#ejemplo").html("Ej. Mt.: 8.5");
  }

  


  $("#buscar_categoria").html('');
  $('#buscar_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#buscar_categoria').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, inputTipo:inputTipo});
}

function quitar_categoria_granel(idCategoria) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "quitar_categoria_granel";

  Swal.fire({
      title:              'Desea quitar ?',
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
          url:         "../../productosBodega/php/validador.php",
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

function quitar_categoria(idCategoria) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "quitar_categoria";

  Swal.fire({
      title:              'Desea quitar ?',
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
          url:         "../../productosBodega/php/validador.php",
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

function calcular_margen_porcentaje() {
  var inputPrecioCompra = document.getElementById('inputPrecioCompra').value;
  var inputMargen       = document.getElementById('inputMargen').value;
  var inputPrecioVenta  = document.getElementById('inputPrecioVenta').value;

  if(inputPrecioCompra > 0){

    paso_1       = (inputPrecioCompra*inputMargen);
    monto_aumento= (paso_1/100);

    suma        = (inputMargen);
    divide      = (suma/100);

    total       = (parseInt(inputPrecioCompra)+parseInt(monto_aumento));
    utilidad    = (total-inputPrecioCompra);

    $("#inputPrecioVenta").val(Math.ceil(total));
    $("#inputPrecioUtilidad").val(Math.ceil(utilidad));
  }
}

function calcular_margen_neto() {
  var inputPrecioCompra = document.getElementById('inputPrecioCompra').value;
  var inputMargen       = document.getElementById('inputMargen').value;
  var inputPrecioVenta  = document.getElementById('inputPrecioVenta').value;

  if(inputPrecioCompra > 0){
    suma        = (inputPrecioVenta*100);
    divide      = ((suma/inputPrecioCompra)-100);

    utilidad    = (inputPrecioVenta-inputPrecioCompra);

    $("#inputMargen").val(Math.ceil(divide));
    $("#inputPrecioUtilidad").val(Math.ceil(utilidad));
  }
}

function ofertar_productos(estado) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "ofertar_productos";

  $("#filtro_productos").html('');
  $("#menus_traer").html('');
  $('#menus_traer').load(url_link+"/app/recursos/img/loader.svg");
  $('#menus_traer').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, estado:estado});
}

function ofertar_productos_formulario() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "ofertar_productos_formulario";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_ingreso").html('');
        $('#resultado_ingreso').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_ingreso').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, productos:productos});
    }
}

function cambiarMonto() {
  var monto_inicial  = document.getElementById('monto_inicial').value;
  var monto          = document.getElementById('monto').value;
  var oferta         = document.getElementById('oferta').value;

  resto = (oferta/100);
  suma  = (monto*resto);
  total = (monto-suma);

  if (monto_inicial > total) {
    perdida = (monto_inicial-total);

    $("#perdida").show();
    $("#monto_perdida").html("$ "+number_format(perdida));
  } else {
    $("#perdida").hide();
    $("#monto_perdida").html('');
  }

  $("#trae").html("$ "+number_format(total));
  $("#precio_final").val(total);
}

function grabar_ofertas() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_ofertas";

  var productos_asignados = document.getElementById('productos_asignados').value;
  var precio_final        = document.getElementById('precio_final').value;
  var oferta              = document.getElementById('oferta').value;
  var finalizar           = document.getElementById('finalizar').value;

  Swal.fire({
      title:              'Desea crear Oferta ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('accion', accion);
            formData.append('productos_asignados', productos_asignados);
            formData.append('precio_final', precio_final);
            formData.append('oferta', oferta);
            formData.append('finalizar', finalizar);

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
          type:        "POST",
          data :       formData,
          processData: false,
          contentType: false,
          success:     function(sec) {

            if(JSON.parse(sec)  == "realizado"){
              Swal.fire({
                title:              'Registro Realizado correctamente',
                icon:               'success',
                showDenyButton:     false,
                showCancelButton:   false,
                confirmButtonText:  'OK',
                cancelButtonText:   'NO',
              }).then((result) => {
                parent.ofertar_productos();
                location.reload();
              })
            } else {
              Swal.fire("Error", "Error", "error");
            }
          },
          error:       function(sec) {
            Swal.fire("Error", "Error", "error");
          }
        });
      }
    })
}

function anular_ofertas(producto_id) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "anular_ofertas";

  Swal.fire({
      title:              'Desea anular Oferta ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('accion', accion);
            formData.append('producto_id', producto_id);

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
          type:        "POST",
          data :       formData,
          processData: false,
          contentType: false,
          success:     function(sec) {

            if(JSON.parse(sec)  == "realizado"){
              Swal.fire({
                title:              'Registro Realizado correctamente',
                icon:               'success',
                showDenyButton:     false,
                showCancelButton:   false,
                confirmButtonText:  'OK',
                cancelButtonText:   'NO',
              }).then((result) => {
                parent.ofertar_productos();
                parent.Fancybox.close();
              })
            } else {
              Swal.fire("Error", "Error", "error");
            }
          },
          error:       function(sec) {
            Swal.fire("Error", "Error", "error");
          }
        });
      }
    })
}

function promocionar_productos() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "promocionar_productos";

  $("#filtro_productos").html('');
  $("#menus_traer").html('');
  $('#menus_traer').load(url_link+"/app/recursos/img/loader.svg");
  $('#menus_traer').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion});
}

function promocionar_productos_formulario() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "promocionar_productos_formulario";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_ingreso").html('');
        $('#resultado_ingreso').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_ingreso').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, productos:productos});
    }
}

function consulta_codigo_promocion() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "consulta_codigo_promocion";

  var inputCodigo = limpiar_input(document.getElementById('inputCodigo').value);

  $("#codigo_existe").html("<span class='text-info'>Consultando código...</span>");
  //$('#codigo_existe').load(url_link+"/app/recursos/img/loader.svg");
  $('#codigo_existe').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, inputCodigo:inputCodigo});
}

function grabar_promocion() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_promocion";

  var inputNombre   = document.getElementById('inputNombre').value; 
  var inputCodigo   = document.getElementById('inputCodigo').value; 
  var inputStock    = document.getElementById('inputStock').value;
  var inputMonto    = document.getElementById('inputMonto').value;
  var inputFecha    = document.getElementById('inputFecha').value;
  var inputSucursal = document.getElementById('inputSucursal').value;

  //PRODUCTOS STOCKS
  var id_productos_asignados = document.getElementsByName('productos_asignados[]');
  var id_cantidad_promo      = document.getElementsByName('cantidad_promo[]');

  var productos_asignados    = "";
  var cantidad_promo         = "";

  for (var loop1   = 0; loop1 < id_productos_asignados.length; loop1++) {
    var asssoc1         = id_productos_asignados[loop1];
    productos_asignados = productos_asignados + "" + asssoc1.value + ";";
  }

  for (var loop2   = 0; loop2 < id_cantidad_promo.length; loop2++) {
    var asssoc2    = id_cantidad_promo[loop2];
    cantidad_promo = cantidad_promo + "" + asssoc2.value + ";";
  }

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputCodigo.length == 0){
    $("#inputCodigo").focus();
    Swal.fire("Alerta", "** Ingresar Código **", "warning");
  } else if(inputStock == 0){
    $("#inputStock").focus();
    Swal.fire("Alerta", "** Ingresar Stock **", "warning");
  } else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  } else if(inputFecha.length == 0){
    $("#inputFecha").focus();
    Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
  } else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Ingresar Sucursal **", "warning");
  } else {
    var formData = new FormData();
        formData.append('accion', accion);
        formData.append('inputNombre', inputNombre);
        formData.append('inputCodigo', inputCodigo);
        formData.append('inputStock', inputStock);
        formData.append('inputMonto', inputMonto);
        formData.append('inputFecha', inputFecha);
        formData.append('inputSucursal', inputSucursal);
        formData.append('productos_asignados', productos_asignados);
        formData.append('cantidad_promo', cantidad_promo);

    Swal.fire({
      title:              'Desea crear Promoción ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
          type:        "POST",
          data :       formData,
          processData: false,
          contentType: false,
          success:     function(sec) {

            if(JSON.parse(sec)  == "realizado"){
              Swal.fire({
                title:              'Registro Realizado correctamente',
                icon:               'success',
                showDenyButton:     false,
                showCancelButton:   false,
                confirmButtonText:  'OK',
                cancelButtonText:   'NO',
              }).then((result) => {
                parent.Fancybox.close();
                parent.promocionar_productos();
              })
            } else {
              Swal.fire("Error", "Error", "error");
            }
          },
          error:       function(sec) {
            Swal.fire("Error", "Error", "error");
          }
        });
      }
    });
  }
}

function editar_promocion(idPromo) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "editar_promocion";

  var inputNombre   = document.getElementById('inputNombre').value; 
  var inputCodigo   = document.getElementById('inputCodigo').value; 
  var inputStock    = document.getElementById('inputStock').value;
  var inputMonto    = document.getElementById('inputMonto').value;
  var inputFecha    = document.getElementById('inputFecha').value;
  var inputSucursal = document.getElementById('inputSucursal').value;

  //PRODUCTOS STOCKS
  var id_productos_asignados = document.getElementsByName('productos_asignados[]');
  var id_cantidad_promo      = document.getElementsByName('cantidad_promo[]');

  var productos_asignados    = "";
  var cantidad_promo         = "";

  for (var loop1   = 0; loop1 < id_productos_asignados.length; loop1++) {
    var asssoc1         = id_productos_asignados[loop1];
    productos_asignados = productos_asignados + "" + asssoc1.value + ";";
  }

  for (var loop2   = 0; loop2 < id_cantidad_promo.length; loop2++) {
    var asssoc2    = id_cantidad_promo[loop2];
    cantidad_promo = cantidad_promo + "" + asssoc2.value + ";";
  }

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputCodigo.length == 0){
    $("#inputCodigo").focus();
    Swal.fire("Alerta", "** Ingresar Código **", "warning");
  } else if(inputStock == 0){
    $("#inputStock").focus();
    Swal.fire("Alerta", "** Ingresar Stock **", "warning");
  } else if(inputMonto == 0){
    $("#inputMonto").focus();
    Swal.fire("Alerta", "** Ingresar Monto **", "warning");
  } else if(inputFecha.length == 0){
    $("#inputFecha").focus();
    Swal.fire("Alerta", "** Ingresar Fecha **", "warning");
  } else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Ingresar Sucursal **", "warning");
  } else {
    var formData = new FormData();
        formData.append('accion', accion);
        formData.append('idPromo', idPromo);
        formData.append('inputNombre', inputNombre);
        formData.append('inputCodigo', inputCodigo);
        formData.append('inputStock', inputStock);
        formData.append('inputMonto', inputMonto);
        formData.append('inputFecha', inputFecha);
        formData.append('inputSucursal', inputSucursal);
        formData.append('productos_asignados', productos_asignados);
        formData.append('cantidad_promo', cantidad_promo);

    Swal.fire({
      title:              'Desea crear Promoción ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
          type:        "POST",
          data :       formData,
          processData: false,
          contentType: false,
          success:     function(sec) {

            if(JSON.parse(sec)  == "realizado"){
              Swal.fire({
                title:              'Registro Realizado correctamente',
                icon:               'success',
                showDenyButton:     false,
                showCancelButton:   false,
                confirmButtonText:  'OK',
                cancelButtonText:   'NO',
              }).then((result) => {
                location.reload();
                parent.promocionar_productos();
              })
            } else {
              Swal.fire("Error", "Error", "error");
            }
          },
          error:       function(sec) {
            Swal.fire("Error", "Error", "error");
          }
        });
      }
    });
  }
}

function anular_promocion(idPromo) {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "anular_promocion";

  Swal.fire({
      title:              'Desea anular Promoción ?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
            formData.append('accion', accion);
            formData.append('idPromo', idPromo);

        $.ajax({
          url:         "../../productosBodega/php/validador.php",
          type:        "POST",
          data :       formData,
          processData: false,
          contentType: false,
          success:     function(sec) {

            if(JSON.parse(sec)  == "realizado"){
              Swal.fire({
                title:              'Registro Realizado correctamente',
                icon:               'success',
                showDenyButton:     false,
                showCancelButton:   false,
                confirmButtonText:  'OK',
                cancelButtonText:   'NO',
              }).then((result) => {
                parent.promocionar_productos();
                parent.Fancybox.close();
              })
            } else {
              Swal.fire("Error", "Error", "error");
            }
          },
          error:       function(sec) {
            Swal.fire("Error", "Error", "error");
          }
        });
      }
    })
}

function buscador_de_productos(excell) {
  const url_link    = document.getElementById('url_link').value;
  var accion        = "buscador_de_productos";

  var tipo_busqueda = document.getElementById('tipo_busqueda').value;

  if (excell == 0) {
    if (tipo_busqueda == 1) {
      var codigo_producto = document.getElementById('codigo_producto').value;

      $("#filtro_productos").html('');
      $('#filtro_productos').load(url_link+"/app/recursos/img/loader.svg");
      $('#filtro_productos').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, tipo_busqueda:tipo_busqueda, codigo_producto:codigo_producto, print:excell});

    } else if (tipo_busqueda == 2) {
      var tipo_producto   = document.getElementById('tipo_producto').value;
      var inputCategoria  = document.getElementById('inputCategoria').value;

      $("#filtro_productos").html('');
      $('#filtro_productos').load(url_link+"/app/recursos/img/loader.svg");
      $('#filtro_productos').load(url_link+"app/vistas/productosBodega/php/validador.php", {accion:accion, tipo_busqueda:tipo_busqueda, tipo_producto:tipo_producto, inputCategoria:inputCategoria, print:excell});
    }
  } else if (excell == 1) {
    if (tipo_busqueda == 1) {
      var codigo_producto = document.getElementById('codigo_producto').value;

      window.open(url_link+"app/vistas/productosBodega/php/validador.php?accion="+accion+"&tipo_busqueda="+tipo_busqueda+"&codigo_producto="+codigo_producto+"&print="+excell+"","_blank");
    } else if (tipo_busqueda == 2) {
      var tipo_producto   = document.getElementById('tipo_producto').value;
      var inputCategoria  = document.getElementById('inputCategoria').value;

      window.open(url_link+"app/vistas/productosBodega/php/validador.php?accion="+accion+"&tipo_busqueda="+tipo_busqueda+"&tipo_producto="+tipo_producto+"&inputCategoria="+inputCategoria+"&print="+excell+"","_blank");
    }
  }
}

function tipo_buscar(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "tipo_busqueda";

  var tipo_busqueda = document.getElementById("tipo_busqueda").value;

  $('#resultado_tipo_busqueda').load(url_link + "/app/recursos/img/loader.svg");
  $('#resultado_tipo_busqueda').load(url_link + "app/vistas/productosBodega/php/validador.php", { accion:accion, tipo_busqueda:tipo_busqueda });
}

function buscar_categoria_tipo_producto() {
  const url_link    = document.getElementById('url_link').value;

  var tipo_producto = document.getElementById('tipo_producto').value;
  var accion        = "buscar_categoria_tipo_producto";

  $('#categoria').load(url_link + "/app/recursos/img/loader.svg");
  $('#categoria').load(url_link + "app/vistas/productosBodega/php/validador.php", { accion:accion, tipo_producto:tipo_producto });
}
