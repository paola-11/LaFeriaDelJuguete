<?php

use PHPUnit\Framework\TestCase;

// Nota: No se necesitan setUp/tearDown para simular superglobales 
// si usamos las anotaciones @runInSeparateProcess, que es más seguro para la sesión.

class ProcesarDatosAdicionalesTest extends TestCase
{
    private $funcionPath = __DIR__ . '/../funciones/procesar_datos_adicionales.php';
    private $cdped_de_prueba = 1; // ID del registro que debe existir en la tabla PEDIDO (ya insertado)
    
    /**
     * @return PDO
     */
    private function obtenerConexionDB() {
        // *** IMPORTANTE: REEMPLAZA ESTO CON TUS CREDENCIALES FUNCIONALES ***
        // Estas credenciales deben ser las que ya arreglaste en Docker.
        $host = 'db'; 
        $db = 'granferia'; 
        $user = 'usuario'; 
        $pass = 'usuario123'; 
        
        try {
            // Se usa PDO para asegurar compatibilidad con mysqli (que usa tu función) 
            // y para poder hacer la verificación aquí.
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            // Si esto falla, significa que el error de 'Access denied' aún no está 100% resuelto.
            $this->fail("Fallo la conexión a la base de datos de prueba: " . $e->getMessage());
        }
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @coversNothing
     */
    public function testProcesarDatosAdicionalesActualizaCorrectamente()
    {
        // 1. SIMULACIÓN DE ENTORNO
        
        $nueva_direccion = 'Nueva Direccion Test 2025';
        $nuevo_celular = '3219876543';
        
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['direccion'] = $nueva_direccion;
        $_POST['celular'] = $nuevo_celular;

        // 2. SIMULACIÓN DE SESIÓN (cdusu = 1, que debe ser un registro existente en PEDIDO)
        @session_start();
        $_SESSION['cdusu'] = $this->cdped_de_prueba; 
        @session_write_close();

        // 3. EXPECTATIVAS DE SALIDA
        // Captura el echo del script PHP
        $this->expectOutputString("Información actualizada correctamente en la base de datos");

        // 4. EJECUCIÓN DEL CÓDIGO A PROBAR
        include $this->funcionPath;
        
        // 5. VERIFICACIÓN DEL ESTADO DE LA BASE DE DATOS (Lo más importante)
        
        $conn = $this->obtenerConexionDB();
        
        // Consulta para obtener el registro actualizado
        $stmt = $conn->prepare("SELECT dirpedusu, celusuped FROM PEDIDO WHERE cdped = :cdped");
        $stmt->bindParam(':cdped', $this->cdped_de_prueba);
        $stmt->execute();
        $datos_actualizados = $stmt->fetch(PDO::FETCH_ASSOC);

        // AFIRMACIONES: Comprobar que los valores en la DB son los enviados
        $this->assertEquals(
            $nueva_direccion, 
            $datos_actualizados['dirpedusu'], 
            "FALLO: La dirección no se actualizó correctamente en la DB."
        );
        $this->assertEquals(
            $nuevo_celular, 
            $datos_actualizados['celusuped'], 
            "FALLO: El celular no se actualizó correctamente en la DB."
        );
    }
    
    // Limpieza de superglobales y sesión después de cada prueba
    protected function tearDown(): void
    {
        $_POST = [];
        $_SERVER = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}