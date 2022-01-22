<?php 
include('conexion.php');
$id = $_SESSION['id'];
$area = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id=$id"));

if($area['rol']!="Administrador"){
	echo '<script>M.toast({html:"Permiso denegado. Direccionando a la página principal.", classes: "rounded"})</script>';
  	echo '<script>admin();</script>';
	mysqli_close($conn);
	exit;
}

?>