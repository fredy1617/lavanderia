<?php
include ('../php/is_logged.php');
include('../php/conexion.php');
$valorId = $conn->real_escape_string($_POST["valorId"]);
$IdCliente = $conn->real_escape_string($_POST["valorIdCliente"]);
$id_usuario = $_SESSION['id'];

$area = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id=$id_usuario"));

if($area['rol']!="Administrador"){
	echo '<script>M.toast({html:"Permiso denegado. Direccionando a la página principal.", classes: "rounded"})</script>';
  	?>
	<script>
	    var a = document.createElement("a");
	        a.href = "../views/home.php";
	        a.click();   
	</script>
<?php
}else{
	$sql_delete = "DELETE FROM servicios WHERE id = $valorId";

	if(mysqli_query($conn, $sql_delete)){
	    echo '<script>M.toast({html:"Servico eliminado.", classes: "rounded"})</script>';
	}else{
	    echo '<script>M.toast({html:"Ocurrio un error.", classes: "rounded"})</script>';
	}
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
      $sql_servicios = mysqli_query($conn,"SELECT * FROM servicios WHERE id_cliente = ".$IdCliente."  ORDER BY id DESC");
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