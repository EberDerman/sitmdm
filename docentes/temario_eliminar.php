<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);
// Incluir la conexión a la base de datos
include("../sql/conexion.php");

// Verificar si se han recibido los parámetros ID e ID_Materia a través de la solicitud GET
if (isset($_GET['id']) && isset($_GET['id_Materia'])) {
    $id = intval($_GET['id']); // Convertir el ID a un entero
    $id_Materia = intval($_GET['id_Materia']); 

    // Preparar la consulta para eliminar el registro
    $sql = "DELETE FROM temario WHERE id_temario = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conexion->error));
    }

    $stmt->bind_param('i', $id); // 'i' indica que el parámetro es un entero

    // Ejecutar la consulta y verificar si se eliminó correctamente
    if ($stmt->execute()) {
        // Redirigir a la página deseada con el ID_Materia
        header("Location: Temario_cargar.php?id_Materia=" . $id_Materia);
        exit; // Terminar el script para asegurarte de que no se ejecute código adicional
    } else {
        echo "Error al eliminar el registro: " . htmlspecialchars($stmt->error);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "Parámetros ID o ID_Materia no recibidos.";
}

// Cerrar la conexión
$conexion->close();
?>
