<?php
include '../../sql/conexion.php';


// Validar conexión (opcional)
if ($mysqli->connect_errno) {
    die(json_encode(['success' => false, 'error' => $mysqli->connect_error]));
}

$id_Tecnicatura = $_GET['id_Tecnicatura'];

// Consultar todas las fechas ocupadas para la tecnicatura
$sql = "SELECT fecha1, fecha2 FROM fechas_materias WHERE id_Tecnicatura = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id_Tecnicatura);
$stmt->execute();
$result = $stmt->get_result();

$fechas = [];
while ($row = $result->fetch_assoc()) {
    if ($row['fecha1']) $fechas[] = $row['fecha1'];
    if ($row['fecha2']) $fechas[] = $row['fecha2'];
}

$stmt->close();
$mysqli->close();

echo json_encode(['success' => true, 'fechas' => $fechas]);
?>