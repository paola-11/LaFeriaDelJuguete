<?php
// Incluir el archivo de conexión
include('../conexion.php');

try {
    // Consulta SQL para obtener los colores únicos
    $query = "SELECT DISTINCT color FROM producto";

    // Preparar la consulta
    $statement = $conn->prepare($query);

    // Ejecutar la consulta
    $statement->execute();

    // Obtener resultados
    $colores = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Enviar los resultados como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($colores);
} catch (PDOException $e) {
    // Manejar errores
    echo "Error: " . $e->getMessage();
}
?>
