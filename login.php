<!DOCTYPE html>  
<html>
<head>
	<title>La Gran Feria del Juguete</title>
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/formulario.css">
	<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
</head>
<body>
	<header>
		<div class="logo-space"><a href="index.php"><img src="img/logo.png"></a></div>
	</header>
	<div class="content-prin">
		<div class="content-pgn">
			<div>
			<form action="funciones/login.php" method="POST">
				<h3> Iniciar sesi&oacuten</h3>
				<input type="text" name="emailusu" placeholder="Correo">
					<input type="password" name="passusu" placeholder="Contraseña">

					<?php 
					    if(isset($_GET['e'])){
					    	switch ($_GET['e']) {
					    		case '1':
					    			echo '<p>Error de conexión</p>';
					    			break;
					    		case '2':
					    			echo '<p>Email inválido</p>';
					    			break;
					    			case '3':
					    			echo '<p>Contraseña incorrecta</p>';
					    			break;
					    		
					    		default:
					    			break;
					    	}

					    }

					?>
					<p>¿Aún no estás registrado? <a href="registro.php">Regístrate aquí</a></p>


				<button type="submit">Ingresar</button>

			</form>





		</div>
		</div>
	</div>
</body>
</html>