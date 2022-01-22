<!DOCTYPE html>
<html>
<head>
	<title>Lavanderia | Usuarios</title>
<?php
include('Nav.php')
?>
<script>
  function eliminar(id){
    $.post("../php/delete_usuario.php", {
            valorId: id,
          }, function(mensaje) {
              $("#resultado_usuarios").html(mensaje);
          }); 
  };
</script>
</head>
<main>
<body>
  <div class="container">
    <h3 id="resultado_usuarios">Usuarios</h3>
            <table class="bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Cargo</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                include('../php/conexion.php');            
                $sql_tmp1 = mysqli_query($conn,"SELECT * FROM usuarios");
                $filas = mysqli_num_rows($sql_tmp1);
                if($filas == 0){
                    ?>
                    <h5 class="center">No hay usuarios</h5>
                    <?php
                }else{
                    while($tmp = mysqli_fetch_array($sql_tmp1)){
                ?>
                    <tr>
                      <td><?php echo $tmp['nombre']; ?></td>
                      <td><?php echo $tmp['usuario']; ?></td>
                      <td><?php echo $tmp['cargo']; ?></td>
                      <td><?php echo $tmp['rol']; ?></td>
                      <td><form action="editar_usuario.php" method="post"><input type="hidden" name="id_usuario" value="<?php echo $tmp['id'];?>"><button type="submit" class="btn-floating btn-tiny waves-effect waves-light indigo darken-1"><i class="material-icons">edit</i></button></form></td>
                      <td><a onclick="eliminar(<?php echo $tmp['id'];?>);" class="btn-floating btn-tiny waves-effect waves-light red darken-1"><i class="material-icons">delete</i></a></td>
                    </tr>
                <?php
                    }
                }
                mysqli_close($conn);
                ?>
                </tbody>
            </table>
            <br><br>
        </div>
  </div>
</body>
</main>
</html>