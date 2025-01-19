<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuario();
checkAccess([$id_preceptor, 4]);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include("../sql/EstudiantesRepository.php");
include("precepMenuNav.php");

$nombre_estudiante = "";
$ciclo = "";
$materias = [];

// Verificar si se han recibido los parámetros 
if (isset($_GET["id_estudiante"]) && isset($_GET["nombre"]) && isset($_GET["id_Tecnicatura"])) {
    $id_estudiante = $_GET["id_estudiante"];
    $nombre = $_GET["nombre"];
    $id_Tecnicatura = $_GET["id_Tecnicatura"];

    // Obtener las materias de la tecnicatura
    $queryMaterias = $conexiones->prepare("
        SELECT m.id_Materia, m.Materia, em.id_Tipocursada
        FROM materias m
        LEFT JOIN estudiante_materia em ON m.id_Materia = em.id_Materia AND em.id_estudiante = :id_estudiante
        WHERE m.IdTec = :id_Tecnicatura
    ");
    $queryMaterias->execute(['id_estudiante' => $id_estudiante, 'id_Tecnicatura' => $id_Tecnicatura]);
    $materias = $queryMaterias->fetchAll();

    // Obtener todos los tipos de cursada
    $queryTipoCursada = $conexiones->query("SELECT id_Tipocursada, tipocursada FROM tipocursada");
    $tiposCursada = $queryTipoCursada->fetchAll();
}

?>

<title>Asignar Tipo de Cursada</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>
        <div class="container card text-center my-3 px-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                style="border-radius: 8px;">
                <h4 class="mb-0"><b><?= htmlspecialchars($nombre) ?></b> - Asignar Tipo de Cursada</h4>
                <button class="btn btn-primary" onclick="history.back()">VOLVER</button>
            </div>

            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <th>Materia</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                <th>Notas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $materia): ?>
                                <tr>
                                    <td><?= htmlspecialchars($materia["Materia"]) ?></td>
                                    <td>
                                        <?php
                                        $estadoActual = array_filter($tiposCursada, function ($tipo) use ($materia) {
                                            return $tipo['id_Tipocursada'] == $materia['id_Tipocursada'];
                                        });
                                        echo $estadoActual ? reset($estadoActual)['tipocursada'] : 'Regular';
                                        ?>
                                    </td>
                                    <td>
                                        <form method="post" action="actualizarTipoCursada.php"
                                            onsubmit="return actualizarTipoCursada(this);">
                                            <input type="hidden" name="id_estudiante"
                                                value="<?= htmlspecialchars($id_estudiante) ?>">
                                            <input type="hidden" name="id_Materia"
                                                value="<?= htmlspecialchars($materia['id_Materia']) ?>">
                                            <input type="hidden" name="nombre" value="<?= htmlspecialchars($nombre) ?>">
                                            <input type="hidden" name="id_Tecnicatura"
                                                value="<?= htmlspecialchars($id_Tecnicatura) ?>">
                                            <input type="hidden" name="nombreTec"
                                                value="<?= htmlspecialchars($_GET['nombreTec']) ?>">
                                            <input type="hidden" name="Ciclo"
                                                value="<?= htmlspecialchars($_GET['Ciclo']) ?>">
                                            <select name="id_Tipocursada" style="display: block !important"
                                                class="form-control" onchange="actualizarTipoCursada(this.form, this);">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <?php foreach ($tiposCursada as $tipo): ?>
                                                    <option value="<?= htmlspecialchars($tipo['id_Tipocursada']) ?>"
                                                        <?= $tipo['id_Tipocursada'] == $materia['id_Tipocursada'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($tipo['tipocursada']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>



                                    </td>
                                    <td>
                                        <!-- Botón para redirigir a la página de carga de notas -->
                                        <a href="cargarNotas.php?id_estudiante=<?= htmlspecialchars($id_estudiante) ?>&id_Materia=<?= htmlspecialchars($materia['id_Materia']) ?>&nombre=<?= htmlspecialchars($nombre) ?>&id_Tecnicatura=<?= htmlspecialchars($id_Tecnicatura) ?>" 
                                        class="btn btn-info">
                                        <img src="..\assets\img\svg\notas.png" alt="Cargar Notas"style="display: block; width: 50px; height: 50px;">
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <?php include("../includes/pie.php"); ?>


    <script>
        function actualizarTipoCursada(form, selectElement) {
            var formData = new FormData(form);

            fetch('actualizarTipoCursada.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Puedes usar esto para depuración
                    // Actualizar la columna "Estado" con el nuevo tipo de cursada seleccionado y cambiar el color a verde
                    var estadoCell = selectElement.closest('tr').querySelector('td:nth-child(2)');
                    estadoCell.textContent = selectElement.options[selectElement.selectedIndex].text;
                    estadoCell.style.color = 'green'; // Cambiar el color del texto a verde
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            return false; // Evita que el formulario se envíe de la manera tradicional
        }
    </script>



</body>

</html>