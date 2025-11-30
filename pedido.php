<?php
	session_start();
	if (!isset($_SESSION['cdusu'])) {
		header('location: index.php');
	}
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
			<h3>Mis Pedidos</h3>
			<div class="cuerpo_pedido" id="espacio-lis">
			</div>
                <div class="orden-pago"><div>Total a pagar:</div>$<span id="total_pedido"></span></div>

        
			
		
            <div class="datos-adicionales">
    <h3>Información adicional</h3>
    <form action="funciones/procesar_datos_adicionales.php" method="POST">
        <label for="direccion">Dirección:</label>
       <input type="text" id="direccion" name="direccion" style="width: 200px;"><br><br> 

        <label for="celular">Celular:     </label>
       <input type="text" id="celular" name="celular" style="width: 200px;"><br><br> 

        
       
    </form>
    <button id="btnComprar">Comprar</button>
       

</div>
           

		</div>
	</div>
	<script type="text/javascript" src="js/main-scripts.js"></script>
	<script type="text/javascript">
			$(document).ready(function(){
		$.ajax({
			url:'funciones/pedidos/pedido_procesado.php',
			type:'POST',
			data:{},
			success:function(data){
				console.log(data);
				let html='';
				let totalAPagar = 0;
				
				for (var i = 0; i < data.datos.length; i++) {
					
					let subtotal = parseFloat(data.datos[i].costpro) * parseInt(data.datos[i].cantidad);
    subtotal = subtotal.toFixed(3); 
					 html+=


					'<div class="item-pedido">'+
					    '<div class="img-pedido">'+
						'<img src="img/pro/'+data.datos[i].rutimg+'">'+
				     '</div>'+
			    '<div class="detalle-pedido">'+
					'<h3>'+data.datos[i].nopro+'</h3>'+
					'<p><b>Precio:</b> $'+data.datos[i].costpro+'</p>'+
					'<p><b>Fecha:</b> '+data.datos[i].fchped+'</p>'+
					'<p><b>Estado:</b> '+data.datos[i].estado+'</p>'+
					'<p><b>Cantidad:</b> '+data.datos[i].cantidad+'</p>'+
					'<p><b>Subtotal:</b> ' + subtotal + '</p>' + // 
			     '</div>'+	
				'</div>';
				if (data.datos[i].estado==2) {}
				 totalAPagar += parseFloat(subtotal);

				}
				 document.getElementById("total_pedido").innerHTML = totalAPagar.toFixed(3);
				document.getElementById("espacio-lis").innerHTML=html;

			},
			error:function(err){
					console.error(err);
				}
		});


	});

	</script>
   <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnComprar').addEventListener('click', function() {
                var confirmacion = confirm('¡Gracias por su compra!');

                if (confirmacion) {
                    window.location.href = 'index.php';
                } else {
                    // Si el usuario cancela, no se hace nada
                }
            });
        });

        $(document).ready(function(){
            // Tu código AJAX existente...
        });
    </script>



</body>
</html>