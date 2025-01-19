<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);


include("../sql/conexion.php");
include("../includes/encabezado.php");

$idUsuario = $_SESSION['idUsuario']; // Asegúrate de que este valor proviene de la sesión activa.

// Consulta para obtener los datos necesarios
$sql = "
    SELECT 
        p.nombre, 
        p.apellido, 
        p.email, 
        r.nombreRol,
        p.dni,
        p.cuil, 
        p.fecha_nacimiento, 
        p.nacionalidad, 
        p.estado_civil, 
        p.domicilio, 
        p.pais, 
        p.telefono_1, 
        p.telefono_2, 
        p.titulo
    FROM personas p
    INNER JOIN usuarios u ON p.idUsuario = u.idUsuario
    INNER JOIN roles r ON p.codRol = r.codRol
    WHERE u.idUsuario = ?
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Asignamos los valores obtenidos a variables
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $email = $row['email'];
    $nombreRol = $row['nombreRol'];
    $dni = $row['dni'];
    $cuil = $row['cuil'];
    $fecha_nacimiento = $row['fecha_nacimiento'];
    $nacionalidad = $row['nacionalidad'];
    $estado_civil = $row['estado_civil'];
    $domicilio = $row['domicilio'];
    $pais = $row['pais'];
    $telefono_1 = $row['telefono_1'];
    $telefono_2 = $row['telefono_2'];
    $titulo = $row['titulo'];
} else {
    echo "<script>alert('No se encontraron datos para este usuario.'); window.location.href='inicioDoc.php';</script>";
    exit;
}

// Procesar el formulario si se envía
if (isset($_POST['Actualizar'])) {
    $email = $_POST['email'];
    $estado_civil = $_POST['estado_civil'];
    $domicilio = $_POST['domicilio'];
    $telefono_1 = $_POST['celular'];
    $telefono_2 = $_POST['telefono'];
    $titulo = $_POST['titulo'];

    // Actualizar los datos en la base de datos
    $sql_update = "
        UPDATE personas 
        SET email = ?, estado_civil = ?, domicilio = ?, telefono_1 = ?, telefono_2 = ?, titulo = ?
        WHERE idUsuario = ?
    ";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param('ssssssi', $email, $estado_civil, $domicilio, $telefono_1, $telefono_2, $titulo, $idUsuario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Datos actualizados correctamente.'); window.location.href = 'Datos_PersonalesDoc.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar los datos.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include 'docMenuNav.php' ?>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #2c3d66 !important;
            color: #fff;
            z-index: 1000;
        }

        .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #ddd;
        }

        .side-nav {

            background: #2c3d66;
            color: #fff;
        }

        .side-nav.open {
            transform: translateX(0);
        }

        .side-nav .collapsible .collapsible-accordion li a {
            color: #fff;
        }

        .side-nav .collapsible .collapsible-accordion li a:hover {
            background: #444;
        }

        .dropdown-menu {
            display: none;
        }

        .dropdown-menu.show {
            display: block;
        }

        .container-fluid {
            padding: 20px;
            margin-left: 0;
            flex-grow: 1;
        }

        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .btn-sm-custom {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .text-center {
            text-align: center;
        }

        .animated-title {
            animation: colorChange 5s infinite;
        }

        footer {
            background-color: #2c3d66;
            color: #fff;

        }
    </style>
</head>

<body>

    <!-- Main content -->
    <main>

        <div class="container-fluid">

            <div class="container">
                <h1 class="text-center animated-title">DATOS PERSONALES</h1>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="inputName" class="form-label">NOMBRE:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" disabled required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
                    </div>
                    <div class="mb-3">
                        <label for="inputName" class="form-label">APELLIDO:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" disabled required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
                    </div>
                    <div class="mb-3">
                    <label for="inputRol" class="form-label">ROL:</label>
                    <input type="text" class="form-control" id="nombreRol" name="nombreRol" value="<?php echo $nombreRol; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="inputDNI" class="form-label">DNI:</label>
                        <input id="dni" type="text" class="form-control" name="dni" value="<?php echo $dni; ?>" disabled required pattern="[0-9]{8}">
                    </div>
                    <div class="mb-3">
                        <label for="cuil" class="form-label">CUIT/CUIL:</label>
                        <input id="cuil" type="text" class="form-control" name="cuil" value="<?php echo $cuil; ?>" disabled />
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">* Fecha de nacimiento:</label>
                        <input type="text" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="pais" class="form-label">Extranjeros, especificar país:</label>
                        <input type="text" class="form-control" id="pais" name="pais" value="<?php echo $nacionalidad; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="nacionalidad" class="form-label">NACIONALIDAD</label>
                        <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad; ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">CORREO ELECTRONICO:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTelefono" class="form-label">TELEFONO:</label>
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $telefono_1; ?>" required title="Debe contener exactamente 10 dígitos numéricos">
                    </div>
                    <div class="mb-3">
                        <label for="inputTelefono" class="form-label">TELEFONO FIJO:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono_2; ?>" title="Debe contener exactamente 10 dígitos numéricos">
                    </div>
                    <div class="mb-3">
                        <label for="civil_update" class="form-label">Estado Civil:</label>
                        <input type="text" class="form-control" id="estado_civil" name="estado_civil" value="<?php echo $estado_civil; ?>" disabled>
                        <div class="form-group d-flex justify-content-between">
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="estado_civil" id="SOLTERO" value="SOLTERO" <?php echo ($row['estado_civil'] == 'SOLTERO') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="SOLTERO">SOLTERO</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="estado_civil" id="CASADO" value="CASADO" <?php echo ($row['estado_civil'] == 'CASADO') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="CASADO">CASADO</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="estado_civil" id="VIUDO" value="VIUDO" <?php echo ($row['estado_civil'] == 'VIUDO') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="VIUDO">VIUDO</label>
                            </div>
                            <div class="form-check form-check-inline mr-2">
                                <input class="form-check-input" type="radio" name="estado_civil" id="DIVORCIADO" value="DIVORCIADO" <?php echo ($row['estado_civil'] == 'DIVORCIADO') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="DIVORCIADO">DIVORCIADO</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDomicilio" class="form-label">Domicilio</label>
                        <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $domicilio; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputTitulo" class="form-label">TITULO:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="Actualizar">MODIFICAR</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='inicioDoc.php'">CANCELAR</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include '../includes/pie.php' ?>
</body>

</html>