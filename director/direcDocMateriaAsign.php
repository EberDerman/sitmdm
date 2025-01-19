<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../includes/encabezado.php");
include("../sql/DocenteRepository.php");

$idDoc = $_GET['idDoc'];
$nombreDoc = $_GET['nombreDoc'];
$apellidoDoc = $_GET['apellidoDoc'];

$docenteRepository = new DocenteRepository();
$materiasSinAsignar = $docenteRepository->getNotAgisnedMaterias();

?>
<link rel="stylesheet" href="../assets/css/direcDocMateriaAsign.css">
<title>SITMDM-Asignar materias</title>
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
                <h4><i class="fas fa-user"></i> Asignar nuevas materias a
                    <?= $nombreDoc . ' ' . $apellidoDoc ?>
                </h4>
                <button class="btn btn-primary"
                    onclick="window.location.href='direcDocMateria.php?idDoc=<?= $idDoc ?>&nombreDoc=<?= $nombreDoc ?>&apellidoDoc=<?= $apellidoDoc ?>';">VOLVER</button>
            </div>
            <div class="container mt-1">
                <div class="container card text-center mt-3">
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-hover display AllDataTables" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Tecnicatura</th>
                                        <th>Materia</th>
                                        <th>Año Cursada</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materiasSinAsignar as $idTecnicatura => $tecnicaturas) { ?>
                                        <?php foreach ($tecnicaturas as $nombreTec => $materiasArray) { ?>
                                            <?php foreach ($materiasArray as $materia) { ?>
                                                <tr>
                                                    <td><?= $nombreTec; ?></td>
                                                    <td><?= $materia['Materia']; ?></td>
                                                    <td><?= $materia['AnioCursada']; ?></td>
                                                    <td><a style='color: #55acee'><i class='fas fa-plus fa-lg' title='Asignar'
                                                                onClick='asignarMateria(<?= $idDoc ?>,<?= $materia['id_Materia'] ?>,"<?= $nombreDoc ?>","<?= $apellidoDoc ?>","<?= $materia['Materia'] ?>","<?= $nombreTec ?>")'></i></a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
    include("../includes/pie_sinTable.php");
    ?>
    <script src="../assets/js/directorjs/direcDocMateriaAsign.js"></script>
</body>

</html>