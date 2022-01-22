<?php
include("../php/conexion.php");//Contiene las variables de configuración para conectar a la base de datos
include ('../php/is_logged.php');
date_default_timezone_set('America/Mexico_City');

$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","{","}","=");
$caracteres_buenos = array("", "", "", "", "", "", "", "","","", "","","", "","","");
		 
// Eliminamos cualquier tipo de código HTML o JavaScript
$valorDescripcion = $conn->real_escape_string($_POST["valorDescripcion"]);

//ELIMINAR CODIGO PHP
$Descripcion = str_replace($caracteres_malos, $caracteres_buenos, $valorDescripcion);
$Entrega = $conn->real_escape_string($_POST["valorEntrega"]);
$Cantidad = $conn->real_escape_string($_POST["valorCantidad"]);
$Anticipo = $conn->real_escape_string($_POST["valorAnticipo"]);
$Descuento = $conn->real_escape_string($_POST["valorDescuento"]);
$Id = $conn->real_escape_string($_POST["valorIdCliente"]);
$Domicilio = $conn->real_escape_string($_POST["valorDomicilio"]);
$Hora = $conn->real_escape_string($_POST["valorHora"]);

$Hoy = date('Y-m-d'); 
$id_usuario = $_SESSION['id'];

if ($Descuento > 0) {
    $Cantidad = $Cantidad-$Descuento;
}
// Comprobamos si el usuario o el correo ya existe
$sql =mysqli_query($conn, "SELECT * FROM servicios WHERE id_cliente = '$Id'");
$No = 'Si';
if (mysqli_num_rows($sql) <= 0) {
    $insert = "INSERT INTO servicios (id_cliente, cantidad, anticipo, descripcion, fecha_entrada, fecha_entrega, hora_entrega, usuario, cont, estatus, domicilio) VALUES ('$Id', '$Cantidad', '$Anticipo', '$Descripcion', '$Hoy', '$Entrega','$Hora', '$id_usuario', 1, 'Pendiente', '$Domicilio')";
} else {
    $sql =mysqli_query($conn, "SELECT * FROM servicios WHERE id_cliente = '$Id' AND cantidad = '$Cantidad' AND descripcion = '$Descripcion' AND fecha_entrada = '$Hoy' AND hora_entrega = '$Hora'");
    if (mysqli_num_rows($sql) == 1) {
      echo '<script>M.toast({html:"Ya existe un servicio con los mismos valores.", classes: "rounded"})</script>';
      $No = 'No';
    }else{
      $cont_sql = mysqli_fetch_array(mysqli_query($conn, "SELECT cont FROM servicios WHERE id_cliente = '$Id' ORDER BY id DESC LIMIT 1"));
      if ($cont_sql['cont'] == 3) {
        $Cont = 1;
      }else{
        $Cont = $cont_sql['cont']+1;
      }
      $insert = "INSERT INTO servicios (id_cliente, cantidad, anticipo, descripcion, fecha_entrada, fecha_entrega, hora_entrega, usuario, cont, estatus, domicilio) VALUES ('$Id', '$Cantidad', '$Anticipo', '$Descripcion', '$Hoy', '$Entrega','$Hora', '$id_usuario', '$Cont', 'Pendiente', '$Domicilio')";
    }
}
if ($No == 'No') {
    # code...
}else if (mysqli_query($conn,$insert)){
    echo '<script>M.toast({html:"Se agrego el servicio correctamente.", classes: "rounded"})</script>'; 
    $ultimo =  mysqli_fetch_array(mysqli_query($conn, "SELECT MAX(id) AS id FROM servicios WHERE id_cliente = $Id"));            
    $id = $ultimo['id'];
    ?>
    <script>
    id = <?php echo $id; ?>;
    var a = document.createElement("a");
      a.target = "_blank";
      a.href = "../php/imprimir.php?Id="+id;
      a.click();
    </script> 
    <?php
}else{
    echo '<script>M.toast({html:"Ocurrio un error, intente mas tarde.", classes: "rounded"})</script>';
}
?>
<div id="mostrar_servicios">
      <table class="bordered highlight responsive-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Fecha Entrada</th>
            <th>Fecha Entrega</th>
            <th>Fecha Listo</th>
            <th>Fecha Salida</th>
            <th>Registro</th>
            <th>Imprimir</th>
            <th>Borrar</th>
          </tr>
        </thead>
      <tbody>
        <?php
      $sql_servicios = mysqli_query($conn,"SELECT * FROM servicios WHERE id_cliente = ".$Id."  ORDER BY id DESC");
      $aux = mysqli_num_rows($sql_servicios);
      if($aux>0){
      while($servicio = mysqli_fetch_array($sql_servicios)){
        $id_user = $servicio['usuario'];
        $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$id_user'"));
      ?> 
      <tr>
        <td><b><?php echo $aux;?></b></td>
        <td>$<?php echo $servicio['cantidad'];?></td>
        <td><?php echo $servicio['descripcion'];?></td>
        <td><?php echo $servicio['fecha_entrada'];?></td>
        <td><?php echo $servicio['fecha_entrega'];?></td>
        <td><?php echo $servicio['fecha_listo'];?></td>
        <td><?php echo $servicio['fecha_salida'];?></td>
        <td><?php echo $user['usuario']; ?></td>
        <td><a onclick="imprimir(<?php echo $servicio['id'];?>);" class="btn-small indigo darken-4 waves-effect waves-light"><i class="material-icons">print</i></a>
        </td>
        <td><a onclick="borrar(<?php echo $servicio['id'];?>);" class="btn-small red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a>
        </td>
      </tr>
      <?php
      $aux--;
      }//Fin while
      }else{
      echo "<center><b><h4>Este cliente aún no ha registrado servicios</h4></b></center>";
    }
    ?> 
      
    </tbody>
  </table>    
  </div>