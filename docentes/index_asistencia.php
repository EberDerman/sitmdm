<?php
include("../includes/sesion.php");

/* $id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente); */
// Obtener el id_Materia desde la URL
$id_Materia = isset($_GET['id_Materia']) ? $_GET['id_Materia'] : null;

// Validar que se recibió un id_Materia válido
if ($id_Materia === null) {
    die("Error: id_Materia no especificado.");
}

// Incluir la conexión
include("../sql/conexion.php");
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaActual = date("d-m-Y");

try {
    // Consulta para obtener el nombre de la materia
    $stmt = $conexiones->prepare("SELECT Materia FROM materias WHERE id_Materia = :id_Materia");
    $stmt->execute(['id_Materia' => $id_Materia]);
    $materia = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validar si se obtuvo el nombre de la materia
    $nombreMateria = $materia ? $materia['Materia'] : 'Materia no encontrada';

    // Cerrar la conexión
    $stmt = null; // Liberar el statement
    $conexiones = null; // Cerrar la conexión
} catch (Exception $e) {
    // Manejo de errores en la conexión o consulta
    $nombreMateria = 'Error al obtener la materia';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomar Asistencia</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        .editable {
            cursor: pointer;
            background-color: #f9f9f9;
        }

        .botones-asistencia {
            margin: 20px 0;
            /* Espaciado entre el título y los botones */
            text-align: center;
            /* Centrar los botones */
        }

        .botones-asistencia button {
            background-color: #00bfff;
            /* Color celeste */
            color: white;
            /* Letras blancas */
            border: none;
            /* Sin borde */
            border-radius: 15px;
            /* Bordes redondeados */
            padding: 10px 20px;
            /* Espaciado interno */
            font-size: 16px;
            /* Tamaño del texto */
            cursor: pointer;
            /* Indicador de clic */
            margin: 0 10px;
            /* Espaciado entre botones */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            /* Sombra */
            transition: transform 0.2s ease, background-color 0.2s ease;
            /* Animación al hacer hover */
        }

        .botones-asistencia button:hover {
            background-color: #0099cc;
            /* Cambiar a un azul más oscuro al pasar el mouse */
            transform: scale(1.05);
            /* Efecto de agrandamiento */
        }
    </style>
</head>

<body>

    <?php
    include("nav_bar_doc.php");
    ?>
    <h2>Tomar Asistencia - <?php echo htmlspecialchars($nombreMateria); ?> - fecha <?php echo date('d/m/Y'); ?></h2>
    <div class="botones-asistencia">
        <button id="asistenciaPorDia"
            onclick="window.location.href='asistencia_mostrar.php?id_Materia=<?php echo $id_Materia; ?>'">Asistencia por
            Día</button>
        <button id="porcentajeAsistencia"
            onclick="window.location.href='asistencia_porcentaje.php?id_Materia=<?php echo $id_Materia; ?>'">Porcentaje
            de Asistencia</button>
    </div>
    <table id="example" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Presente</th>
                <th>Horas Asistidas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php



            // Consultar los estudiantes basados en id_Materia
            $sql = "SELECT 
e.id_estudiante, 
e.nombre, 
e.apellido, 
a.presente, 
a.horas_asistidas, 
a.fecha, 
em.id_Tipocursada, 
tc.tipocursada 
FROM estudiantes AS e
JOIN estudiante_materia AS em ON e.id_estudiante = em.id_estudiante
LEFT JOIN asistencia AS a ON e.id_estudiante = a.id_estudiante AND a.id_Materia = ? AND DATE(a.fecha) = CURDATE()
LEFT JOIN tipocursada AS tc ON em.id_Tipocursada = tc.id_Tipocursada
WHERE em.id_Materia = ?";

            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ii", $id_Materia, $id_Materia);
            $stmt->execute();
            $result = $stmt->get_result();

            // Mostrar los datos en la tabla
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $presente = $row['presente'] == 1 ? 'Sí' : 'No';
                    $readonly = $row['id_Tipocursada'] != 3 ? "readonly" : "";

                    echo "<tr data-id='{$row['id_estudiante']}' data-tipocursada='{$row['id_Tipocursada']}'>
    <td>{$row['id_estudiante']}</td>
    <td class='editable' data-column='nombre'>{$row['nombre']}</td>
    <td class='editable' data-column='apellido'>{$row['apellido']}</td>";

                    // Mostrar checkbox de "Presente" solo si Tipocursada es 3
                    if ($row['id_Tipocursada'] == 3) {
                        echo "<td><input type='checkbox' class='edit-presente' data-id='{$row['id_estudiante']}' " . (!is_null($row['presente']) && $row['presente'] == 1 ? "checked" : "") . "></td>";
                    } else {
                        echo "<td><input type='checkbox' class='edit-presente' data-id='{$row['id_estudiante']}' disabled></td>";
                    }

                    // Mostrar select de "Horas Asistidas" solo si Tipocursada es 3
                    if ($row['id_Tipocursada'] == 3) {
                        echo "<td>
        <select class='edit-horas' data-id='{$row['id_estudiante']}'>";
                        for ($i = 0; $i <= 4; $i++) {
                            $selected = (!is_null($row['horas_asistidas']) && $i == $row['horas_asistidas']) ? "selected" : "";
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        echo "</select>
      </td>";
                    } else {
                        echo "<td><input type='text' value='{$row['horas_asistidas']}' disabled></td>";
                    }

                    // Mostrar acciones según id_Tipocursada
                    if ($row['id_Tipocursada'] == 3) {
                        if (is_null($row['fecha'])) {
                            echo "<td><button class='nueva-asistencia' data-id='{$row['id_estudiante']}'>Nueva Asistencia</button></td>";
                        } else {
                            echo "<td>Asistencia creada</td>";
                        }
                    } else {
                        echo "<td>{$row['tipocursada']}</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
            }

            $stmt->close();
            $conexion->close();
            ?>
        </tbody>
    </table>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encontraron resultados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": activar para ordenar la columna de manera descendente"
                    }
                }
            });

            // Evitar edición si no es tipocursada 3
            $('.edit-presente').each(function () {
                if ($(this).closest('tr').data('tipocursada') != 3) {
                    $(this).prop('disabled', true);
                }
            });

            $('.edit-horas').each(function () {
                if ($(this).closest('tr').data('tipocursada') != 3) {
                    $(this).prop('disabled', true);
                }
            });

            // Evento para el botón "Nueva asistencia"
            $('.nueva-asistencia').on('click', function () {
                var idEstudiante = $(this).data('id');
                var idMateria = <?php echo $id_Materia; ?>;
                var button = $(this);

                $.ajax({
                    url: 'update_asistencia.php',
                    type: 'POST',
                    data: { action: 'nueva_asistencia', id_estudiante: idEstudiante, id_Materia: idMateria },
                    success: function (response) {
                        alert(response);
                        if (response.includes("Asistencia creada")) {
                            button.replaceWith("Asistencia creada"); // Cambiar el botón al texto "Asistencia creada"
                        }
                    }
                });
            });

            // Checkbox de "Presente"
            $('.edit-presente').on('change', function () {
                var idEstudiante = $(this).data('id');
                var idMateria = <?php echo $id_Materia; ?>;
                var value = $(this).is(':checked') ? 1 : 0;

                var checkbox = $(this); // Almacenar referencia al checkbox

                updateAsistencia(idEstudiante, idMateria, 'presente', value, function (success) {
                    if (!success) {
                        checkbox.prop('checked', false); // Restablecer el checkbox
                    }
                });
            });

            // Select de "Horas Asistidas"
            $('.edit-horas').on('change', function () {
                var idEstudiante = $(this).data('id');
                var idMateria = <?php echo $id_Materia; ?>;
                var value = $(this).val();

                var select = $(this); // Almacenar referencia al select

                updateAsistencia(idEstudiante, idMateria, 'horas_asistidas', value, function (success) {
                    if (!success) {
                        select.val(0); // Restablecer el select a 0
                    }
                });
            });

            function updateAsistencia(idEstudiante, idMateria, column, value, callback) {
                $.ajax({
                    url: 'update_asistencia.php',
                    type: 'POST',
                    data: { action: 'update', id_estudiante: idEstudiante, id_Materia: idMateria, column: column, value: value },
                    success: function (response) {
                        alert(response);

                        // Si el servidor responde con el mensaje de error, ejecutar el callback con `false`
                        if (response.includes("Error: El registro de asistencia no existe para el día de hoy.")) {
                            callback(false);
                        } else {
                            callback(true); // Todo está bien
                        }
                    }
                });
            }
        });
    </script>


    <?php
    include("foot_bar_doc.php");
    ?>
</body>

</html>