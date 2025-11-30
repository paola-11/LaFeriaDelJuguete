<?php
// actualizar_subtotal_pedido.php

// Incluir el archivo de conexión a la base de datos
include('conexion.php');

// Obtener los datos del POST
$cdped = $_POST['cdped'];
$sub_total = $_POST['sub_total'];

try {
    // Actualizar el sub_total en la tabla de pedidos
    $query = "UPDATE pedido SET sub_total = :sub_total WHERE cdped = :cdped";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':sub_total', $sub_total);
    $statement->bindParam(':cdped', $cdped);
    
    // Ejecutar la consulta
    $statement->execute();

    // Enviar respuesta (código de estado 200)
    http_response_code(200);
} catch (PDOException $e) {
    // Manejar excepciones en caso de error
    http_response_code(500); // Error del servidor
    echo "Error al actualizar el subtotal: " . $e->getMessage();
}
?>
