<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('Nav.php');
  include('../php/admin.php');
?>
<title>Lavanderia | Agregar Usuarios</title>
<script>
  function insert_usuario() {
      var textoNombre = $("input#nombre").val();
      var textoApellidos = $("input#apellidos").val();
      var textoUsuario = $("input#usuario").val();
      var textoContra = $("input#contra").val();
      var textoRepiteContra = $("input#repite_contra").val();
      var textoRol = $("select#rol").val();
      var textoCargo = $("input#cargo").val();
    
      if (textoNombre == "") {
        M.toast({html:"Por favor ingrese el nombre(s).", classes: "rounded"});
      }else if(textoApellidos == ""){
        M.toast({html:"Por favor ingrese los apellidos.", classes: "rounded"});
      }else if(textoUsuario == ""){
        M.toast({html:"Por favor ingrese el nombre de usuario.", classes: "rounded"});
      }else if(textoContra == ""){
        M.toast({html:"Por favor ingrese una contraseña.", classes: "rounded"});
      }else if ((textoContra.length) < 6) {
        M.toast({html:"Por favor ingrese una contraseña mas larga.", classes: "rounded"});
      }else if(textoContra != textoRepiteContra){
        M.toast({html:"Las contraseñas no coinciden.", classes: "rounded"});
      }else if(textoRol == 0){
        M.toast({html:"Seleccione un rol de usuario.", classes: "rounded"});
      }else if(textoCargo == ""){
        M.toast({html:"Por favor ingrese un cargo.", classes: "rounded"});
      }else{
        $.post("../php/insert_usuario.php", {
            valorNombre: textoNombre+' '+textoApellidos,
            valorUsuario: textoUsuario,
            valorContra: textoContra,
            valorRol: textoRol,
            valorCargo: textoCargo
          }, function(mensaje) {
              $("#resultado_usuarios").html(mensaje);
          }); 
      }
  };
</script>
</head>
<main>
<body>
  <div class="container">
    <div id="resultado_usuarios"></div>
  <h3>Registrar Usuario</h3>
    <div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" class="validate" required id="nombre">
        <label for="nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" class="validate" required id="apellidos">
        <label for="apellidos">Apellidos</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">sentiment_very_satisfied</i>
        <input type="text" class="validate" required id="usuario">
        <label for="usuario">Nombre de usuario</label>
      </div>
      <div class="input-field col s12 m6 l6"><br>
          <select id="rol" class="browser-default">
            <option value="0" selected>Seleccione un rol</option>
            <option value="Oficina">Usuario</option>
            <option value="Administrador">Administrador</option>
          </select>
          <label></label>
      </div>     
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">security</i>
        <input type="password" class="validate" required id="contra">
        <label for="contra">Contraseña</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">supervisor_account</i>
        <input type="text" class="validate" required id="cargo">
        <label for="cargo">Cargo:</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">verified_user</i>
        <input type="password" class="validate" required id="repite_contra">
        <label for="repite_contra">Repite Contraseña</label>
      </div><br><br>
      <div class="col s12 m6 l6"><br><br>
        <a onclick="insert_usuario();" class="waves-effect waves-light btn indigo darken-4 right"><i class="material-icons right">send</i>Guardar</a>
      </div>
    </div>
  </div>
</body>
</main>
</html>