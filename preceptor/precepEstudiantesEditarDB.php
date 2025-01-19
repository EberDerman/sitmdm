<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuario();
checkAccess([$id_preceptor, 4]);

include '../sql/conexion.php';
include("../sql/EstudiantesRepository.php");
include('../sql/PersonaRepository.php');

$personaRepository = new PersonaRepository();
$estudiantesRepository = new EstudiantesRepository();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir todas las variables POST y manejarlas
    $id_estudiante = $_POST['id_estudiante'] ?? ''; // Asumimos que el ID del estudiante se pasa desde el formulario
    $id_Tecnicatura = $_POST['id_Tecnicatura'] ?? '';
    $nombreTec = $_POST['nombreTec'] ?? '';
    $Ciclo = $_POST['Ciclo'] ?? '';

    $estudiante = $estudiantesRepository->getEstudianteById($id_estudiante);

    // Aquí se toman los valores de los campos del formulario para actualizar la información del estudiante
    $numero_establecimiento = $_POST['numero_establecimiento'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $posee_dni = $_POST['posee_dni'] ?? '';
    $dni_numero = $_POST['dni_numero'] ?? '';
    $cuil = $_POST['cuil'] ?? '';
    $tiene_cpi = isset($_POST['tiene_cpi']) ? 'SI' : 'NO';
    $documento_extranjero = $_POST['documento_extranjero'] ?? '';
    $tipo_documento_extranjero = $_POST['tipo_documento_extranjero'] ?? '';
    $numero_documento_extranjero = $_POST['numero_documento_extranjero'] ?? '';
    $identidad_genero = $_POST['identidad_genero'] ?? '';
    $lugar_nacimiento = $_POST['lugar_nacimiento'] ?? '';
    $especificar_pais = $_POST['especificar_pais'] ?? '';
    $provincia = $_POST['provincia'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';
    $codigo_postal = $_POST['codigo_postal'] ?? '';
    $calle = $_POST['calle'] ?? '';
    $localidad = $_POST['localidad'] ?? '';
    $distrito = $_POST['distrito'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $piso = $_POST['piso'] ?? '';
    $departamento = $_POST['departamento'] ?? '';

    // Preparar la consulta para actualizar los datos del estudiante
    $stmt = $conexion->prepare("UPDATE estudiantes SET 
        numero_establecimiento = ?, apellido = ?, nombre = ?, telefono = ?, email = ?, posee_dni = ?, dni_numero = ?, 
        cuil = ?, tiene_cpi = ?, documento_extranjero = ?, tipo_documento_extranjero = ?, numero_documento_extranjero = ?, 
        identidad_genero = ?, lugar_nacimiento = ?, especificar_pais = ?, provincia = ?, ciudad = ?, codigo_postal = ?, 
        calle = ?, localidad = ?, distrito = ?,numero = ?, piso = ?, departamento = ? WHERE id_estudiante = ?");

    if ($stmt === false) {
        $message = 'Error al preparar la consulta: ' . htmlspecialchars($conexion->error);
    } else {
        // Los valores que serán actualizados
        $values = [
            $numero_establecimiento,
            $apellido,
            $nombre,
            $telefono,
            $email,
            $posee_dni,
            $dni_numero,
            $cuil,
            $tiene_cpi,
            $documento_extranjero,
            $tipo_documento_extranjero,
            $numero_documento_extranjero,
            $identidad_genero,
            $lugar_nacimiento,
            $especificar_pais,
            $provincia,
            $ciudad,
            $codigo_postal,
            $calle,
            $localidad,
            $distrito,
            $numero,
            $piso,
            $departamento,
            $id_estudiante // ID del estudiante para hacer el UPDATE
        ];

        // El tipo de datos de los valores (todos son cadenas excepto el ID que es entero)
        $types = str_repeat('s', count($values) - 1) . 'i'; // Todos 's' excepto el último, que es 'i'

        // Enlazar los parámetros
        $stmt->bind_param($types, ...$values);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $message = "Datos actualizados correctamente.";
        } else {
            $message = "Error al actualizar los datos: " . htmlspecialchars($stmt->error);
        }
    }

    $stmt->close();
}

$personaRepository->updateEmail($estudiante['idUsuario'], $email);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <script>
        window.onload = function () {
            <?php if ($message): ?>
                alert("<?php echo addslashes($message); ?>");
                setTimeout(function () {
                    window.location.href = "precepEstudiantesVer.php?id_estudiante=<?= $id_estudiante ?>&id_Tecnicatura=<?= $id_Tecnicatura ?>&nombreTec=<?= $nombreTec ?>&Ciclo=<?= $Ciclo ?>"; // Redirige a la URL especificada
                }, 100);
            <?php endif; ?>
        };
    </script>

</head>

<body>
</body>

</html>