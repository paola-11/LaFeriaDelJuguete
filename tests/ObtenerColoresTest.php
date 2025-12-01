<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/bootstrap.php'; // Inicializa $_SERVER y $conn

class ObtenerColoresTest extends TestCase
{
    public function testObtenerColoresSimulado()
    {
        // Mock de PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')
                 ->willReturn([
                     ['color' => 'Rojo'],
                     ['color' => 'Azul'],
                     ['color' => 'Verde'],
                 ]);

        // Mock de PDO
        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->method('prepare')->willReturn($stmtMock);

        // Inyectar mock en $conn antes de incluir el script
        $conn = $pdoMock;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../funciones/busquedas/obtener_colores.php';
        $output = ob_get_clean();

        // Decodificar JSON
        $response = json_decode($output, true);

        // Validaciones
        $this->assertIsArray($response);
        $this->assertCount(3, $response);
        $this->assertEquals('Rojo', $response[0]['color']);
        $this->assertEquals('Azul', $response[1]['color']);
        $this->assertEquals('Verde', $response[2]['color']);
    }
}

