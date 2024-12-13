<?php
    require_once __dir__."/../../../controlador/controlador.php";
    require_once __dir__."/../../../controlador/dashboardControlador.php";
	require_once __dir__."/../../../recursos/head.php";

    $mvc2 = new controlador();
    $dash = new DashBoard();
	$hoy  = date("d");
	$mes  = date("m");
    $mvc2->iniciar_sesion();
?>
<input type="hidden" name="nombre_docente" id="nombre_docente" value="<?= $_SESSION['NOMBREUSER']; ?>">
<input type="hidden" name="idUser" id="idUser" value="<?= $_SESSION['IDUSER']; ?>">
<input type="hidden" name="idNivel" id="idNivel" value="<?= $_SESSION['NIVELDOCENTE']; ?>">
<input type="hidden" name="idCurso" id="idCurso" value="<?= $_SESSION['CURSODOCENTE']; ?>">
<input type="hidden" name="idCategoria" id="idCategoria" value="<?= $_REQUEST['idCategoria']; ?>">
<input type="hidden" name="nombreSubCategoria" id="nombreSubCategoria" value="<?= $dash->nombre_Subcategoria($_REQUEST['idSubCategoria']); ?>">
<input type="hidden" name="nombreCategoria" id="nombreCategoria" value="<?= $dash->nombre_categoria($_REQUEST['idCategoria']); ?>">
<input type="hidden" name="idSubCategoria" id="idSubCategoria" value="<?= $_REQUEST['idSubCategoria']; ?>">

<!DOCTYPE html>
<html>
<body>
	<div id='wrap'>
        <div id='calendar'></div>
         <div style='clear:both'></div>

    </div>
</body>
</html>
<script>
    $(document).ready(function() {
        var date                = new Date();
        var d                   = date.getDate();
        var m                   = date.getMonth();
        var y                   = date.getFullYear();
        var nombre_docente      = document.getElementById("nombre_docente").value;
        var nombreCategoria     = document.getElementById("nombreCategoria").value;    
        var nombreSubCategoria  = document.getElementById("nombreSubCategoria").value;    
        var idSubCategoria      = document.getElementById("idSubCategoria").value;    
        var idCategoria         = document.getElementById("idCategoria").value;    
        var idUser              = document.getElementById("idUser").value;  
        var idNivel             = document.getElementById("idNivel").value; 
        var idCurso             = document.getElementById("idCurso").value;

        $('#external-events div.external-event').each(function() {
            var eventObject = {
                title: $.trim($(this).text()) 
            };
            
            $(this).data('eventObject', eventObject);
            
            $(this).draggable({
                zIndex: 980,
                revert: true,      
                revertDuration: 0  
            });
        });
        /* initialize the calendar */

        var calendar =  $('#calendar').fullCalendar({
            header: {
                left:   'title',
                center: 'agendaDay,agendaWeek,month',
                right:  'prev,next today'
            },
            editable:       true,
            firstDay:       1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
            selectable:     true,
            defaultView:    'agendaWeek',
            
            axisFormat: 'h:mm',
            columnFormat: {
                month: 'ddd',    // Mon
                week: 'ddd d', // Mon 7
                day: 'dddd M/d',  // Monday 9/7
                agendaDay: 'dddd d'
            },
            titleFormat: {
                month: 'MMMM yyyy', // September 2009
                week: "MMMM yyyy", // September 2009
                day: 'MMMM yyyy'                  // Tuesday, Sep 8, 2009
            },
            allDaySlot:     false,
            selectHelper:   true,
            select: function(start, end, allDay) {
                fstart          = new Date(start);
                fend            = new Date(end);
                
                dia_ini = fstart.getDate();
                mes_ini = fstart.getMonth()+1;
                ano_ini = fstart.getFullYear();
                hr_ini  = fstart.getHours();
                min_ini = fstart.getMinutes();

                if(min_ini <= 9 || min_ini == 0){
                    mins_ini = "0"+min_ini;
                }else{
                    mins_ini = min_ini;
                }

                if(hr_ini <= 9 || hr_ini == 0){
                    hrs_ini = "0"+hr_ini;
                }else{
                    hrs_ini = hr_ini;
                }

                hora_ini = hrs_ini+":"+mins_ini;

                dia_fin  = fend.getDate();
                mes_fin  = fend.getMonth()+1;
                ano_fin  = fend.getFullYear();
                hr_fin   = fend.getHours();
                min_fin  = fend.getMinutes();

                if(min_fin <= 9 || min_fin == 0){
                    mins_fin = "0"+min_fin;
                }else{
                    mins_fin = min_fin;
                }

                if(hr_fin <= 9 || hr_fin == 0){
                    hrs_fin = "0"+hr_fin;
                }else{
                    hrs_fin = hr_fin;
                }

                hora_fin   = hrs_fin+":"+mins_fin;

                desde   = dia_ini+'-'+mes_ini+'-'+ano_ini;
                hasta   = dia_fin+'-'+mes_fin+'-'+ano_fin;

                if (parseInt(dia_ini) == parseInt(dia_fin)) {
                    texto  = '<span class="color_verde" style="font-size:25px;">'+desde+'</span><table width="80%" style="margin-left:10%;margin-bottom:2%;padding:1%;">';
                    texto += '<tr class="color_fondo4">';
                    texto += '<td width="30%"><b>&nbsp;Sala</b></td>';
                    texto += '<td width="70%">'+nombreSubCategoria+'-'+nombreCategoria+'.</td>';
                    texto += '</tr>';
                    texto += '<tr class="color_fondo4">';
                    texto += '<td width="30%"><b>&nbsp;Docente</b></td>';
                    texto += '<td width="70%">'+nombre_docente+'</td>';
                    texto += '</tr>';
                    texto += '<td colspan="2"><br>';
                    texto += '<table width="100%">';
                    texto += '<tr>';
                    texto += '<td width="50%" align="center"><b>Hora Inicial</b></td><td width="50%" align="center"><b>Hora Final</b></td>';
                    texto += '</tr>';
                    texto += '<tr>';
                    texto += '<td align="center">'+hora_ini+'</td><td align="center">'+hora_fin+'</td>';
                    texto += '</tr>';
                    texto += '</table>';
                    texto += '</td>';
                    texto += '</tr>';
                    texto += '</table>';
                } else {
                    texto  = '<span style="font-size:25px;">'+desde+'</span><table width="80%" style="margin-left:10%;margin-bottom:2%;">';
                    texto += '<tr>';
                    texto += '<td><b>Fecha Inicial</b></td><td><b>Fecha Final</b></td>';
                    texto += '</tr>';
                    texto += '<tr>';
                    texto += '<td>'+desde+'</td><td>'+hasta+'</td>';
                    texto += '</tr>';
                    texto += '<td colspan="2"><br>';
                    texto += '<table width="100%">';
                    texto += '<tr>';
                    texto += '<td width="50%" align="center"><b>Hora Inicial</b></td><td width="50%" align="center"><b>Hora Final</b></td>';
                    texto += '</tr>';
                    texto += '<tr>';
                    texto += '<td align="center">'+hora_ini+'</td><td align="center">'+hora_fin+'</td>';
                    texto += '</tr>';
                    texto += '</table>';
                    texto += '</td>';
                    texto += '</tr>';
                    texto += '</table>';
                }
                Swal.fire({
                    title:              'Registro de Agenda',
                    html:               texto,
                    input:              'textarea',
                    showDenyButton:     false,
                    showCancelButton:   true,
                    confirmButtonText:  'GRABAR',
                    cancelButtonText:   'Cancelar',
                }).then((result) => {

                    if (result.isConfirmed) {

                        var formData = new FormData();
                        formData.append('idUser', $("#idUser").val());
                        formData.append('idCategoria', $("#idCategoria").val());
                        formData.append('idSubCategoria', $("#idSubCategoria").val());
                        formData.append('desde', desde);
                        formData.append('hasta', hasta);
                        formData.append('result', result.value);
                        formData.append('hora_ini', hora_ini);
                        formData.append('hora_fin', hora_fin);
                        formData.append('idNivel', idNivel);
                        formData.append('idCurso', idCurso);


                        $.ajax({
                            url:         "grabar_agenda.php",
                            type:        "POST",
                            data :       formData,
                            processData: false,
                            contentType: false,
                            success:     function(sec) {
                              Swal.fire({
                                    title:              'Registro Realizado correctamente',
                                    icon:             'success',
                                    showDenyButton:     false,
                                    showCancelButton:   false,
                                    confirmButtonText:  'OK',
                                    cancelButtonText:   'Cancelar',
                                }).then((result) => {
                                    location.reload();
                                })  
                            },
                            error:       function(sec) {
                               Swal.fire("Error", "Error", "error")
                            }
                        });

                    }

                })
                calendar.fullCalendar('unselect');
            },
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function(date, allDay) { // this function is called when something is dropped
                var originalEventObject = $(this).data('eventObject');
                var copiedEventObject = $.extend({}, originalEventObject);
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                if ($('#drop-remove').is(':checked')) {
                    $(this).remove();
                }
            },
            
            events: [
                        <?= $dash->traer_registros_calendario($_REQUEST['idCategoria'], $_REQUEST['idSubCategoria']); ?>
                    ],          
        });
    });
</script>
<style>
    #calendar {
/*      float: right; */
        margin: 0 auto;
        width: 100%;
        margin-top: 2%;
        background-color: #FFFFFF;
          border-radius: 6px;
        box-shadow: 0 1px 2px #C3C3C3;
        -webkit-box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.12);
        -moz-box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.12);
        box-shadow: 0px 0px 1px 1px rgba(0,0,0,0.12);
        }

</style>
