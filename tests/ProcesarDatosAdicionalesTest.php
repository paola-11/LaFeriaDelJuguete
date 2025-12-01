<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../funciones/procesarPedidosAdicionales.php';

class ProcesarDatosAdicionalesTest extends TestCase
{
    public function testProcesarPedidosAdicionalesEjecutaUpdateCorrectamente()
    {
        // Mock de mysqli
        $mockConexion = $this->createMock(mysqli::class);
        $mockStmt = $this->createMock(mysqli_stmt::class);

        // Configurar prepare() para devolver el mock del statement
        $mockConexion->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains("UPDATE pedidos SET valor_adicional"))
            ->willReturn($mockStmt);

        // Configurar bind_param()
        $mockStmt->expects($this->once())
            ->method('bind_param')
            ->with("di", 5000, 10);

        // Configurar execute() para que devuelva true
        $mockStmt->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        // Capturar salida
        ob_start();
        $resultado = procesarPedidosAdicionales($mockConexion, 10, 5000);
        $salida = ob_get_clean();

        // Verificar que se imprimió el mensaje esperado
        $this->assertStringContainsString(
            "Información actualizada correctamente en la base de datos",
            $salida,
            "La función NO imprimió el mensaje esperado."
        );

        // Verificar retorno
        $this->assertTrue($resultado);
    }
}
