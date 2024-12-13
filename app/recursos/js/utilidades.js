var load  = "<br><br><div style='text-align: center;'><img alt='cargando' src='/app/recursos/img/loader.svg'/><br><b>...Cargando Pantalla</b></div>";


document.addEventListener("DOMContentLoaded", function(event) {

const showNavbar = (toggleId, navId, bodyId, headerId) =>{
const toggle = document.getElementById(toggleId),
nav = document.getElementById(navId),
bodypd = document.getElementById(bodyId),
headerpd = document.getElementById(headerId)

// Validate that all variables exist
if(toggle && nav && bodypd && headerpd){
toggle.addEventListener('click', ()=>{
// show navbar
nav.classList.toggle('show')
// change icon
toggle.classList.toggle('bx-x')
// add padding to body
bodypd.classList.toggle('body-pd')
// add padding to header
headerpd.classList.toggle('body-pd')
})
}
}

showNavbar('header-toggle','nav-bar','body-pd','header')

/*===== LINK ACTIVE =====*/
const linkColor = document.querySelectorAll('.nav_link')

function colorLink(){
if(linkColor){
linkColor.forEach(l=> l.classList.remove('active'))
this.classList.add('active')
}
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))

// Your code to run since DOM is loaded and ready
});

function alerta_normal(titulo, texto, mensaje){
	Swal.fire(""+titulo+"", ""+texto+"", ""+mensaje+"");
}

function initCounterNumber() {
    var counter = document.querySelectorAll('.counter-value');
    var speed = 150; // The lower the slower
    counter.forEach(function (counter_value) {
        function updateCount() {
            var target = +counter_value.getAttribute('data-target');
            var count = +counter_value.innerText;
            var inc = target / speed;
            if (inc < 1) {
                inc = 1;
            }
            // Check if target is reached
            if (count < target) {
                // Add inc to count and output in counter_value
                counter_value.innerText = (count + inc).toFixed(0);
                // Call function every ms
                setTimeout(updateCount, 1);
            } else {
                counter_value.innerText = money_format(target);
            }
        };
        updateCount();
    });
}

function initCounterPorcent() {
    var counter = document.querySelectorAll('.counter-value');
    var speed = 150; // The lower the slower
    counter.forEach(function (counter_value) {
        function updateCount() {
            var target = +counter_value.getAttribute('data-target2');
            var count = +counter_value.innerText;
            var inc = target / speed;
            if (inc < 1) {
                inc = 1;
            }
            // Check if target is reached
            if (count < target) {
                // Add inc to count and output in counter_value
                counter_value.innerText = (count + inc).toFixed(0);
                // Call function every ms
                setTimeout(updateCount, 1);
            } else {
                counter_value.innerText = number_format(target);
            }
        };
        updateCount();
    });
}

function getChartColorsArray(chartId) {
    var colors = $(chartId).attr('data-colors');
    var colors = JSON.parse(colors);
    return colors.map(function(value){
        var newValue = value.replace(' ', '');
        if(newValue.indexOf('--') != -1) {
            var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
            if(color) return color;
        } else {
            return newValue;
        }
    })
}

function money_format(amount, decimals){

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return "$ "+amount_parts.join('.');
}

function number_format(amount, decimals){

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + '.' + '$2');

    return  amount_parts.join('.');
}

function mostrar_meta_ventas(ano, mes) {
    const url_link = document.getElementById('url_link').value;
    var fecha_meta = document.getElementById('fecha_meta').value;
    var accion     = "mostrar_metas";

    $('#mostrar_meta_ventas').empty();
    $('#mostrar_meta_ventas').load(url_link+"/app/recursos/img/loader.svg");
    $('#mostrar_meta_ventas').load(url_link+"app/vistas/dashboard/php/validador_dashboard.php", {fecha_meta:fecha_meta, ano,ano, accion:accion});
}

function mostrar_facturas_ventas(ano, mes) {
    const url_link = document.getElementById('url_link').value;
    var fecha_meta = document.getElementById('fecha_meta_ventas').value;
    var accion     = "mostrar_facturas_ventas";

    $('#mostrar_facturas_ventas').empty();
    $('#mostrar_facturas_ventas').load(url_link+"/app/recursos/img/loader.svg");
    $('#mostrar_facturas_ventas').load(url_link+"app/vistas/dashboard/php/validador_dashboard.php", {fecha_meta:fecha_meta, ano,ano, accion:accion});
}

function mostrar_facturas_compras(ano, mes) {
    const url_link = document.getElementById('url_link').value;
    var fecha_meta = document.getElementById('fecha_meta_compras').value;
    var accion     = "mostrar_facturas_compras";

    $('#mostrar_facturas_compras').empty();
    $('#mostrar_facturas_compras').load(url_link+"/app/recursos/img/loader.svg");
    $('#mostrar_facturas_compras').load(url_link+"app/vistas/dashboard/php/validador_dashboard.php", {fecha_meta:fecha_meta, ano,ano, accion:accion});
}

function mostrar_pagos_pendientes(ano, mes) {
    const url_link = document.getElementById('url_link').value;
    var fecha_meta = document.getElementById('pagos_pendientes').value;
    var accion     = "mostrar_pagos_pendientes";

    $('#mostrar_pagos_pendientes').empty();
    $('#mostrar_pagos_pendientes').load(url_link+"/app/recursos/img/loader.svg");
    $('#mostrar_pagos_pendientes').load(url_link+"app/vistas/dashboard/php/validador_dashboard.php", {fecha_meta:fecha_meta, ano,ano, accion:accion});
}

function mostrar_gastos(ano, mes) {
    const url_link = document.getElementById('url_link').value;
    var fecha_meta = document.getElementById('pagos_gastos').value;
    var accion     = "mostrar_gastos";

    $('#mostrar_gastos').empty();
    $('#mostrar_gastos').load(url_link+"/app/recursos/img/loader.svg");
    $('#mostrar_gastos').load(url_link+"app/vistas/dashboard/php/validador_dashboard.php", {fecha_meta:fecha_meta, ano,ano, accion:accion});
}

function validar_rut(ruta){
    const url_link = document.getElementById('url_link').value;
    var inputRut   = document.getElementById('inputRut').value;
    var accion     = "validar_rut";

    $('#validar_rut').empty();
    $('#validar_rut').load(url_link+"/app/recursos/img/loader.svg");
    $('#validar_rut').load(url_link+"app/vistas/"+ ruta +"/php/validador_"+ ruta +".php", {accion:accion, inputRut:inputRut});
}

function limpiar_input(myString){
    return myString.replace(/^\s+/g,'').replace(/\s+$/g,'')
}