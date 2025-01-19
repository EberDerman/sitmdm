<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);


include("../includes/encabezado.php");
include("../sql/conexion.php");
include("../sql/EstudiantesRepository.php");
include("precepMenuNav.php");

if (isset($_GET["id_Tecnicatura"]) && isset($_GET["nombreTec"]) && isset($_GET["Ciclo"])) {
    $estudiantesRepository = new EstudiantesRepository();
    $estudiantesPreinscriptos = $estudiantesRepository->getAllInscriptos($_GET["id_Tecnicatura"]);
}

?>

<title>Gestion de preinscriptos</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>

        <div class="container card text-center my-3 px-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                style="border-radius: 8px;">
                <h4 class="mb-0"><b><?= $_GET["nombreTec"] ?></b> ciclo <b><?= $_GET["Ciclo"] ?></b>
                </h4>
                <div>
                    <button class="btn btn-primary"
                        onclick="window.location.href='precepEstudiantes.php'">VOLVER</button>
                    <button class="btn btn-primary"
                        onclick="window.location.href='precepEstudiantesDesactivados.php'">VER
                        ESTUDIANTES DESACTIVADOS</button>
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
                                $idUsuario = $row['idUsuario'];
                            ?>
                                <tr>
                                    <td><?php echo $nombre = $row['nombre']; ?></td>
                                    <td><?php echo $apellido = $row['apellido']; ?></td>
                                    <td><?php echo $dni_numero = $row['dni_numero']; ?></td>
                                    <td>
                                        <a style='color: #55acee'
                                            href='precepEstudiantesVerDatos.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= $_GET["nombreTec"] ?>&Ciclo=<?= $_GET["nombreTec"] ?>'
                                            title='Verificar datos personales'>
                                            <i class='far fa-eye fa-lg'></i>
                                        </a>
                                        <a style='color: #55acee'
                                            href='precepEstudiantesEditar.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= $_GET["nombreTec"] ?>&Ciclo=<?= $_GET["Ciclo"] ?>'
                                            title='Editar datos personales'>
                                            <i class='far fa-edit fa-lg'></i>
                                        </a>
                                        <a style='color: orange'><i class='fa fa-key fa-lg' title='Reiniciar contraseña'
                                                onClick='reiniciarPassword(<?= $id_estudiante ?>,<?= $idUsuario ?>,"<?= $nombre ?>","<?= $apellido ?>")'></i></a>
                                        <a style='color: blue'
                                            href='precepEstudiantesFaltaJust.php?id_estudiante=<?= $id_estudiante ?>&nombre=<?= urlencode($nombre . " " . $apellido) ?>'>
                                            <i class='far fa-plus-square fa-lg' title='Cargar falta justificada'></i>
                                        </a>
                                        <a style='color: #55acee'
                                            href='menuTrayectoria.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>'
                                            title='Visualizar trayectoria'>
                                            <i class='far fa-list-alt fa-lg'></i>
                                        </a>
                                        <a style='color: #a87532'
                                            href='precepCambiarTec.php?id_estudiante=<?= $id_estudiante ?>&nombre=<?= urlencode($nombre . " " . $apellido) ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= urlencode($_GET["nombreTec"]) ?>&Ciclo=<?= $_GET["Ciclo"] ?>'>
                                            <i class='fas fa-book fa-lg' title='Gestionar materias'></i>
                                        </a>
                                        <a style='color: #ff4500'>
                                            <i class='far fa-trash-alt fa-lg' title='Desactivar estudiante' onClick='desactivarEstudiante(<?= $id_estudiante ?>, <?= !empty($idUsuario) ? $idUsuario : 'null' ?>,
                                            "<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>", 
                                            "<?= htmlspecialchars($apellido, ENT_QUOTES, 'UTF-8') ?>")'>
                                            </i>
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
    <script src="../assets/js/preceptorjs/desactivarEstudiante.js"></script>
    <script src="../assets/js/preceptorjs/resetPassword.js"></script>

</body>

</html>