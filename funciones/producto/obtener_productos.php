<?php
include('../conexion.php');

$respuesta = new stdClass();
$datos = array();
$i = 0;
$sql = "SELECT * FROM producto WHERE estado = 1";
$stmt = $conn->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $obj = new stdClass();
    $obj->cdpro = $row['cdpro'];
    $obj->nopro = $row['nopro'];
    $obj->despro = $row['despro'];
    $obj->costpro = $row['costpro'];
    $obj->rutimg = $row['rutimg'];
    $obj->stock = $row['stock'];
    $obj->descrip = $row['descrip'];
    $datos[$i] = $obj;
    $i++;
}

$respuesta->datos = $datos;
header('Content-Type: application/json');
echo json_encode($respuesta);

// Cerrar conexión
$conn = null;
?>













