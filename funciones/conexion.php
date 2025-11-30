<?php
$host = 'db'; // nombre del servicio de MySQL en docker-compose
$user = 'usuario';
$password = 'usuario123';
$database = 'granferia';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}
?>


