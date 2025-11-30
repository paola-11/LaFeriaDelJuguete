<?php
include('conexion.php');

// Obtener datos del formulario de registro
$nomusu = $_POST['nomusu'];
$apeusu = $_POST['apeusu'];
$emailusu = $_POST['emailusu'];
$passusu = $_POST['passusu'];

// Verificar si el correo electrónico ya está registrado
$sql_check_email = "SELECT * FROM USUARIO WHERE emailusu = :emailusu";
$stmt_check_email = $conn->prepare($sql_check_email);
$stmt_check_email->bindParam(':emailusu', $emailusu);
$stmt_check_email->execute();

$count = $stmt_check_email->rowCount();

if ($count > 0) {
    // El correo electrónico ya está registrado, redirigir con un mensaje de error
    header('Location: ../login.php?e=2');
} else {
    // El correo electrónico no está registrado, proceder con el registro
    $sql_insert = "INSERT INTO USUARIO (nomusu, apeusu, emailusu, passusu) VALUES (:nomusu, :apeusu, :emailusu, :passusu)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bindParam(':nomusu', $nomusu);
    $stmt_insert->bindParam(':apeusu', $apeusu);
    $stmt_insert->bindParam(':emailusu', $emailusu);
    $stmt_insert->bindParam(':passusu', $passusu);

    if ($stmt_insert->execute()) {
        // Registro exitoso, redirigir o realizar alguna acción adicional
        header('Location: ../login.php'); // Redirigir al formulario de inicio de sesión
    } else {
        // Error durante el registro
        header('Location: ../login.php?e=1'); // Redirigir con mensaje de error de conexión
    }
}
?>