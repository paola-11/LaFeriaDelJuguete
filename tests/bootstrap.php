<?php
// Evitar warnings por REQUEST_METHOD
if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'POST';
}