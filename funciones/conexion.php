<?php
// Utilizar PDO para coincidir con la sentencia preparada en procesar_datos_adicionales.php

$host = 'db'; // nombre del servicio de MySQL en docker-compose
$user = 'usuario';
$password = 'usuario123';
$database = 'granferia';

try {
    // Crea la conexión PDO
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    
    // Configura PDO para lanzar excepciones en caso de error (buena práctica)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Mostrar un error fatal si la conexión falla
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
// Al finalizar, $conn es un objeto PDO que soporta la sintaxis :placeholder
?>

