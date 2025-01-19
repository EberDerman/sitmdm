<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);




include("../includes/encabezado.php");
include("../sql/MateriasRepository.php");
include("../sql/DocenteRepository.php");

$idDoc = $_GET['idDoc'];
$nombreDoc = $_GET['nombreDoc'];
$apellidoDoc = $_GET['apellidoDoc'];

$docenteRepository = new DocenteRepository();
$materiasPorDocente = $docenteRepository->getMateriaByDocente($idDoc);
?>

<title>SITMDM-Materias</title>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("direcMenuNav.php"); ?>
    </div>

    <main>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4" style="border-radius: 8px;">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Materias asignadas a <?= $nombreDoc . ' ' . $apellidoDoc ?></h4>
                    <div>
                        <button class="btn btn-primary" onclick="window.location.href='direcDoc.php';">VOLVER</button>
                        <button class="btn btn-primary" onclick="window.location.href='direcDocMateriaAsign.php?idDoc=<?= $idDoc ?>&nombreDoc=<?= $nombreDoc ?>&apellidoDoc=<?= $apellidoDoc ?>'">ASIGNAR NUEVA MATERIA +</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <?php if (!empty($materiasPorDocente)): ?>
                            <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Materia</th>
                                        <th>Tecnicatura</th>
                                        <th>Año</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materiasPorDocente as $materia):
                                        $iddocentesmaterias = $materia['iddocentesmaterias'];
                                    ?>
                                        <tr>
                                            <td><?= $materia['Materia'] ?></td>
                                            <td><?= $materia['nombreTec'] ?></td>
                                            <td><?= $materia['AnioCursada'] ?></td>
                                            <td>
                                                <a style='color: #ff4500'>
                                                    <i class='far fa-trash-alt fa-lg' title='Quitar materia asignada' onClick='quitarMateriaAsignada(<?= $iddocentesmaterias ?>,<?= $idDoc ?>,"<?= $materia['Materia'] ?>","<?= $materia['nombreTec'] ?>","<?= $nombreDoc ?>","<?= $apellidoDoc ?>")'></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No se encontraron materias para el docente seleccionado.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>
    <script src="../assets/js/directorjs/direcDocMateriaDelDB.js"></script>
</body>

</html>
