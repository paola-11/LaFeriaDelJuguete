<?php
// tests/PruebaConexionBD.php

use PHPUnit\Framework\TestCase;

// Incluir la función que vamos a probar
require_once __DIR__ . '/../funciones/utilidades_conexion.php';

class PruebaConexionBDTest extends TestCase
{
    /**
     * @covers ::verificar_conexion_bd
     */
    public function testConexionBDCorrecta()
    {
        // Ejecutamos la función. El contenedor 'db' debe estar activo en GitHub Actions.
        $resultado = verificar_conexion_bd();

        // Verificamos que contenga el mensaje de éxito
        $this->assertStringContainsString("Conexión exitosa", $resultado, 
            "FALLO: El contenedor 'granferia_db' no está listo o las credenciales son incorrectas.");
    }
}
?>