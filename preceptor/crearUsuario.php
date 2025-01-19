<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include("precepMenuNav.php");

// Verificar si se reciben id_estudiante e id_Tecnicatura por GET
if (isset($_GET['id_estudiante']) && is_numeric($_GET['id_estudiante']) &&
    isset($_GET['id_Tecnicatura']) && is_numeric($_GET['id_Tecnicatura'])) {
    $id_estudiante = intval($_GET['id_estudiante']);
    $id_Tecnicatura = intval($_GET['id_Tecnicatura']);
} else {
    die("ID de estudiante o tecnicatura no válido o no proporcionado.");
}

// Consulta SQL para obtener los datos del estudiante
$sql = "SELECT nombre, apellido, dni_numero, email FROM estudiantes WHERE id_estudiante = ?";
$stmt = $conexion->prepare($sql);

// Vincular el parámetro y ejecutar la consulta
$stmt->bind_param("i", $id_estudiante); // 'i' indica que el parámetro es un entero
$stmt->execute();

// Obtener el resultado
$stmt->bind_result($nombre, $apellido, $dni, $email);

// Almacenar los valores sin mostrarlos
if ($stmt->fetch()) {
    // Los valores ya se han almacenado en las variables, no se muestran
} else {
    echo "No se encontró el estudiante.";
}

// Cerrar la declaración y la conexión
$stmt->close();
$conexion->close();

?>

<title>Crear Usuario</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>

        <div class="container card text-center my-3 px-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                style="border-radius: 8px;">
                <h4 class="mb-0"><b>Crear Usuario</b></h4>
            </div>

            <div class="card-body">
                <form action="procesarUsuario.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $id_Tecnicatura ?>" method="POST">
                    <div class="form-group">
                        <label for="alumno">Alumno: <?php echo $nombre . " " . $apellido; ?></label>
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" 
                               placeholder="Elige un nombre de usuario" required value="<?php echo $email; ?>">
                    </div>

                   
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="text" class="form-control" id="password" name="password" 
                               placeholder="Elige una contraseña" required value="<?php echo $dni; ?>">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirmar Contraseña</label>
                        <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" 
                               placeholder="Confirma tu contraseña" required value="<?php echo $dni; ?>">
                    </div>


                    <button type="submit" class="btn btn-success">Crear Usuario</button>
                </form>
            </div>
        </div>

    </main>
    <?php include("../includes/pie.php"); ?>

</body>

</html>
