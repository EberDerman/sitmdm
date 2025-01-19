<?php
include("../includes/sesion.php");

$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante


include("../sql/conexion.php");

// Verifica si se recibieron los datos de materia y tipo de fecha
if (isset($_POST['materia']) && isset($_POST['tipo'])) {
    // Sanitiza y asigna las variables
    $materia = $conexion->real_escape_string($_POST['materia']);
    $tipo = $conexion->real_escape_string($_POST['tipo']);
    $id_usuario = getIdUsuario();

    // Obtiene el ID de estudiante en base al usuario
    $sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
    $stmt_estudiante = $conexion->prepare($sql_estudiante);
    $stmt_estudiante->bind_param("i", $id_usuario);
    $stmt_estudiante->execute();
    $stmt_estudiante->bind_result($id_estudiante);
    $stmt_estudiante->fetch();
    $stmt_estudiante->close();

    // Verifica que el ID del estudiante se haya obtenido correctamente
    if ($id_estudiante) {
        // Prepara la consulta de inserción para guardar la inscripción
        $sql_insert = "INSERT INTO inscripciones_examenes (id_estudiante, materia, fecha_tipo) VALUES (?, ?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $id_estudiante, $materia, $tipo);

        if ($stmt_insert->execute()) {
            echo "Inscripción guardada exitosamente.";
        } else {
            echo "Error al guardar la inscripción: " . $conexion->error;
        }

        $stmt_insert->close();
    } else {
        echo "No se encontró el estudiante.";
    }
} else {
    echo "Datos incompletos para realizar la inscripción.";
}

// Cierra la conexión
$conexion->close();
