/////////////////////////////////
// Script para formularios.

function obtener_moneda(){
  var data = $('#take-data-form').serialize();
  var url = $('#take-data-form').attr('action');
  
  $.ajax({
    async : true,
    data : data,
    method : "POST",
    url : url,
    dataType : "json"
  }).done(function(resp) {
    console.log(resp);
  });
}

////////// TOMA DE DATOS.
// Envia los datos personales para ser guardados.

$('#btn_take_data_save').click(function(){
  var data = $('#take-data-form').serialize();
  var url = $('#take-data-form').attr('action');
  
  $.ajax({
    async : true,
    data : data,
    method : "POST",
    url : url,
    dataType : "json"
  }).done(function(resp) {
    console.log(resp);
  });
});

$('#take-data-form #birthdate_1').change(function(){
  var edad = f_edad($('#take-data-form #birthdate_1').val());
  $('#take-data-form #age_1').val(edad);
});

$('#take-data-form #birthdate_2').change(function(){
  var edad = f_edad($('#take-data-form #birthdate_2').val());
  $('#take-data-form #age_2').val(edad);
});

function f_edad(fecha)
{
  var actual = new Date();
  var hdia = actual.getDate();
  var hmes = actual.getMonth();
  var hano = actual.getFullYear();
  var hoy = new Date(hano, hmes, hdia);
  
  var fe = fecha.toString();
  var cdia = fe.split("-")[0];
  var cmes = parseInt(fe.split("-")[1]) - 1;
  var cano = fe.split("-")[2];
  var cumpleanos = new Date(cano, cmes, cdia);
  
  var edad = hano - cano;
  var m = hmes - cmes;

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
    edad--;
  }

  return edad;  
}

$('#take-data-form #maintenance_1').change(function(){
  if ($('#take-data-form #maintenance_1').val()=="1") $('#take-data-form #amount_1').val('0,00');
});

$('#take-data-form #maintenance_2').change(function(){
  if ($('#take-data-form #maintenance_2').val()=="1") $('#take-data-form #amount_2').val('0,00');
});

///////////
// Calcula totales en prestamos.

// Titular 1.
$('#economic-data-form #pending_1_1').change(function(){ $('#economic-data-form #pending_total_1').val(calcula_total_pendiente_prestamos_1()); });
$('#economic-data-form #pending_2_1').change(function(){ $('#economic-data-form #pending_total_1').val(calcula_total_pendiente_prestamos_1()); });
$('#economic-data-form #pending_3_1').change(function(){ $('#economic-data-form #pending_total_1').val(calcula_total_pendiente_prestamos_1()); });
$('#economic-data-form #pending_4_1').change(function(){ $('#economic-data-form #pending_total_1').val(calcula_total_pendiente_prestamos_1()); });
function calcula_total_pendiente_prestamos_1(){
  
  var total = parseFloat($('#economic-data-form #pending_1_1').val()) + parseFloat($('#economic-data-form #pending_2_1').val()) + parseFloat($('#economic-data-form #pending_3_1').val()) + parseFloat($('#economic-data-form #pending_4_1').val());
  return total;
}
$('#economic-data-form #share_1_1').change(function(){ $('#economic-data-form #share_total_1').val(calcula_total_cuotas_prestamos_1()); });
$('#economic-data-form #share_2_1').change(function(){ $('#economic-data-form #share_total_1').val(calcula_total_cuotas_prestamos_1()); });
$('#economic-data-form #share_3_1').change(function(){ $('#economic-data-form #share_total_1').val(calcula_total_cuotas_prestamos_1()); });
$('#economic-data-form #share_4_1').change(function(){ $('#economic-data-form #share_total_1').val(calcula_total_cuotas_prestamos_1()); });
function calcula_total_cuotas_prestamos_1(){
  var total = parseFloat($('#economic-data-form #share_1_1').val()) + parseFloat($('#economic-data-form #share_2_1').val()) + parseFloat($('#economic-data-form #share_3_1').val()) + parseFloat($('#economic-data-form #share_4_1').val());
  return total;
}

// Titular 2.
$('#economic-data-form #pending_1_2').change(function(){ $('#economic-data-form #pending_total_2').val(calcula_total_pendiente_prestamos_2()); });
$('#economic-data-form #pending_2_2').change(function(){ $('#economic-data-form #pending_total_2').val(calcula_total_pendiente_prestamos_2()); });
$('#economic-data-form #pending_3_2').change(function(){ $('#economic-data-form #pending_total_2').val(calcula_total_pendiente_prestamos_2()); });
$('#economic-data-form #pending_4_2').change(function(){ $('#economic-data-form #pending_total_2').val(calcula_total_pendiente_prestamos_2()); });
function calcula_total_pendiente_prestamos_2(){
  var total = parseFloat($('#economic-data-form #pending_1_2').val()) + parseFloat($('#economic-data-form #pending_2_2').val()) + parseFloat($('#economic-data-form #pending_3_2').val()) + parseFloat($('#economic-data-form #pending_4_2').val());
  return total;
}
$('#economic-data-form #share_1_2').change(function(){ $('#economic-data-form #share_total_2').val(calcula_total_cuotas_prestamos_2()); });
$('#economic-data-form #share_2_2').change(function(){ $('#economic-data-form #share_total_2').val(calcula_total_cuotas_prestamos_2()); });
$('#economic-data-form #share_3_2').change(function(){ $('#economic-data-form #share_total_2').val(calcula_total_cuotas_prestamos_2()); });
$('#economic-data-form #share_4_2').change(function(){ $('#economic-data-form #share_total_2').val(calcula_total_cuotas_prestamos_2()); });
function calcula_total_cuotas_prestamos_2(){
  var total = parseFloat($('#economic-data-form #share_1_2').val()) + parseFloat($('#economic-data-form #share_2_2').val()) + parseFloat($('#economic-data-form #share_3_2').val()) + parseFloat($('#economic-data-form #share_4_2').val());
  return total;
}

/// Fin calcula totales en prestamos.

// Ejecuta modal para gestionar los estatus.
$('#btn_manage_status').click( function() {
  $('#operation_manage_mod').modal();
  $('#operation_manage_mod').modal({ keyboard: false });
  $('#operation_manage_mod').modal('show');
});
