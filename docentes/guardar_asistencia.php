<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../sql/conexion.php");

// Obtener los datos enviados desde la solicitud AJAX
$id_estudiante = $_POST['id_estudiante'] ?? null;
$presente = $_POST['presente'] ?? null;
$horas_asistidas = $_POST['horas_asistidas'] ?? null;

// Comprobar que se han recibido todos los datos necesarios
if (!$id_estudiante || $presente === null || $horas_asistidas === null) {
    die("Datos incompletos.");
}

// Obtener el id_Materia desde el GET de la página anterior
$id_Materia = $_POST['id_Materia'] ?? null;

if (!$id_Materia) {
    die("Materia no especificada.");
}

// Preparar la consulta para insertar la asistencia
$stmt = $conexiones->prepare("
    INSERT INTO asistencia (id_estudiante, id_Materia, presente, horas_asistidas, fecha)
    VALUES (:id_estudiante, :id_Materia, :presente, :horas_asistidas, NOW())
");

// Ejecutar la consulta
try {
    $stmt->execute([
        'id_estudiante' => $id_estudiante,
        'id_Materia' => $id_Materia,
        'presente' => $presente,
        'horas_asistidas' => $horas_asistidas
    ]);
    echo "Asistencia guardada con éxito.";
} catch (PDOException $e) {
    // Aquí se agrega más información de depuración
    echo "Error al guardar asistencia: " . $e->getMessage();
}
// Ahora, después de guardar la asistencia, obtener la lista actualizada de estudiantes
$stmt = $conexiones->prepare("
    SELECT e.id_estudiante, e.apellido, e.nombre, 
           COALESCE(a.presente, 0) as presente, 
           COALESCE(a.horas_asistidas, 0) as horas_asistidas
    FROM estudiantes e
    LEFT JOIN asistencia a ON e.id_estudiante = a.id_estudiante AND a.id_Materia = :id_Materia
    WHERE e.id_estudiante IN (
        SELECT id_estudiante FROM estudiante_materia WHERE id_Materia = :id_Materia
    )
");
$stmt->execute(['id_Materia' => $id_Materia]);
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Devolver la nueva tabla
$tableRows = '';
foreach ($estudiantes as $estudiante) {
    $tableRows .= '<tr>
        <td>' . htmlspecialchars($estudiante['apellido']) . '</td>
        <td>' . htmlspecialchars($estudiante['nombre']) . '</td>
        <td><input type="checkbox" name="presente[' . $estudiante['id_estudiante'] . ']" class="presente-checkbox" data-id="' . $estudiante['id_estudiante'] . '"' . ($estudiante['presente'] ? ' checked' : '') . '></td>
        <td>
            <select name="horas_asistidas[' . $estudiante['id_estudiante'] . ']" class="horas-select" data-id="' . $estudiante['id_estudiante'] . '">
                <option value="0"' . ($estudiante['horas_asistidas'] == 0 ? ' selected' : '') . '>0</option>
                <option value="1"' . ($estudiante['horas_asistidas'] == 1 ? ' selected' : '') . '>1</option>
                <option value="2"' . ($estudiante['horas_asistidas'] == 2 ? ' selected' : '') . '>2</option>
                <option value="3"' . ($estudiante['horas_asistidas'] == 3 ? ' selected' : '') . '>3</option>
                <option value="4"' . ($estudiante['horas_asistidas'] == 4 ? ' selected' : '') . '>4</option>
            </select>
        </td>
        <td><button class="btn btn-primary guardar-asistencia" data-id="' . $estudiante['id_estudiante'] . '">Guardar</button></td>
    </tr>';
}

// Devolver la tabla completa
echo json_encode(['rows' => $tableRows]);
?>
