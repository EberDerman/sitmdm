<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");

// Verifica si se ha recibido un ID válido por GET
if (isset($_GET['id']) && isset($_GET['id_Materia'])) {
    $id_temario = $_GET['id'];
    $id_Materia = intval($_GET['id_Materia']); 

    // Consulta para obtener los detalles del temario con el ID dado
    $sql = "SELECT id_temario, fecha, Clase, Unidad, Caracter, Contenidos, Actividad, Observaciones, horas_dadas FROM temario WHERE id_temario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_temario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el registro
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Registro no encontrado.'); window.location.href = 'Temario_cargar.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID no válido.'); window.location.href = 'Temario_cargar.php?id_Materia=" . $id_Materia . "';</script>";
    exit();
}


// Verifica si se ha enviado el formulario para actualizar
if (isset($_POST['Actualizar'])) {
    $Unidad = $_POST['unidad'];
    $Clase = $_POST['clase'];
    $Contenidos = $_POST['contenidos'];
    $Actividad = $_POST['actividad'];
    $Observaciones = $_POST['observaciones'];
    $horasDadas = $_POST['horas_dadas'];

    // Inicializar la variable caracter
    $Caracter = null;

    // Verifica si se ha seleccionado un radio button para caracter
    if (isset($_POST['caracter']) && !empty($_POST['caracter'])) {
        $Caracter = $_POST['caracter'];
    } else {
        // Si no se ha seleccionado un radio button, se mantiene el valor actual de caracter
        $Caracter = $row['Caracter'];
    }

    $sql = "UPDATE temario SET Clase = ?, Unidad = ?, Caracter = ?, Contenidos = ?, Actividad = ?, Observaciones = ?, horas_dadas = ? WHERE id_temario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('isssssii', $Clase, $Unidad, $Caracter, $Contenidos, $Actividad, $Observaciones, $horasDadas, $id_temario);

    if ($stmt->execute()) {
        echo "<script>alert('Temario actualizado correctamente.'); window.location.href = 'Temario_cargar.php?id_Materia=" . $id_Materia . "';</script>";
    } else {
        echo "<script>alert('Error al actualizar el temario.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Temario</title>
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

        .form-header {
            background-color: #007bff; /* Mismo color que el botón */
            padding: 1rem;
            color: white;
            text-align: center;
            border: 1px solid #007bff; /* Agregado borde para que coincida con el botón */
        }

        h3 {
            font-weight: 400;
            font-size: 24px;
            margin: 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .materias-select {
            width: calc(50% - 10px); /* Ajuste de ancho para el select */
            display: inline-block; /* Para mostrarlo en línea con el input */
        }
    </style>
</head>
<body class="hidden-sn mdb-skin">
<main>
    <div class="container card text-center my-3 px-0">
        <form method="POST">
            <div class="card-body">
                <div class="form-header w-max-content">
                    <h3 class="text-white"><i class="fas fa-edit"></i> Editar Temario</h3>
                </div>

                <!-- Mostrar los campos en modo solo lectura -->
                <div class="col-md-8 col-sm-8">
                    <div class="md-form md-outline">
                        <input id="fecha" name="fecha" type="text" class="form-control" value="<?php echo $row['fecha']; ?>" readonly>
                        <label for="fecha" class="active">Fecha</label>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="md-form md-outline">
                        <input id="clase" name="clase" type="text" class="form-control" value="<?php echo $row['Clase']; ?>" >
                        <label for="clase" class="active">Clase</label>
                    </div>
                </div>
                <br>
                
                <!-- Campos editables -->
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="unidad" class="form-label">Unidad</label>
                        <input id="unidad" name="unidad" type="text" class="form-control" value="<?php echo $row['Unidad']; ?>" required>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="md-form md-outline">
                        <input id="caracter" name="caracter_readonly" type="text" class="form-control" value="<?php echo $row['Caracter']; ?>" readonly>
                        <label for="caracter" class="active">Carácter</label>
                    </div>
                </div>
                <br>
                <div class="col-md-8 col-sm-8">
                    <div class="md-form md-outline">
                        <label for="caracter_update" class="active">Seleccionar Carácter de la Clase</label>
                        <div class="form-group d-flex justify-content-between">
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="caracter" id="TEORIA" value="TEORIA" <?php echo ($row['Caracter'] == 'TEORIA') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="TEORIA">TEORIA</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="caracter" id="PRACTICA" value="PRACTICA" <?php echo ($row['Caracter'] == 'PRACTICA') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="PRACTICA">PRACTICA</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="caracter" id="PARCIAL" value="PARCIAL" <?php echo ($row['Caracter'] == 'PARCIAL') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="PARCIAL">PARCIAL</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="caracter" id="RECUPERATORIO" value="RECUPERATORIO" <?php echo ($row['Caracter'] == 'RECUPERATORIO') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="RECUPERATORIO">RECUPERATORIO</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="caracter" id="OTROS" value="OTROS" <?php echo ($row['Caracter'] == 'OTROS') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="OTROS">OTROS</label>
                            </div>
                        </div>
                    </div>
                </div>
                    <br>
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="contenidos" class="form-label">Contenidos</label>
                        <textarea id="contenidos" name="contenidos" class="form-control-textarea" required><?php echo $row['Contenidos']; ?></textarea>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="actividad" class="form-label">Actividad</label>
                        <textarea id="actividad" name="actividad" class="form-control-textarea" required><?php echo $row['Actividad']; ?></textarea>
                    </div>
                </div>

                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control-textarea"><?php echo $row['Observaciones']; ?></textarea>
                    </div>
            
                <!-- Campo para Horas Dadas en el formulario -->
                <div class="col-md-8 col-sm-8">
                    <div class="form-group">
                        <label for="horas_dadas" class="form-label">Horas Dadas</label>
                        <input id="horas_dadas" name="horas_dadas" type="text" class="form-control" value="<?php echo htmlspecialchars($row['horas_dadas']); ?>" required>
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

                        <div class="col-md-8 col-sm-8">
                            <button type="submit" name="Actualizar" class="btn btn-primary">Actualizar</button>
                            <a href="Temario_cargar.php?id_Materia=<?php echo $id_Materia; ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>
