<?php

include("../includes/sesion.php");

$id_director = getIdUsuario();
checkAccess([$id_director, 3]);

$pagina = 'Doc_tecniNuevas';
include("../includes/encabezado.php");
include("../sql/conexion.php");
include("direcMenuNav.php");
include("botonPreins.php");

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Tecnicaturas</title>
    <script>
        function showAlert(message) {
            alert(message);
        }

        function borrarCaps(element) {
            window.location.href = "doc_tec_eliminar.php?id=" + element.id;
        }
    </script>
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
                    <h4 class="mb-0">Ingresar Tecnicatura</h4>
                    <div>
                        <button class="btn btn-primary" onclick="window.location.href='inicioDirec.php'">VOLVER</button>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row align-items-start d-flex align-items-center">
                            <div class="col-md-6 col-sm-6">
                                <div class="md-form md-outline my-4">
                                    <input id="nombre" name="nombre" placeholder="" type="text" class="form-control"
                                        required autofocus>
                                    <label for="nombre" class="active">Nombre</label>
                                </div>
                                <div class="md-form md-outline my-4">
                                    <input id="resolucion" name="resolucion" placeholder="" type="text"
                                        class="form-control" required autofocus>
                                    <label for="resolucion" class="active">Resolución</label>
                                </div>
                                <div class="md-form md-outline my-4">
                                    <input id="ciclo" name="ciclo" placeholder="" type="text" class="form-control"
                                        required autofocus>
                                    <label for="ciclo" class="active">Ciclo Lectivo</label>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">HABILITAR INSCRIPCIONES DE ALUMNOS A NUEVAS CARRERAS</h5>
                                        <a href="HabilitarPreinscripcion.php"><?php echo $botonTexto; ?></a>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                                <div class="md-form md-outline my-4">
                                    <button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                    </form>

                    <?php
                    // Consulta para obtener los datos de la tabla tecnicaturas
                    $sql = "SELECT id_Tecnicatura, nombreTec, Resolucion, Ciclo, FechaModificacion FROM tecnicaturas";
                    $result = $conexion->query($sql);

                    if (isset($_POST['Guardar'])) {
                        $nombre = $_POST['nombre'];
                        $resolucion = $_POST['resolucion'];
                        $ciclo = $_POST['ciclo'];

                        $sql = "INSERT INTO tecnicaturas (nombreTec, Resolucion, Ciclo) VALUES (?, ?, ?)";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param('sss', $nombre, $resolucion, $ciclo);

                        if ($stmt->execute()) {
                            echo "<script>showAlert('Los datos fueron guardados correctamente.'); window.location.href = 'Doc_tecniNuevas.php';</script>";
                        } else {
                            echo "<script>showAlert('Error al guardar los datos.');</script>";
                        }
                    }
                    ?>

                    <div class="container card text-center my-3 px-0">
                        <h4 class="card-header primary-color-dark white-text">Búsqueda de Tecnicaturas</h4>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered table-hover table-striped display AllDataTables"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <td>ID</td>
                                            <td>Nombre</td>
                                            <td>Resolución</td>
                                            <td>Ciclo</td>
                                            <td>Fecha de Modificación</td>
                                            <td>Acciones</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $id_Tecnicatura = $row['id_Tecnicatura'];
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id_Tecnicatura']; ?></td>
                                                <td><?php echo $row['nombreTec']; ?></td>
                                                <td><?php echo $row['Resolucion']; ?></td>
                                                <td><?php echo $row['Ciclo']; ?></td>
                                                <td><?php echo $row['FechaModificacion']; ?></td>
                                                <td>
                                                <a style='color: #55acee' href='doc_tec_editar.php?id=<?php echo $id_Tecnicatura; ?>'><i class='far fa-edit fa-lg' title='Modificar'></i></a>
                                                <a style='color: #007bff' href='ver_materias.php?id=<?php echo $id_Tecnicatura; ?>'><i class='fas fa-book fa-lg' title='Ver Materias'></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="md-form md-outline text-center">
                        <button class="btn btn-primary"
                            onclick="window.location.href='inicioDirec.php';">VOLVER</button>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>

    <!-- <script>
        $(".button-collapse").sideNav();
        var container = document.querySelector('.custom-scrollbar');
        var ps = new PerfectScrollbar(container, {
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20
        });

        $('.datepicker').pickadate();

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script> -->
</body>

</html>