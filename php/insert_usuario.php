<?php
// Si estamos usando una versión de PHP superior entonces usamos la API para encriptar la contrasela con el archivo: password_api_compatibility_library.php
include_once("password_compatibility_library.php");
include("../php/conexion.php");//Contiene las variables de configuración para conectar a la base de datos
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/",";","?", "php", "echo","{","}","=");
$caracteres_buenos = array("", "", "", "", "", "", "", "","","", "","","", "","","");
			
				// Eliminamos cualquier tipo de código HTML o JavaScript
$valorNombre = $conn->real_escape_string($_POST["valorNombre"]);
$valorUserName = $conn->real_escape_string($_POST["valorUsuario"]);
$valorCargo = $conn->real_escape_string($_POST["valorCargo"]);
$valorUserPassword = $conn->real_escape_string($_POST['valorContra']);

//ELIMINAR CODIGO PHP
$valorNombre = str_replace($caracteres_malos, $caracteres_buenos, $valorNombre);
$valorUserName = str_replace($caracteres_malos, $caracteres_buenos, $valorUserName);
$valorCargo = str_replace($caracteres_malos, $caracteres_buenos, $valorCargo);         
$valorUserPassword = str_replace($caracteres_malos, $caracteres_buenos, $valorUserPassword);
$valorRol = $conn->real_escape_string($_POST['valorRol']);
// Se encripta el la contraseña del usuario con la función password_hash(), y retorna una cadena de 60 caracteres
$valorUserPassword_hash = password_hash($valorUserPassword, PASSWORD_DEFAULT);
					
// Comprobamos si el usuario o el correo ya existe
$sql = "SELECT * FROM usuarios WHERE nombre = '$valorNombre' AND usuario = '$valorUserName' AND rol = '$valorRol' AND cargo = '$valorCargo'";
$query_check_user=mysqli_num_rows(mysqli_query($conn,$sql));
if ($query_check_user == 1) {
    echo '<script>M.toast({html:"Este usuario o correo ya existe en la base de datos.", classes: "rounded"})</script>';
} else {
	// Escribimos el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (usuario, nombre, cargo, rol, password_hash) VALUES('$valorUserName', '$valorNombre', '$valorCargo', '$valorRol', '$valorUserPassword_hash')";
    // Si el usuario fue añadido con éxito
    if (mysqli_query($conn,$sql)) {
        echo '<script>M.toast({html:"Usuario añadido correctamente.", classes: "rounded"})</script>';
    } else {
    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
    }
    ?>
        <script>
          var a = document.createElement("a");
            a.href = "../views/usuarios.php";
            a.click();   
        </script>
    <?php
}
?>
