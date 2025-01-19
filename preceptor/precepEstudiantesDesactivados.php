<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/EstudiantesRepository.php");

$estudianteRepository = new EstudiantesRepository();
$listaEstudiantesDesactivados = $estudianteRepository->getDisabledEstudiantes();
?>

<title>SITMDM-Docentes</title>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php
        include("precepMenuNav.php");
        ?>
    </div>

    <div class="container mt-5">
        <div class="container card text-center">
            <div
                class="card-header primary-color-dark white-text d-flex justify-content-between align-items-center mt-3">
                <h4 class="mb-0">Listado de Estudiantes desactivados</h4>
                <div>
                <button class="btn btn-primary" onclick="history.back()">VOLVER</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0"
                        width="100%">
                        <thead>
                            <tr>
                                <td>Nombre</td>
                                <td>Apellido</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($listaEstudiantesDesactivados as $row) {
                                $id_estudiante = $row['id_estudiante'];
                                $idUsuario = $row['idUsuario'];
                                ?>
                                <tr>
                                    <td><?php echo $nombre = $row['nombre']; ?></td>
                                    <td><?php echo $apellido = $row['apellido']; ?></td>
                                    <td>
                                        <a style='color: Green'><i class='fa fa-share-square fa-lg'
                                                title='Habilitar estudiante'
                                                onClick='habilitarUsuario(<?= $id_estudiante ?>,<?= $idUsuario ?>,"<?= $nombre ?>","<?= $apellido ?>")'></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Main layout -->
    <?php
    include("../includes/pie.php");
    ?>
    <script src="../assets/js/preceptorjs/habilitarUsuario.js"></script>
</body>

</html>