<?php

use PHPUnit\Framework\TestCase;

class ProcesarDatosAdicionalesTest extends TestCase
{
    private $backupServer;
    private $backupPost;
    private $backupSession;

    protected function setUp(): void
    {
        // Respaldar variables superglobales
        $this->backupServer = $_SERVER;
        $this->backupPost = $_POST;
        $this->backupSession = $_SESSION ?? [];

        // Simular petición POST
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['direccion'] = 'Calle 123';
        $_POST['celular'] = '3001234567';

        // Simular sesión
        $_SESSION = [];
        $_SESSION['cdusu'] = 1;
    }

    protected function tearDown(): void
    {
        $_SERVER = $this->backupServer;
        $_POST = $this->backupPost;
        $_SESSION = $this->backupSession;
    }

    public function testProcesarDatosAdicionalesActualizaCorrectamente()
    {
        // Crear mock de PDOStatement
        $mockStmt = $this->createMock(PDOStatement::class);

        // Indicar que execute() debe retornar true (éxito)
        $mockStmt->expects($this->once())
                 ->method('execute')
                 ->willReturn(true);

        // Crear mock de PDO para que prepare() retorne el mock del statement
        $mockConn = $this->createMock(PDO::class);
        $mockConn->expects($this->once())
                 ->method('prepare')
                 ->willReturn($mockStmt);

        // Hacer que $conn esté disponible dentro del archivo que vamos a incluir
        $conn = $mockConn;

        // Capturar salida del script
        ob_start();
        include __DIR__ . '/../funciones/procesar_datos_adicionales.php';
        $output = ob_get_clean();

        // Verificar que el script imprimió éxito
        $this->assertStringContainsString(
            "Información actualizada correctamente en la base de datos",
            $output
        );
    }
}