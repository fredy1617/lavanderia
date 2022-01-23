<?php
include('../php/conexion.php');
include('../php/is_logged.php');
$Pendientes = mysqli_fetch_array(mysqli_query($conn,"SELECT count(*) FROM servicios WHERE estatus = 'Pendiente'"));
$Listos = mysqli_fetch_array(mysqli_query($conn,"SELECT count(*) FROM servicios WHERE estatus = 'Listo'"));
?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<!--Import material-icons.css-->
      <link href="css/material-icons.css" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <!--Let browser know website is optimized for mobile-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	  <link rel="shortcut icon" href="img/Logo.png" type="image/png" />
      <style rel="stylesheet">
		.dropdown-content{  overflow: visible;	}
	</style>
	<div class="navbar-fixed">
	<nav class="indigo">
    <div class="nav-wrapper container">
      <a href="home.php" class="brand-logo center"><img  class="responsive-img" style="width: 68px; height: 64px;" src="img/Logo.png"></a>
      <a href="#" data-target="menu-responsive" class="sidenav-trigger">
				<i class="material-icons">menu</i>
	  </a>
      <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li><a class='dropdown-button' data-target='dropdown1'><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">people</i>Admin</a></li>
        <ul id='dropdown1' class='dropdown-content'>
			<li><a href="crear_usuario.php" class="black-text"><i class="material-icons">add</i>Nuevo Usuario</a></li>
			<li><a href="usuarios.php" class="black-text"><i class="material-icons">list</i>Usuarios</a></li>
 		</ul>
        <li><a class='dropdown-button' data-target='dropdown2'><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">edit</i>Servicio</a></li>
        <ul id='dropdown2' class='dropdown-content'>
			<li><a href="#precios" class="black-text modal-trigger"><i class="material-icons">attach_money</i>Precios</a></li>
			<li><a href="crear_cliente.php" class="black-text"><i class="material-icons">add</i>Nuevo Cliente</a></li>
			<li><a href="clientes.php" class="black-text"><i class="material-icons">list</i>Clientes</a></li>
			<li><a href="reportes.php" class="black-text"><i class="material-icons">playlist_add_check</i>Reportes</a></li>
 		</ul>
      </ul>
      <ul class="right hide-on-med-and-down">
      	<li><a class='dropdown-button' data-target='dropdown3'><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">assignment</i>Pendientes</a></li>
		<ul id='dropdown3' class='dropdown-content'>
			<li><a href="pendientes.php" class="black-text"><i class="material-icons">list</i>Pendientes<span class="new badge pink" data-badge-caption=""><?php echo $Pendientes['count(*)'];?></span></a></li>
			<li><a href="entregar.php" class="black-text"><i class="material-icons">playlist_add_check</i>Entregar<span class="new badge pink" data-badge-caption=""><?php echo $Listos['count(*)'];?></span></a></li>
 		</ul>
        <li><a class='dropdown-button' data-target='dropdown4'> <i class="material-icons right">arrow_drop_down</i><?php echo $_SESSION['usuario'];?></a></li>
		<ul id='dropdown4' class='dropdown-content'>
			<li><a href="../php/cerrar_sesion.php" class="black-text"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 		</ul>
	  </ul>	
	  <ul class="right hide-on-large-only hide-on-small-only">
			<li><a class='dropdown-button' data-target='dropdown10'> <i class="material-icons right">arrow_drop_down</i> <i class="material-icons right">face</i> .</a></li>
			<ul id='dropdown10' class='dropdown-content'>
				<li><a href="../php/cerrar_sesion.php" class="black-text"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 			</ul>
	  </ul>
	  <ul class="right hide-on-med-and-up">
		<li><a class='dropdown-button' data-target='dropdown8'><i class="material-icons left">account_circle</i><b>></b></a></li>
		<ul id='dropdown8' class='dropdown-content'>
			<li><a href="../php/cerrar_sesion.php" class="black-text"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
 		</ul>
	  </ul>			
	</div>		
	</nav>
	</div>
	<ul class="sidenav blue-grey lighten-3" id="menu-responsive" style="width: 270px;">
				<h2>Menú</h2>
    			<li><div class="divider"></div></li>
    			<br>
				<li>
	    			<ul class="collapsible collapsible-accordion">
	    				<li>
	    				  <div class="collapsible-header"><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">people</i>Admin</div>
		      				<div class="collapsible-body blue-grey lighten-3">
		      				  <span>
		      					<ul>
		      					  <li><a href="crear_usuario.php"><i class="material-icons">add</i>Nuevo Usuario</a></li>
								  <li><a href="usuarios.php"><i class="material-icons">list</i>Usuarios</a></li>
					    		</ul>
					          </span>
		      			  </div>    			
	    				</li>	    			
	    			</ul>	     				
	    		</li>
	    		<li>
	    			<ul class="collapsible collapsible-accordion">
	    				<li>
	    				  <div class="collapsible-header"><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">edit</i>Servicio</div>
		      				<div class="collapsible-body blue-grey lighten-3">
		      				  <span>
		      					<ul>
		      					  <li><a href="#precios" class="modal-trigger"><i class="material-icons">attach_money</i>Precios</a></li>
								  <li><a href="crear_cliente.php"><i class="material-icons">add</i>Nuevo Cliente</a></li>
								  <li><a href="clientes.php"><i class="material-icons">list</i>Clientes</a></li>
								  <li><a href="reportes.php"><i class="material-icons">playlist_add_check</i>Reportes</a></li>
					    		</ul>
					          </span>
		      			  </div>    			
	    				</li>	    			
	    			</ul>	     				
	    		</li>
	    		<li>
	    			<ul class="collapsible collapsible-accordion">
	    				<li>
	    				  <div class="collapsible-header"><i class="material-icons right">arrow_drop_down</i><i class="material-icons left">assignment</i>Pendientes</div>
		      				<div class="collapsible-body blue-grey lighten-3">
		      				  <span>
		      					<ul>
		      					  <li><a href="pendientes.php"><i class="material-icons">list</i>Pendientes</a><span class="new badge pink" data-badge-caption=""><?php echo $Pendientes['count(*)'];?></span></li>
								  <li><a href="entregar.php"><i class="material-icons">playlist_add_check</i>Entregar<span class="new badge pink" data-badge-caption=""><?php echo $Listos['count(*)'];?></span></a></li>
					    		</ul>
					          </span>
		      			  </div>    			
	    				</li>	    			
	    			</ul>	     				
	    		</li>
	</ul>
	<?php 
	include('../php/scripts.php');
	include ('modals.php');
	?>
	<script src="js/jquery-3.1.1.js"></script>
	<!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="js/materialize.min.js"></script>
	<script>
    	$(document).ready(function() {
	    
	 	});
	 	$('.dropdown-button').dropdown({
	      	  inDuration: 500,
	          outDuration: 500, constrainWidth: false, // Does not change width of dropdown to that of the activator
	          coverTrigger: false, 
	    });
	    $('.dropdown-btn').dropdown({
	      	  inDuration: 500,
	          outDuration: 500,
	          hover: true,
	          constrainWidth: false, // Does not change width of dropdown to that of the activator
	          coverTrigger: false, 
	    });
		document.addEventListener('DOMContentLoaded', function(){
			M.AutoInit();
		});
		document.addEventListener('DOMContentLoaded', function() {
		    var elems = document.querySelectorAll('.fixed-action-btn');
		    var instances = M.FloatingActionButton.init(elems, {
		      direction: 'left'
		    });
		});
	</script>
