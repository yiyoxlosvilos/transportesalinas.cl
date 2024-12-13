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

function asignar_productos_merma() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "asignar_productos_merma";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_merma").html('');
        $('#resultado_merma').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_merma').load(url_link+"app/vistas/bodega/php/validador_merma.php", {accion:accion, productos:productos});
    }
}

function realizar_merma() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "realizar_merma";

    var conteo_ingresos     = document.getElementById('conteo_ingresos').value;
    var productos_asignados = document.getElementsByName('productos_asignados[]');
    var inputStock          = document.getElementsByName('inputStock[]');
    var inputGlosa          = document.getElementsByName('inputGlosa[]');

    var productos           = "";
    var stock               = "";
    var glosa               = "";

    for (var loop = 0; loop < productos_asignados.length; loop++) {
        var asssoc= productos_asignados[loop];
        productos = productos + "" + asssoc.value + ";";
    }

    for (var loop2 = 0; loop2 < inputStock.length; loop2++) {
        var asssoc2= inputStock[loop2];
        stock      = stock + "" + asssoc2.value + ";";
    }

    for (var loop3 = 0; loop3 < inputGlosa.length; loop3++) {
        var asssoc3= inputGlosa[loop3];
        glosa      = glosa + "" + asssoc3.value + ";";
    }

    if(productos.length > 0){
        Swal.fire({
              title:              'Desea realizar Ingreso ?',
              showDenyButton:     false,
              showCancelButton:   true,
              confirmButtonText:  'SI',
              cancelButtonText:   'NO',
              icon:               'question',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resultado_ingreso").html('');

                var formData = new FormData();                    
                formData.append('productos', productos);              
                formData.append('stock', stock);                   
                formData.append('glosa', glosa);                
                formData.append('conteo_ingresos', conteo_ingresos);                
                formData.append('accion', accion);

                $.ajax({                    
                    url:         url_link+"app/vistas/bodega/php/validador.php",                    
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

                            Fancybox.show([{
                                src:      url_link+"app/vistas/bodega/php/imprimir_informe.php?lote="+sec+"&tipo_movimiento=3",
                                type:     "iframe",
                                preload:  false,
                                width:    1800,
                                height:   1200,
                                dragToClose : false,
                                click: close,
                            }]);
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

function buscar_informes_bodega() {
    const url_link   = document.getElementById('url_link').value;
    var tipo_accion  = document.getElementById('tipo_accion').value;
    var desde        = document.getElementById('desde').value;
    var hasta        = document.getElementById('hasta').value;
    var accion       = "buscar_informes_bodega";

    if(tipo_accion > 0){
        $("#resultado_busqueda").html('');
        $('#resultado_busqueda').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_busqueda').load(url_link+"app/vistas/bodega/php/validador_merma.php", {accion:accion, tipo_accion:tipo_accion, desde:desde, hasta:hasta});
    }else{
        Swal.fire("Alerta", "Seleccionar tipo de búsqueda", "warning");
    }
}

function ingresos_productos_lista() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "ingresos_productos_lista";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_ingreso").html('');
        $('#resultado_ingreso').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_ingreso').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion, productos:productos});
    }
}

function realizar_ingreso() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "realizar_ingreso";

    var conteo_ingresos     = document.getElementById('conteo_ingresos').value;
    var factura_proveedor   = document.getElementById('factura_proveedor').value;
    var productos_asignados = document.getElementsByName('productos_asignados[]');
    var inputStock          = document.getElementsByName('inputStock[]');
    var inputGlosa          = document.getElementsByName('inputGlosa[]');

    var productos           = "";
    var stock               = "";
    var glosa               = "";

    for (var loop = 0; loop < productos_asignados.length; loop++) {
        var asssoc= productos_asignados[loop];
        productos = productos + "" + asssoc.value + ";";
    }

    for (var loop2 = 0; loop2 < inputStock.length; loop2++) {
        var asssoc2= inputStock[loop2];
        stock      = stock + "" + asssoc2.value + ";";
    }

    for (var loop3 = 0; loop3 < inputGlosa.length; loop3++) {
        var asssoc3= inputGlosa[loop3];
        glosa      = glosa + "" + asssoc3.value + ";";
    }



    if(productos.length > 0){

        if (factura_proveedor.length == 0) {
            $("#factura_proveedor").focus();
            Swal.fire("Alerta", "** Ingresar Número de factura proveedor **", "warning");
        } else {
            Swal.fire({
                  title:              'Desea realizar Ingreso ?',
                  showDenyButton:     false,
                  showCancelButton:   true,
                  confirmButtonText:  'SI',
                  cancelButtonText:   'NO',
                  icon:               'question',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#resultado_ingreso").html('');

                    var formData = new FormData();                    
                    formData.append('productos', productos);              
                    formData.append('stock', stock);                   
                    formData.append('glosa', glosa);                
                    formData.append('conteo_ingresos', conteo_ingresos);             
                    formData.append('factura_proveedor', factura_proveedor);             
                    formData.append('accion', accion);

                    $.ajax({                    
                        url:         url_link+"app/vistas/bodega/php/validador.php",                    
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

                                Fancybox.show([{
                                    src:      url_link+"app/vistas/bodega/php/imprimir_informe.php?lote="+sec+"&tipo_movimiento=2",
                                    type:     "iframe",
                                    preload:  false,
                                    width:    1800,
                                    height:   1200,
                                    dragToClose : false,
                                    click: close,
                                }]);
                            })  
                          },
                        error:       function(sec) {
                            Swal.fire("Error", "Error"+sec, "error");
                        }
                    });
                }
            });
        }
    }
}


function salidas_productos_lista() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "salidas_productos_lista";

    var productos  = new Array();
    $('#productos option:selected').each(function(){
        productos.push($(this).val());
    });

    if(productos.length > 0){
        $("#resultado_ingreso").html('');
        $('#resultado_ingreso').load(url_link+"/app/recursos/img/loader.svg");
        $('#resultado_ingreso').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion, productos:productos});
    }
}

function realizar_salida() {
    const url_link = document.getElementById('url_link').value;
    var accion     = "realizar_salida";

    var nombre_retira       = document.getElementById('nombre_retira').value;
    var rut_retira          = document.getElementById('rut_retira').value;
    var rutArreglo          = rut_retira.split("-");
    var inputSucursal       = document.getElementById('inputSucursal').value;
    var descripcion         = document.getElementById('descripcion').value;


    var conteo_ingresos     = document.getElementById('conteo_egreso').value;
    var productos_asignados = document.getElementsByName('productos_asignados[]');
    var inputStock          = document.getElementsByName('inputStock[]');
    var inputGlosa          = document.getElementsByName('inputGlosa[]');

    var productos           = "";
    var stock               = "";
    var glosa               = "";

    for (var loop = 0; loop < productos_asignados.length; loop++) {
        var asssoc= productos_asignados[loop];
        productos = productos + "" + asssoc.value + ";";
    }

    for (var loop2 = 0; loop2 < inputStock.length; loop2++) {
        var asssoc2= inputStock[loop2];
        stock      = stock + "" + asssoc2.value + ";";
    }

    for (var loop3 = 0; loop3 < inputGlosa.length; loop3++) {
        var asssoc3= inputGlosa[loop3];
        glosa      = glosa + "" + asssoc3.value + ";";
    }

    if (nombre_retira.length == 0) {
        $("#nombre_retira").focus();
        Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
    } else if (rut_retira.length == 0) {
        $("#rut_retira").focus();
        Swal.fire("Alerta", "** Ingresar Rut **", "warning");
    }  else if (inputSucursal == 0) {
        $("#inputSucursal").focus();
        Swal.fire("Alerta", "** Selecciona Sucursal **", "warning");
    } else if (productos.length > 0){
        Swal.fire({
              title:              'Desea realizar Ingreso ?',
              showDenyButton:     false,
              showCancelButton:   true,
              confirmButtonText:  'SI',
              cancelButtonText:   'NO',
              icon:               'question',
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resultado_ingreso").html('');

                var formData = new FormData();                    
                formData.append('nombre_retira', nombre_retira);            
                formData.append('rut_retira', rut_retira);            
                formData.append('inputSucursal', inputSucursal);            
                formData.append('descripcion', descripcion);            
                formData.append('productos', productos);            
                formData.append('stock', stock);                   
                formData.append('glosa', glosa);                
                formData.append('conteo_ingresos', conteo_ingresos);                
                formData.append('accion', accion);

                $.ajax({                    
                    url:         url_link+"app/vistas/bodega/php/validador.php",                    
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

                            Fancybox.show([{
                                src:      url_link+"app/vistas/bodega/php/imprimir_informe_salida.php?lote="+sec+"&tipo_movimiento=1",
                                type:     "iframe",
                                preload:  false,
                                width:    1800,
                                height:   1200,
                                dragToClose : false,
                                click: close,
                            }]);
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

function mostrar_informe(lote, tipo) {
    const url_link = document.getElementById('url_link').value;

    if (tipo == 1) {
        Fancybox.show([{
            src:            url_link+"app/vistas/bodega/php/imprimir_informe_salida.php?lote="+lote+"&tipo_movimiento="+tipo,
            type:           "iframe",
            preload:        false,
            width:          800,
            height:         1200,
            dragToClose:   false,
            click:          close,
        }]);
    } else {
        Fancybox.show([{
            src:            url_link+"app/vistas/bodega/php/imprimir_informe.php?lote="+lote+"&tipo_movimiento="+tipo,
            type:           "iframe",
            preload:        false,
            width:          800,
            height:         1200,
            dragToClose:   false,
            click:          close,
        }]);
    }
}

function buscar_movimientos_caja() {
    const url_link  = document.getElementById('url_link').value;
    var accion      = "buscar_movimientos_caja";

    var desde           = document.getElementById('desde').value;
    var hasta           = document.getElementById('hasta').value;

    $("#traer_reporteria").html('');
    $('#traer_reporteria').load(url_link+"/app/recursos/img/loader.svg");
    $('#traer_reporteria').load(url_link+"app/vistas/bodega/php/validador_merma.php", {accion:accion, desde:desde, hasta:hasta});
}




/**************************************************************************************************************/


function nueva_categoria(){
  const url_link = document.getElementById('url_link').value;
  var accion     = "nueva_categoria";

  $("#nueva_categoria").html('');
  $('#nueva_categoria').load(url_link+"/app/recursos/img/loader.svg");
  $('#nueva_categoria').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion});
}

function crear_categoria() {
  var inputNombre = document.getElementById('inputNombre').value;
  var tipo_categoria = document.getElementById('tipo_categoria').value;
  const url_link  = document.getElementById('url_link').value;
  var accion      = "crear_categoria";

  if(inputNombre.length == 0){
    $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if (tipo_categoria == 0) {
    $("#tipo_categoria").focus();
    Swal.fire("Alerta", "** Seleccionar Tipo Categoria **", "warning");
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
                formData.append('tipo_categoria', tipo_categoria);
                formData.append('inputNombre', inputNombre);
                formData.append('accion', accion);
              
            $.ajax({
              url:         "../../bodega/php/validador.php",
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
  $('#nueva_marca').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion});
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
              url:         "../../bodega/php/validador.php",
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
  $('#nueva_marca').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion, idMarca:idMarca});
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
          url:         "../../bodega/php/validador.php",
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
  $('#nueva_categoria').load(url_link+"app/vistas/bodega/php/validador.php", {accion:accion, idCategoria:idCategoria});
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
          url:         "../../bodega/php/validador.php",
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