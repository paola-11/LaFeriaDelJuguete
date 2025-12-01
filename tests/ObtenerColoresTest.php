<?php
use PHPUnit\Framework\TestCase;

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

        // Inyectar el mock en lugar de $conn
        $conn = $pdoMock;

        // Evitar que el include de conexion.php falle
        // Nota: Esto no cambia tu aplicación, solo afecta el test
        if (!isset($conn)) {
            $conn = $pdoMock;
        }

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../Funciones/Busquedas/obtener_colores.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);

        // Verificar que sea un array con los colores simulados
        $this->assertIsArray($response);
        $this->assertCount(3, $response);
        $this->assertEquals('Rojo', $response[0]['color']);
        $this->assertEquals('Azul', $response[1]['color']);
        $this->assertEquals('Verde', $response[2]['color']);
    }
}

