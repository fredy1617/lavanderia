<?php
include ('../php/is_logged.php');
include('../php/conexion.php');
$valorId = $conn->real_escape_string($_POST["valorId"]);
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
	mysqli_close($conn);
}else{
	$sql_delete = "DELETE FROM usuarios WHERE id = $valorId";

	if(mysqli_query($conn, $sql_delete)){
	    echo '<script>M.toast({html:"Usuario eliminado.", classes: "rounded"})</script>';
	}else{
	    echo '<script>M.toast({html:"Ocurrio un error.", classes: "rounded"})</script>';
	}
	?>
	<script>
	    var a = document.createElement("a");
	        a.href = "../views/usuarios.php";
	        a.click();   
	</script>
<?php
	mysqli_close($conn);
}
?>