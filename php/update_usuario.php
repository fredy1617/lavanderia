<?php
// Si estamos usando una versión de PHP superior entonces usamos la API para encriptar la contrasela con el archivo: password_api_compatibility_library.php
include_once("password_compatibility_library.php");
include("../php/conexion.php");//Contiene las variables de configuración para conectar a la base de datos
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","{","}","=");
$caracteres_buenos = array("", "", "", "", "", "", "", "","","", "","","", "","","");
			
				// Eliminamos cualquier tipo de código HTML o JavaScript
$valorId = $conn->real_escape_string($_POST["valorIdUsuario"]);
$valorNombre = $conn->real_escape_string($_POST["valorNombre"]);
$valorUserName = $conn->real_escape_string($_POST["valorUsuario"]);
$valorCargo = $conn->real_escape_string($_POST["valorCargo"]);
$valorUserPassword = $conn->real_escape_string($_POST['valorContra']);
$valorUserTelefono = $conn->real_escape_string($_POST['valorTelefono']);

if ($valorUserPassword == 'No') {
    $Pass = '';
}else{
    $valorUserPassword = str_replace($caracteres_malos, $caracteres_buenos, $valorUserPassword);
    $valorUserPassword_hash = password_hash($valorUserPassword, PASSWORD_DEFAULT);
    $Pass = ", password_hash = '$valorUserPassword_hash'";
}

//ELIMINAR CODIGO PHP
$valorNombre = str_replace($caracteres_malos, $caracteres_buenos, $valorNombre);
$valorUserName = str_replace($caracteres_malos, $caracteres_buenos, $valorUserName);
$valorCargo = str_replace($caracteres_malos, $caracteres_buenos, $valorCargo);         
$valorRol = $conn->real_escape_string($_POST['valorRol']);
$valorUserTelefono = str_replace($caracteres_malos, $caracteres_buenos, $valorUserTelefono);
// Se encripta el la contraseña del usuario con la función password_hash(), y retorna una cadena de 60 caracteres
					
$sql = "UPDATE usuarios SET usuario = '$valorUserName', nombre = '$valorNombre', cargo = '$valorCargo', rol = '$valorRol', telefono = '$valorUserTelefono' ".$Pass." WHERE id='$valorId'";
    if(mysqli_query($conn, $sql)){
        echo '<script>M.toast({html:"El usuario se actualizó correctamente.", classes: "rounded"})</script>';
        ?>
        <script>
          var a = document.createElement("a");
            a.href = "../views/usuarios.php";
            a.click();   
        </script>
        <?php
    }else{
        echo '<script>M.toast({html:"Ha ocurrido un error.", classes: "rounded"})</script>';  
    }

mysqli_close($conn);
?>
