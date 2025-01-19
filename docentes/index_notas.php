<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);
// Obtener el id_Materia desde la URL
$id_Materia = isset($_GET['id_Materia']) ? $_GET['id_Materia'] : null;

// Validar que se recibió un id_Materia válido
if ($id_Materia === null) {
    die("Error: id_Materia no especificado.");
}

// Incluir la conexión
include("../sql/conexion.php");

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
    <title>Cargar Notas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        .editable {
            cursor: pointer;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<?php
$id_Materia = $_GET['id_Materia'];
?>
   <?php
      include ("nav_bar_doc.php");
    ?>
<h1>Cargar Notas - <?php echo htmlspecialchars($nombreMateria); ?></h1>
<table id="example" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Nota Primer Cuatrimestre</th>
            <th>Nota Segundo Cuatrimestre</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
  

        $sql = "SELECT e.id_estudiante, e.nombre, e.apellido, em.nota_primer_cuatrimestre, em.nota_segundo_cuatrimestre, em.observaciones 
                FROM estudiantes AS e
                JOIN estudiante_materia AS em ON e.id_estudiante = em.id_estudiante
                WHERE em.id_Materia = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_Materia);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr data-id='{$row['id_estudiante']}'>
                        <td>{$row['id_estudiante']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['apellido']}</td>
                        <td><input type='number' class='edit-nota' data-column='nota_primer_cuatrimestre' data-id='{$row['id_estudiante']}' value='{$row['nota_primer_cuatrimestre']}'></td>
                        <td><input type='number' class='edit-nota' data-column='nota_segundo_cuatrimestre' data-id='{$row['id_estudiante']}' value='{$row['nota_segundo_cuatrimestre']}'></td>
                        <td><input type='text' class='edit-nota' data-column='observaciones' data-id='{$row['id_estudiante']}' value='{$row['observaciones']}'></td>
                      </tr>";
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
$(document).ready(function() {
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

    // Evento para campos de nota y observaciones
    $('.edit-nota').on('change', function() {
        var idEstudiante = $(this).data('id');
        var idMateria = <?php echo $id_Materia; ?>;
        var column = $(this).data('column');
        var value = $(this).val();

        updateNota(idEstudiante, idMateria, column, value);
    });

    function updateNota(idEstudiante, idMateria, column, value) {
        $.ajax({
            url: 'update_notas.php',
            type: 'POST',
            data: { action: 'update_nota', id_estudiante: idEstudiante, id_Materia: idMateria, column: column, value: value },
            success: function(response) {
                alert(response);
            }
        });
    }
});
</script>

<?php
      include ("foot_bar_doc.php");
    ?>
</body>
</html>
