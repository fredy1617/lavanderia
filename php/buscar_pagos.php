<?php
include('../php/conexion.php');
$ValorDe = $conn->real_escape_string($_POST['valorDe']);
$ValorA = $conn->real_escape_string($_POST['valorA']);
?>
<br><br>
<table class="bordered highlight responsive-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Cliente</th>
        <th>Cantidad</th>
        <th>Servicio</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Usuario</th>
        <th>Estatus</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql_servicio = mysqli_query($conn, "SELECT * FROM servicios WHERE (fecha_entrada >='$ValorDe' AND fecha_entrada <='$ValorA' AND anticipo > 0) OR (fecha_salida >='$ValorDe' AND fecha_salida <='$ValorA' AND estatus = 'Entregado') ORDER BY id");
      $aux = mysqli_num_rows($sql_servicio);
      if($aux>0){
        $Total = 0;
      while($servicio = mysqli_fetch_array($sql_servicio)){
        $id_cliente = $servicio['id_cliente'];
        $cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre FROM clientes WHERE id = '$id_cliente'"));
        $id_usuario = $servicio['usuario'];
        $Usuario = mysqli_fetch_array(mysqli_query($conn, "SELECT usuario FROM usuarios WHERE id = '$id_usuario'"));
        ($servicio['anticipo'] == 0) ? $cantidad = $servicio['cantidad']: $cantidad = $servicio['anticipo'];
        ?>
        <tr> 
          <td><?php echo $aux;?></td>
          <td><?php echo $cliente['nombre'];?></td>
          <td>$<?php echo $cantidad ?></td>
          <td><?php echo $servicio['descripcion'];?></td>
          <td><?php echo ($servicio['anticipo'] == 0) ? $servicio['fecha_salida']:$servicio['fecha_entrada'] ?></td>
          <td><?php echo ($servicio['anticipo'] == 0) ? 'Liquidacion':'Anticipo' ?></td>
          <td><?php echo $Usuario['usuario'];?></td>
          <td><?php echo $servicio['estatus'];?></td>
        </tr>
        <?php
        $aux--;
        $Total += $cantidad;
      }
      ?>
        <tr> 
          <td></td>
          <td><b>TOTAL:</b></td>
          <td><b>$<?php echo $Total ?></b></td>
          <td></td><td></td><td></td><td></td><td></td>
        </tr>
        <?php
      }else{
        echo "<center><b><h5>No se encontraron pagos de servicios</h5></b></center>";
      }
?>
<?php 
mysqli_close($conn);
?>        
    </tbody>
</table><br><br><br>