<?php
// db_config.php

$filePath = __DIR__ . '/../../sql/.env.ini';

$env = parse_ini_file($filePath, true); // Leer archivo

// Usar valores desde el archivo de configuración
$host = $env['database']['DB_HOST'];
$db = $env['database']['DB_NAME'];
$user = $env['database']['DB_USER'] ;
$pass = $env['database']['DB_PASSWORD'] ;

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Comprobar la conexión
if ($conn->connect_error) {
    // Manejo de errores mejorado
    error_log("Conexión fallida: " . $conn->connect_error);
    die("Se ha producido un error en la conexión. Por favor, intente más tarde.");
}
?>
