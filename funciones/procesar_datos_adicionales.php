<?php
// Verificar si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];

    // Validar y sanitizar los datos (ejemplo básico)
    $direccion = htmlspecialchars($direccion);
    $celular = htmlspecialchars($celular);

    // Incluir el archivo de conexión a la base de datos
    include 'conexion.php'; 

    // Obtener el ID del usuario de la sesión 
    session_start();
    if (!isset($_SESSION['cdusu'])) {
        die("Error: No se encontró el ID de usuario en la sesión.");
    }
    $cdusu = $_SESSION['cdusu'];

    // Consulta para actualizar la información en la tabla 'pedido'
    $sql = "UPDATE pedido SET dirpedusu = :direccion, celusuped = :celular WHERE cdped = :cdped";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);

    // Bind de parámetros
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':cdped', $cdusu); // Aquí usamos el ID de usuario de la tabla 'pedido'

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Información actualizada correctamente en la base de datos";
    } else {
        echo "Error al actualizar la información: " . $stmt->errorInfo()[2];
    }
}
?>
