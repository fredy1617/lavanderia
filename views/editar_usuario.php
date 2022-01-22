<html>
<head>
<?php 
include('Nav.php');
include('../php/admin.php');
?>
<title>Lavanderia | Editar Usuarios</title>
<script>
  function showContent() {
    element = document.getElementById("content");
    element2 = document.getElementById("content2");
    if (document.getElementById('cambio').checked==true) {
      element.style.display='block';
      element2.style.display='block';
    }else {
      element.style.display='none';
      element2.style.display='none';
    }
        
  };
  function update_usuario(){    
      var textoIdUsuario = $("input#id_usuario").val();
      var textoNombre = $("input#nombre").val();
      var textoTelefono = $("input#telefono").val();
      var textoUsuario = $("input#usuario").val();
      var textoRol = $("select#rol").val();
      var textoCargo = $("input#cargo").val();

      if(document.getElementById('cambio').checked==true){
          var textoContra = $("input#contra").val();
          var textoRepiteContra = $("input#repite_contra").val();
          Entra = 'No';
          if(textoContra == ""){
            Texto = "Por favor ingrese una contraseña.";
          }else if ((textoContra.length) < 6) {
            Texto = "Por favor ingrese una contraseña mas larga.";
          }else if(textoContra != textoRepiteContra){
            Texto = "Las contraseñas no coinciden.";
          }else{ Entra = 'Si'}
      }else{
        textoContra = "No";
        Entra = 'Si';
      }
    
      if (textoNombre == "") {
        M.toast({html:"Por favor ingrese el nombre(s).", classes: "rounded"});
      }else if(textoUsuario == ""){
        M.toast({html:"Por favor ingrese el nombre de usuario.", classes: "rounded"});
      }else if(textoCargo == ""){
        M.toast({html:"Por favor ingrese un cargo.", classes: "rounded"});
      }else if(Entra == "No"){
        M.toast({html:""+Texto, classes: "rounded"});
      }else{
        $.post("../php/update_usuario.php", {
              valorIdUsuario: textoIdUsuario,
              valorNombre: textoNombre,
              valorTelefono: textoTelefono,
              valorUsuario: textoUsuario,
              valorContra: textoContra,
              valorRol: textoRol,
              valorCargo: textoCargo
            }, function(mensaje) {
                $("#update_usuario").html(mensaje);
        });
      }
  };
</script>
</head>
<main>
<?php
if (isset($_POST['id_usuario'])==false) {
  ?>
  <script>
    function atras(){
      M.toast({html: "Regresando a usuarios...", classes: "rounded"});
      setTimeout("location.href='usuarios.php'", 1000);
    }
    atras();
  </script>
  <?php
}else{
include('../php/conexion.php');
$id_usuario = $_POST['id_usuario'];
$usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id=$id_usuario"));
?>
<body>
<div class="container">
  <h3 class="hide-on-med-and-down">Editar usuario (<?php echo $id_usuario; ?>)</h3>
  <h5 class="hide-on-large-only">Editar usuario (<?php echo $id_usuario; ?>)</h5>

  <div id="update_usuario"></div>

  <div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" class="validate" required id="nombre" value="<?php echo $usuario['nombre'];?>">
        <label for="nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">supervisor_account</i>
        <input type="text" class="validate" required id="cargo" value="<?php echo $usuario['cargo'];?>">
        <label for="cargo">Cargo:</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">sentiment_very_satisfied</i>
        <input type="text" class="validate" required id="usuario" value="<?php echo $usuario['usuario'];?>">
        <label for="usuario">Nombre de usuario</label>
      </div>
      <div class="input-field col s12 m6 l6">
          <select id="rol" class="browser-default">
            <option value="<?php echo $usuario['rol'];?>" selected><?php echo $usuario['rol'];?></option>
            <option value="Oficina">Usuario</option>
            <option value="Administrador">Administrador</option>
          </select>
      </div> 
      <div class="col s1"><br></div>
      <div class="col s12 m5 l5">
          <p>
            <input type="checkbox" id="cambio"  onchange="javascript:showContent()"/>
            <label for="cambio">Cambiar contraseña</label>
          </p>
      </div>
           
      <div class="input-field col s12 m6 l6" id="content" style="display: none;">
        <i class="material-icons prefix">security</i>
        <input type="password" class="validate" required id="contra">
        <label for="contra">Nueva Contraseña</label>
      </div>
      <div class="input-field col s12 m6 l6" id="content2" style="display: none;">
        <i class="material-icons prefix">verified_user</i>
        <input type="password" class="validate" required id="repite_contra">
        <label for="repite_contra">Repite Contraseña</label>
      </div><br><br>
      <input type="hidden" id="id_usuario" value="<?php echo $id_usuario;?>">
      <div class="row">
        <a onclick="update_usuario();" class="waves-effect waves-light btn indigo darken-4 right"><i class="material-icons right">send</i>Guardar</a>
      </div>
  </div>
</div>

<?php 
mysqli_close($conn);
?>
</div>
</body>
<?php
}
?>
</main>
</html>