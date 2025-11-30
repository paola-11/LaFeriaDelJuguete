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
            <div class="filtro-header">
            <?php include("Diseños/div-filtro.php"); ?>
        </div>
            <div class="titulo-sec">Productos</div>
            <div class="pro-lista" id="espacio-lis">

            </div>
        </div>
    </div>
    
    <script type="text/javascript" src="js/main-scripts.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            // Obtener marcas
            $.ajax({
                url: 'funciones/busquedas/obtener_marcas.php',
                type: 'GET',
                dataType: 'json', 
                success: function(data) {
                    let marcas = data;
                    let selectMarcas = $('#marca');
                    $.each(marcas, function(index, value) {
                        selectMarcas.append('<option value="' + value.marca + '">' + value.marca + '</option>');
                    });
                },
                error: function(err) {
                    console.error(err);
                }
            });

            // Obtener colores
            $.ajax({
                url: 'funciones/busquedas/obtener_colores.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    let colores = data;
                    let selectColores = $('#color');
                    $.each(colores, function(index, value) {
                        selectColores.append('<option value="' + value.color + '">' + value.color + '</option>');
                    });
                },
                error: function(err) {
                    console.error(err);
                }
            });

            // Función para obtener y mostrar productos
            function obtenerYMostrarProductos(filtro = {}) {
                $.ajax({
                    url: 'funciones/producto/filtrar_productos.php',
                    type: 'POST',
                    data: filtro,
                    success: function(data) {
                        let html = '';
                        if (data && Array.isArray(data)) {
                            data.forEach(function(producto) {
                                html +=
                                '<div class="contenedor-pro">' +
                                    '<a href="producto.php?pt=' + producto.cdpro + '">' +
                                        '<div class="producto">' +
                                            '<img src="img/pro/' + producto.rutimg + '">' +
                                            '<div class="titulo-producto">' + producto.nopro + '</div>' +
                                            '<div class="descrip-producto">' + producto.despro + '</div>' +
                                            '<div class="descrip-producto" style="color: red; font-size: 16px; font-weight: bold;">Stock disponible: ' + producto.stock + '</div>' +
                                            '<div class="precio-producto">' + '$' + producto.costpro + '</div>' +
                                        '</div>' +
                                    '</a>' +
                                '</div>';
                            });
                        } else {
                            html = '<div>No se encontraron productos.</div>';
                        }
                        $('#espacio-lis').html(html);
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            }

            // Obtener y mostrar todos los productos al cargar la página
            obtenerYMostrarProductos();

            // Manejar cambio en la selección de marca o color
            $('#marca, #color').change(function() {
                let marcaSeleccionada = $('#marca').val();
                let colorSeleccionado = $('#color').val();

                let filtro = {};
                if (marcaSeleccionada) filtro.marca = marcaSeleccionada;
                if (colorSeleccionado) filtro.color = colorSeleccionado;

                obtenerYMostrarProductos(filtro);
            });
        });
    </script>

</body>
</html>
