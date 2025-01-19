<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include('session_check.php');


// Obtener la fecha actual
date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaActual = date("d-m-Y");

// Consulta para obtener todos los registros de la tabla 'temario'
$sql = "SELECT id_temario, fecha, Clase, Unidad, Caracter, Contenidos, Actividad, Observaciones, horas_dadas FROM temario WHERE id_Materia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_Materia);
$stmt->execute();
$result = $stmt->get_result();

// Capturamos el id_Materia desde la URL
$id_Materia = isset($_GET['id_Materia']) ? (int)$_GET['id_Materia'] : 0;

// Consulta para obtener el nombre de la materia
$stmt = $conexiones->prepare("SELECT Materia FROM materias WHERE id_Materia = :id_Materia");
$stmt->execute(['id_Materia' => $id_Materia]);
$materia = $stmt->fetch(PDO::FETCH_ASSOC);

// Mostramos el título de la materia
echo "<title>Temario de " . htmlspecialchars($materia['Materia']) . "</title>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Temario</title>
    <style>
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control, .form-control-textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            box-sizing: border-box;
        }

        .form-control-textarea {
            height: 100px;
        }

        .form-label {
            position: absolute;
            top: -0.75rem;
            left: 0.75rem;
            background-color: white;
            padding: 0 0.25rem;
            font-size: 0.9rem;
            color: #495057;
        }
    </style>
    <script>
        function showAlert(message) {
            alert(message);
        }

        // Función para validar que los inputs solo reciban valores enteros positivos
        function validatePositiveInteger(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
        }

        // Función para confirmar la eliminación
        function confirmDelete(url) {
            if (confirm("¿Estás seguro de que deseas eliminar este registro?")) {
                window.location.href = url; // Redirigir a la URL para eliminar
            }
        }

    </script>
</head>
<body class="hidden-sn mdb-skin">
<main>
<div class="container-fluid">
      <?php
      include ("docMenuNav.php");
      ?>
    </div>
    <div class="container card text-center my-3 px-0">
        <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_Materia" value="<?php echo $id_Materia; ?>">
            <div class="card-body">
                <div class="form-header bgRosa w-max-content">
                <h3 class="font-weight-200 text-white"><i class="fas fa-book"></i> Ingresar temario de <?php echo htmlspecialchars($materia['Materia']); ?></h3>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="md-form md-outline">
                        <input id="fecha" name="fecha" type="text" class="form-control" value="<?php echo $fechaActual; ?>" readonly>
                        <label for="fecha" class="active">Fecha</label>
                    </div>
                </div>
                <br>
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="materia" class="form-label">Clase</label>
                        <input id="clase" name="clase" type="text" class="form-control" required autofocus oninput="validatePositiveInteger(this);">
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="unidad" class="form-label">Unidad</label>
                        <input id="unidad" name="unidad" type="text" class="form-control" required oninput="validatePositiveInteger(this);">
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div id="selectContainer" class="md-form md-outline">
                        <select name="caracter" class="materias-select mdb-select colorful-select dropdown-primary md-form" required>
                            <option value="" disabled selected>Seleccionar Carácter de la Clase</option>              
                            <option value="TEORIA">TEORIA</option>
                            <option value="PRACTICA">PRACTICA</option>
                            <option value="PARCIAL">PARCIAL</option>
                            <option value="RECUPERATORIO">RECUPERATORIO</option>
                            <option value="OTROS">OTROS</option>     
                        </select>
                    </div>
                </div>
                <br>

                <!-- Textareas con su pequeño título en el borde -->
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="contenidos" class="form-label">Contenidos</label>
                        <textarea id="contenidos" name="contenidos" class="form-control-textarea form-control" required></textarea>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="actividad" class="form-label">Actividad</label>
                        <textarea id="actividad" name="actividad" class="form-control-textarea form-control" required></textarea>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control-textarea form-control" required></textarea>
                    </div>
                </div>
                <!-- Campo para Horas Dadas en el formulario -->
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="horas_dadas" class="form-label">Horas Dadas</label>
                        <input id="horas_dadas" name="horas_dadas" type="text" class="form-control" value="0" required oninput="validatePositiveInteger(this);">
                    </div>
                </div>
                <!-- Validación JavaScript para verificar que Horas Dadas no sea 0 -->
                    <script>
                        function validateForm() {
                            const horasDadas = document.getElementById('horas_dadas').value;
                            if (horasDadas === '0') {
                                alert("No puedes cargar 0 horas");
                                return false;
                            }
                            return true;
                        }
                    </script>
            </div>
            <button type="submit" name="Guardar" class="btn btn-primary" onclick="return validateForm()">GUARDAR</button>
            <button class="btn btn-primary" onclick="window.location.href='MisCursos.php'">VOLVER</button>
        </div>
    </form>
</div>

<?php
    if (isset($_POST['Guardar'])) {
        // Obtener solo la fecha (día, mes y año)
        $fecha = date("Y-m-d");
        $Clase = $_POST['clase'];
        $Unidad = $_POST['unidad'];
        $Caracter = $_POST['caracter'];
        $Contenidos = $_POST['contenidos'];
        $Actividades = $_POST['actividad'];
        $Observaciones = $_POST['observaciones'];
        $id_Materia = $_POST['id_Materia'];
        $horasDadas = $_POST['horas_dadas'];

       // Consulta preparada con PDO para guardar en la tabla 'temario'
       $sql = "INSERT INTO temario (id_Materia, fecha, Clase, Unidad, Caracter, Contenidos, Actividad, Observaciones, horas_dadas) 
       VALUES (:id_Materia, :fecha, :Clase, :Unidad, :Caracter, :Contenidos, :Actividad, :Observaciones, :horas_dadas)";
        $stmt = $conexiones->prepare($sql);
        $stmt->bindParam(':id_Materia', $id_Materia);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':Clase', $Clase);
        $stmt->bindParam(':Unidad', $Unidad);
        $stmt->bindParam(':Caracter', $Caracter);
        $stmt->bindParam(':Contenidos', $Contenidos);
        $stmt->bindParam(':Actividad', $Actividades);
        $stmt->bindParam(':Observaciones', $Observaciones);
        $stmt->bindParam(':horas_dadas', $horasDadas);

        if ($stmt->execute()) {
            echo "<script>
                    showAlert('Los datos fueron guardados correctamente.');
                    window.location.href = 'Temario_cargar.php?id_Materia=" . $id_Materia . "';
                  </script>";
        } else {
            echo "<script>showAlert('Error al guardar los datos.');</script>";
        }
}
$sql = "SELECT id_temario, fecha, Clase, Unidad, Caracter, Contenidos, Actividad, Observaciones, horas_dadas FROM temario WHERE id_Materia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_Materia);
$stmt->execute();
$result = $stmt->get_result();

?>
<!-- Mostrar los registros existentes -->
<div class="container card text-center my-3 px-0">
<h4 class="card-header primary-color-dark white-text">Registros ingresados para <?php echo htmlspecialchars($materia['Materia']); ?></h4>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <td>Fecha</td>
                    <td>Clase</td>
                    <td>Unidad</td>
                    <td>Caracter</td>
                    <td>Contenidos</td>
                    <td>Actividad</td>
                    <td>Observaciones</td>
                    <td>Horas Dadas</td>
                    <td>Acciones</td>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id_Temario = $row['id_temario'];
                        echo "<tr>
                            <td>{$row['fecha']}</td>
                            <td>{$row['Clase']}</td>
                            <td>{$row['Unidad']}</td>
                            <td>{$row['Caracter']}</td>
                            <td>{$row['Contenidos']}</td>
                            <td>{$row['Actividad']}</td>
                            <td>{$row['Observaciones']}</td>
                            <td>{$row['horas_dadas']}</td>
                            <td>
                                <a style='color: #55acee' href='temario_editar.php?id={$id_Temario}&id_Materia={$id_Materia}'><i class='far fa-edit fa-lg' title='Modificar'></i></a>
                                <a style='color: #ff4500' href='javascript:void(0);' onclick='confirmDelete(\"temario_eliminar.php?id={$id_Temario}&id_Materia={$id_Materia}\")'><i class='far fa-trash-alt fa-lg' title='Eliminar'></i></a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No hay registros</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<?php 
include ("../includes/pie.php");
?>



</body>
</html>
