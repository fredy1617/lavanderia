<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('Nav.php');
?>
<title>Lavanderia | Editar Cliente</title>
<script>
  function validar_email( email ) 
  {
      var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email) ? true : false;
  };
  function update_cliente(id) {
      var textoNombre = $("input#nombre").val();
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
        M.toast({html:"Por favor ingrese el nombre.", classes: "rounded"});
      }else if(textoTelefono == ""){
        M.toast({html:"Por favor ingrese un telefono.", classes: "rounded"});
      }else if ((textoTelefono.length) < 10) {
        M.toast({html:"El telefono debe de ser de 10 dijitos.", classes: "rounded"});
      }else if (Entra == 'No') {
        M.toast({html:""+Texto, classes: "rounded"});
      }else{
        $.post("../php/update_cliente.php", {
            valorNombre: textoNombre,
            valorTelefono: textoTelefono,
            valorCorreo: textoEmail,
            valorId: id
          }, function(mensaje) {
              $("#resultado_cliente").html(mensaje);
          }); 
      }
  };
</script>
</head>
<?php
if (isset($_POST['id_cliente'])==false) {
  ?>
  <script>
    function atras(){
      M.toast({html: "Regresando a clientes...", classes: "rounded"});
      setTimeout("location.href='clientes.php'", 1000);
    }
    atras();
  </script>
  <?php
}else{
include('../php/conexion.php');
$id_cliente = $_POST['id_cliente'];
$cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id=$id_cliente"));
?>
<main>
<body>
  <div class="container">
    <div id="resultado_cliente"></div>
  <h3>Editar Cliente</h3>
    <div class="row">
    <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" class="validate" required id="nombre" value="<?php echo $cliente['nombre'];?>">
        <label for="nombre">Nombre</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">phone</i>
        <input type="text" class="validate" required id="telefono" value="<?php echo $cliente['telefono'];?>">
        <label for="telefono">Telefono</label>
      </div>
      <div class="input-field col s12 m6 l6">
        <i class="material-icons prefix">mail</i>
        <input type="text" class="validate" required id="correo" value="<?php echo $cliente['correo'];?>">
        <label for="correo">Correo</label>
      </div>
      <br><br>
      <div class="col s12"><br>
        <a onclick="update_cliente(<?php echo $id_cliente;?>);" class="waves-effect waves-light btn indigo darken-4 right"><i class="material-icons right">send</i>Guardar</a>
      </div>
    </div>
  </div>
</body>
</main>
<?php
}
?>
</html>