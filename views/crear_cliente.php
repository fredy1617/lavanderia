<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('Nav.php');
?>
<title>Lavanderia | Agregar Cliente</title>
<script>
  function validar_email( email ) 
  {
      var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email) ? true : false;
  };
  function insert_cliente() {
      var textoNombre = $("input#nombre").val();
      var textoApellidos = $("input#apellidos").val();
      var textoTelefono = $("input#telefono").val();
      var textoEmail = $("input#correo").val();

      if (textoEmail != '') {
        if (!validar_email(textoEmail)) {
        Texto = "Por favor ingrese un Email correcto.";
        Entra = 'No';
        }else{
          Entra = 'Si';
        }
      }else{
        Entra = 'Si';
      }
    
      if (textoNombre == "") {
        M.toast({html:"Por favor ingrese el nombre(s).", classes: "rounded"});
      }else if(textoApellidos == ""){
        M.toast({html:"Por favor ingrese los apellidos.", classes: "rounded"});
      }else if(textoTelefono == ""){
        M.toast({html:"Por favor ingrese un telefono.", classes: "rounded"});
      }else if ((textoTelefono.length) < 10) {
        M.toast({html:"El telefono debe de ser de 10 dijitos.", classes: "rounded"});
      }else if (Entra == 'No') {
        M.toast({html:""+Texto, classes: "rounded"});
      }else{
        $.post("../php/insert_cliente.php", {
            valorNombre: textoNombre+' '+textoApellidos,
            valorTelefono: textoTelefono,
            valorCorreo: textoEmail
          }, function(mensaje) {
              $("#resultado_cliente").html(mensaje);
          }); 
      }
  };
</script>
</head>
<main>
<body>
  <div class="container">
    <div id="resultado_cliente"></div>
  <h3>Registrar Cliente</h3>
    <div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" class="validate" required id="nombre">
        <label for="nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <input type="text" class="validate" required id="apellidos">
        <label for="apellidos">Apellidos</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">phone</i>
        <input type="text" class="validate" required id="telefono">
        <label for="telefono">Telefono</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">mail</i>
        <input type="text" class="validate" required id="correo">
        <label for="correo">Correo</label>
      </div>
      <br><br>
      <div class="col s12"><br>
        <a onclick="insert_cliente();" class="waves-effect waves-light btn indigo darken-4 right"><i class="material-icons right">send</i>Guardar</a>
      </div>
    </div>
  </div>
</body>
</main>
</html>