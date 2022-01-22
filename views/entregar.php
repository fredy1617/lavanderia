<!DOCTYPE html>
<html>
<head>
  <title>Lavanderia | Entregar</title>
<?php
include('Nav.php')
?>
<script>
  function recargar() {
    setTimeout("location.href='entregar.php'", 800);
  }
  function buscar() {
    var texto = $("input#busqueda").val();
    $.post("../php/buscar_listos.php", {
          texto: texto,
        }, function(mensaje) {
            $("#mostrar").html(mensaje);
        }); 
  };
  function salida(id) {
    $.post("../php/salida.php", {
          texto: texto,
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
      <h3 class="hide-on-med-and-down col s12 m6 l6">Servicios A Entregar:</h3>
          <h5 class="hide-on-large-only col s12 m6 l6">Servicios A Entregar:</h5>
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
                        <th># Serv.</th>
                        <th>Cliente</th>
                        <th>Telefono</th>
                        <th>Fecha Entrega</th>
                        <th>Fecha Listo</th>
                        <th>Total</th>
                        <th>Resta</th>
                        <th>Descripcion</th>
                        <th>Salida</th>
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