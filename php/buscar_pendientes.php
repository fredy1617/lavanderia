<?php
include 'conexion.php';

$Texto = $conn->real_escape_string($_POST['texto']);
$mensaje = '';

date_default_timezone_set('America/Mexico_City');
$Hoy = date('Y-m-d'); 
//Comprueba si $Texto está seteado
if (isset($Texto)) {
	$consulta = mysqli_query($conn, "SELECT * FROM servicios WHERE (id LIKE '%$Texto%' OR id = '$Texto' OR id_cliente = '$Texto') AND estatus = 'Pendiente' ORDER BY fecha_entrega, hora_entrega LIMIT 50");
	$filas = mysqli_num_rows($consulta);
	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas == 0) {
		echo '<script>M.toast({html:"No se encontraron servicios pendientes.", classes: "rounded"})</script>';
	} else {
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle	
		while($resultados = mysqli_fetch_array($consulta)) {
		  $id_cliente = $resultados['id_cliente'];
		  $cliente = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM clientes WHERE id=$id_cliente"));
		  $estatus = 0;	
	      $date1 = new DateTime($Hoy);
	      $date2 = new DateTime($resultados['fecha_entrega']);
	      //Le restamos a la fecha date1-date2
	      $diff = $date2->diff($date1);
	      $estatus= $diff->days;
	    
	      $color = "green";
	      if ($Hoy>$resultados['fecha_entrega']) {
	      	$estatus = -1*$estatus;
	      }
	      if ($estatus == 1) {
	      	$Dia = "<b>MAÑANA</b>";
	      }elseif ($estatus == -1) {
	      	$Dia = "<b>AYER</b>";
	      }else{
	      	$Dia = $resultados['fecha_entrega'];
	      }
	      if ($estatus == 0) { 
	      	$color = "indigo darken-2";
	      	$Dia = "<b>HOY</b>";
	      }elseif ($estatus < 0) { $color = "red accent-4"; }	

	      
      
      		$mensaje .= '
                  <tr>
                    <td><span class="new badge '.$color.'" data-badge-caption="">'.$estatus.'</span></td>
		            <td>'.$resultados['id'].'</td>
		            <td>'.$cliente['id'].' - '.$cliente['nombre'].'</td>
		            <td>'.$resultados['fecha_entrada'].'</td>
		            <td>'.$Dia.'</td>
		            <td>'.$resultados['hora_entrega'].'</td>
		            <td>$'.$resultados['anticipo'].'</td>
		            <td>$'.$resultados['cantidad'].'</td>
		            <td>'.$resultados['descripcion'].'</td>
		            <td><a onclick="listo('.$resultados['id'].')" class="btn-small green darken-1 waves-effect waves-light"><i class="material-icons">check</i></a></td>
		          </tr>';     

		}//Fin while $resultados
	} //Fin else $filas

}//Fin isset $Texto

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;

mysqli_close($conn);
?>