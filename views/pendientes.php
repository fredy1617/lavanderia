<!DOCTYPE html>
<html>
<head>
  <title>Lavanderia | Pendientes</title>
<?php
include('Nav.php')
?>
<script>
  function buscar() {
    var texto = $("input#busqueda").val();
    $.post("../php/buscar_pendientes.php", {
          texto: texto,
        }, function(mensaje) {
            $("#mostrar").html(mensaje);
        }); 
  };
  function listo(id) {
    $.post("../php/pasar_listos.php", {
          valorId: id
        }, function(mensaje){
            $("#mostrar").html(mensaje);
        }); 
  };
</script>
</head>
<main>
<body onload="buscar();">
  <div class="container">
    <div class="row">
      <br><br>
      <h3 class="hide-on-med-and-down col s12 m6 l6">Servicios Pendientes:</h3>
          <h5 class="hide-on-large-only col s12 m6 l6">Servicios Pendientes:</h5>
          <form class="col s12 m6 l6">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">search</i>
              <input id="busqueda" name="busqueda" type="text" class="validate" onkeyup="buscar();">
              <label for="busqueda">Buscar.. (Ej. No. Cliente, No. Servico)</label>
            </div>
          </div>
          </form>
      </div>
            <table class="bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>Estatus</th>
                        <th># Serv.</th>
                        <th>Cliente</th>
                        <th>Fecha Entrada</th>
                        <th>Entrega</th>
                        <th>Hora Entrega</th>
                        <th>Pago</th>
                        <th>Total</th>
                        <th>Descripcion</th>
                        <th>Listo</th>
                    </tr>
                </thead>
                <tbody id="mostrar">
                </tbody>
            </table>
            <br><br>
        </div>
  </div>
</body>
</main>
</html>