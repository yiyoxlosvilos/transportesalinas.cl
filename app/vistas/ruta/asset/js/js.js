function ingresar_hoja_ruta() {
	const url_link = document.getElementById('url_link').value;
	var accion     = "ingresar_hoja_ruta";

	var inputRut   = document.getElementById('inputRut').value;
	var inputCodigo= document.getElementById('inputCodigo').value;

	if (inputRut.length <= 8) {
		$("#inputRut").focus();
    	Swal.fire("Alerta", "** Ingresar rut correctamente **", "warning");
	} else if (inputCodigo.length == 0) {
		$("#inputCodigo").focus();
    	Swal.fire("Alerta", "** Ingresar codigo de servicio **", "warning");
	} else {
		$("#panel_ruta").html('');
		$('#panel_ruta').load(url_link+"/app/recursos/img/loader.svg");
		$('#panel_ruta').load(url_link+"/app/vistas/ruta/php/validador.php", {accion:accion, inputRut:inputRut, inputCodigo:inputCodigo});
	}
}

function cerrar_session() {
	const url_link = document.getElementById('url_link').value;
	var accion     = "cerrar_session";

	$("#control_ruta").html('');
	$('#control_ruta').load(url_link+"/app/recursos/img/loader.svg");
	$('#control_ruta').load(url_link+"/app/vistas/ruta/php/validador.php", {accion:accion});
}

function grabar_hoja_ruta() {
	const url_link    = document.getElementById('url_link').value;
	var accion        = "grabar_hoja_ruta";

	var monto_inicial = document.getElementById('monto_inicial').value;
	var fecha_hoja 	  = document.getElementById('fecha_hoja').value;
	var descripcion   = document.getElementById('descripcion').value;
	var idServicio    = document.getElementById('idServicio').value;
	var idTrabajador  = document.getElementById('idTrabajador').value;
	var idFlete       = document.getElementById('idFlete').value;

	if(monto_inicial == 0){
	    $("#monto_inicial").focus();
	    Swal.fire("Alerta", "** Ingresar Dep&oacute;sito **", "warning");
	}else if(fecha_hoja.length == 0){
	    $("#fecha_hoja").focus();
	    Swal.fire("Alerta", "** Seleccionar Fecha **", "warning");
	}else if(descripcion.length == 0){
	    $("#descripcion").focus();
	    Swal.fire("Alerta", "** Ingresar Descripci&oacute;n **", "warning");
	}else{

	    Swal.fire({
	          title:              'Desea grabar Hoja de Ruta ?',
	          showDenyButton:     false,
	          showCancelButton:   true,
	          confirmButtonText:  'SI',
	          cancelButtonText:   'NO',
	          icon:               'question',
	    }).then((result) => {
	          if (result.isConfirmed) {
	          var formData = new FormData();
	                  formData.append('monto_inicial', monto_inicial);
	                  formData.append('fecha_hoja', fecha_hoja);
	                  formData.append('descripcion', descripcion);
	                  formData.append('idServicio', idServicio);
	                  formData.append('idTrabajador', idTrabajador);
	                  formData.append('idFlete', idFlete);
	                  formData.append('accion', accion);
	              
	              $.ajax({
	                  url:         url_link+"/app/vistas/ruta/php/validador.php",
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

function grabar_nuevo_gasto_ruta() {
  const url_link  = document.getElementById('url_link').value;
  var accion      = "grabar_nuevo_gasto_ruta";

  var inputNombre             = document.getElementById('inputNombre').value;
  var inputPrecio             = document.getElementById('inputPrecio').value;
  var tipo_gastos             = document.getElementById('tipo_gastos').value;
  var tipo_gastos_categorias  = document.getElementById('tipo_gastos_categorias').value;
  var inputSucursal           = document.getElementById('inputSucursal').value;
  var inputDescripcion        = document.getElementById('inputDescripcion').value;
  var inputFecha              = document.getElementById('inputFecha').value;
  var idServicio              = document.getElementById('idServicio').value;
  var idTrabajador            = document.getElementById('idTrabajador').value;
  var idFlete                 = document.getElementById('idFlete').value;

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
                  formData.append('idTrabajador', idTrabajador);
                  formData.append('idFlete', idFlete);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputPrecio', inputPrecio);
                  formData.append('tipo_gastos', tipo_gastos);
                  formData.append('tipo_gastos_categorias', tipo_gastos_categorias);
                  formData.append('inputSucursal', inputSucursal);
                  formData.append('inputDescripcion', inputDescripcion);
                  formData.append('inputFecha', inputFecha);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         url_link+"/app/vistas/ruta/php/validador.php",
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