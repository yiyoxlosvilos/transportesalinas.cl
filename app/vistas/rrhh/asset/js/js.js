$(document).ready(function() {
    $('#productos_list').DataTable({     
      "aLengthMenu": [[10, 20, 30, -1], [10, 20, 30, "Todos"]],
        "iDisplayLength": 10
       });
});

function liquidaciones_ver() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "liquidaciones_ver";

  $("#panel_rrhh").html('');
  $('#panel_rrhh').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_rrhh').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion});
}

function mostrar_liquidaciones_sueldo() {
  const url_link  = document.getElementById('url_link').value;
  var mes         = document.getElementById('fecha_liquidacion').value;
  var ano         = document.getElementById('ano_liquidacion').value;
  var accion      = "liquidaciones_buscar";

  $("#panel_rrhh").html('');
  $('#panel_rrhh').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_rrhh').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, mes:mes, ano:ano});
}

function limpiar_valores(valor){

    valor = valor.toString();
    valor = valor.replace(/\./g, '');
    valor = valor.replace(/\$ /g, '');
    valor = valor.replace(/\$/g, '');
    valor = valor.replace(/\-/g, '');
    valor = valor.replace(/\%/g, '');
    return valor
}

function comprobar_contrato(){
  var inputTipoContrato = document.getElementById('inputTipoContrato').value;

  if(inputTipoContrato == 0) {
    $("#fin_contrato").hide(50);
    $("#fin_contrato").val(0);
  } else if(inputTipoContrato == 1) {
    $("#fin_contrato").hide(50);
    $("#fin_contrato").val(0);
  } else if(inputTipoContrato == 2) {
    $("#fin_contrato").show(50);
  } 
}

function grabar_trabajador(){
  var inputNombre       = document.getElementById('inputNombre').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputTelefono     = document.getElementById('inputTelefono').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var inputSueldo       = document.getElementById('inputSueldo').value;
  var inputCargo        = document.getElementById('inputCargo').value;
  var inputEmpresa      = document.getElementById('inputEmpresa').value;
  var inputTipoContrato = document.getElementById('inputTipoContrato').value;
  var inputIngreso      = document.getElementById('inputIngreso').value;
  var inputFin          = document.getElementById('inputFin').value;

  const url_link        = document.getElementById('url_link').value;
  var accion            = "grabar_trabajador";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputSueldo == 0) {
    $("#inputSueldo").focus();
    Swal.fire("Alerta", "** Ingresar Sueldo **", "warning");
  } else if(inputCargo.length == 0) {
    $("#inputCargo").focus();
    Swal.fire("Alerta", "** Ingresar Cargo **", "warning");
  } else if(inputTipoContrato == 0) {
    $("#inputTipoContrato").focus();
    Swal.fire("Alerta", "** Selecionar Tipo Contrato **", "warning");
  } else if(inputTipoContrato == 0) {
    $("#inputTipoContrato").focus();
    Swal.fire("Alerta", "** Selecionar Tipo Contrato **", "warning");
  } else if(inputTelefono.length == 0) {
    $("#inputTelefono").focus();
    Swal.fire("Alerta", "** Ingresar Telefono **", "warning");
  } else if(inputEmail.length == 0) {
    $("#inputEmail").focus();
    Swal.fire("Alerta", "** Ingresar E-mail **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Crear Trabajador ?',
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
              formData.append('inputEmail', inputEmail);
              formData.append('inputSueldo', inputSueldo);
              formData.append('inputCargo', inputCargo);
              formData.append('inputEmpresa', inputEmpresa);
              formData.append('inputTipoContrato', inputTipoContrato);
              formData.append('inputIngreso', inputIngreso);
              formData.append('inputFin', inputFin);
              formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../rrhh/php/validador.php",
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

function traer_editar_trabajador(idTrabajador) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_trabajador";

  $("#editar_trabajador").html('');
  $('#editar_trabajador').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_trabajador').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, idTrabajador:idTrabajador});
}

function editar_trabajador(idTrabajador){
  var inputNombre       = document.getElementById('inputNombre').value;
  var inputRut          = document.getElementById('inputRut').value;
  var inputTelefono     = document.getElementById('inputTelefono').value;
  var inputEmail        = document.getElementById('inputEmail').value;
  var inputSueldo       = document.getElementById('inputSueldo').value;
  var inputCargo        = document.getElementById('inputCargo').value;
  var inputEmpresa      = document.getElementById('inputEmpresa').value;
  var inputPrestacion   = document.getElementById('inputPrestacion').value;
  var inputTipoContrato = document.getElementById('inputTipoContrato').value;
  var inputIngreso      = document.getElementById('inputIngreso').value;
  var inputFin          = document.getElementById('inputFin').value;
  var accion            = "editar_trabajador";

  if(inputNombre.length == 0){
   $("#inputNombre").focus();
    Swal.fire("Alerta", "** Ingresar Nombre **", "warning");
  } else if(inputRut.length == 0) {
    $("#inputRut").focus();
    Swal.fire("Alerta", "** Ingresar Rut**", "warning");
  } else if(inputSueldo == 0) {
    $("#inputSueldo").focus();
    Swal.fire("Alerta", "** Ingresar Sueldo **", "warning");
  } else if(inputCargo.length == 0) {
    $("#inputCargo").focus();
    Swal.fire("Alerta", "** Ingresar Cargo **", "warning");
  } else if(inputTipoContrato == 0) {
    $("#inputTipoContrato").focus();
    Swal.fire("Alerta", "** Selecionar Tipo Contrato **", "warning");
  } else {
    Swal.fire({
          title:              'Desea Editar Trabajador ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idTrabajador', idTrabajador);
                  formData.append('inputNombre', inputNombre);
                  formData.append('inputRut', inputRut);
                  formData.append('inputTelefono', inputTelefono);
                  formData.append('inputEmail', inputEmail);
                  formData.append('inputSueldo', inputSueldo);
                  formData.append('inputCargo', inputCargo);
                  formData.append('inputEmpresa', inputEmpresa);
                  formData.append('inputPrestacion', inputPrestacion);
                  formData.append('inputTipoContrato', inputTipoContrato);
                  formData.append('inputIngreso', inputIngreso);
                  formData.append('inputFin', inputFin);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../rrhh/php/validador.php",
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

function traer_nuevo_documento(idTrabajador) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_nuevo_documento";

  $("#panel_documentos").html('');
  $('#panel_documentos').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_documentos').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, idTrabajador:idTrabajador});
}

function subir_documento_trabajador() {
  const url_link      = document.getElementById('url_link').value;
  var inputTitulo     = document.getElementById('inputTitulo').value;
  var idTrabajador    = document.getElementById('idTrabajador').value;
  var foto            = ($('input[type="file"]'))[0].files[0]; 
  var archivo         = document.getElementById('input-b8').value;
  var accion          = "subir_documento_trabajador";

  if(inputTitulo.length == 0){
   $("#inputTitulo").focus();
    Swal.fire("Alerta", "** Ingresar Titulo **", "warning");
  } else {
      Swal.fire({
        title:              'Desea subir documento a trabajador ?',
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
                data.append("inputTitulo", inputTitulo);
                data.append("idTrabajador", idTrabajador);

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

function quitar_documento_trabajador(idDocu){
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_documento_trabajador";

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
              url:         "../../rrhh/php/validador.php",
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

//simulacion liquidacion de sueldo
function simular_sueldo(){
  var sueldo_minimo           = parseInt(document.getElementById('sueldo_minimo').value);  //SUELDO MINIMO
  var sueldo_base             = parseInt(document.getElementById('sueldo_base').value);    //SUELDO BASE
  var dias_trabajado          = parseInt(document.getElementById('dias_trabajado').value);
  var gratifica               = parseInt(document.getElementById('gratifica').value);
  var hrextra                 = parseInt(document.getElementById('hrextra').value);
  var comisiones              = parseInt(document.getElementById('comisiones').value);
  var bonos                   = parseInt(document.getElementById('bonos').value);
  var colacion                = parseInt(document.getElementById('colacion').value);
  var movilizacion            = parseInt(document.getElementById('movilizacion').value);
  var afp                     = document.getElementById('afp').value;
  var salud                   = document.getElementById('salud').value;
  var apv                     = document.getElementById('apv').value;
  var anticipos               = document.getElementById('anticipos').value;
  var seguro_vida             = document.getElementById('seguro_vida').value;
  var valor_uf                = document.getElementById('valor_uf').value;
  var adicional_isapre        = document.getElementById('adicional_isapre').value;
  var base_tributable         = document.getElementById('base_tributable').value;
  var caja_compensacion       = document.getElementById('caja_compensacion').value;
  var monto_caja_compensacion = document.getElementById('monto_caja_compensacion').value;
  

  if(hrextra === null){ var hrextra2 = 0; } else { var hrextra2 = hrextra; }

  if(sueldo_base > 1){
    var valor_diario    = (sueldo_base/30);
    var nuevo_sueldo    = (valor_diario*dias_trabajado);
    var valor_hr_dia    = (sueldo_base*0.0077777);
    var medio_valor_hr  = (valor_hr_dia/2);
    var nueva_hr_dia    = Math.round(valor_hr_dia*hrextra2);

/********************* Gratificaciones ****************************/
/********************* Gratificaciones ****************************/

      if(gratifica == 1){

        tope_gratifi  = Math.round((sueldo_minimo*4.75)/12);
        grati_sueldo  = parseInt(nuevo_sueldo)*(25/100);
        grati_horas   = parseInt(nueva_hr_dia)*(25/100);
        grati_comis   = parseInt(comisiones)*(25/100);
        grati_bonos   = parseInt(bonos)*(25/100);
        sumas_grati2  = (grati_sueldo+grati_horas+grati_comis+grati_bonos);   //TOTAL GRATIFICACION

        if(sumas_grati2 >= tope_gratifi) { 
          sumas_grati = tope_gratifi;
        } else { 
          sumas_grati = sumas_grati2; 
        }

        grati_fin    = Math.round(sumas_grati);                  //TOTAL GRATIFICACION REDONDEO
        $('#total_grati').prop('readonly', true);

      } else if(gratifica == 3) {

        grati_sueldo = 0;
        $('#total_grati').prop('readonly', false);

      } else {

        grati_sueldo = 0;
        $('#total_grati').prop('readonly', true);

      }

      total_haber  = (nuevo_sueldo+nueva_hr_dia+sumas_grati+comisiones+bonos+colacion+movilizacion);   //TOTAL HABERES
      total_haber2 = (sueldo_base+nueva_hr_dia+sumas_grati+comisiones+bonos);   //TOTAL HABERES

/********************* Descuentos Previsionales ****************************/
/********************* Descuentos Previsionales ****************************/
      
      if(afp == 0){
        total_afp  = 0;
      } else  {
        var coste_afp    = '1.'+limpiar_valores(afp);
            factor_afp   = (afp/100);
            total_afp    = Math.round(total_haber2*factor_afp);
      }

      if(salud           == 0){
        total_salud      = 0;
        $("#add_isapre").hide(50);
        $("#valor_uf_isapre").html('');
      } else {
        var coste_salud  = (salud/100);
          descto_salud   = (total_haber2-(colacion+movilizacion));
          total_salud    = Math.round(descto_salud*coste_salud);

        // comprobar si es isapre
        var name = $('select[name="salud"] option:selected').text();
        if(name == "ISAPRE"){
          var salud_uf = (total_salud/valor_uf);
            round      = salud_uf.toFixed(2);

          $("#valor_uf_isapre").html(round+" uf");
          $("#add_isapre").show(50);
          $("#add_isapre").val(0);
        } else {
          $("#valor_uf_isapre").html('');
          $("#isapre").val(0);
          $("#add_isapre").hide(50);
          $("#add_isapre").val(0);
        }
      }

      if(adicional_isapre  > 0){
        var add_salud_uf = (adicional_isapre/valor_uf);
          round          = add_salud_uf.toFixed(2);

        $("#valor_uf_isapre_add").html(round+" uf");
      } else {
        $("#valor_uf_isapre_add").html("");
      }

/********************* Seguro Cesantia ****************************/
/********************* Seguro Cesantia ****************************/

    descto_cesantia = (total_haber-(colacion+movilizacion));
    total_cesantia  = Math.round(descto_cesantia*0.006);

/********************* Seguro Cesantia *********************/
/************* Seguro Cesantia base tributable son los haberes, menos afp, fonasa, seg cesantia ***********/

      b_tributable = parseInt(total_haber2)-(parseInt(total_salud)+parseInt(total_afp)+parseInt(total_cesantia));
      
      if(parseInt(b_tributable) > parseInt(base_tributable)){

        $("#impuesto_unico_add").show(50);
        $("#impuesto_unico_add").load('validador.php', {accion:'impuesto_unico', sueldo_base:b_tributable});
      } else {
        $("#impuesto_unico_add").hide(50);
      }

    var impuesto_unico= document.getElementById('impuesto_unico').value;

    total_desctos     = parseInt(total_salud)+parseInt(total_afp)+parseInt(total_cesantia)+parseInt(apv)+parseInt(anticipos)+parseInt(seguro_vida)+parseInt(adicional_isapre)+parseInt(monto_caja_compensacion)+parseInt(impuesto_unico);   //TOTAL HABERES

    // CAMBIAR VALORES INPUT
    $("#total_grati").val(grati_fin);
    $("#total_afp").val(total_afp);
    $("#total_salud").val(total_salud);
    $("#cesantia").val(total_cesantia);
    $("#hrextra_total").val(nueva_hr_dia);

    // CAMBIAR INFORMACION DE RESULTADOS
    $("#haber_tot").html('Haberes<br>'+number_format(total_haber)+'');
    $("#haber_dsc").html('Descuentos<br>'+number_format(total_desctos)+'');
    $("#haber_liq").html('Sueldo l&iacute;quido<br>'+number_format(total_haber-total_desctos)+'');
    $("#haber_tot2").val(total_haber);
    $("#haber_dsc2").val(total_desctos);
    $("#haber_liq2").val(total_haber-total_desctos);
    $("#base_tributable2").val(b_tributable);

    // BLOQUEAR INPUTS
    $('#hrextra_total').prop('readonly', true);

    simular_sueldo_totales();
  }
}

function simular_sueldo_totales(){
  var total_desctos  = document.getElementById('haber_dsc2').value;

  $("#haber_dsc").html('Descuentos<br>'+number_format(total_desctos)+'');
  $("#haber_liq").html('Sueldo l&iacute;quido<br>'+number_format(total_haber-total_desctos)+'');
}

//grabar liquidacion de sueldo
function generar_liquidacion_sueldo(idTrabajador){
  const url_link              = document.getElementById('url_link').value;
  var accion                  = "generar_liquidacion_sueldo";

  var sueldo_base             = document.getElementById('sueldo_base').value;    //SUELDO BAE
  var dias_trabajado          = document.getElementById('dias_trabajado').value;
  var gratifica               = document.getElementById('gratifica').value;
  var total_grati             = document.getElementById('total_grati').value;
  var hrextra                 = document.getElementById('hrextra').value;
  var hrextra_total           = document.getElementById('hrextra_total').value;
  var comisiones              = document.getElementById('comisiones').value;
  var bonos                   = document.getElementById('bonos').value;
  var colacion                = document.getElementById('colacion').value;
  var movilizacion            = document.getElementById('movilizacion').value;
  var afp                     = document.getElementById('afp').value;
  var total_afp               = document.getElementById('total_afp').value;
  var salud                   = document.getElementById('salud').value;
  var total_salud             = document.getElementById('total_salud').value;
  var isapre                  = document.getElementById('isapre').value;
  var adicional_isapre        = document.getElementById('adicional_isapre').value;
  var cesantia                = document.getElementById('cesantia').value;
  var apv                     = document.getElementById('apv').value;
  var anticipos               = document.getElementById('anticipos').value;
  var seguro_vida             = document.getElementById('seguro_vida').value;
  var caja_compensacion       = document.getElementById('caja_compensacion').value;
  var monto_caja_compensacion = document.getElementById('monto_caja_compensacion').value;
  var impuesto_unico          = document.getElementById('impuesto_unico').value;
  var haber_tot2              = document.getElementById('haber_tot2').value;
  var haber_dsc2              = document.getElementById('haber_dsc2').value;
  var haber_liq2              = document.getElementById('haber_liq2').value;

  if(dias_trabajado > 0){

    Swal.fire({
      title:              'Desea generar liquidacion de sueldo?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {

      if(result.isConfirmed){
        $("#traer_liquidacion").html('');
        $('#traer_liquidacion').load(url_link+"/app/recursos/img/loader.svg");
        $("#traer_liquidacion").load('validador.php', {accion:accion, idTrabajador:idTrabajador, sueldo_base:sueldo_base, dias_trabajado:dias_trabajado, gratifica:gratifica, total_grati:total_grati, hrextra:hrextra, hrextra_total:hrextra_total, comisiones:comisiones, bonos:bonos, colacion:colacion, movilizacion:movilizacion, afp:afp, total_afp:total_afp, salud:salud, total_salud:total_salud, isapre:isapre, cesantia:cesantia, apv:apv, anticipos:anticipos, seguro_vida:seguro_vida, adicional_isapre:adicional_isapre, caja_compensacion:caja_compensacion, monto_caja_compensacion:monto_caja_compensacion, haber_tot2:haber_tot2, haber_dsc2:haber_dsc2, haber_liq2:haber_liq2, impuesto_unico:impuesto_unico});
      }
    })
  }
}

function finalizado_liquidaciones(idTrabajador) {
  const url_link              = document.getElementById('url_link').value;
  var accion                  = "finalizado_liquidaciones";

  $("#traer_liquidacion").html('');
  $('#traer_liquidacion').load(url_link+"/app/recursos/img/loader.svg");
  $("#traer_liquidacion").load('validador.php', {accion:accion, idTrabajador:idTrabajador});
}

function liquidacion_de_sueldo(idTrabajador) {
  const url_link              = document.getElementById('url_link').value;
  var accion                  = "liquidacion_de_sueldo";
  
  $("#traer_liquidacion").html('');
  $('#traer_liquidacion').load(url_link+"/app/recursos/img/loader.svg");
  $("#traer_liquidacion").load('validador.php', {accion:accion, idTrabajador:idTrabajador});
}

function vacaciones_ver() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "vacaciones_ver";

  $("#panel_rrhh").html('');
  $('#panel_rrhh').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_rrhh').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion});
}




/*******************************************/

function finiquitos_ver() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "finiquitos_ver";

  $("#panel_rrhh").html('');
  $('#panel_rrhh').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_rrhh').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion});
}

function calcular_dias() {
  var desde       = new Date(document.getElementById("desde").value);
  var hasta       = new Date(document.getElementById("hasta").value);
  var actualDate  = new Date();

  if (hasta > desde)
  {
      var diff    = hasta.getTime() - desde.getTime();
      var calculo = Math.round(diff / (1000 * 60 * 60 * 24));
      var divide  = (Math. trunc(calculo/7)*2);
      $("#cantidad_dias").html(calculo-divide);
      $("#dias").val(calculo-divide);
  }
  else if (hasta != null && hasta < desde) {
      $("#cantidad_dias").html("La fecha hasta debe ser mayor a la fecha desde");
      $("#dias").val(0);
  }
}

function grabar_permiso(idTrabajador){
  const url_link     = document.getElementById('url_link').value;
  var dias_restantes = document.getElementById('dias_restantes').value;
  var tipo_permiso   = document.getElementById('tipo_permiso').value;
  var desde          = document.getElementById("desde").value;
  var hasta          = document.getElementById("hasta").value;
  var dias           = document.getElementById('dias').value;
  var comentario     = document.getElementById('comentario').value;
  var accion         = "grabar_permiso";

  if(dias_restantes < dias){
    Swal.fire("Alerta", "Trabajador tiene "+dias_restantes+" dias disponibles.", "warning");
  } else if(tipo_permiso == 0){
    $("#tipo_permiso").focus();
    Swal.fire("Alerta", "Seleccionar tipo Permiso", "warning");
  } else if(comentario.length == 0) {
    $("#comentario").focus();
    Swal.fire("Alerta", "Escribir comentario", "warning");
  }  else if(dias == 0) {
    Swal.fire("Alerta", "Seleccionar Fechas", "warning");
  } else {

    Swal.fire({
          title:              'Desea grabar permiso ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
    }).then((result) => {
          if (result.isConfirmed) {
          var formData = new FormData();
                  formData.append('idTrabajador', idTrabajador);
                  formData.append('dias_restantes', dias_restantes);
                  formData.append('tipo_permiso', tipo_permiso);
                  formData.append('desde', desde);
                  formData.append('hasta', hasta);
                  formData.append('dias', dias);
                  formData.append('comentario', comentario);
                  formData.append('accion', accion);
              
              $.ajax({
                  url:         "../../rrhh/php/validador.php",
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

function quitar_solicitud(idSolicitud) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_solicitud";

  Swal.fire({
          title:              'Quieres Quitar Solicitud ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('idSolicitud', idSolicitud);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      vacaciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function mostrar_solicitudes(ano) {
  const url_link = document.getElementById('url_link').value;
  var mes_permiso= document.getElementById('mes_permiso').value;
  var accion     = "mostrar_solicitudes";  

  $('#filtro_solicitudes').empty();  
  $('#filtro_solicitudes').load(url_link+"/app/recursos/img/loader.svg");
  $('#filtro_solicitudes').load(url_link+"app/vistas/rrhh/php/validador.php", {mes_permiso:mes_permiso, ano,ano, accion:accion});
}

function calcular_finiquito_trabajador(){
  var fecha_inicio     = document.getElementById('fecha_inicio').value;
  var fecha_final      = document.getElementById('fecha_final').value;
  var uf_valor     = document.getElementById('uf_valor').value;
  var utm_valor    = document.getElementById('utm_valor').value;
  var sueldo_minimo  = document.getElementById('sueldo_minimo').value;
  var tope_sueldo_min  = (uf_valor*90);
  var vacas_pendientes = document.getElementById('vacas_pendientes').value;
  var dias_inabiles    = document.getElementById('dias_inabiles').value;
  var tot_vacas_pen    = document.getElementById('tot_vacas_pendientes').value;
  var tot_concepto_v   = document.getElementById('tot_concepto_vacaciones').value;
  var sueldo_base      = document.getElementById('sueldo_base').value;
  var bono_pendiente   = document.getElementById('bono_pendiente').value;
  var bonos_3_meses    = document.getElementById('bonos_3_meses').value;
  var bono_colacion    = document.getElementById('bono_colacion').value;
  var bono_movilizacion= document.getElementById('bono_movilizacion').value;
  var total_haberes_mes= document.getElementById('total_haberes_mes').value;
  var total_desctos_mes= document.getElementById('total_desctos_mes').value;

  var aFecha1          = fecha_inicio.split('-');
  var aFecha2          = fecha_final.split('-');
  var fFecha1          = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
  var fFecha2          = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
  var dif              = fFecha2-fFecha1;
  var dias             = Math.floor(dif/(1000*60*60*24))+1+parseInt(dias_inabiles);         //dias_trabajados
  var factor           = (dias/360).toFixed(2);                     //factor_dia
  var factor_anos      = (dias/360).toFixed(0);                     //ano_trabajados
    var meses_servicio   = (dias/30);
    var facto_meses      = (15/12);
  var tot_vacas        = Math.round(meses_servicio*facto_meses);    //vacaciones_tomadas
  var tot_sueldo       = (parseInt(sueldo_base)+parseInt(bono_pendiente)+parseInt(bonos_3_meses));
  var renumeracion_dia = Math.round(tot_sueldo/30);

  if (vacas_pendientes == 0) {
    var total_vacaciones = 0;
  } else {
    var total_vacaciones = vacas_pendientes;
  }

  if (factor_anos >= 11) {
    var mostrar = 11;
  } else {
    var mostrar = factor_anos;
  }

  var tot_concepto_vacaciones = (total_vacaciones*renumeracion_dia);
  var total_ano_servicio      = 0;
  //tope gratificacion sueldo minimo * 4.75
  var tope_grati              = (sueldo_minimo*(4.75/12));
  var gratificacion           = (sueldo_base*0.25);

  if(gratificacion > tope_grati) {
    var mostrar_grati  = tope_grati;
  } else {
    var mostrar_grati  = gratificacion;
  }

  var total_sueldo_base = (parseInt(sueldo_base)+parseInt(bono_pendiente)+parseInt(bonos_3_meses)+parseInt(mostrar_grati)+parseInt(bono_colacion)+parseInt(bono_movilizacion));
  var ano_servicio      = (total_sueldo_base*mostrar);
  var sub_total         = (parseInt(ano_servicio)+parseInt(total_sueldo_base)+parseInt(tot_concepto_vacaciones));

  var total_pagar       = ((parseInt(sub_total)+parseInt(total_haberes_mes))-parseInt(total_desctos_mes));

  $("#dias_trabajados").val(dias);
  $("#dias_trabajados_ver").html(dias);

  $("#factor_dia").val(factor);
  $("#factor_dia_ver").html(factor);

  $("#ano_trabajados").val(mostrar);
  $("#ano_trabajados_ver").html(mostrar);

  $("#vacaciones_tomadas").val(tot_vacas);
  $("#vacaciones_tomadas_ver").html(tot_vacas);

  $("#gratificacion").val(mostrar_grati);
  $("#gratificacion_ver").html(number_format(mostrar_grati));

  $("#renumeracion_diaria").val(renumeracion_dia);
  $("#renumeracion_diaria_ver").html(number_format(renumeracion_dia));

  $("#tot_concepto_vacaciones").val(tot_concepto_vacaciones);
  $("#tot_concepto_vacaciones_ver").html(number_format(tot_concepto_vacaciones)); 

  $("#tot_vacas_pendientes").val(total_vacaciones);
  $("#tot_vacas_pendientes_ver").html(total_vacaciones);

  $("#total_sueldo_base").val(total_sueldo_base);
  $("#total_sueldo_base_ver").html(number_format(total_sueldo_base));

  $("#total_pagar").val(total_pagar);
  $("#total_pagar_ver").html(number_format(total_pagar)); 

  $("#ano_servicio").val(ano_servicio);
  $("#ano_servicio_ver").html(number_format(ano_servicio));
  $("#previo_aviso").val(total_sueldo_base);
  $("#previo_aviso_ver").html(number_format(total_sueldo_base));
  $("#tot_vacas_pendientes_propor").val(tot_concepto_vacaciones);
  $("#tot_vacas_pendientes_propor_ver").html(number_format(tot_concepto_vacaciones));
  $("#sub_total_ver").html(number_format(sub_total));
  $("#sub_total").val(sub_total);
}

function generar_finiquito_trabajador(idTrabajador){
  const url_link                  = document.getElementById('url_link').value;
  var accion                      = "generar_finiquito_trabajador";

  var fecha_inicio                = document.getElementById('fecha_inicio').value;
  var fecha_final                 = document.getElementById('fecha_final').value;
  var dias_trabajados             = document.getElementById('dias_trabajados').value;
  var factor_dia                  = document.getElementById('factor_dia').value;
  var ano_trabajados              = document.getElementById('ano_trabajados').value;
  var vacaciones_tomadas          = document.getElementById('vacaciones_tomadas').value;
  var vacas_pendientes            = document.getElementById('vacas_pendientes').value;
  var dias_inabiles               = document.getElementById('dias_inabiles').value;
  var tot_vacas_pendientes        = document.getElementById('tot_vacas_pendientes').value;
  var tot_concepto_vacaciones     = document.getElementById('tot_concepto_vacaciones').value;
  var sueldo_base                 = document.getElementById('sueldo_base').value;
  var bono_pendiente              = document.getElementById('bono_pendiente').value;
  var bonos_3_meses               = document.getElementById('bonos_3_meses').value;
  var renumeracion_diaria         = document.getElementById('renumeracion_diaria').value;
  var gratificacion               = document.getElementById('gratificacion').value;
  var bono_colacion               = document.getElementById('bono_colacion').value;
  var bono_movilizacion           = document.getElementById('bono_movilizacion').value;
  var total_sueldo_base           = document.getElementById('total_sueldo_base').value;
  var ano_servicio                = document.getElementById('ano_servicio').value;
  var previo_aviso                = document.getElementById('previo_aviso').value;
  var tot_vacas_pendientes_propor = document.getElementById('tot_vacas_pendientes_propor').value;
  var sub_total                   = document.getElementById('sub_total').value;
  var total_haberes_mes           = document.getElementById('total_haberes_mes').value;
  var total_desctos_mes           = document.getElementById('total_desctos_mes').value;
  var total_pagar                 = document.getElementById('total_pagar').value;
  var comentario                  = document.getElementById('comentario').value;

  if(fecha_final == 0){
    $("#fecha_final").focus();
    Swal.fire("Alerta", "Seleccionar fecha finiquito", "warning");
  } else if(total_haberes_mes == 0){
    $("#total_haberes_mes").focus();
    Swal.fire("Alerta", "ingresar total Haberes", "warning");
  } else if(total_desctos_mes == 0){
    $("#total_desctos_mes").focus();
    Swal.fire("Alerta", "ingresar total Descuentos", "warning");
  } else if(comentario.length == 0){
    $("#comentario").focus();
    Swal.fire("Alerta", "ingresar comentario causa", "warning");
  } else {
    Swal.fire({
      title:              'Desea generar finiquito?',
      showDenyButton:     false,
      showCancelButton:   true,
      confirmButtonText:  'SI',
      cancelButtonText:   'NO',
      icon:               'question',
    }).then((result) => {

      if(result.isConfirmed){
        $("#traer_finiquito").html('');
        $('#traer_finiquito').load(url_link+"/app/recursos/img/loader.svg");
        $("#traer_finiquito").load('validador.php', {accion:accion, idTrabajador:idTrabajador, fecha_inicio:fecha_inicio, fecha_final:fecha_final, dias_trabajados:dias_trabajados, factor_dia:factor_dia, ano_trabajados:ano_trabajados, vacaciones_tomadas:vacaciones_tomadas, vacas_pendientes:vacas_pendientes, dias_inabiles:dias_inabiles, tot_vacas_pendientes:tot_vacas_pendientes, tot_concepto_vacaciones:tot_concepto_vacaciones, sueldo_base:sueldo_base, bono_pendiente:bono_pendiente, bonos_3_meses:bonos_3_meses, renumeracion_diaria:renumeracion_diaria, gratificacion:gratificacion, bono_colacion:bono_colacion, bono_movilizacion:bono_movilizacion, total_sueldo_base:total_sueldo_base, ano_servicio:ano_servicio, previo_aviso:previo_aviso, tot_vacas_pendientes_propor:tot_vacas_pendientes_propor, sub_total:sub_total, total_haberes_mes:total_haberes_mes, total_desctos_mes:total_desctos_mes, total_pagar:total_pagar, comentario:comentario});
      }
    })

  }
}

function finalizar_finiquito(idTrabajador) {
  const url_link = document.getElementById('url_link').value;

  $("#traer_finiquito").html('');
  $('#traer_finiquito').load(url_link+"/app/recursos/img/loader.svg");
  $("#traer_finiquito").load('documento_finiquito.php', {idTrabajador:idTrabajador, print:1});
}

function finiquitos_buscar(ano) {
  const url_link = document.getElementById('url_link').value;
  var mes_finiquito= document.getElementById('mes_finiquito').value;
  var accion     = "finiquitos_buscar";  

  $('#filtro_finiquito').empty();  
  $('#filtro_finiquito').load(url_link+"/app/recursos/img/loader.svg");
  $('#filtro_finiquito').load(url_link+"app/vistas/rrhh/php/validador.php", {mes_finiquito:mes_finiquito, ano,ano, accion:accion});
}

function configuraciones_ver() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "configuraciones_ver";

  $("#panel_rrhh").html('');
  $('#panel_rrhh').load(url_link+"/app/recursos/img/loader.svg");
  $('#panel_rrhh').load(url_link+"app/vistas/rrhh/php/panel_configuraciones.php", {accion:accion});
}

function grabar_prevision() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "grabar_prevision";

  var nombre     = document.getElementById('nombre').value;
  var descuentos = document.getElementById('descuentos').value;

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else if(descuentos == 0){
    $("#descuentos").focus();
    Swal.fire("Alerta", "ingresar descuentos", "warning");
  } else {
    $("#validar_pension").html('');
    $('#validar_pension').load(url_link+"/app/recursos/img/loader.svg");
    $('#validar_pension').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, nombre:nombre, descuentos:descuentos});
  }
}

function traer_editar_prevision(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_prevision";

  $("#editar_prevision").html('');
  $('#editar_prevision').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_prevision').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id});
}

function grabar_editar_prevision(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "grabar_editar_prevision";

  var nombre     = document.getElementById('nombre').value;
  var descuentos = document.getElementById('descuentos').value;

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else if(descuentos == 0){
    $("#descuentos").focus();
    Swal.fire("Alerta", "ingresar descuentos", "warning");
  } else {
    $("#editar_prevision").html('');
    $('#editar_prevision').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_prevision').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id, nombre:nombre, descuentos:descuentos});
  }
}

function quitar_prevision(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_prevision";

  Swal.fire({
          title:              'Quieres Quitar prevision ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('id', id);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function grabar_pensiones() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "grabar_pensiones";

  var nombre     = document.getElementById('nombre').value;
  var descuentos = document.getElementById('descuentos').value;

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else if(descuentos == 0){
    $("#descuentos").focus();
    Swal.fire("Alerta", "ingresar descuentos", "warning");
  } else {
    $("#validar_prevision").html('');
    $('#validar_prevision').load(url_link+"/app/recursos/img/loader.svg");
    $('#validar_prevision').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, nombre:nombre, descuentos:descuentos});
  }
}

function traer_editar_pensiones(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_pensiones";

  $("#editar_pension").html('');
  $('#editar_pension').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_pension').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id});
}

function grabar_editar_pension(id) {
   const url_link = document.getElementById('url_link').value;
  var accion     = "grabar_editar_pension";

  var nombre     = document.getElementById('nombre').value;
  var descuentos = document.getElementById('descuentos').value;

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else if(descuentos == 0){
    $("#descuentos").focus();
    Swal.fire("Alerta", "ingresar descuentos", "warning");
  } else {
    $("#editar_pension").html('');
    $('#editar_pension').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_pension').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id, nombre:nombre, descuentos:descuentos});
  }
}

function quitar_pension(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_pension";

  Swal.fire({
          title:              'Quieres Quitar pension ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('id', id);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function grabar_isapre() {
  const url_link = document.getElementById('url_link').value;
  var nombre     = document.getElementById('nombre').value;

  var accion     = "grabar_isapre";

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else {
    $("#validar_isapre").html('');
    $('#validar_isapre').load(url_link+"/app/recursos/img/loader.svg");
    $('#validar_isapre').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, nombre:nombre});
  }
}

function traer_editar_isapre(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_isapre";

  $("#editar_isapre").html('');
  $('#editar_isapre').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_isapre').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id});
}

function grabar_editar_isapre(id) {
  const url_link = document.getElementById('url_link').value;
  var nombre     = document.getElementById('nombre').value;

  var accion     = "grabar_editar_isapre";

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else {
    $("#editar_isapre").html('');
    $('#editar_isapre').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_isapre').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id, nombre:nombre});
  }
}

function quitar_isapre(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_isapre";

  Swal.fire({
          title:              'Quieres Quitar isapre ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('id', id);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function grabar_caja() {
  const url_link = document.getElementById('url_link').value;
  var nombre     = document.getElementById('nombre').value;

  var accion     = "grabar_caja";

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else {
    $("#validar_caja").html('');
    $('#validar_caja').load(url_link+"/app/recursos/img/loader.svg");
    $('#validar_caja').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, nombre:nombre});
  }
}

function traer_editar_caja(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "traer_editar_caja";

  $("#editar_caja").html('');
  $('#editar_caja').load(url_link+"/app/recursos/img/loader.svg");
  $('#editar_caja').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id});
}

function grabar_editar_caja(id) {
  const url_link = document.getElementById('url_link').value;
  var nombre     = document.getElementById('nombre').value;

  var accion     = "grabar_editar_caja";

  if(nombre.length == 0){
    $("#nombre").focus();
    Swal.fire("Alerta", "Ingresar Nombre", "warning");
  } else {
    $("#editar_caja").html('');
    $('#editar_caja').load(url_link+"/app/recursos/img/loader.svg");
    $('#editar_caja').load(url_link+"app/vistas/rrhh/php/validador.php", {accion:accion, id:id, nombre:nombre});
  }
}

function quitar_caja(id) {
  const url_link = document.getElementById('url_link').value;
  var accion     = "quitar_caja";

  Swal.fire({
          title:              'Quieres Quitar caja ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('id', id);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function editar_sueldo_minimo() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_sueldo_minimo";

  var sueldo_mini= document.getElementById('sueldo_mini').value;

  Swal.fire({
          title:              'Quieres editar sueldo minimo ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('sueldo_mini', sueldo_mini);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function editar_uf() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_uf";

  var sueldo_uf_mini= document.getElementById('sueldo_uf_mini').value;

  Swal.fire({
          title:              'Quieres editar uf ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('sueldo_uf_mini', sueldo_uf_mini);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}

function editar_utm() {
  const url_link = document.getElementById('url_link').value;
  var accion     = "editar_utm";

  var sueldo_utm_mini= document.getElementById('sueldo_utm_mini').value;

  Swal.fire({
          title:              'Quieres editar utm ?',
          showDenyButton:     false,
          showCancelButton:   true,
          confirmButtonText:  'SI',
          cancelButtonText:   'NO',
          icon:               'question',
  }).then((result) => {
      if (result.isConfirmed) {
      var formData = new FormData();
          formData.append('sueldo_utm_mini', sueldo_utm_mini);
          formData.append('accion', accion);
              
           $.ajax({
              url:         "../../app/vistas/rrhh/php/validador.php",
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
                      configuraciones_ver();
                    })  
                  },
                  error:       function(sec) {
                    Swal.fire("Error", "Error", "error");
                  }
                });
            }
  })
}