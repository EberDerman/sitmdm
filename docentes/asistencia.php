<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../sql/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editable DataTable</title>
    <!-- DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Eliminar cualquier versión anterior de jQuery -->
    <script>
        // Detecta y elimina cualquier versión de jQuery que no sea la 3.6.0
        document.querySelectorAll('script[src*="jquery"]').forEach(script => {
            if (!script.src.includes("3.6.0")) {
                script.remove();
            }
        });
    </script>

    <!-- Cargar jQuery 3.6.0 después de eliminar versiones anteriores -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .editable {
            cursor: pointer;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<?php
$id_Materia = 1;
?>

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
        // Conectar a la base de datos
        $conn = new mysqli("localhost", "root", "", "sitmdm");

        // Comprobar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consultar los estudiantes basados en id_Materia
        $sql = "SELECT e.id_estudiante, e.nombre, e.apellido, a.presente, a.horas_asistidas, a.fecha 
            FROM estudiantes AS e
            JOIN estudiante_materia AS em ON e.id_estudiante = em.id_estudiante
            LEFT JOIN asistencia AS a ON e.id_estudiante = a.id_estudiante AND a.id_Materia = ? AND DATE(a.fecha) = CURDATE()
            WHERE em.id_Materia = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_Materia, $id_Materia);
        $stmt->execute();
        $result = $stmt->get_result();

        // Mostrar los datos en la tabla
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $presente = $row['presente'] == 1 ? 'Sí' : 'No';
                echo "<tr data-id='{$row['id_estudiante']}'>
                    <td>{$row['id_estudiante']}</td>
                    <td class='editable' data-column='nombre'>{$row['nombre']}</td>
                    <td class='editable' data-column='apellido'>{$row['apellido']}</td>";

                // Mostrar siempre checkbox y select, asignando valores si existe el registro
                echo "<td><input type='checkbox' class='edit-presente' data-id='{$row['id_estudiante']}' " . (!is_null($row['presente']) && $row['presente'] == 1 ? "checked" : "") . "></td>";

                echo "<td>
                    <select class='edit-horas' data-id='{$row['id_estudiante']}'>";
                for ($i = 0; $i <= 4; $i++) {
                    $selected = (!is_null($row['horas_asistidas']) && $i == $row['horas_asistidas']) ? "selected" : "";
                    echo "<option value='$i' $selected>$i</option>";
                }
                echo "</select>
                  </td>";

                // Si no hay registro de asistencia, mostrar botón "Nueva Asistencia"
                if (is_null($row['fecha'])) {
                    echo "<td><button class='nueva-asistencia' data-id='{$row['id_estudiante']}'>Nueva Asistencia</button></td>";
                } else {
                    echo "<td>Asistencia creada</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#example').DataTable();

        // Evento para el botón "Nueva asistencia"
        $('.nueva-asistencia').on('click', function() {
            var idEstudiante = $(this).data('id');
            var idMateria = <?php echo $id_Materia; ?>;
            var button = $(this);

            $.ajax({
                url: 'update_asistencia.php',
                type: 'POST',
                data: {
                    action: 'nueva_asistencia',
                    id_estudiante: idEstudiante,
                    id_Materia: idMateria
                },
                success: function(response) {
                    alert(response);
                    if (response.includes("Asistencia creada")) {
                        button.replaceWith("Asistencia creada"); // Cambiar el botón al texto "Asistencia creada"
                    }
                }
            });
        });

        // Checkbox de "Presente"
        $('.edit-presente').on('change', function() {
            var idEstudiante = $(this).data('id');
            var idMateria = <?php echo $id_Materia; ?>;
            var value = $(this).is(':checked') ? 1 : 0;

            updateAsistencia(idEstudiante, idMateria, 'presente', value);
        });

        // Select de "Horas Asistidas"
        $('.edit-horas').on('change', function() {
            var idEstudiante = $(this).data('id');
            var idMateria = <?php echo $id_Materia; ?>;
            var value = $(this).val();

            updateAsistencia(idEstudiante, idMateria, 'horas_asistidas', value);
        });

        function updateAsistencia(idEstudiante, idMateria, column, value) {
            $.ajax({
                url: 'update_asistencia.php',
                type: 'POST',
                data: {
                    action: 'update',
                    id_estudiante: idEstudiante,
                    id_Materia: idMateria,
                    column: column,
                    value: value
                },
                success: function(response) {
                    alert(response);
                }
            });
        }
    });
</script>

<?php include '../includes/pie.php' ?>
</body>

</html>
