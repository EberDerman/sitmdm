<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);




include("../sql/PersonaRepository.php");
include("../includes/encabezado.php");
include("./utils/constantes.php");
include("direcMenuNav.php");

if (isset($_GET["id_Persona"])) {
    $id_Persona = $_GET['id_Persona'];
} else {
    echo "<script>alert('No se encontro el ID de la persona.');</script>";
}

$personaRepository = new PersonaRepository();
$codRol = $personaRepository->getRolById($id_Persona);
$row = $personaRepository->getPersonaById($id_Persona);

if ($row) {
    $nombre = $row['nombre'] ?? null;
    $apellido = $row['apellido'] ?? null;
    $email = $row['email'] ?? null;
    $codRol = $row['codRol'] ?? null;
    $dni = $row['dni'] ?? null;
    $cuil = $row['cuil'] ?? null;
    $fecha_nacimiento = $row['fecha_nacimiento'] ?? null;
    $nacionalidad = $row['nacionalidad'] ?? null;
    $estado_civil = $row['estado_civil'] ?? null;
    $domicilio = $row['domicilio'] ?? null;
    $pais = $row['pais'] ?? null;
    $telefono_1 = $row['telefono_1'] ?? null;
    $telefono_2 = $row['telefono_2'] ?? null;
    $titulo = $row['titulo'] ?? null;
    $estado = $row['estado'] ?? null;
} else {
    // Si no se encuentra la persona
    echo "<script>alert('Persona no encontrada.');</script>";
    exit; // Salir si no se encuentra el ID
}

switch ($codRol) {
    case 5:
        $rolTitulo = "Docente";
        break;
    case 4:
        $rolTitulo = "Preceptor";
        break;
    default:
        $rolTitulo = "-";
}

?>

<title>SITMDM-Editar <?= $rolTitulo ?></title>
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("direcMenuNav.php"); ?>
    </div>

    <main>
        <div class="container">
            <div class="card text-center">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                    style="border-radius: 8px;">
                    <h4 class="mb-0">Editar Datos del <?= $rolTitulo ?></h4>
                    <div class="d-flex justify-content-center">
                        <a href="<?php
                        switch ($codRol) {
                            case 5:
                                echo "direcDoc.php";
                                break;
                            case 4:
                                echo "direcPrecep.php";
                                break;
                            default:
                                echo "inicioDirec.php"; // Opcional: manejar un caso por defecto
                        }
                        ?>" class="btn btn-primary">Volver</a>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <form method="POST" action="direcDocEditarDB.php" class="w-50">
                        <!-- Campo oculto para id_Persona -->
                        <input type="hidden" name="id_Persona" value="<?php echo $id_Persona; ?>">

                        <!-- Campo oculto para codRol -->
                        <input type="hidden" name="codRol" value="<?php echo $codRol; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">NOMBRE:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?php echo $nombre; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">APELLIDO:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                value="<?php echo $apellido; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">CORREO ELECTRÓNICO:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $email; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="celular" class="form-label">TELÉFONO:</label>
                            <input type="text" class="form-control" id="celular" name="celular"
                                value="<?php echo $telefono_1; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">TELÉFONO FIJO:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="<?php echo $telefono_2; ?>">
                        </div>
                        <div class="mb-3">
                            <fieldset class="d-flex justify-content-center">
                                <legend class="form-label h6">ESTADO CIVIL:</legend>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="Soltero"
                                        value="Soltero" <?php echo ($estado_civil == 'Soltero') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="Soltero">Soltero</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="Casado"
                                        value="Casado" <?php echo ($estado_civil == 'Casado') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="Casado">Casado</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="Viudo"
                                        value="Viudo" <?php echo ($estado_civil == 'Viudo') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="Viudo">Viudo</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estado_civil" id="Divorciado"
                                        value="Divorciado" <?php echo ($estado_civil == 'Divorciado') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="Divorciado">Divorciado</label>
                                </div>

                            </fieldset>
                        </div>
                        <div class="mb-3">
                            <label for="domicilio" class="form-label">DOMICILIO:</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio"
                                value="<?php echo $domicilio; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">TÍTULO:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo"
                                value="<?php echo $titulo; ?>" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="Actualizar">MODIFICAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>
</body>

</html>