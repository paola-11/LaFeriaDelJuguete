<?php
// Evitar warning de REQUEST_METHOD
if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'POST';
}

// Inicializar $conn si no existe (será reemplazado en tests)
if (!isset($conn)) {
    $conn = null;
}