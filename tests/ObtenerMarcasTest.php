<?php 
use PHPUnit\Framework\TestCase;

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

        // Inyectar el mock en lugar de $conn
        $conn = $pdoMock;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../Funciones/Busquedas/obtener_marcas.php'; // ruta correcta
        $output = ob_get_clean();

        $response = json_decode($output, true);

        // Verificar que sea un array con las marcas simuladas
        $this->assertIsArray($response);
        $this->assertCount(3, $response);
        $this->assertEquals('Marca A', $response[0]['marca']);
        $this->assertEquals('Marca B', $response[1]['marca']);
        $this->assertEquals('Marca C', $response[2]['marca']);
    }
}
