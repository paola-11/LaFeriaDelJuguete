<?php
// Incluir el archivo de conexión a la base de datos
include_once('../conexion.php');

// Verificar si se ha enviado el estado del pedido
if (isset($_POST['estado'])) {
    $nuevoEstado = $_POST['estado']; // Estado que se desea establecer

    // Verificar si el nuevo estado es "Pendiente de Pago"
    if ($nuevoEstado === 'Pendiente de Pago') {
        $valorEstado = 2; // Valor en la base de datos para "Pendiente de Pago" 
        
        try {
            // Query para actualizar el estado del pedido en la tabla 'pedido'
            $sql = "UPDATE pedido SET estado = :valorEstado"; // Ajusta 'pedido' por el nombre correcto de tu tabla
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':valorEstado', $valorEstado);
            $stmt->execute();

            // Enviar respuesta de éxito a la solicitud AJAX
            $respuesta['success'] = true;
            echo json_encode($respuesta);
        } catch (PDOException $e) {
            // Enviar respuesta de error en caso de excepción
            $respuesta['success'] = false;
            $respuesta['error'] = $e->getMessage();
            echo json_encode($respuesta);

            // Agregar un registro de error adicional
            error_log('Error al ejecutar la consulta SQL: ' . $e->getMessage(), 0);
        }
    } else {
        // Manejo de un estado desconocido o no válido
        $respuesta['success'] = false;
        $respuesta['error'] = 'Estado no válido';
        echo json_encode($respuesta);
    }
}
?>
