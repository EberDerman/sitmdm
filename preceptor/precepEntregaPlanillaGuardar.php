<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");

// Verificar si se reciben id_estudiante e id_tecnicatura por GET
if (
    isset($_GET['id_estudiante']) && is_numeric($_GET['id_estudiante']) &&
    isset($_GET['id_Tecnicatura']) && is_numeric($_GET['id_Tecnicatura'])
) {
    $id_estudiante = intval($_GET['id_estudiante']);
    $id_tecnicatura = intval($_GET['id_Tecnicatura']);
} else {
    die("ID de estudiante o tecnicatura no válido o no proporcionado.");
}

// Función para actualizar el campo 'inscripto' a 1
function actualizarInscripto($conexion, $id_estudiante, $id_tecnicatura)
{
    $sql_inscripto = "UPDATE estudiante_tecnicatura SET inscripto = 1 
                      WHERE id_estudiante = ? AND id_Tecnicatura = ?";
    $stmt_inscripto = $conexion->prepare($sql_inscripto);
    $stmt_inscripto->bind_param("ii", $id_estudiante, $id_tecnicatura);

    if (!$stmt_inscripto->execute()) {
        $_SESSION['mensaje_error'] = "Error al actualizar el campo 'inscripto': " . $stmt_inscripto->error;
    }
    $stmt_inscripto->close();
}

// Si el formulario ha sido enviado, actualiza o inserta los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asignar valores de los checkboxes
    $entrega_dni = isset($_POST['entrega_dni']) ? 1 : 0;
    $entrega_partida = isset($_POST['entrega_partida']) ? 1 : 0;
    $entrega_fotos = isset($_POST['entrega_fotos']) ? 1 : 0;
    $entrega_titulo = isset($_POST['entrega_titulo']) ? 1 : 0;
    $entrega_certificado = isset($_POST['entrega_certificado']) ? 1 : 0;
    $entrega_inscripcion = isset($_POST['entrega_inscripcion']) ? 1 : 0;
    $entrega_carpeta = isset($_POST['entrega_carpeta']) ? 1 : 0;

    // Verificar si el estudiante existe en estudiantes_planillas
    $sql = "SELECT * FROM estudiantes_planillas WHERE id_estudiante = ?;";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_estudiante);

    if ($stmt->execute()) {
        // Recoger resultado sin procesar si hay datos y cerrar el statement
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Actualización de datos
            $sql_update = "UPDATE estudiantes_planillas 
                           SET entrega_dni = ?, entrega_partida = ?, entrega_fotos = ?, entrega_titulo = ?, 
                               entrega_certificado = ?, entrega_inscripcion = ?, entrega_carpeta = ? 
                           WHERE id_estudiante = ?;";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param(
                "iiiiiiii",
                $entrega_dni,
                $entrega_partida,
                $entrega_fotos,
                $entrega_titulo,
                $entrega_certificado,
                $entrega_inscripcion,
                $entrega_carpeta,
                $id_estudiante
            );

            if ($stmt_update->execute()) {
                $_SESSION['mensaje_exito'] = "Datos actualizados correctamente.";
                actualizarInscripto($conexion, $id_estudiante, $id_tecnicatura);
                echo "<script type='text/javascript'>
                window.location.href = 'crearUsuario.php?id_estudiante=$id_estudiante&id_Tecnicatura=$id_tecnicatura';
              </script>";
                exit;
            } else {
                $_SESSION['mensaje_error'] = "Error al actualizar los datos: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            // Insertar nuevo estudiante
            $sql_insert = "INSERT INTO estudiantes_planillas 
                           (id_estudiante, entrega_dni, entrega_partida, entrega_fotos, entrega_titulo, 
                            entrega_certificado, entrega_inscripcion, entrega_carpeta) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $stmt_insert = $conexion->prepare($sql_insert);
            $stmt_insert->bind_param(
                "iiiiiiii",
                $id_estudiante,
                $entrega_dni,
                $entrega_partida,
                $entrega_fotos,
                $entrega_titulo,
                $entrega_certificado,
                $entrega_inscripcion,
                $entrega_carpeta
            );

            if ($stmt_insert->execute()) {
                $_SESSION['mensaje_exito'] = "Datos insertados correctamente.";
                actualizarInscripto($conexion, $id_estudiante, $id_tecnicatura);
                echo "<script type='text/javascript'>
                window.location.href = 'crearUsuario.php?id_estudiante=$id_estudiante&id_Tecnicatura=$id_tecnicatura';
              </script>";
                exit;
            } else {
                $_SESSION['mensaje_error'] = "Error al insertar los datos: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
        $stmt->close();
    } else {
        $_SESSION['mensaje_error'] = "Error al buscar estudiante: " . $conexion->error;
    }
}
