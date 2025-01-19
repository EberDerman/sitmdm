<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);



include("../includes/encabezado.php");
include("../sql/DocenteRepository.php");
$docenteRepository = new DocenteRepository();
$listaDocentes = $docenteRepository->getDisabledDocentes();
?>

<title>SITMDM-Docentes</title>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php
        include("direcMenuNav.php");
        ?>
    </div>

    <div class="container mt-5">
        <div class="container card text-center">
            <div
                class="card-header primary-color-dark white-text d-flex justify-content-between align-items-center mt-3">
                <h4 class="mb-0">Listado de Docentes desactivados</h4>
                <div>
                    <button class="btn btn-primary" onclick="window.location.href='direcDoc.php'">VOLVER</button>
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
                            foreach ($listaDocentes as $row) {
                                $id_Persona = $row['id_Persona'];
                                $idUsuario = $row['idUsuario'];
                                ?>
                                <tr>
                                    <td><?php echo $nombreDoc = $row['nombre']; ?></td>
                                    <td><?php echo $apellidoDoc = $row['apellido']; ?></td>
                                    <td>
                                        <a style='color: Green'><i class='fa fa-share-square fa-lg'
                                                title='Habilitar docente'
                                                onClick='habilitarUsuario(<?= $id_Persona ?>,<?= $idUsuario ?>,"<?= $nombreDoc ?>","<?= $apellidoDoc ?>")'></i></a>
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
    <script src="../assets/js/directorjs/habilitarUsuario.js"></script>
</body>

</html>