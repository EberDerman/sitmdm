<?php
session_start();

// Configuración de la sesión
session_regenerate_id(true); // Regenerar el ID de sesión para prevenir la fijación de sesión

// Definir la constante para validar el acceso a las páginas
define('ACCESO_PERMITIDO', true);

// Función para verificar el acceso según los roles permitidos
function checkAccess($allowedRoles, $allowedUserId = null)
{

    // Verifica si la sesión está activa y tiene los datos necesarios
    if (!isset($_SESSION['usuario'], $_SESSION['codRol'], $_SESSION['idUsuario'])) {
        session_unset();
        session_destroy();
        echo "<script>window.location.href = '../index.php';</script>";
        exit();
    }

    // Verifica el rol del usuario
    $codRol = $_SESSION['codRol'];
    if (!in_array($codRol, $allowedRoles)) {
        session_unset();
        session_destroy();
        echo "<script>window.location.href = '../index.php';</script>";
        exit();
    }

    // Verifica el ID del usuario si se especifica
    if ($allowedUserId !== null && $_SESSION['idUsuario'] !== $allowedUserId) {
        session_unset();
        session_destroy();
        echo "<script>window.location.href = '../index.php';</script>";
        exit();
    }
}


function getIdUsuarioSeguridad()
{
    if (isset($_SESSION['idUsuario'])) {
        return $_SESSION['idUsuario'];
    }

    // Si no está definida, destruye la sesión y redirige
    session_unset();
    session_destroy();
    echo "<script>window.location.href = '../index.php';</script>";
    exit();
}




// Función para obtener el ID del usuario
function getIdUsuario()
{
    return isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
}

// Función para obtener el ID de la tecnicatura
function getIdTecnicatura()
{
    return isset($_SESSION['id_tecnicatura']) ? $_SESSION['id_tecnicatura'] : null;
}
