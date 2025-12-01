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

        // Capturar bindParam
        $stmtMock->method('bindParam')
                 ->willReturnCallback(function($param, &$value) use (&$boundParams) {
                     // Guardar la referencia, para luego verificar
                     $boundParams[$param] = $value;
                     return true;
                 });

        // Configurar fetch() para SELECT (simula obtener el pedido)
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

        // Inyectar el mock de PDO en lugar de la conexión real
        $conn = $pdoMock;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../Funciones/Pedidos/eliminar_pedido.php';
        $output = ob_get_clean();

        $response = json_decode($output, true);

        // Validaciones principales
        $this->assertArrayHasKey('success', $response);
        $this->assertTrue($response['success']);

        // Verificar que los parámetros se hayan pasado correctamente
        $this->assertEquals(123, $boundParams[':cdped']);
        $this->assertEquals(5, $boundParams[':cantidad']);
        $this->assertEquals(10, $boundParams[':cdpro']);
    }
}
