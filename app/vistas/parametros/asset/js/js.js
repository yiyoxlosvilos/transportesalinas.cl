function grabar_usuario(){

  var inputNombre       = document.getElementById('inputNombre').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var inputContrasena   = document.getElementById('inputContrasena').value;
  var inputSucursal     = document.getElementById('inputSucursal').value;
  var inputTipoUsuario  = document.getElementById('inputTipoUsuario').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_usuario";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputEmail.length == 0) {
    $("#inputEmail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  } else if(inputContrasena.length == 0) {
    $("#inputContrasena").focus();
    Swal.fire("Alerta", "** Ingresar Contraseña **", "warning");
  } else if(inputSucursal == 0) {
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Selecionar Sucursal **", "warning");
  } else if(inputTipoUsuario == 0) {
    $("#inputTipoUsuario").focus();
    Swal.fire("Alerta", "** Selecionar Tipo Usuario **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Crear Usuario ?',
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
                  formData.append('inputEmail', inputEmail);
                  formData.append('inputContrasena', inputContrasena);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputTipoUsuario', inputTipoUsuario);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../parametros/php/validador.php",
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

function editar_usuario(idUsuario){

  var inputNombre       = document.getElementById('inputNombre').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var cambia_clave      = document.getElementById('cambia_clave').value;
  var inputContrasena   = document.getElementById('inputContrasena').value;
  var inputSucursal     = document.getElementById('inputSucursal').value;
  var inputTipoUsuario  = document.getElementById('inputTipoUsuario').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "editar_usuario";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputEmail.length == 0) {
    $("#inputEmail").focus();
    Swal.fire("Alerta", "** Ingresar E-Mail **", "warning");
  } else if(inputSucursal == 0) {
    $("#inputSucursal").focus();
    Swal.fire("Alerta", "** Selecionar Sucursal **", "warning");
  } else if(inputTipoUsuario == 0) {
    $("#inputTipoUsuario").focus();
    Swal.fire("Alerta", "** Selecionar Tipo Usuario **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Editar Usuario ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idUsuario', idUsuario);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputRut', inputRut);
                  formData.append('inputEmail', inputEmail);
                  formData.append('cambia_clave', cambia_clave);
                  formData.append('inputContrasena', inputContrasena);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputTipoUsuario', inputTipoUsuario);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../parametros/php/validador.php",
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

function quitar_usuario(idUsuario){
  const url_link        = document.getElementById('url_link').value;
  var accion            = "quitar_usuario";

  Swal.fire({
          title:              'Desea Quitar Usuario ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idUsuario', idUsuario);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../app/vistas/parametros/php/validador.php",
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

function cambia_clave() {
  var cambia_clave = document.getElementById('cambia_clave').value;

  if (cambia_clave == 0) {
    $("#contrasena").hide();
  } else {
    $("#contrasena").show();
  }
}

function grabar_sucursal(){

  var inputNombre       = document.getElementById('inputNombre').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_sucursal";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Crear Sucursal ?',
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
                  url:         "../../parametros/php/validador.php",
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

function editar_sucursal(idSucursal){

  var inputNombre       = document.getElementById('inputNombre').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "editar_sucursal";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else {
    Swal.fire({
          title:              'Desea editar Sucursal ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idSucursal', idSucursal);
                  formData.append('inputNombre', inputNombre);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../parametros/php/validador.php",
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

function desactivar_sucursal(idSucursal){
  const url_link        = document.getElementById('url_link').value;
  var accion            = "desactivar_sucursal";

  Swal.fire({
          title:              'Desea desactivar Sucursal ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idSucursal', idSucursal);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../app/vistas/parametros/php/validador.php",
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

function editar_empresa(){

  var inputRazonSocial  = document.getElementById('inputRazonSocial').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputDireccion    = document.getElementById('inputDireccion').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "editar_empresa";

  if(inputRazonSocial.length == 0){
   $("#inputRazonSocial").focus();
    Swal.fire("Alerta", "** Ingresar Razon Social **", "warning");
  } else if(inputRut.length == 0){
   $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut **", "warning");
  } else if(inputDireccion.length == 0){
   $("#inputDireccion").focus();
    Swal.fire("Alerta", "** Ingresar Direccion **", "warning");
  } else {
    Swal.fire({
          title:              'Desea editar empresa ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('inputRazonSocial', inputRazonSocial);
                  formData.append('inputRut', inputRut);
                  formData.append('inputDireccion', inputDireccion);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../parametros/php/validador.php",
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

function cambiar_logo() {
  const url_link      = document.getElementById('url_link').value;
  var foto            = ($('input[type="file"]'))[0].files[0]; 
  var archivo         = document.getElementById('input-b8').value;
  var accion          = "cambiar_logo";
 
  Swal.fire({
    title:              'Desea cambiar logo empresa ?',
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

        $("#cambiar_logo").html('');
        $('#cambiar_logo').load(url_link+"/app/recursos/img/loader.svg");

        $.ajax({
            url:                    "../../parametros/php/validador.php",
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
                  parent.location.reload();
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

function grabar_localidad() {
  var inputNombre       = document.getElementById('inputNombre').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_localidad";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Crear Localidad ?',
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
                  url:         "../../parametros/php/validador.php",
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