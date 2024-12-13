$(document).ready(function() {
    $('#productos_list').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 20
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
  $('#filtro_productos').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion, estado:estado});
}

function grabar_nuevo_producto() {
  var inputCodigo     = document.getElementById('inputCodigo').value;
  var inputNombre     = document.getElementById('inputNombre').value;
  var inputMarca      = document.getElementById('inputMarca').value;
  var inputCategoria  = document.getElementById('inputCategoria').value;
  var inputPatente    = document.getElementById('inputPatente').value;
  var inputSucursal   = document.getElementById('inputSucursal').value;
  const url_link      = document.getElementById('url_link').value;
  var accion          = "productos_grabar";

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputMarca == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Seleccionar Marca **", "warning");
  }else if(inputCategoria == 0){
    $("#inputCategoria").focus();
    Swal.fire("Alerta", "** Seleccionar Categoria **", "warning");
  }else if(inputPatente.length == 0){
    $("#inputPatente").focus();
    Swal.fire("Alerta", "** Ingresar Patente **", "warning");
  }else if(inputSucursal == 0){
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Seleccionar Sucursal **", "warning");
  }else{

    Swal.fire({
          title:              'Desea Crear Maquinaria ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('inputCodigo', inputCodigo);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputMarca', inputMarca);
                  formData.append('inputCategoria', inputCategoria);
                  formData.append('inputPatente', inputPatente);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productos/php/validador.php",
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

function nueva_categoria(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nueva_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion});
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
              url:         "../../productos/php/validador.php",
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
  $('#nueva_marca').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion});
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
              url:         "../../productos/php/validador.php",
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
  $('#nueva_marca').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion, idMarca:idMarca});
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
          url:         "../../productos/php/validador.php",
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
  $('#nueva_categoria').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion, idCategoria:idCategoria});
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
          url:         "../../productos/php/validador.php",
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
  var inputCodigo     = document.getElementById('inputCodigo').value;
  var inputNombre     = document.getElementById('inputNombre').value;
  var inputMarca      = document.getElementById('inputMarca').value;
  var inputCategoria  = document.getElementById('inputCategoria').value;
  var inputPatente    = document.getElementById('inputPatente').value;
  var inputSucursal   = document.getElementById('inputSucursal').value;
  const url_link      = document.getElementById('url_link').value;
  var accion          = "editar_producto";

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  }else if(inputMarca == 0){
    $("#inputMarca").focus();
    Swal.fire("Alerta", "** Seleccionar Marca **", "warning");
  }else if(inputCategoria == 0){
    $("#inputCategoria").focus();
    Swal.fire("Alerta", "** Seleccionar Categoria **", "warning");
  }else if(inputPatente.length == 0){
    $("#inputPrecio").focus();
    Swal.fire("Alerta", "** Ingresar Patente **", "warning");
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
                  formData.append('inputCodigo', inputCodigo);
                  formData.append('idProducto', idProducto);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputMarca', inputMarca);
                  formData.append('inputCategoria', inputCategoria);
                  formData.append('inputPatente', inputPatente);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../productos/php/validador.php",
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
                  url:         "../../productos/php/validador.php",
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
                  url:         "../../productos/php/validador.php",
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
  $('#subir_foto_producto').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion, idProducto:idProducto});
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

  var inputCodigo = document.getElementById('inputCodigo').value;

  $("#codigo_existe").html("<span class='text-info'>Consultando código...</span>");
  //$('#codigo_existe').load(url_link+"/app/recursos/img/loader.svg");
  $('#codigo_existe').load(url_link+"app/vistas/productos/php/validador.php", {accion:accion, inputCodigo:inputCodigo});
}