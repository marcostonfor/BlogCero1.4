<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../login/authservice.php';

// Llamamos al método estático logout. No necesita una instancia de AuthService
// ni una conexión a la base de datos, lo que lo hace más robusto.
AuthService::logout();

// Este script se encarga de la redirección una vez completada la acción
header('Location: ../login/login.php');
exit;