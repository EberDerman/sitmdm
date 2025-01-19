<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include("precepMenuNav.php");

// ID del estudiante que deseas consultar (puede ser dinámico)
$id_estudiante = $_GET['id_estudiante']; // Cambiar a la variable adecuada o recibir como parámetro


// Consulta SQL para obtener los datos del estudiante
$sql = "
    SELECT 
        e.nombre, 
        e.apellido, 
        e.dni_numero, 
        e.email, 
        u.usuario, 
        u.contrasenia
    FROM 
        estudiantes e
    INNER JOIN 
        usuarios u 
    ON 
        e.idUsuario = u.idUsuario
    WHERE 
        e.id_estudiante = ?";

$stmt = $conexion->prepare($sql);

// Verificar si la consulta fue preparada correctamente
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

// Vincular el parámetro y ejecutar la consulta
$stmt->bind_param("i", $id_estudiante); // 'i' indica que el parámetro es un entero
$stmt->execute();

// Vincular los resultados a variables
$stmt->bind_result($nombre, $apellido, $dni, $email, $usuario, $contrasenia);


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

<title>Usuario Creado</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>

        <div class="container card text-center my-3 px-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                style="border-radius: 8px;">
                <h4 class="mb-0"><b>Usuario Creado</b></h4>
                <div>
                    <button class="btn btn-primary"
                        onclick="window.location.href='precepEstudiantes.php'">VOLVER</button>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title">¡El usuario ha sido creado con éxito!</h5>

                <div class="form-group">
                    <label for="nombreCompleto"><b>Nombre y Apellido</b></label>
                    <p id="nombreCompleto"><?php echo $nombre . " " . $apellido; ?></p>
                </div>

                <div class="form-group">
                    <label for="usuario"><b>Usuario</b></label>
                    <p id="usuario"><?php echo $usuario; ?></p>
                </div>

                <div class="form-group">
                    <label for="password"><b>Contraseña</b></label>
                    <p id="password"><?php echo $contrasenia; ?></p>
                </div>

            </div>
        </div>

    </main>
    <?php include("../includes/pie.php"); ?>

</body>

</html>
