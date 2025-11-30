<?php
//1: Error de conexión
//2: Email inválido
//3: Contraseña incorrecta
include('conexion.php');
$emailusu = $_POST['emailusu'];
$sql = "SELECT * FROM USUARIO  WHERE emailusu = :emailusu";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':emailusu', $emailusu);
$stmt->execute();

if ($stmt) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($count != 0) {
        $passusu = $_POST['passusu'];
        if ($row['passusu'] != $passusu) {
            header('Location: ../login.php?e=3');
        } else {
            session_start();
            $_SESSION['cdusu'] = $row['cdusu'];
            $_SESSION['emailusu'] = $row['emailusu'];
            $_SESSION['nomusu'] = $row['nomusu'];
            header('Location: ../');
        }
    } else {
        header('Location: ../login.php?e=2');
    }
} else {
    header('Location: ../login.php?e=1');
}



