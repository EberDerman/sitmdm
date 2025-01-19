<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/MateriasRepository.php");

$materiasRepository = new MateriasRepository();
$materiasNoAsignadas = $materiasRepository->getMateriasNoAsignadas($anio);  // Valor predeterminado para la primera carga
?>
<title>SITMDM-Preceptores</title>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("precepMenuNav.php"); ?>
    </div>
    <main>
        <div class="container">
            <div class="card text-center">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3"
                    style="border-radius: 8px;">
                    <h3 class="font-weight-200 text-white">Asignar regularidad</h3>
                    <span data-toggle="tooltip" data-placement="top" class="mx-2"
                        title="Seleccionar un año para asignar el tipo de cursada como regular a todos los estudiantes de las materias afectadas. Se podrá modificar el tipo de cursada a cada alumno en el listado de estudiantes.">
                        Ayuda para esta pantalla
                    </span>
                    <button class="btn btn-primary" onclick="window.location.href='inicioPrecep.php'">VOLVER</button>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-center mb-3">
                        <label for="year" class="form-control col-3 text-right border-0 m-3">Selecciona un
                            año:</label>
                        <select id="year" name="year" style="display: block !important;" class="form-control col-2 m-3">
                            <!-- Los valores se llenarán mediante JavaScript -->
                        </select>
                        <button class="btn btn-primary col-3 m-3" data-toggle="modal" data-target="#myModal">Asignar
                            regularidad</button>
                    </div>
                    <div class="bg-primary text-white p-2 mb-3">
                        <h4 class="mb-0">Se asignaran como regular a los alumnos de las siguientes materias:</h4>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-striped display AllDataTables"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <td>Tecnicatura</td>
                                    <td>Ciclo de Tecnicatura</td>
                                    <td>Materia</td>
                                    <td>Año de cursada</td>
                                </tr>
                            </thead>
                            <tbody id="materias-list">
                                <!-- Las materias se llenarán aquí mediante JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>

    <!-- Modal for Pasaje De Año -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro? Esta acción no puede ser revertida.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="acceptBtn">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
<script src="../assets/js/directorjs/precepSiguiente.js"></script>
</body>

</html>