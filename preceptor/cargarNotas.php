<?php
include("../includes/sesion.php");
include("../includes/encabezado.php");
include("../sql/MateriasRepository.php");
include("../sql/conexion.php");
include("../sql/EstudiantesRepository.php");
include("precepMenuNav.php");

// Captura el nombre y los IDs desde la URL
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : 'Nombre no disponible';
$id_estudiante = isset($_GET['id_estudiante']) ? $_GET['id_estudiante'] : '';
$id_materia = isset($_GET['id_Materia']) ? $_GET['id_Materia'] : '';
$id_tecnicatura = isset($_GET['id_Tecnicatura']) ? $_GET['id_Tecnicatura'] : '';

// Inicializar mensajes de error y éxito
$error = $success = "";

// Procesar solicitudes POST según el valor de 'action'
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'delete') {
        // Lógica para eliminar un registro
        if (isset($_POST['id_final'])) {
            $id_final = $_POST['id_final'];

            try {
                $deleteQuery = $conexiones->prepare("DELETE FROM finales WHERE id_final = :id_final");
                $deleteQuery->execute([':id_final' => $id_final]);
                $success = "El registro fue eliminado correctamente.";
            } catch (PDOException $e) {
                $error = "Error al eliminar el registro: " . $e->getMessage();
            }
        }
    } elseif ($action === 'add') {
        // Lógica para guardar una nota
        $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
        $nota = isset($_POST['nota']) ? $_POST['nota'] : '';

        if (empty($fecha) || empty($nota)) {
            $error = "Por favor, complete todos los campos.";
        } elseif ($nota < 1 || $nota > 10) {
            $error = "La nota debe estar entre 1 y 10.";
        } else {
            try {
                $queryInsert = $conexiones->prepare("
                    INSERT INTO finales (id_estudiante, id_tecnicatura, id_materia, fecha, nota) 
                    VALUES (:id_estudiante, :id_tecnicatura, :id_materia, :fecha, :nota)
                ");
                $queryInsert->execute([
                    'id_estudiante' => $id_estudiante,
                    'id_tecnicatura' => $id_tecnicatura,
                    'id_materia' => $id_materia,
                    'fecha' => $fecha,
                    'nota' => $nota
                ]);
                $success = "La nota se asignó correctamente.";
            } catch (PDOException $e) {
                $error = "Error al asignar la nota: " . $e->getMessage();
            }
        }
    }
}

// Consultar notas del estudiante para la materia específica
$queryNotas = $conexiones->prepare("
    SELECT 
        t.nombreTec AS tecnicatura,
        t.Ciclo AS ciclo_tecnicatura,
        m.Materia AS materia,
        YEAR(f.fecha) AS anio_cursada,
        f.nota AS nota,
        f.fecha AS fecha,
        f.id_final AS id_final
    FROM finales f
    INNER JOIN tecnicaturas t ON f.id_tecnicatura = t.id_Tecnicatura
    INNER JOIN materias m ON f.id_materia = m.id_Materia
    WHERE f.id_estudiante = :id_estudiante 
      AND f.id_materia = :id_materia
      AND f.id_tecnicatura = :id_tecnicatura
");
$queryNotas->execute([
    'id_estudiante' => $id_estudiante,
    'id_materia' => $id_materia,
    'id_tecnicatura' => $id_tecnicatura
]);
$notas = $queryNotas->fetchAll();

// Obtener el nombre de la materia
$materiaQuery = $conexiones->prepare("SELECT Materia FROM materias WHERE id_Materia = :id_materia");
$materiaQuery->execute(['id_materia' => $id_materia]);
$nombreMateria = $materiaQuery->fetchColumn();
?>

<title>SITMDM-Preceptores</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
</head>

<body class="hidden-sn mdb-skin">
    <main>
        <div class="container mt-5">

            <div class="card mt-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3" style="border-radius: 8px;">
                    <h3>Cargar notas de finales</h3>
                    <h4 class="font-weight-200 text-white">Alumno: <?= htmlspecialchars($nombre) ?></h4>
                    <button class="btn btn-primary" onclick="window.location.href='precepEstudiantes.php'">VOLVER</button>
                </div>
                
                <div class="card-body">
                    <!-- Mostrar mensajes de error o éxito -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php elseif (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>

                    <!-- Formulario para agregar una nota -->
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="add">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <label for="date" class="form-control col-3 text-right border-0 m-2">Selecciona una fecha:</label>
                            <input type="text" id="date" name="fecha" class="form-control col-2 m-2" style="max-width: 150px;" required>

                            <label for="nota" class="form-control col-2 text-right border-0 m-2">Asignar Nota (1-10):</label>
                            <input type="number" id="nota" name="nota" class="form-control col-2 m-2" style="max-width: 100px;" min="1" max="10" required>

                            <button type="submit" class="btn btn-primary col-2 m-2">Asignar Nota</button>
                        </div>
                    </form>

                    <div class="bg-primary text-white p-2 mb-3">
                        <h3 class="mb-0">Materia: <?= htmlspecialchars($nombreMateria) ?></h3>
                    </div>
                    
                    <!-- Tabla para mostrar notas -->
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td>Tecnicatura</td>
                                    <td>Ciclo de Tecnicatura</td>
                                    <td>Materia</td>
                                    <td>Año de cursada</td>
                                    <td>Nota</td>
                                    <td>Fecha</td>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($notas)): ?>
                                    <?php foreach ($notas as $nota): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($nota['tecnicatura']) ?></td>
                                            <td><?= htmlspecialchars($nota['ciclo_tecnicatura']) ?></td>
                                            <td><?= htmlspecialchars($nota['materia']) ?></td>
                                            <td><?= htmlspecialchars($nota['anio_cursada']) ?></td>
                                            <td><?= htmlspecialchars($nota['nota']) ?></td>
                                            <td><?= htmlspecialchars($nota['fecha']) ?></td>
                                            <td>
                                                <form method="POST" action="" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id_final" value="<?= $nota['id_final'] ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No hay notas registradas para esta materia.</td>
                                    </tr>
                                <?php endif; ?>
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
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
</body>
</html>
