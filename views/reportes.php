<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('Nav.php');
?>
<title>SIC | Reportes</title>
<script>
  function buscar_pagos(tipo) {
    if (tipo == 2) {
      var textoDe = $("input#fecha_de").val();
      var textoA = $("input#fecha_a").val();
      if (textoA == '' || textoDe == '') {
        M.toast({html:"Seleccione un rango de fechas.", classes: "rounded"});  
      }else{
        $.post("../php/buscar_pagos.php", {
          valorDe: textoDe,
          valorA: textoA,
          valorTipo: tipo
        }, function(mensaje) {
          $("#resultado").html(mensaje);
        }); 
      }
    }else{
      var textoFecha = $("input#fecha").val();
      if (textoFecha == '') {
        M.toast({html:"Seleccione una fecha.", classes: "rounded"});  
      }else{
        $.post("../php/buscar_pagos.php", {
            valorFecha: textoFecha,
            valorTipo: tipo
        }, function(mensaje) {
            $("#resultado").html(mensaje);
        });
      }
    }
  };
</script>
</head>
<main>
<body>
	<div class="container">
    <h3 class="hide-on-med-and-down">Reporte de Pagos de Servicios</h3>
    <h5 class="hide-on-large-only">Reporte de Pagos de Servicios</h5>
    <div class="row">
      <div class="col s12">
        <ul id="tabs-swipe-demo" class="tabs">
          <li class="tab col s6"><a class="active black-text" href="#test-swipe-1">Reporte Diario</a></li>
          <li class="tab col s6"><a class="black-text" href="#test-swipe-2">Reporte Semanal</a></li>
        </ul>
      </div><br><br><br>
      <!-- ----------------------------  FORMULARIO 1 Tabs  ---------------------------------------->
        <div  id="test-swipe-1" class="col s12">
          <div class="row">
            <div class="col s10 l5 m5">
                <label for="fecha">DIA:</label>
                <input id="fecha" type="date" >
            </div>
            <br>
            <div class="col s10 l3 m3 right">
              <button class="btn waves-light waves-effect indigo darken-1" onclick="buscar_pagos(1);"><i class="material-icons prefix right">send</i>BUSCAR</button>
            </div>           
          </div>
        </div>
      <!-- ----------------------------  FORMULARIO 2 Tabs  ---------------------------------------->
        <div  id="test-swipe-2" class="col s12">
          <div class="row">
            <div class="col s12 l5 m5">
              <label for="fecha_de">De:</label>
              <input id="fecha_de" type="date" >    
            </div>
            <div class="col s12 l5 m5">
              <label for="fecha_a">A:</label>
              <input id="fecha_a" type="date" >
            </div>
            <br>
            <div>
              <button class="btn waves-light waves-effect right indigo darken-1" onclick="buscar_pagos(2);"><i class="material-icons prefix">send</i></button>
            </div>
          </div>
        </div>
    <div id="resultado">
    </div>        
  </div>
</body>
</main>
</html>