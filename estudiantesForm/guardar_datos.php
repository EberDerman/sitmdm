<?php
include '../sql/conexion.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir todas las variables POST y manejarlas
    $id_Tecnicatura = $_POST['id_Tecnicatura'] ?? '';
    $dni_numero = $_POST['dni_numero'] ?? '';

    // Consulta para verificar si el estudiante ya está registrado en la tecnicatura
    $check_stmt = $conexion->prepare("SELECT 1 FROM estudiantes e 
                                      JOIN estudiante_tecnicatura et ON e.id_estudiante = et.id_estudiante
                                      WHERE e.dni_numero = ? AND et.id_Tecnicatura = ?");
    $check_stmt->bind_param('si', $dni_numero, $id_Tecnicatura);
    $check_stmt->execute();
    $check_stmt->store_result();

    // Verificar si ya existe un registro
    if ($check_stmt->num_rows > 0) {
        $message = "El estudiante con DNI $dni_numero ya se encuentra registrado en la tecnicatura.";
    } else {
        // Aquí continúa el resto del código para insertar el estudiante y asociarlo con la tecnicatura
        $numero_establecimiento = $_POST['numero_establecimiento'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $nombre = $_POST['nombre'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $email = $_POST['email'] ?? '';
        $posee_dni = $_POST['posee_dni'] ?? '';
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
        $torre = $_POST['piso'] ?? '';
        $departamento = $_POST['departamento'] ?? '';

        // Preparar la consulta para guardar al estudiante
        $stmt = $conexion->prepare("INSERT INTO estudiantes (numero_establecimiento, apellido, nombre, telefono, email, posee_dni, dni_numero, cuil, tiene_cpi, documento_extranjero, tipo_documento_extranjero, numero_documento_extranjero, identidad_genero, lugar_nacimiento, especificar_pais, provincia, ciudad, codigo_postal, calle, localidad, distrito, numero, piso, torre, departamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            $message = 'Error al preparar la consulta: ' . htmlspecialchars($conexion->error);
        } else {
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
                $torre,
                $departamento
            ];
            $types = str_repeat('s', count($values));
            $stmt->bind_param($types, ...$values);

            if ($stmt->execute()) {
                $insertedId = $conexion->insert_id;
                $message = "Datos guardados correctamente. ID del estudiante: " . $insertedId;

                // Insertar en estudiante_tecnicatura
                $stmt = $conexion->prepare("INSERT INTO estudiante_tecnicatura (id_estudiante, id_Tecnicatura) VALUES (?, ?)");
                $stmt->bind_param('ii', $insertedId, $id_Tecnicatura);
                if ($stmt->execute()) {
                    $message = "Datos guardados correctamente."/*  . $insertedId */ ;
                } else {
                    $message = "Error al guardar los datos: " . htmlspecialchars($stmt->error);
                }
                $stmt->close();
            } else {
                $message = "Error al guardar los datos: " . htmlspecialchars($stmt->error);
            }
        }
    }
    $check_stmt->close();
}
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
                    window.location.href = "https://isft135.edu.ar/"; // Redirige a la URL especificada
                }, 100);
            <?php endif; ?>
        };
    </script>

</head>

<body>
</body>

</html>