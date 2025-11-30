<?php
session_start();
include_once('../conexion.php');

// Verificar si se ha enviado el cdped a eliminar
if (isset($_POST['cdped'])) {
    // Obtener el id del pedido a eliminar
    $cdped = $_POST['cdped'];

    try {
        // Obtener la cantidad del pedido para restaurar el stock
        $stmt = $conn->prepare("SELECT cdpro, cantidad FROM pedido WHERE cdped = :cdped");
        $stmt->bindParam(':cdped', $cdped);
        $stmt->execute();
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

        $cdpro = $pedido['cdpro'];
        $cantidad = $pedido['cantidad'];

        // Actualizar la cantidad en la tabla producto sumándole la cantidad del pedido
        $updateStmt = $conn->prepare("UPDATE producto SET stock = stock + :cantidad WHERE cdpro = :cdpro");
        $updateStmt->bindParam(':cantidad', $cantidad);
        $updateStmt->bindParam(':cdpro', $cdpro);
        $updateStmt->execute();

        // Eliminar el pedido
        $deleteStmt = $conn->prepare("DELETE FROM pedido WHERE cdped = :cdped");
        $deleteStmt->bindParam(':cdped', $cdped);
        $deleteStmt->execute();

        // Comprobar si se eliminó con éxito y enviar una respuesta al cliente
        $eliminado = $deleteStmt->rowCount() > 0;
        echo json_encode(['success' => $eliminado]);

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se recibió el ID del pedido a eliminar']);
}
?>
