<?php
class LoginService
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function buscarUsuarioPorEmail(string $email)
    {
        $sql = "SELECT * FROM USUARIO WHERE emailusu = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function validarCredenciales(string $email, string $password)
    {
        $usuario = $this->buscarUsuarioPorEmail($email);

        if (!$usuario) {
            return 'EMAIL_NO_EXISTE';
        }

        if ($usuario['passusu'] !== $password) {
            return 'PASSWORD_INCORRECTA';
        }

        return 'LOGIN_CORRECTO';
    }
}