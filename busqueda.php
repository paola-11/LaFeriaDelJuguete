	<?php
	session_start();
	?> 
	<!DOCTYPE html>
	<html>
	<head>
	<title>La Gran Feria del Juguete</title>
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link href="https://fonts.googleapis.com/css?family=Sen&display=swap" rel="stylesheet">
</head>
<body>
	<?php include("Diseños/main-header.php"); ?>
	<div class="content-prin">
		<div class="content-pgn">
			<div class="titulo-sec">Resultados para<strong>"<?php echo $_GET['text']; ?>"</strong></div>
			<div class="pro-lista" id="espacio-lis">
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/main-scripts.js"></script>
<script type="text/javascript">
	var text="<?php echo $_GET['text']; ?>";
	$(document).ready(function(){
		$.ajax({
			url:'funciones/producto/resultado_busqueda.php',
			type:'POST',
			data:{
				text:text
			},
			
			success:function(data){
				console.log(data);
				let html='';
				//bucle
				for (var i = 0; i < data.datos.length; i++) {
					html+=
					'<div class="contenedor-pro">'+
					'<a href="producto.php?pt='+data.datos[i].cdpro+'">'+
						'<div class="producto">'+
							'<img src="img/pro/'+data.datos[i].rutimg+'">'+
							'<div class="titulo-producto">'+data.datos[i].nopro+'</div>'+
							'<div class="descrip-producto">'+data.datos[i].despro+'</div>'+
							'<div class="descrip-producto" style="color: red; font-size: 16px; font-weight: bold;">Stock disponible: '+data.datos[i].stock+'</div>'+
							'<div class="precio-producto">'+'$'+ data.datos[i].costpro+'</div>'+



						'</div>'+
					 '</a>'+
		         '</div>';
				}
				if (html==""){
					document.getElementById("espacio-lis").innerHTML='<div class="ms_sin_resultado">No hay resultados';

				}else{

				document.getElementById("espacio-lis").innerHTML=html;
				}
			},
			error:function(err){
					console.error(err);
				}
		});
	});
</script>
</body>
</html>