<?php
use PHPUnit\Framework\TestCase;

class RegistroUsuarioTest extends TestCase
{
    private $backupPost;

    protected function setUp(): void
    {
        // Respaldar POST
        $this->backupPost = $_POST;

        // Simular datos enviados por formulario
        $_POST['nomusu'] = 'Juan';
        $_POST['apeusu'] = 'Pérez';
        $_POST['emailusu'] = 'juan@test.com';
        $_POST['passusu'] = '12345';
    }

    protected function tearDown(): void
    {
        $_POST = $this->backupPost;
    }

    /** Caso 1: El correo YA existe */
    public function testCorreoYaRegistrado()
    {
        // Mock del PDOStatement para SELECT (rowCount devuelve > 0)
        $mockSelectStmt = $this->createMock(PDOStatement::class);
        $mockSelectStmt->method('execute');
        $mockSelectStmt->method('rowCount')->willReturn(1); // correo existe

        // Mock de PDO: prepare() retorna el statement del SELECT
        $mockPDO = $this->createMock(PDO::class);
        $mockPDO->method('prepare')->willReturn($mockSelectStmt);

        // Definir conn dentro del script
        $conn = $mockPDO;

        // Capturar salida y headers
        ob_start();
        include __DIR__ . '/../funciones/registro.php';
        ob_end_clean();

        // PHPUnit no ejecuta header(), pero lo captura en headers_list()
        $headers = xdebug_get_headers();

        $this->assertContains('Location: ../login.php?e=2', $headers);
    }

    /** Caso 2: El correo NO existe y registro exitoso */
    public function testRegistroExitoso()
    {
        // Mock SELECT: rowCount = 0 (correo no existe)
        $mockSelectStmt = $this->createMock(PDOStatement::class);
        $mockSelectStmt->method('execute');
        $mockSelectStmt->method('rowCount')->willReturn(0);

        // Mock INSERT: execute() retorna true
        $mockInsertStmt = $this->createMock(PDOStatement::class);
        $mockInsertStmt->method('execute')->willReturn(true);

        // Mock PDO: primer prepare → SELECT, segundo prepare → INSERT
        $mockPDO = $this->getMockBuilder(PDO::class)
                        ->disableOriginalConstructor()
                        ->onlyMethods(['prepare'])
                        ->getMock();

        $mockPDO->expects($this->exactly(2))
                ->method('prepare')
                ->willReturnOnConsecutiveCalls(
                    $mockSelectStmt,
                    $mockInsertStmt
                );

        // Hacer accesible $conn al archivo
        $conn = $mockPDO;

        ob_start();
        include __DIR__ . '/../funciones/registro.php';
        ob_end_clean();

        $headers = xdebug_get_headers();

        $this->assertContains('Location: ../login.php', $headers);
    }

    /** Caso 3: Falla el INSERT */
    public function testRegistroFalla()
    {
        // SELECT → correo no existe
        $mockSelectStmt = $this->createMock(PDOStatement::class);
        $mockSelectStmt->method('execute');
        $mockSelectStmt->method('rowCount')->willReturn(0);

        // INSERT → falla
        $mockInsertStmt = $this->createMock(PDOStatement::class);
        $mockInsertStmt->method('execute')->willReturn(false);

        // Mock consecutivo
        $mockPDO = $this->getMockBuilder(PDO::class)
                        ->disableOriginalConstructor()
                        ->onlyMethods(['prepare'])
                        ->getMock();

        $mockPDO->expects($this->exactly(2))
                ->method('prepare')
                ->willReturnOnConsecutiveCalls(
                    $mockSelectStmt,
                    $mockInsertStmt
                );

        $conn = $mockPDO;

        ob_start();
        include __DIR__ . '/../funciones/registro.php';
        ob_end_clean();

        $headers = xdebug_get_headers();

        $this->assertContains('Location: ../login.php?e=1', $headers);
    }
}