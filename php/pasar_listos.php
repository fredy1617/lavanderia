<?php
include("../php/conexion.php");  
$valorId = $conn->real_escape_string($_POST["valorId"]);
date_default_timezone_set('America/Mexico_City');
$Hoy = date('Y-m-d'); 

// Escribimos el nuevo usuario en la base de datos
$sql = "UPDATE servicios SET estatus ='Listo', fecha_listo = '$Hoy' WHERE  id = '$valorId'";
    // Si el usuario fue añadido con éxito
    if (mysqli_query($conn,$sql)) {
        echo '<script>M.toast({html:"Servicio actualizado correctamente.", classes: "rounded"})</script>';
    } else {
    echo '<script>M.toast({html:"Hubo un error, intentelo mas tarde.", classes: "rounded"})</script>';
    }
    ?>
    <script>
        var a = document.createElement("a");
          a.href = "../views/pendientes.php";
          a.click();   
    </script>
    <?php
?>
