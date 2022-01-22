<!DOCTYPE html>
<html>
<head>
  <title>Lavanderia | Clientes</title>
<?php
include('Nav.php')
?>
<script>
  function delete_cliente(id){
    $.post("../php/delete_cliente.php", {
            valorId: id,
          }, function(mensaje) {
              $("#mostrar").html(mensaje);
          }); 
  };
  function buscar() {
    var texto = $("input#busqueda").val();
    $.post("../php/buscar_cliente.php", {
          texto: texto,
        }, function(mensaje) {
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
      <h3 class="hide-on-med-and-down col s12 m6 l6">Clientes:</h3>
          <h5 class="hide-on-large-only col s12 m6 l6">Clientes:</h5>
          <form class="col s12 m6 l6">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">search</i>
              <input id="busqueda" name="busqueda" type="text" class="validate" onkeyup="buscar();">
              <label for="busqueda">Buscar.. (Ej. No. Cliente, Nombre)</label>
            </div>
          </div>
          </form>
      </div>
            <table class="bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th>Registro</th>
                        <th>Fecha</th>
                        <th>Servicio</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
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