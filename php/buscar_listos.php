<?php
include 'conexion.php';

$Texto = $conn->real_escape_string($_POST['texto']);
$mensaje = '';
//Comprueba si $Texto está seteado
if (isset($Texto)) {
	$consulta = mysqli_query($conn, "SELECT * FROM servicios WHERE (id LIKE '%$Texto%' OR id = '$Texto' OR id_cliente = '$Texto') AND estatus = 'Listo' ORDER BY fecha_entrega LIMIT 50");
	$filas = mysqli_num_rows($consulta);
	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas == 0) {
		echo '<script>M.toast({html:"No se encontraron servicios pendientes.", classes: "rounded"})</script>';
	} else {
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle	
		while($resultados = mysqli_fetch_array($consulta)) {
		  $id_cliente = $resultados['id_cliente'];
		  $cliente = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM clientes WHERE id=$id_cliente"));
      	  $resta = $resultados['cantidad']-$resultados['anticipo'];
      	  ($resultados['domicilio'] == 1)? $icono = ' <i class="material-icons green-text small rigth"> local_shipping </i>':$icono = '';
      		$mensaje .= '
                  <tr>
		            <td>'.$resultados['id'].' '.$icono.'</td>
		            <td>'.$cliente['id'].' - '.$cliente['nombre'].'</td>
		            <td>'.$cliente['telefono'].'</td>
		            <td>'.$resultados['fecha_entrada'].'</td>
		            <td>'.$resultados['fecha_entrega'].'</td>
		            <td>$'.$resultados['cantidad'].'</td>
		            <td>$'.$resta.'</td>
		            <td>'.$resultados['descripcion'].'</td>
		            <td><a href="../php/salida.php?Id='.$resultados['id'].'" onclick = "recargar()" target = "bank" class="btn-small red darken-3 waves-effect waves-light"><i class="material-icons">exit_to_app</i></a></td>
		          </tr>';     

		}//Fin while $resultados
	} //Fin else $filas

}//Fin isset $Texto

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;

mysqli_close($conn);
?>