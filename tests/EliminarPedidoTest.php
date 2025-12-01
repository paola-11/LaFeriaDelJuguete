<?php
use PHPUnit\Framework\TestCase;

class EliminarPedidoTest extends TestCase
{
    public function testEliminarPedidoSimulado()
    {
        // Simular POST
        $_POST['cdped'] = 123;

        // Array para capturar los parámetros pasados a bindParam
        $boundParams = [];

        // Mock de PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);

        $stmtMock->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[$param] = $value; // Captura referencia
                     return true;
                 });

        $stmtMock->method('fetch')
                 ->willReturn(['cdpro' => 10, 'cantidad' => 5]);

        $stmtMock->method('rowCount')
                 ->willReturn(1);

        $stmtMock->method('execute')
                 ->willReturn(true);

        // Mock de PDO
        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->method('prepare')
                ->willReturn($stmtMock);

        // Inyectar el mock en $conn antes de incluir el script
        $conn = $pdoMock;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../Funciones/Pedidos/eliminar_pedido.php';
        $output = ob_get_clean();

        // Decodificar respuesta
        $response = json_decode($output, true);

        // Validaciones
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        $this->assertEquals(123, $boundParams[':cdped']);
        $this->assertEquals(5, $boundParams[':cantidad']);
        $this->assertEquals(10, $boundParams[':cdpro']);
    }
}
