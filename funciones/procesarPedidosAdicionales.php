<?php

function procesarPedidosAdicionales($conexion, $idPedido, $nuevoValor) {
    // Validar conexión
    if (!$conexion) {
        echo "Error: No hay conexión a la base de datos.";
        return false;
    }

    // Preparar consulta
    $sql = "UPDATE pedidos SET valor_adicional = ? WHERE id = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        echo "Error al preparar la consulta.";
        return false;
    }

    // Ejecutar
    $stmt->bind_param("di", $nuevoValor, $idPedido);

    if ($stmt->execute()) {
        echo "Información actualizada correctamente en la base de datos";
        return true;
    } else {
        echo "Error al actualizar la información";
        return false;
    }
}
