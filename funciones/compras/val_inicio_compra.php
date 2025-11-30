<?php
session_start();
$respuesta = new stdClass();

if (!isset($_SESSION['cdusu'])) {
    $respuesta->state = false;
    $respuesta->detail = "No está logueado";
    $respuesta->inicio_sesion = true;
} else {
    include_once('../conexion.php');

    $cdusu = $_SESSION['cdusu'];
    $cdpro = $_POST['cdpro'];
    $cantidad = $_POST['cantidad'];

    try {
        // Inicia la transacción
        $conn->beginTransaction();

        // Consulta para obtener el stock actual
        $stmt = $conn->prepare("SELECT stock FROM producto WHERE cdpro = :cdpro FOR UPDATE");
        $stmt->bindParam(':cdpro', $cdpro);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stock_actual = $result['stock'];

        // Verifica si hay suficiente stock para la compra
        if ($stock_actual >= $cantidad) {
            // Actualiza el stock restando la cantidad comprada
            $nuevo_stock = $stock_actual - $cantidad;
            $stmt = $conn->prepare("UPDATE producto SET stock = :nuevo_stock WHERE cdpro = :cdpro");
            $stmt->bindParam(':nuevo_stock', $nuevo_stock);
            $stmt->bindParam(':cdpro', $cdpro);
            $stmt->execute();

            // Resto del código para realizar la inserción en la tabla pedido
            $sql = "INSERT INTO pedido (cdusu, cdpro, cantidad, fchped, estado, dirpedusu, celusuped) 
                    VALUES (:cdusu, :cdpro, :cantidad, CURRENT_TIMESTAMP, 1, '', '')";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cdusu', $cdusu);
            $stmt->bindParam(':cdpro', $cdpro);
            $stmt->bindParam(':cantidad', $cantidad);

            if ($stmt->execute()) {
                $conn->commit();
                $respuesta->state = true;
                $respuesta->detail = "Producto agregado";
            } else {
                $conn->rollBack();
                $respuesta->state = false;
                $respuesta->detail = "No se pudo agregar el producto. Intente más tarde";
            }
        } else {
            $conn->rollBack();
            $respuesta->state = false;
            $respuesta->detail = "La cantidad seleccionada supera el stock disponible";
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        $respuesta->state = false;
        $respuesta->detail = "Error al realizar la compra: " . $e->getMessage();
    }

    $conn = null;
}

header('Content-Type: application/json');
echo json_encode($respuesta);
?>
