<?php 
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/bootstrap.php'; // Inicializa $_SERVER y $conn

class ObtenerMarcasTest extends TestCase
{
    public function testObtenerMarcasSimulado()
    {
        // Mock de PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')
                 ->willReturn([
                     ['marca' => 'Marca A'],
                     ['marca' => 'Marca B'],
                     ['marca' => 'Marca C'],
                 ]);

        // Mock de PDO
        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->method('prepare')->willReturn($stmtMock);

        // Inyectar mock en $conn
        $conn = $pdoMock;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../funciones/busquedas/obtener_marcas.php';
        $output = ob_get_clean();

        // Decodificar JSON
        $response = json_decode($output, true);

        // Validaciones
        $this->assertIsArray($response);
        $this->assertCount(3, $response);
        $this->assertEquals('Marca A', $response[0]['marca']);
        $this->assertEquals('Marca B', $response[1]['marca']);
        $this->assertEquals('Marca C', $response[2]['marca']);
    }
}
