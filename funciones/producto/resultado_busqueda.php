<?php
include('../conexion.php');

$respuesta = new stdClass();
$datos = array();
$text = $_POST['text'];
$sql = "SELECT * FROM producto WHERE estado = 1 AND nopro LIKE '%$text%'";
$stmt = $conn->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $obj = new stdClass();
    $obj->cdpro = $row['cdpro'];
    $obj->nopro = $row['nopro'];
    $obj->despro = $row['despro'];
    $obj->costpro = $row['costpro'];
    $obj->rutimg = $row['rutimg'];
    $obj->stock = $row['stock'];
    $datos[] = $obj;
}

$respuesta->datos = $datos;
header('Content-Type: application/json');
echo json_encode($respuesta);

// Cerrar conexión
$conn = null;
?>
