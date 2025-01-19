<?php
if (!isset($_SESSION)) {
    session_start();
}

ob_start(); // inicia el buffer

// agregar los roles que sean necesarios
$allowedRoles = [1, 2, 3, 4, 5, 6];

// conexión a la base de datos
include("../sql/conexion.php");

if (!isset($_SESSION['usuario']) || !isset($_SESSION['clave']) || !in_array($_SESSION['codRol'], $allowedRoles)) {
    session_destroy();
    header("Location: ../index.php");
    ob_end_flush();
    exit();
}

// Obtener idUsuario basado en usuario y clave
$usuario = $_SESSION['usuario'];
$clave = $_SESSION['clave'];

// Consulta para obtener el idUsuario
$sql = "SELECT idUsuario FROM usuarios WHERE usuario = ? AND contrasenia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $clave);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idUsuario = $row['idUsuario'];
    $_SESSION['idUsuario'] = $idUsuario;

    // Obtener id_Persona asociado al idUsuario
    $sqlPersona = "SELECT id_Persona FROM personas WHERE idUsuario = ?";
    $stmtPersona = $conexion->prepare($sqlPersona);
    $stmtPersona->bind_param("i", $idUsuario);
    $stmtPersona->execute();
    $resultPersona = $stmtPersona->get_result();

    if ($resultPersona->num_rows > 0) {
        $rowPersona = $resultPersona->fetch_assoc();
        $idPersona = $rowPersona['id_Persona'];
        $_SESSION['id_Persona'] = $idPersona;

        // Obtener todas las materias asignadas al docente
        $sqlMaterias = "SELECT id_Materia FROM docentesmaterias WHERE id_Persona = ?";
        $stmtMaterias = $conexion->prepare($sqlMaterias);
        $stmtMaterias->bind_param("i", $idPersona);
        $stmtMaterias->execute();
        $resultMaterias = $stmtMaterias->get_result();

        $materias_del_docente = [];
        while ($rowMaterias = $resultMaterias->fetch_assoc()) {
            $materias_del_docente[] = $rowMaterias['id_Materia'];
        }

        // Almacenar el arreglo de materias en la sesión
        $_SESSION['materias_del_docente'] = $materias_del_docente;
    } else {
        // Si no encuentra persona asociada, redirigir al index
        session_destroy();
        header("Location: ../index.php");
        ob_end_flush();
        exit();
    }
} else {
    // Si no se encuentra el usuario, redirigir al index
    session_destroy();
    header("Location: ../index.php");
    ob_end_flush();
    exit();
}

ob_end_flush();
?>