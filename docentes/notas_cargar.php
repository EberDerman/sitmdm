<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editable DataTable con Bootstrap</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .editable {
            width: 100%;
            border: none;
            background-color: transparent;
            text-align: center;
        }

        .editable:focus {
            outline: 2px solid #007bff;
        }

        .action-btn {
            text-align: center;
        }

        .dataTables_wrapper {
            overflow: auto;
        }

        table.dataTable {
            width: 100%;
            border-collapse: collapse;
        }
        .name-column {
            width: 170px; /* Cambia el valor según tus necesidades */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Registro de alumnos</h2>

        <form method="post" action="">
            <table id="editableTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nombre y apellido</th>
                        <th>1° cuat</th>
                        <th>2° cuat</th>
                        <th>Aprobo SI/NO</th>
                        <th>Recup febrero</th>
                        <th>Prefinal febrero</th>
                        <th>Aprobo SI/NO 2</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Datos de ejemplo
                    $datos = [
                        ['nombre y apellido' => 'Juan Pérez', '1° cuatrimestre' => 5, '2° cuatrimestre' => 5, 'aprobo cursada' => 'si', 'recuperatorio_febrero' => 8, 'prefinal_febrero' => 5, 'aprobo cursada 2' => 'si', 'observaciones' => 'Ninguna'],
                        // Agrega más datos según sea necesario
                    ];

                    // Generar filas de la tabla
                    foreach ($datos as $fila) {
                        echo '<tr>';
                        echo '<td><input type="text" name="nombre[]" value="' . htmlspecialchars($fila['nombre y apellido']) . '" class="editable form-control name-column" readonly></td>';
                        echo '<td><input type="number" name="1° cuatrimestre[]" value="' . htmlspecialchars($fila['1° cuatrimestre']) . '" class="editable form-control"></td>';
                        echo '<td><input type="number" name="2° cuatrimestre[]" value="' . htmlspecialchars($fila['2° cuatrimestre']) . '" class="editable form-control"></td>';
                        echo '<td><input type="text" name="aprobo cursada[]" value="' . htmlspecialchars($fila['aprobo cursada']) . '" class="editable form-control" readonly></td>';
                        echo '<td><input type="number" name="recuperatorio_febrero[]" value="' . htmlspecialchars($fila['recuperatorio_febrero']) . '" class="editable form-control"></td>';
                        echo '<td><input type="number" name="prefinal_febrero[]" value="' . htmlspecialchars($fila['prefinal_febrero']) . '" class="editable form-control"></td>';
                        echo '<td><input type="text" name="aprobo cursada 2[]" value="' . htmlspecialchars($fila['aprobo cursada 2']) . '" class="editable form-control" readonly></td>';

                        // Columna de Observaciones
                        echo '<td class="action-btn">';
                        echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#observacionModal" onclick="showObservacion('  . ', \'' . htmlspecialchars($fila['observaciones']) . '\')">Ver/Editar</button>';
                        echo '</td>';

                        // Columna de Acciones (Guardar)
                        echo '<td class="action-btn">';
                        echo '<button type="submit" name="guardar" value="'  . '" class="btn btn-primary">Guardar</button>';
                        echo '</td>';

                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </form>

        <!-- Modal para Observaciones -->
        <div class="modal fade" id="observacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Observación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formObservaciones">
                            <div class="form-group">
                                <label for="observacionTexto">Observaciones</label>
                                <textarea class="form-control" id="observacionTexto" name="observaciones"></textarea>
                                <input type="hidden" id="observacionId" name="id">
                            </div>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="guardarObservacion()">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php
        // Procesar la edición
        if (isset($_POST['guardar'])) {
            $id = $_POST['guardar'];
            $nombres = $_POST['nombre'];
            echo '<div class="alert alert-success mt-4">';
            echo '<h4>Datos Guardados:</h4>';
            echo '<ul>';
            foreach ($datos as $index => $fila) {
                if ($fila['id'] == $id) {
                    echo '<li>ID: ' . htmlspecialchars($fila['id']) . ', Nombre: ' . htmlspecialchars($nombres[$index]) . '</li>';
                }
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            $('#editableTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "lengthChange": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });

        function showObservacion(id, observacion) {
            $('#observacionId').val(id);
            $('#observacionTexto').val(observacion);
        }

        function guardarObservacion() {
            var id = $('#observacionId').val();
            var observacion = $('#observacionTexto').val();
            alert('Observación guardada para el ID: ' + id + ' - ' + observacion);
        }
    </script>

</body>

</html>
