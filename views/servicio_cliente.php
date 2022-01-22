<html>
<head>
  <title>Lavanderia | Realizar Servicio</title>
</head>
<?php 
include('Nav.php');
include('../php/conexion.php');
if (isset($_POST['no_cliente']) == false) {
  ?>
  <script>    
    function atras() {
      M.toast({html: "Regresando a clientes.", classes: "rounded"})
      setTimeout("location.href='clientes.php'", 800);
    };
    atras();
  </script>
  <?php
}else{
$no_cliente = $_POST['no_cliente'];
?>
<script>   
function imprimir(id){
  var a = document.createElement("a");
      a.target = "_blank";
      a.href = "../php/imprimir.php?Id="+id;
      a.click();
};
function borrar(Id){
  textoIdCliente = <?php echo $no_cliente; ?>;
  $.post("../php/borrar_servicio.php", { 
          valorId: Id,
          valorIdCliente: textoIdCliente,
  }, function(mensaje) {
  $("#mostrar_servicios").html(mensaje);
  }); 
};

function insert_servicio() {  
    var textoIdCliente = $("input#id_cliente").val();
    var textoDescripcion = $("input#descripcion").val();
    var textoEntrega = $("input#fecha_entrega").val();
    var textoCantidad = $("input#cantidad").val();
    var textoAnticipo = $("input#anticipo").val();
    var textoDescuento = $("input#descuento").val();
    var textoHora = $("input#hora").val();
    
    if (document.getElementById('domicilio').checked==true) {
      textoDomicilio = 1;
    }else{
      textoDomicilio = 0;
    }
      
    if (textoDescuento != 0) {
        textoDescripcion = textoDescripcion+"( - Descuento: $"+textoDescuento+" )";
    }

    if (textoDescripcion == "") {
      M.toast({html: 'Ingrese una descripcion.', classes: 'rounded'});
    }else if (textoEntrega == '') {
        M.toast({html: 'Seleccione una fecha de entrega.', classes: 'rounded'});
    }else if (textoCantidad == "" || textoCantidad ==0) {
      M.toast({html: 'El campo Precio se encuentra vacío o en 0.', classes: 'rounded'});
    }else {
        $.post("../php/insert_servicio.php" , { 
            valorCantidad: textoCantidad,
            valorAnticipo: textoAnticipo,
            valorDescripcion: textoDescripcion,
            valorIdCliente: textoIdCliente,
            valorDescuento: textoDescuento,
            valorEntrega: textoEntrega,
            valorDomicilio: textoDomicilio,
            valorHora: textoHora
          }, function(mensaje) {
              $("#mostrar_servicios").html(mensaje);
          });  
    }    
};
</script>
<main>
<body>
<?php
$sql = "SELECT * FROM clientes WHERE id=$no_cliente";
$datos = mysqli_fetch_array(mysqli_query($conn, $sql));
$cont_sql = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servicios WHERE id_cliente = '$no_cliente' ORDER BY id DESC LIMIT 1"));
if ($cont_sql['cont'] == 2) {
  $cont_sql2 = mysqli_query($conn, "SELECT * FROM servicios WHERE id_cliente = '$no_cliente' ORDER BY id DESC LIMIT 0, 2");
  $Suma = 0;
  while($tmp = mysqli_fetch_array($cont_sql2)){
    $Suma = $Suma+$tmp['cantidad'];
  }
  $Descuento = $Suma*0.15;
}else{
  $Descuento = 0;
}
?>
<div class="container">
  <h3 class="hide-on-med-and-down">Realizando servicio del cliente:</h3>
  <h5 class="hide-on-large-only">Realizando servicio del cliente:</h5>
  <ul class="collection">
    <li class="collection-item avatar"><br>
      <img src="../img/cliente.png" alt="" class="circle">
      <span class="title"><b>No. Cliente: </b><?php echo $datos['id'];?></span>
      <p><b>Nombre(s): </b><?php echo $datos['nombre'];?><br>
         <b>Telefono: </b><?php echo $datos['telefono'];?><br>
         <b>Correo: </b><?php echo $datos['correo'];?><br><br>
      </p>
    </li>
  </ul>
  <div id="imprimir"></div><br>
  <h4 class="hide-on-med-and-down indigo-text "><< Nuevo Servicio >></h4>
  <h5 class="hide-on-large-only  indigo-text"><< Nuevo Servicio >></h5>
<!-- ----------------------------  TABs o MENU  ---------------------------------------->
  <div class="row">
    <div class="col s12">
      <div class="row">
      <form class="col s12" name="formMensualidad">
      <br>
      <div class="row">
      <div class="row col s12 m4 l4">
        <div class="input-field">
          <i class="material-icons prefix">edit</i>
          <input id="descripcion" type="text" class="validate" data-length="6"  required>
          <label for="descripcion">Descripcion:</label>
        </div>
      </div>
      <div class="row col s12 m3 l3">
          <label for="fecha_entrega">Fecha de Entrega</label>
          <input id="fecha_entrega"  type="date">
      </div>
      <div class="row col s12 m2 l2">
        <div class="input-field">
          <input id="hora" type="time" class="validate" data-length="6"  required>
          <label for="hora">Hora:</label>
        </div>
      </div>
      <div class="row col s12 m3 l3">
        <div class="input-field">
          <i class="material-icons prefix">payment</i>
          <input id="cantidad" type="number" class="validate" data-length="6"  required>
          <label for="cantidad">Precio ($ 0.00):</label>
        </div>
      </div>
      <div class="row col s12 m4 l4">
        <div class="input-field">
          <i class="material-icons prefix">monetization_on</i>
          <input id="anticipo" type="number" class="validate" data-length="6" value="0" required>
          <label for="anticipo">Anticipo ($ 0.00):</label>
        </div>
      </div>
      <div class="row col s12 m4 l4">
        <div class="input-field">
          <i class="material-icons prefix">money_off</i>
          <input id="descuento" type="number" class="validate" data-length="6" required value="<?php echo $Descuento; ?>">
          <label for="descuento">Descuento ($ 0.00):</label>
        </div>
      </div>
      <div class="col s12 m4 l4">
          <p>
            <br>
            <input type="checkbox" id="domicilio"/>
            <label for="domicilio">A Domicilio</label>
          </p>
        </div>      
      </div>
      <input id="id_cliente" value="<?php echo htmlentities($datos['id']);?>" type="hidden">
    </form>
        <a onclick="insert_servicio();" class="waves-effect waves-light btn indigo darken-4 right"><i class="material-icons right">send</i>Registar Servicio</a>
    </div>
<!-- ----------------------------  TABLA DE FORM 1  ---------------------------------------->
    <h4>Historial </h4>
    <div id="mostrar_servicios">
      <table class="bordered highlight responsive-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Fecha Entrada</th>
            <th>Fecha Entrega</th>
            <th>Fecha Listo</th>
            <th>Fecha Salida</th>
            <th>Registro</th>
            <th>Imprimir</th>
            <th>Borrar</th>
          </tr>
        </thead>
      <tbody>
        <?php
      $sql_servicios = mysqli_query($conn,"SELECT * FROM servicios WHERE id_cliente = ".$datos['id']."  ORDER BY id DESC");
      $aux = mysqli_num_rows($sql_servicios);
      if($aux>0){
      while($servicio = mysqli_fetch_array($sql_servicios)){
        $id_user = $servicio['usuario'];
        $user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id = '$id_user'"));
      ?> 
      <tr>
        <td><b><?php echo $aux;?></b></td>
        <td>$<?php echo $servicio['cantidad'];?></td>
        <td><?php echo $servicio['descripcion'];?></td>
        <td><?php echo $servicio['fecha_entrada'];?></td>
        <td><?php echo $servicio['fecha_entrega'];?></td>
        <td><?php echo $servicio['fecha_listo'];?></td>
        <td><?php echo $servicio['fecha_salida'];?></td>
        <td><?php echo $user['usuario']; ?></td>
        <td><a onclick="imprimir(<?php echo $servicio['id'];?>);" class="btn-small indigo darken-4 waves-effect waves-light"><i class="material-icons">print</i></a>
        </td>
        <td><a onclick="borrar(<?php echo $servicio['id'];?>);" class="btn-small red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a>
        </td>
      </tr>
      <?php
      $aux--;
      }//Fin while
      }else{
      echo "<center><b><h4>Este cliente aún no ha registrado servicios</h4></b></center>";
    }
    ?> 
      
    </tbody>
  </table>    
  </div>
</div>
</div><!------------------ row de TAB o MENU  ------------------------------------->
</div><!-------------------------  CONTAINER  -------------------------------------->
</body>
<?php } ?>
</main>
</html>