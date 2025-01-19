<?php
include("../includes/sesion.php");
$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante

// archivo solicitar_certificado.php
include("../sql/conexion.php"); // Incluye el archivo de conexión

// Recoger datos del request 
$tipoCertificado = $_POST['tipoCertificado'];
$fechaSolicitud = date('Y-m-d');

$id_Tecnicatura = getIdTecnicatura();
$id_usuario = getIdUsuario();


$sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
$stmt_estudiante = $conexion->prepare($sql_estudiante);
$stmt_estudiante->bind_param("i", $id_usuario);
$stmt_estudiante->execute();
$stmt_estudiante->bind_result($id_estudiante);
$stmt_estudiante->fetch();
$stmt_estudiante->close();


// Preparar la consulta SQL
$sql = "INSERT INTO certificados (id_estudiante, FechaSolicitud, TipoCertificado, idEstado, id_Tecnicatura) VALUES (?, ?, ?, 1, ?)";

if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param('issi', $id_estudiante, $fechaSolicitud, $tipoCertificado, $id_Tecnicatura);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => $mysqli->error]);
}

// Cerrar la conexión
$mysqli->close();
?>
