<?php 
session_start();
if (!isset($_SESSION['usuario'])) {
		header('Location: login_admin.php');
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Administrador</title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="../estilos/estilo-admin.css">
	<script src="../highcharts/highcharts.js"></script>
	<meta charset="utf-8">
</head>
<body>
	<nav>
		<div class="nav-titulo">
			Sistema de Administración
		</div>
		<div class="usuario">
			<div class="img-usuario"><img src="icono.png"></div>
			<div class="nombre-usuario">Eduardo Juárez</div>
			<a href="logout.php"><div class="logout-usuario"><img src="logout.png"></div></a>
		</div>
	</nav>
	<div id="menu">
		<img src="../img/logo-menu.png">
		<ul>
			<a href="administrador.php"><li class="actual">Pedidos Recientes</li></a>
			<a href="ver-pedidos.php"><li>Ver Pedidos</li></a>
			<!-- <a href="inventario.php"><li>Inventario</li></a> -->
			<a href="estadisticas.php"><li>Estadísticas</li></a>
		</ul>
	</div>
	<div id="contenedor">
		 <?php
		 	$con=mysqli_connect('localhost','root','','purificadora_olas');
		 	$Pedidos="SELECT * FROM pedidos WHERE estado=0 ORDER BY fechaentrega ASC";
		 	$resultado=mysqli_query($con,$Pedidos);
		 	// $res=mysqli_fetch_array($resultado);	 	
		 ?> 
		 <h1>Pedidos Recientes</h1>
		 <table>
		 	<tr>
		 		<th>Folio</th>
			 	<th>Cantidad</th>
			 	<th>Tipo</th>
			 	<th>Dirección</th>
			 	<th>Fecha de Entrega</th>
			 	<th>Hora de Entrega</th>
			 	<th>Repartidor</th>
			 	<th></th>
		 	</tr>
		 	<?php
			while ($res = mysqli_fetch_array($resultado)) { ?>
				
			 	<tr>
			 	<form method="GET" action="mandar-repartidor.php">
			 		<td><input type="hidden" name="folio" value="<?php echo $res['folio'];?>"><?php echo $res['folio'];?></td>
			 		<td><?php echo $res['cantidad'];?></td>
			 		<td><?php echo $res['tipogarrafon'];?></td>
			 		<td><?php echo $res['direccion'];?></td>
			 		<td><?php 
			 			if ($res['fechaentrega']==$res['horapedido']) {
			 				echo "Hoy";
			 			}else{ 
			 				echo $res['fechaentrega'];
			 			}?></td>
			 		<td><?php echo $res['horaentrega'];?></td>
			 		<td><select name="repartidor" required>
			 		<option style="display:none" value="">Selecciona uno...</option>
			 			<?php
			 			$Repartidores ="SELECT * FROM repartidores";
		 				$respuesta= mysqli_query($con, $Repartidores);
						while ($resp = mysqli_fetch_array($respuesta)) { ?>
			 				<option value="<?php echo utf8_encode($resp['usuario']);?>"><?php echo utf8_encode($resp['usuario']);?></option>
			 				<?php } ?>
			 		</select></td>
			 		<td><button name="mandarPedido" value="mandar">Enviar Pedido</button></td>	
			 		</form>
			 	</tr>
			 	
			 <?php } ?>
		 </table>
		 
	</div>
</body>
</html>