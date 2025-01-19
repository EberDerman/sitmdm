<?php

include("../includes/sesion.php");

$id_director = getIdUsuario();
checkAccess([$id_director, 3]);

include("../includes/encabezado.php");
include("../sql/PreceptorRepository.php");

$preceptorRepository = new PreceptorRepository();
$listaPreceptores = $preceptorRepository->getAllPreceptores();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SITMDM-Preceptores</title>
    <!-- Include necessary CSS and JS files here -->
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
                    <h4 class="mb-0">Listado de Preceptores</h4>
                    <div>
                        <button class="btn btn-primary" onclick="window.location.href='inicioDirec.php'">VOLVER</button>
                        <button class="btn btn-primary" onclick="window.location.href='direcPrecepDesactivados.php'">VER
                            PRECEPTORES DESACTIVADOS</button>
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
                                <?php foreach ($listaPreceptores as $row):
                                    $id_Persona = $row['id_Persona'];
                                    $idUsuario = $row['idUsuario'];
                                    ?>
                                    <tr>
                                        <td><?php echo $nombrePrecep = $row['Nombre']; ?></td>
                                        <td><?php echo $apellidoPrecep = $row['Apellido']; ?></td>
                                        <td>
                                            <a style='color: blue'
                                                href='direcFormPersonaVer.php?id_Persona=<?= $id_Persona ?>'><i
                                                    class='far fa-eye fa-lg' title='Ver datos personales'></i></a>
                                            <a style='color: #55acee'
                                                href='direcDocEditar.php?id_Persona=<?= $id_Persona ?>'><i
                                                    class='far fa-edit fa-lg' title='Editar datos personales'></i></a>
                                            <a style='color: orange'><i class='fa fa-key fa-lg' title='Reiniciar contraseña'
                                                    onClick='reiniciarPassword(<?= $id_Persona ?>,<?= $idUsuario ?>,"<?= $nombrePrecep ?>","<?= $apellidoPrecep ?>")'></i></a>
                                            <a style='color: #ff4500'><i class='far fa-trash-alt fa-lg'
                                                    title='Desactivar preceptor'
                                                    onClick='desactivarDocente(<?= $id_Persona ?>,<?= $idUsuario ?>,"<?= $nombrePrecep ?>","<?= $apellidoPrecep ?>")'></i></a>
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
    <script src="../assets/js/directorjs/desactivarPreceptor.js"></script>
    <script src="../assets/js/directorjs/resetPassword.js"></script>
</body>

</html>