<?php
use PHPUnit\Framework\TestCase;

class EliminarPedidoTest extends TestCase
{
    public function testEliminarPedidoSimulado()
    {
        // Simular POST
        $_POST['cdped'] = 123;

        // Variables para verificar bindParam
        $boundParams = [];

        // Mock de PDOStatement
        $stmtMock = $this->createMock(PDOStatement::class);

        // Capturar bindParam
        $stmtMock->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     $boundParams[$param] = $value;
                     return true;
                 });

        // Configurar fetch() para SELECT
        $stmtMock->method('fetch')
                 ->willReturn(['cdpro' => 10, 'cantidad' => 5]);

        // Configurar rowCount() para DELETE
        $stmtMock->method('rowCount')
                 ->willReturn(1);

        // Configurar execute()
        $stmtMock->method('execute')
                 ->willReturn(true);

        // Mock de PDO
        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->method('prepare')
                ->willReturn($stmtMock);

        // Capturar salida
        ob_start();
        $conn = $pdoMock; // Inyectar el mock de PDO
        include __DIR__ . '/../Funciones/Pedidos/eliminar_pedido.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);

        // Validaciones
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        // Verificar que se pasó el cdped correcto
        $this->assertEquals(123, $boundParams[':cdped']);
        // Verificar que se pasó la cantidad y cdpro correctos
        $this->assertEquals(5, $boundParams[':cantidad']);
        $this->assertEquals(10, $boundParams[':cdpro']);
    }
}
