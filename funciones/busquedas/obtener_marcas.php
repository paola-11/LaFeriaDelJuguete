<?php
// Incluir el archivo de conexión
include('../conexion.php');

try {
    // Consulta SQL para obtener las marcas únicas
    $query = "SELECT DISTINCT marca FROM producto";

    // Preparar la consulta
    $statement = $conn->prepare($query);

    // Ejecutar la consulta
    $statement->execute();

    // Obtener resultados
    $marcas = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Enviar los resultados como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($marcas);
} catch (PDOException $e) {
    // Manejar errores
    echo "Error: " . $e->getMessage();
}
?>
