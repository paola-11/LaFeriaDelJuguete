<?php
session_start();
$respuesta = new stdClass();

include_once('../conexion.php'); 

// Obtener el código de usuario de la sesión
$cdusu = $_SESSION['cdusu'];

// Actualizar el estado del pedido
$sql = "UPDATE pedido SET estado = 2 WHERE estado = 1";
$stmt = $conn->prepare($sql);

if ($stmt->execute()) {
    $respuesta->state = true;
    $respuesta->detail = "Pedido procesado con éxito";
} else {
    $respuesta->state = false;
    $respuesta->detail = "No se pudo procesar el pedido. Intente más tarde";
}

$conn = null;

header('Content-Type: application/json');
echo json_encode($respuesta);
?>
