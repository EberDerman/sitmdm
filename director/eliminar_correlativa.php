<?php

include("../sql/conexion.php");

// Verificar si se recibió el idCorrelativa por POST
if (isset($_POST['idCorrelativa'])) {
    $idCorrelativa = $_POST['idCorrelativa'];

    // Consulta para eliminar la correlativa usando el campo correcto (idCorrelativas)
    $sql = "DELETE FROM correlativas WHERE idCorrelativas = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $idCorrelativa);

    if ($stmt->execute()) {
        echo "Correlativa eliminada correctamente.";
    } else {
        echo "Error al intentar eliminar la correlativa.";
    }

    $stmt->close();
} else {
    echo "No se recibió el identificador de correlativa.";
}
?>
