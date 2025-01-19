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
    <title>Asistencia por Día</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
</head>
<body>
    <?php
      include ("nav_bar_doc.php");
    ?>
<h2>Asistencia por Día - <?php echo htmlspecialchars($nombreMateria); ?></h2>
<label for="fecha">Selecciona una fecha:</label>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fecha", {
            locale: "es", // Configura el idioma a español
            dateFormat: "Y-m-d" // Formato de la fecha
        });
    });
</script>
<input type="text" id="fecha" maxlength="11" style="width: 80px;">
<button id="verAsistencia">Mostrar Asistencia</button>
<button id="ocultarTabla" style="display: none;">Ocultar Tabla</button>

<div id="tablaAsistencia" style="display: none;">
    <table id="asistenciaDia" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Presente</th>
                <th>Horas Asistidas</th>
            </tr>
        </thead>
        <tbody id="datosAsistencia"></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    let dataTable; // Variable para almacenar la instancia de DataTable

    $('#verAsistencia').on('click', function() {
        let fecha = $('#fecha').val();
        let idMateria = <?php echo $_GET['id_Materia']; ?>;

        if (fecha) {
            $.ajax({
                url: 'fetch_asistencia.php',
                type: 'GET',
                data: { id_Materia: idMateria, fecha: fecha },
                success: function(response) {
                    $('#datosAsistencia').html(response);
                    $('#tablaAsistencia').show();
                    $('#ocultarTabla').show();
                    $('#verAsistencia').hide();

                    // Comprobar si la tabla ya está inicializada
                    if (!$.fn.dataTable.isDataTable('#asistenciaDia')) {
                        dataTable = $('#asistenciaDia').DataTable({
                            language: {
                                "decimal": "",
                                "emptyTable": "No hay información disponible",
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
                    } else {
                        // Refrescar los datos en la tabla si ya está inicializada
                        dataTable.clear().draw(); // Limpia los datos actuales
                        dataTable.rows.add($(response)); // Agrega las nuevas filas
                        dataTable.columns.adjust().draw(); // Ajusta las columnas y redibuja
                    }
                }
            });
        } else {
            alert("Por favor, selecciona una fecha.");
        }
    });

    $('#ocultarTabla').on('click', function() {
        $('#tablaAsistencia').hide();
        $('#ocultarTabla').hide();
        $('#verAsistencia').show();
    });
});
</script>
<?php
      include ("foot_bar_doc.php");
    ?>
</body>
</html>
