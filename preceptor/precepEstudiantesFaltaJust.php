<?php
include("../includes/sesion.php");
include("../includes/encabezado.php");
include("../sql/conexion.php"); 
include("precepMenuNav.php");

$id_preceptor = getIdUsuario();
checkAccess([$id_preceptor, 4]);

// Captura el nombre y el id del estudiante desde la URL
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : 'Nombre no disponible';
$id_estudiante = isset($_GET['id_estudiante']) ? $_GET['id_estudiante'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'])) {
    $fecha = $_POST['date'];
    $fecha_formato_db = DateTime::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

    try {
        // Consulta para obtener las materias y horas
        $queryMaterias = "
            SELECT a.id_Asistencia, a.id_Materia, m.Horas
            FROM asistencia a
            INNER JOIN materias m ON a.id_Materia = m.id_Materia
            WHERE a.id_estudiante = :id_estudiante 
              AND DATE(a.fecha) = :fecha 
              AND a.presente = 0
        ";
        $stmtMaterias = $conexiones->prepare($queryMaterias);
        $stmtMaterias->execute([
            ':id_estudiante' => $id_estudiante,
            ':fecha' => $fecha_formato_db,
        ]);

        while ($row = $stmtMaterias->fetch(PDO::FETCH_ASSOC)) {
            $id_Asistencia = $row['id_Asistencia'];
            $id_Materia = $row['id_Materia'];
            $horas = $row['Horas'];

            // Actualizar las horas asistidas en la tabla `asistencia`
            $updateQuery = "
                UPDATE asistencia 
                SET horas_asistidas = :horas, presente = 0 
                WHERE id_Asistencia = :id_Asistencia
            ";
            $updateStmt = $conexiones->prepare($updateQuery);
            $updateStmt->execute([
                ':horas' => $horas,
                ':id_Asistencia' => $id_Asistencia,
            ]);

            // Insertar la justificacion en la tabla `asistencia_justificada`
            $insertQuery = "
                INSERT INTO asistencia_justificada (id_Asistencia, id_estudiante)
                VALUES (:id_Asistencia, :id_estudiante)
            ";
            $insertStmt = $conexiones->prepare($insertQuery);
            $insertStmt->execute([
                ':id_Asistencia' => $id_Asistencia,
                ':id_estudiante' => $id_estudiante,
            ]);
        }

        echo "<script>alert('Faltas justificadas registradas con éxito.');</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//logica para eliminar un error
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteId = $_POST['delete_id'];
    try {
        // Obtener la asistencia asociada para restablecer horas_asistidas
        $queryGetAsistencia = "
            SELECT id_Asistencia 
            FROM asistencia_justificada 
            WHERE id_asistencia_justificada = :id_asistencia_justificada
        ";
        $stmtGetAsistencia = $conexiones->prepare($queryGetAsistencia);
        $stmtGetAsistencia->execute([':id_asistencia_justificada' => $deleteId]);
        $asistencia = $stmtGetAsistencia->fetch(PDO::FETCH_ASSOC);

        if ($asistencia) {
            $idAsistencia = $asistencia['id_Asistencia'];

            // Eliminar de asistencia_justificada
            $deleteQuery = "
                DELETE FROM asistencia_justificada 
                WHERE id_asistencia_justificada = :id_asistencia_justificada
            ";
            $stmtDelete = $conexiones->prepare($deleteQuery);
            $stmtDelete->execute([':id_asistencia_justificada' => $deleteId]);

            // Restablecer horas_asistidas en asistencia
            $updateAsistenciaQuery = "
                UPDATE asistencia 
                SET horas_asistidas = 0 
                WHERE id_Asistencia = :id_Asistencia
            ";
            $stmtUpdateAsistencia = $conexiones->prepare($updateAsistenciaQuery);
            $stmtUpdateAsistencia->execute([':id_Asistencia' => $idAsistencia]);

            echo "<script>alert('Justificación eliminada con éxito.');</script>";
        }
    } catch (PDOException $e) {
        echo "Error al eliminar la justificación: " . $e->getMessage();
    }
}


// Consulta para llenar la tabla con datos de faltas justificadas
$queryTabla = "
    SELECT 
        t.nombreTec AS Tecnicatura,
        t.Ciclo AS CicloTecnicatura,
        m.Materia,
        m.AnioCursada,
        aj.id_asistencia_justificada
    FROM asistencia_justificada aj
    INNER JOIN asistencia a ON aj.id_Asistencia = a.id_Asistencia
    INNER JOIN materias m ON a.id_Materia = m.id_Materia
    INNER JOIN tecnicaturas t ON m.IdTec = t.id_Tecnicatura
    WHERE aj.id_estudiante = :id_estudiante
";

$stmtTabla = $conexiones->prepare($queryTabla);
$stmtTabla->execute([':id_estudiante' => $id_estudiante]);
$materiasData = $stmtTabla->fetchAll(PDO::FETCH_ASSOC);
?>

<title>SITMDM-Preceptores</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
</head>

<body class="hidden-sn mdb-skin">
    <div class="container-fluid">
        <?php include("precepMenuNav.php"); ?>
    </div>
    <main>
        <div class="container mt-5">
            <h1 class="text-center">Cargar falta justificada</h1>

            <div class="card mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3" style="border-radius: 8px;">
                    <h3 class="font-weight-200 text-white">Alumno: <?= htmlspecialchars($nombre) ?></h3>
                    <button class="btn btn-primary" onclick="window.location.href='precepEstudiantes.php'">VOLVER</button>
                </div>
                
                <div class="card-body">
                    <form method="POST" class="form-inline mb-4">
                        <label for="date" class="mr-2">Seleccionar Fecha:</label>
                        <input type="text" id="date" name="date" class="form-control mr-2" placeholder="dd/mm/yyyy" required>
                        <button type="submit" class="btn btn-primary">Justificar Faltas</button>
                    </form>

                    <div class="bg-primary text-white p-2 mb-3">
                        <h4 class="mb-0">Faltas justificadas:</h4>
                    </div>
                    
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
                        <thead>
                                    <tr>
                                    <td>Tecnicatura</td>
                                    <td>Ciclo de Tecnicatura</td>
                                    <td>Materia</td>
                                    <td>Año de cursada</td>
                                    <td>Eliminar</td> <!-- Nueva columna -->
                                </tr>
                            </thead>
                            <tbody id="materias-list">
                                <?php foreach ($materiasData as $materia): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($materia['Tecnicatura']) ?></td>
                                        <td><?= htmlspecialchars($materia['CicloTecnicatura']) ?></td>
                                        <td><?= htmlspecialchars($materia['Materia']) ?></td>
                                        <td><?= htmlspecialchars($materia['AnioCursada']) ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($materia['id_asistencia_justificada']) ?>">
                                                <button type="submit" name="delete" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include("../includes/pie.php"); ?>

<script>
flatpickr("#date", {
    locale: "es",
    dateFormat: "d/m/Y",
    allowInput: true
});
</script>
</body>
</html>
