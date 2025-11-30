<?php
include('../conexion.php');

$marca = $_POST['marca'] ?? '';
$color = $_POST['color'] ?? '';

try {
    $sql = "SELECT * FROM producto WHERE estado = 1";

    // Verifica si se proporcionó marca y/o color para aplicar los filtros correspondientes
    if (!empty($marca) && !empty($color)) {
        $sql .= " AND marca = :marca AND color = :color";
    } elseif (!empty($marca)) {
        $sql .= " AND marca = :marca";
    } elseif (!empty($color)) {
        $sql .= " AND color = :color";
    }

    $stmt = $conn->prepare($sql);

    // Asigna los valores de marca y color si se proporcionaron
    if (!empty($marca) && !empty($color)) {
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':color', $color);
    } elseif (!empty($marca)) {
        $stmt->bindParam(':marca', $marca);
    } elseif (!empty($color)) {
        $stmt->bindParam(':color', $color);
    }

    $stmt->execute();

    $productosFiltrados = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $producto = new stdClass();
        $producto->cdpro = $row['cdpro'];
        $producto->nopro = $row['nopro'];
        $producto->despro = $row['despro'];
        $producto->costpro = $row['costpro'];
        $producto->rutimg = $row['rutimg'];
        $producto->stock = $row['stock'];
        $productosFiltrados[] = $producto;
    }

    header('Content-Type: application/json');
    echo json_encode($productosFiltrados);

    // Cerrar conexión
    $conn = null;
} catch (PDOException $e) {
    // En caso de error, devuelve un mensaje de error en formato JSON
    echo json_encode(array('error' => 'Error al obtener productos: ' . $e->getMessage()));
}
?>
