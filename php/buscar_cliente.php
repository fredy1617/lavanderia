<?php
include 'conexion.php';

$Texto = $conn->real_escape_string($_POST['texto']);

$mensaje = '';

//Comprueba si $Texto está seteado
if (isset($Texto)) {
	
	$sql = "SELECT * FROM clientes WHERE nombre LIKE '%$Texto%' OR id = '$Texto' LIMIT 20";
	$consulta = mysqli_query($conn, $sql);
	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas == 0) {
		echo '<script>M.toast({html:"No se encontraron clientes.", classes: "rounded"})</script>';
	} else {
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle	
		while($resultados = mysqli_fetch_array($consulta)) {
			$id_usuario = $resultados['usuario'];
			$sql_usuario = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM usuarios WHERE id=$id_usuario"));

			$id = $resultados['id'];
			$nombre = $resultados['nombre'];
			$telefono = $resultados['telefono'];
			$correo = $resultados['correo'];
			$usuario = $sql_usuario['nombre'];
			$fecha = $resultados['fecha'];

			//Output
			$mensaje .= '			
		          <tr>
		            <td>'.$id.'</td>
		            <td>'.$nombre.'</td>
		            <td>'.$telefono.'</td>
		            <td>'.$correo.'</td>
		            <td>'.$usuario.'</td>
		            <td>'.$fecha.'</td>
		            <td><form method="post" action="../views/servicio_cliente.php"><input id="no_cliente" name="no_cliente" type="hidden" value="'.$id.'"><button class="btn-floating btn-tiny waves-effect waves-light indigo"><i class="material-icons">local_drink</i> </button></form></td>
		                <td><form method="post" action="../views/editar_cliente.php"><input id="id_cliente" name="id_cliente" type="hidden" value="'.$id.'"><button class="btn-floating btn-tiny waves-effect waves-light indigo darken-1"><i class="material-icons">edit</i></button></form></td>
		            <td><a onclick="delete_cliente('.$id.')" class="btn-floating red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a></td>
		          </tr>';     

		}//Fin while $resultados
	} //Fin else $filas

}//Fin isset $Texto

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;

mysqli_close($conn);
?>