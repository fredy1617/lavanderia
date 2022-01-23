<?php
include('../php/conexion.php');
$Tipo = $conn->real_escape_string($_POST['valorTipo']);

if ($Tipo == 2) {
  $ValorDe = $conn->real_escape_string($_POST['valorDe']);
  $ValorA = $conn->real_escape_string($_POST['valorA']);

  $total_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_entrada >= '$ValorDe' AND fecha_entrada <= '$ValorA' AND anticipo > 0)"));
  $subtotal_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_salida >='$ValorDe' AND fecha_salida <='$ValorA' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $subtotal_cantidad = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(cantidad) AS precio FROM servicios WHERE (fecha_salida >= '$ValorDe' AND fecha_salida <= '$ValorA' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $subtotal_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_salida >='$ValorDe' AND fecha_salida <='$ValorA' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $Liquidacion = $subtotal_cantidad['precio']-$subtotal_anticipo['precio'];
  $sql_anticipo = mysqli_query($conn, "SELECT * FROM servicios WHERE (fecha_entrada >= '$ValorDe' AND fecha_entrada <= '$ValorA' AND anticipo > 0) ORDER BY id DESC");
  $sql_liquidacion = mysqli_query($conn, "SELECT * FROM servicios WHERE (fecha_salida >= '$ValorDe' AND fecha_salida <= '$ValorA' AND estatus = 'Entregado' AND cantidad > anticipo) ORDER BY id DESC");
}else{
  $Fecha = $conn->real_escape_string($_POST['valorFecha']);

  $total_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_entrada = '$Fecha' AND anticipo > 0)"));
  $subtotal_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_salida = '$Fecha' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $subtotal_cantidad = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(cantidad) AS precio FROM servicios WHERE (fecha_salida = '$Fecha' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $subtotal_anticipo = mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(anticipo) AS precio FROM servicios WHERE (fecha_salida = '$Fecha' AND estatus = 'Entregado' AND cantidad > anticipo)"));
  $Liquidacion = $subtotal_cantidad['precio']-$subtotal_anticipo['precio'];
  $sql_anticipo = mysqli_query($conn, "SELECT * FROM servicios WHERE (fecha_entrada = '$Fecha' AND anticipo > 0) ORDER BY id DESC");
  $sql_liquidacion = mysqli_query($conn, "SELECT * FROM servicios WHERE (fecha_salida = '$Fecha' AND estatus = 'Entregado' AND cantidad > anticipo) ORDER BY id DESC");
}

$TOTAL = $total_anticipo['precio']+$Liquidacion;
?>
<br><br>
<h4 class="blue-text">TOTAL = $<?php echo $TOTAL;?></h4><br>
<table class="bordered highlight responsive-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Cliente</th>
        <th>Cantidad</th>
        <th>Tipo</th>
        <th>Descripcion</th>
        <th>Fecha</th>
        <th>Usuario</th>
      </tr>
    </thead>
    <tbody>
    <?php
    #-----------------------------------------------------------------
    # DESGLOSAR PAGOS DE ANTICIPO
    #----------------------------------------------------------------- 
    if(mysqli_num_rows($sql_anticipo)){
      while($servicio_a = mysqli_fetch_array($sql_anticipo)){
        $id_cliente = $servicio_a['id_cliente'];
        $cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre FROM clientes WHERE id = '$id_cliente'"));
        $id_usuario = $servicio_a['usuario'];
        $Usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT usuario FROM usuarios WHERE id = '$id_usuario'"));
        ?>
        <tr> 
          <td><?php echo $servicio_a['id'];?></td>
          <td><?php echo $cliente['nombre'];?></td>
          <td>$<?php echo $servicio_a['anticipo'];?></td>
          <td><b>Anticipo</b></td>
          <td><?php echo $servicio_a['descripcion'];?></td>
          <td><?php echo $servicio_a['fecha_entrada'];?></td>
          <td><?php echo $Usuario['usuario'];?></td>
        </tr>
      <?php
      }//FIN WHILE
    }//FIN IF
    #-----------------------------------------------------------------
    # DESGLOSAR PAGOS DE LIQUIDACION
    #----------------------------------------------------------------- 
    if(mysqli_num_rows($sql_liquidacion)){
      while($servicio_l = mysqli_fetch_array($sql_liquidacion)){
        $id_cliente = $servicio_l['id_cliente'];
        $cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre FROM clientes WHERE id = '$id_cliente'"));
        $id_usuario = $servicio_l['usuario'];
        $Usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT usuario FROM usuarios WHERE id = '$id_usuario'"));
        ?>
        <tr> 
          <td><?php echo $servicio_l['id'];?></td>
          <td><?php echo $cliente['nombre'];?></td>
          <td>$<?php echo $servicio_l['cantidad']-$servicio_l['anticipo'];?></td>
          <td><b>Liquidación</b></td>
          <td><?php echo $servicio_l['descripcion'];?></td>
          <td><?php echo $servicio_l['fecha_salida'];?></td>
          <td><?php echo $Usuario['usuario'];?></td>
        </tr>
      <?php
      }//FIN WHILE
    }//FIN IF
    mysqli_close($conn);
    ?>        
    </tbody>
</table><br><br>