<?php
// funciones/utilidades_conexion.php

/**
 * Intenta conectar a la base de datos para verificar su disponibilidad.
 * @return string Estado de la conexión.
 */
function verificar_conexion_bd() {
    // Usaremos las credenciales de tu docker-compose.yml
    $host = 'db'; 
    $db = 'granferia';
    $user = 'root';
    $pass = 'root';

    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retorna éxito si llega aquí
        return "Conexión exitosa"; 
        
    } catch (PDOException $e) {
        // Retorna error en caso de fallo
        return "Error de conexión: " . $e->getMessage();
    }
}
?>