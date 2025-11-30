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
            <h3>Mi Carrito</h3>
            <div class="cuerpo_pedido" id="espacio-lis">
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            let totalAPagar = 0; // Variable para almacenar el total a pagar
            $.ajax({
                url: 'funciones/pedidos/obtener_pedido.php',
                type: 'POST',
                data: {},
                success: function(data) {
                    console.log(data);
                    let html = '';
                    // Bucle para los elementos del pedido
                    for (var i = 0; i < data.datos.length; i++) {
                        let subtotal = (data.datos[i].cantidad * data.datos[i].costpro).toFixed(3);
                        html +=
                            '<div class="item-pedido">' +
                                '<div class="img-pedido">' +
                                    '<img src="img/pro/' + data.datos[i].rutimg + '">' +
                                '</div>' +
                                '<div class="detalle-pedido">' +
                                    '<h3>' + data.datos[i].nopro + '</h3>' +
                                    '<p><b>Precio:</b> $' + data.datos[i].costpro + '</p>' +
                                    '<p><b>Fecha:</b> ' + data.datos[i].fchped + '</h4>' +
                                    '<p><b>Estado:</b> ' + data.datos[i].estado + '</h4>' +
                                    '<p><b>Cantidad:</b> ' + data.datos[i].cantidad + '</h4>' +
                                    '<p><b>Subtotal:</b> ' + subtotal + '</h4>' +
                                    '<br>' +
                                    '<button class="eliminar-btn" data-cdped="' + data.datos[i].cdped + '">Eliminar</button>' + // Botón eliminar
                                '</div>' +
                            '</div>';
                        // Sumar al total a pagar el subtotal actual
                        totalAPagar += parseFloat(subtotal);
                    }
                    // Mostrar el total a pagar después de los productos
                    html += '<br>';
                    html += '<h4><b>Total a Pagar:</b> $' + totalAPagar.toFixed(3) + '</h4>';
                    html += '<br>';
                    html += '<button id="btnComprar">Comprar</button>';
                    html += '<br><br><br><br>';
                    document.getElementById("espacio-lis").innerHTML = html;

                    // Manejar clic del botón "Comprar"
                    $('#btnComprar').on('click', function() {
                        $.ajax({
                            url: 'funciones/pedidos/actualizar_estado_pedido.php', // Archivo PHP para actualizar el estado del pedido
                            type: 'POST',
                            data: { estado: 'Pendiente de Pago' }, // Estado que se quiere establecer
                            success: function(response) {
                                if (response.success) {
                                    // Redireccionar a pedido.php después de actualizar el estado del pedido
                                    window.location.href = 'pedido.php';
                                } else {
                                    console.error('Error al actualizar el estado del pedido');
                                     window.location.href = 'pedido.php';
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    });
                },
                error: function(err) {
                    console.error(err);
                }
            });

            // Manejar clic del botón eliminar
            $(document).on('click', '.eliminar-btn', function() {
                let cdped = $(this).data('cdped'); // Obtener el cdped del atributo data
                let $this = $(this); // Guardar una referencia al botón

                // Solicitar al servidor que elimine el pedido
                $.ajax({
                    url: 'funciones/pedidos/eliminar_pedido.php',
                    type: 'POST',
                    data: { cdped: cdped }, // Enviar el cdped del pedido a eliminar
                    success: function(response) {
                        if (response.success) {
                            $this.closest('.item-pedido').remove();
                            // ActualizarPedidos(); // Si tienes una función para actualizar pedidos
                        } else {
                            console.error('Error al eliminar el pedido:', response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });    
    </script>
</body>
</html>
