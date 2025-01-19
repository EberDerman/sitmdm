<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

// fetch_asistencia.php
$id_Materia = $_GET['id_Materia'];
$fecha = $_GET['fecha'];

// Database connection
include("../sql/conexion.php");

$sql = "SELECT e.id_estudiante, e.nombre, e.apellido, a.presente, a.horas_asistidas 
        FROM estudiantes AS e
        JOIN estudiante_materia AS em ON e.id_estudiante = em.id_estudiante
        LEFT JOIN asistencia AS a ON e.id_estudiante = a.id_estudiante AND a.id_Materia = em.id_Materia
        WHERE em.id_Materia = ? AND DATE(a.fecha) = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("is", $id_Materia, $fecha);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $presente = $row['presente'] == 1 ? 'Sí' : 'No';
    echo "<tr>
            <td>{$row['id_estudiante']}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['apellido']}</td>
            <td>{$presente}</td>
            <td>{$row['horas_asistidas']}</td>
          </tr>";
}

$stmt->close();
$conexion->close();
?>
