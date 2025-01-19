<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/EstudiantesRepository.php");
include("precepMenuNav.php");

if (isset($_GET["id_Tecnicatura"]) && isset($_GET["nombreTec"]) && isset($_GET["Ciclo"])) {
    $estudiantesRepository = new EstudiantesRepository();
    $estudiantesPreinscriptos = $estudiantesRepository->getAllPreinscriptos($_GET["id_Tecnicatura"]);
}

?>

<title>Gestion de preinscriptos</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>

        <div class="container card text-center my-3 px-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                style="border-radius: 8px;">
                <h4 class="mb-0">Preinscripciones a <b><?= $_GET["nombreTec"] ?></b> ciclo <b><?= $_GET["Ciclo"] ?></b></h4>
                <div>
                    <button class="btn btn-primary"
                        onclick="window.location.href='precepPreinscripciones.php'">VOLVER</button>
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
                                <td>DNI</td>
                                <td>Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($estudiantesPreinscriptos as $row) {
                                $id_estudiante = $row['id_estudiante'];
                                ?>
                                <tr>
                                    <td><?php echo $nombre = $row['nombre']; ?></td>
                                    <td><?php echo $apellido = $row['apellido']; ?></td>
                                    <td><?php echo $dni_numero = $row['dni_numero']; ?></td>
                                    <td>
                                        <a style='color: #55acee'
                                            href='precepPreinscripcionesEditar.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= $_GET["nombreTec"] ?>&Ciclo=<?= $_GET["nombreTec"] ?>'
                                            title='Verificar documentación'>
                                            <i class='fas fa-list fa-lg'></i>
                                        </a>
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
    </main>
    <?php include("../includes/pie.php"); ?>

</body>

</html>