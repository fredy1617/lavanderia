<?php

include("../php/conexion.php");//Contiene las variables de configuración para conectar a la base de datos
include ('../php/is_logged.php');date_default_timezone_set('America/Mexico_City');

$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","{","}","=");
$caracteres_buenos = array("", "", "", "", "", "", "", "","","", "","","", "","","");
			
// Eliminamos cualquier tipo de código HTML o JavaScript
$valorNombre = $conn->real_escape_string($_POST["valorNombre"]);
$valorUserName = $conn->real_escape_string($_POST["valorTelefono"]);
$valorCargo = $conn->real_escape_string($_POST["valorCorreo"]);

//ELIMINAR CODIGO PHP
$valorNombre = str_replace($caracteres_malos, $caracteres_buenos, $valorNombre);
$valorTelefono = str_replace($caracteres_malos, $caracteres_buenos, $valorUserName);
$valorCorreo = str_replace($caracteres_malos, $caracteres_buenos, $valorCargo);   
$valorId = $conn->real_escape_string($_POST["valorId"]);

// Escribimos el nuevo usuario en la base de datos
$sql = "UPDATE clientes SET nombre ='$valorNombre', telefono = '$valorTelefono', correo = '$valorCorreo' WHERE  id = '$valorId'";
    // Si el usuario fue añadido con éxito
    if (mysqli_query($conn,$sql)) {
        echo '<script>M.toast({html:"Cliente actualizado correctamente.", classes: "rounded"})</script>';
    } else {
    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
    }
    ?>
    <script>
        var a = document.createElement("a");
          a.href = "../views/clientes.php";
          a.click();   
    </script>
    <?php
?>
