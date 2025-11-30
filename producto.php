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
			<section>
				<div class="pt-1">
					<img id="idimg" src="img/pro/co1.jpg">
				</div>
				<div class="pt-2">
					<h2 id="idtitulo">NOMBRE PRINCIPAL</h2>
					<h1 id="idprecio">$235.500</h1>
					<h3 id="iddescrip">Descripcion del producto</h3>
					<h3 id="iddetalle">Detalle del producto</h3>
					<h2 id="idstock">Stock disponible:</h2>
					<input type="number" id="quantityInput" min="1" value="1"> <!-- Campo de entrada de cantidad -->
					<button onclick="inicio_compra()">Añadir al Carrito</button>


				</div>
			</section>
			<div class="titulo-sec">Productos</div>
			<div class="pro-lista" id="espacio-lis">
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/main-scripts.js"></script>


	<script type="text/javascript">
		var pt='<?php echo $_GET["pt"]; ?>';
	</script>
<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url:'funciones/producto/obtener_productos.php',
			type:'POST',
			data:{},
			success:function(data){
				console.log(data);
				let html='';
				//bucle
				for (var i = 0; i < data.datos.length; i++) {
					if (data.datos[i].cdpro==pt) {
						document.getElementById('idimg').src="img/pro/"+data.datos[i].rutimg;
						document.getElementById('idtitulo').innerHTML=data.datos[i].nopro;
						document.getElementById('idstock').innerHTML= 'Stock disponible:'+data.datos[i].stock;
						document.getElementById('idstock').style.color = 'red';
                        document.getElementById('idstock').style.fontSize = '18px';
						document.getElementById('idprecio').innerHTML= '$'+data.datos[i].costpro;
						document.getElementById('iddescrip').innerHTML=data.datos[i].despro;
						document.getElementById('iddetalle').innerHTML=data.datos[i].descrip;





					}
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
				document.getElementById("espacio-lis").innerHTML=html;
			},
			error:function(err){
					console.error(err);
				}
		});
	});
	function inicio_compra(){
		var cantidad = document.getElementById('quantityInput').value; // Obtener la cantidad seleccionada
		$.ajax({
			url:'funciones/compras/val_inicio_compra.php',
			type:'POST',
			data:{
				cdpro:pt,
				cantidad: cantidad // Enviar la cantidad al servidor
			},
			success:function(data){
				console.log(data);
				if (data.state) {
					alert(data.detail);

				}else{
					alert(data.detail);
					if (data.inicio_sesion){
						inicio_sesion();
					}
				}		
						
			},
			error:function(err){
					console.error(err);
				}
		});
	}
	function inicio_sesion(){
		window.location.href="login.php";

	}
	
</script>

</body>
</html>