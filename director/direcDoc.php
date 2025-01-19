<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);

include("../includes/encabezado.php");
include("../sql/DocenteRepository.php");
$docenteRepository = new DocenteRepository();
$listaDocentes = $docenteRepository->getAllDocentes();
?>

<title>SITMDM-Docentes</title>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("direcMenuNav.php"); ?>
    </div>

    <main>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                    style="border-radius: 8px;">
                    <h4 class="mb-0">Listado de Docentes</h4>
                    <div>
                        <button class="btn btn-primary" onclick="window.location.href='inicioDirec.php'">VOLVER</button>
                        <button class="btn btn-primary" onclick="window.location.href='direcDocDesactivados.php'">VER
                            DOCENTES DESACTIVADOS</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-striped display AllDataTables"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td>Nombre</td>
                                    <td>Apellido</td>
                                    <td>Acciones</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listaDocentes as $row):
                                    $id_Persona = $row['id_Persona'];
                                    $idUsuario = $row['idUsuario'];
                                    ?>
                                    <tr>
                                        <td><?php echo $nombreDoc = $row['nombre']; ?></td>
                                        <td><?php echo $apellidoDoc = $row['apellido']; ?></td>
                                        <td>
                                            <a style='color: #6b7d4d'
                                                href='direcDocMateria.php?idDoc=<?= $id_Persona ?>&nombreDoc=<?= $nombreDoc ?>&apellidoDoc=<?= $apellidoDoc ?>'><i
                                                    class='fa fa-book fa-lg' title='Gestionar materias'></i></a>
                                            <a style='color: blue'
                                                href='direcFormPersonaVer.php?id_Persona=<?= $id_Persona ?>'><i
                                                    class='far fa-eye fa-lg' title='Ver datos personales'></i></a>
                                            <a style='color: #55acee'
                                                href='direcDocEditar.php?id_Persona=<?= $id_Persona ?>'><i
                                                    class='far fa-edit fa-lg' title='Editar datos personales'></i></a>
                                            <a style='color: orange'><i class='fa fa-key fa-lg' title='Reiniciar contraseña'
                                                    onClick='reiniciarPassword(<?= $id_Persona ?>,<?= $idUsuario ?>,"<?= $nombreDoc ?>","<?= $apellidoDoc ?>")'></i></a>
                                            <a style='color: #ff4500'><i class='far fa-trash-alt fa-lg'
                                                    title='Desactivar docente'
                                                    onClick='desactivarDocente(<?= $id_Persona ?>,<?= $idUsuario ?>,"<?= $nombreDoc ?>","<?= $apellidoDoc ?>")'></i></a>
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
    <script src="../assets/js/directorjs/desactivarDocente.js"></script>
    <script src="../assets/js/directorjs/resetPassword.js"></script>
</body>

</html>