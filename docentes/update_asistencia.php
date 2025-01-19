    <?php
    include("../includes/sesion.php");

/*     $id_docente = getIdUsuarioSeguridad();
    checkAccess([5], $id_docente); */
    include("../sql/conexion.php");
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    
    $action = $_POST['action'];
    $id_estudiante = $_POST['id_estudiante'];
    $id_Materia = $_POST['id_Materia'];

    if ($action == 'nueva_asistencia') {
        $fecha_hoy = date("Y-m-d");

        $sql_check = "SELECT * FROM asistencia WHERE id_estudiante = ? AND id_Materia = ? AND DATE(fecha) = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("iis", $id_estudiante, $id_Materia, $fecha_hoy);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo "Asistencia ya registrada";
        } else {
            $sql_insert = "INSERT INTO asistencia (id_estudiante, id_Materia, presente, horas_asistidas, fecha) VALUES (?, ?, 0, 0, NOW())";
            $stmt_insert = $conexion->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $id_estudiante, $id_Materia);

            echo $stmt_insert->execute() ? "Asistencia creada" : "Error al crear la asistencia";
            $stmt_insert->close();
        }

        $stmt_check->close();
    } elseif ($action == 'update') {
        $column = $_POST['column'];
        $value = $_POST['value'];

        $sql_check = "SELECT * FROM asistencia WHERE id_estudiante = ? AND id_Materia = ? AND DATE(fecha) = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $fecha_hoy = date("Y-m-d");
        $stmt_check->bind_param("iis", $id_estudiante, $id_Materia, $fecha_hoy);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows == 0) {
            echo "Error: El registro de asistencia no existe para el día de hoy.";
        } else {
            $sql_update = "UPDATE asistencia SET $column = ? WHERE id_estudiante = ? AND id_Materia = ? AND DATE(fecha) = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("iiis", $value, $id_estudiante, $id_Materia, $fecha_hoy);

            echo $stmt_update->execute() ? "Asistencia actualizada" : "Error al actualizar la asistencia";
            $stmt_update->close();
        }

        $stmt_check->close();
    }

    $conexion->close();
    ?>
