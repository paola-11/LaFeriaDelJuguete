<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../funciones/LoginService.php';

class LoginServiceTest extends TestCase
{
    private $mockDb;
    private $service;

    protected function setUp(): void
    {
        // Mock de la BD
        $this->mockDb = $this->createMock(PDO::class);
        $this->service = new LoginService($this->mockDb);
    }

    public function testEmailNoExiste()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn(false);

        $this->mockDb->method('prepare')->willReturn($stmt);

        $resultado = $this->service->validarCredenciales("no@existe.com", "123");

        $this->assertEquals("EMAIL_NO_EXISTE", $resultado);
    }

    public function testPasswordIncorrecta()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn([
            'emailusu' => "test@test.com",
            'passusu' => 'correcta'
        ]);

        $this->mockDb->method('prepare')->willReturn($stmt);

        $resultado = $this->service->validarCredenciales("test@test.com", "mala");

        $this->assertEquals("PASSWORD_INCORRECTA", $resultado);
    }

    public function testLoginCorrecto()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturn([
            'emailusu' => "test@test.com",
            'passusu' => '1234'
        ]);

        $this->mockDb->method('prepare')->willReturn($stmt);

        $resultado = $this->service->validarCredenciales("test@test.com", "1234");

        $this->assertEquals("LOGIN_CORRECTO", $resultado);
    }
}