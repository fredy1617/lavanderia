<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('Nav.php');
?>
<title>SIC | Reporte</title>
<script>
  function buscar_pagos() {
      var textoDe = $("input#fecha_de").val();
      var textoA = $("input#fecha_a").val();
        $.post("../php/buscar_pagos.php", {
            valorDe: textoDe,
            valorA: textoA
          }, function(mensaje) {
              $("#resultado").html(mensaje);
          }); 
  };
</script>
</head>
<main>
<body>
	<div class="container">
      <br>
    	<h3 class="hide-on-med-and-down">Reporte de Pagos de Servicios</h3>
      <h5 class="hide-on-large-only">Reporte de Pagos de Servicios</h5>
        <br>
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
                <button class="btn waves-light waves-effect right indigo darken-1" onclick="buscar_pagos();"><i class="material-icons prefix">send</i></button>
            </div>
        </div>
    <div id="resultado">
    </div>        
  </div>
</body>
</main>
</html>