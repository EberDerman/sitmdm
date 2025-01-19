<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/conexion.php");
$id_estudiante = getIdUsuario(); // Se obtiene el ID del estudiante actual
$tipo_certificado = $_POST['tipoCertificado'];
$id_tecnicatura = $_POST['id_Tecnicatura']; // Nueva variable para diferenciar tecnicaturas

// Validación previa para evitar duplicados
$sql_check = "SELECT COUNT(*) as total 
              FROM certificados 
              WHERE id_estudiante = :id_estudiante 
              AND TipoCertificado = :tipo_certificado 
              AND id_Tecnicatura = :id_tecnicatura 
              AND idEstado = 1"; // Estado 1: Pendiente

$stmt_check = $conexiones->prepare($sql_check);
$stmt_check->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
$stmt_check->bindParam(':tipo_certificado', $tipo_certificado, PDO::PARAM_STR);
$stmt_check->bindParam(':id_tecnicatura', $id_tecnicatura, PDO::PARAM_INT);
$stmt_check->execute();
$result = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($result['total'] > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Ya has solicitado este tipo de certificado para esta tecnicatura.']);
    exit;
}

// Inserción si no existe duplicado
$sql_insert = "INSERT INTO certificados (id_estudiante, TipoCertificado, idEstado, FechaSolicitud, id_Tecnicatura) 
               VALUES (:id_estudiante, :tipo_certificado, 1, NOW(), :id_tecnicatura)";

$stmt_insert = $conexiones->prepare($sql_insert);
$stmt_insert->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
$stmt_insert->bindParam(':tipo_certificado', $tipo_certificado, PDO::PARAM_STR);
$stmt_insert->bindParam(':id_tecnicatura', $id_tecnicatura, PDO::PARAM_INT);

if ($stmt_insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Certificado solicitado con éxito.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al solicitar el certificado.']);
}
?>


