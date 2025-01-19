<!-- asistencia_porcentaje.php -->
<?php
include("../includes/sesion.php");

/* $id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente); */
include("../sql/conexion.php");

// Recuperar id_Materia desde la URL
$id_Materia = isset($_GET['id_Materia']) ? intval($_GET['id_Materia']) : 0;

// Validar que id_Materia sea válido
if ($id_Materia <= 0) {
    die("ID de materia inválido. Por favor, selecciona una materia válida.");
}
try {
    // Consulta para obtener el nombre de la materia
    $stmt = $conexiones->prepare("SELECT Materia FROM materias WHERE id_Materia = :id_Materia");
    $stmt->execute(['id_Materia' => $id_Materia]);
    $materia = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar si se obtuvo el nombre de la materia
    $nombreMateria = $materia ? $materia['Materia'] : 'Materia no encontrada';
    
    // Cerrar la conexión
    $stmt = null; // Liberar el statement
    $conexiones = null; // Cerrar la conexión
} catch (Exception $e) {
    // Manejo de errores en la conexión o consulta
    $nombreMateria = 'Error al obtener la materia';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porcentaje de Asistencia</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <?php
    include("nav_bar_doc.php");
    ?>

    <h2>Porcentaje de Asistencia - <?php echo htmlspecialchars($nombreMateria); ?></h2>
    <table id="porcentajeAsistencia" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Porcentaje de Asistencia</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta SQL
            $sql = "
            SELECT e.id_estudiante, e.nombre, e.apellido, 
                   (SELECT COALESCE(SUM(a.horas_asistidas), 0) 
                    FROM asistencia AS a 
                    WHERE a.id_estudiante = e.id_estudiante AND a.id_Materia = ?) AS horas_asistidas,
                   (SELECT COALESCE(SUM(horas_dadas), 0) 
                    FROM temario 
                    WHERE id_Materia = ?) AS total_horas_dadas
            FROM estudiantes AS e
            JOIN estudiante_materia AS em ON e.id_estudiante = em.id_estudiante
            WHERE em.id_Materia = ?";

            // Preparar consulta
            $stmt = $conexion->prepare($sql);
            if (!$stmt) {
                die("Error preparando la consulta: " . $conexion->error);
            }

            // Vincular parámetros y ejecutar
            $stmt->bind_param("iii", $id_Materia, $id_Materia, $id_Materia);
            if (!$stmt->execute()) {
                die("Error ejecutando la consulta: " . $stmt->error);
            }

            // Obtener resultados
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $totalHorasDadas = $row['total_horas_dadas'];
                $horasAsistidas = $row['horas_asistidas'] ?? 0; // Asigna 0 si no hay horas asistidas registradas
                $porcentajeAsistencia = ($totalHorasDadas > 0) ? round(($horasAsistidas / $totalHorasDadas) * 100, 2) : 0;

                echo "<tr>
                    <td>{$row['id_estudiante']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['apellido']}</td>
                    <td>{$porcentajeAsistencia}%</td>
                </tr>";
            }

            // Cerrar conexiones
            $stmt->close();
            $conexion->close();
            ?>
        </tbody>
    </table>

    <script>
    $(document).ready(function() {
        $('#porcentajeAsistencia').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron resultados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
    </script>

    <?php
    include("foot_bar_doc.php");
    ?>
</body>
</html>
