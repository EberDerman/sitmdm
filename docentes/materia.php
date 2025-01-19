<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../sql/conexion.php");

// Verificar si se recibió el ID
if (isset($_GET['id'])) {
    $id_Temario = $_GET['id'];

    // Eliminar el registro de la base de datos
    $sql = "DELETE FROM temario WHERE id_temario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_Temario);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página principal
        header("Location: Temario_cargar.php");
        exit();
    } else {
        echo "Error al eliminar el registro.";
    }
} else {
    echo "ID no proporcionado.";
}
?>
