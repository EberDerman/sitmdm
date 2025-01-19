<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php';

// Obtener el valor de roll almacenado en la sesión
$roll = $_SESSION['codRol'] ?? null; // Si no existe, $roll será null
$id_preceptor = getIdUsuarioSeguridad(); // Asumiendo que esta función devuelve el id del preceptor

// Verificar si el roll es 3 o 4
if ($roll == 3 || $roll == 4) {
    // Llamar a la función checkAccess
    checkAccess([$roll], $id_preceptor);
    // Realizar otras acciones que desees, como la inserción que mencionas
} else {
    // Si no es 3 ni 4, destruir la sesión y redirigir al usuario al índice
    session_destroy();
    echo "<script>window.location.href = '../../index.php';</script>";
    exit(); // Detener la ejecución del script después de la redirección
}

$id = $_GET['id'];
$image = $_GET['image'];

// Usar PDO para consultar las imágenes actuales de la noticia
$sql = "SELECT images FROM news WHERE id = :id";
$stmt = $conexiones->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);
$images = explode(',', $news['images']);

// Remover la imagen seleccionada de la lista
$newImages = array_filter($images, function($img) use ($image) {
    return $img !== $image;
});

// Actualizar la base de datos
$imagesList = implode(',', $newImages);
$sqlUpdate = "UPDATE news SET images = :imagesList WHERE id = :id";
$stmtUpdate = $conexiones->prepare($sqlUpdate);
$stmtUpdate->bindParam(':imagesList', $imagesList);
$stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmtUpdate->execute()) {
    // Eliminar la imagen del servidor
    if (file_exists('../assets/uploads/' . $image)) {
        unlink('../assets/uploads/' . $image);
    }
    echo 'success';
} else {
    echo 'error';
}

$conexiones = null; // Cerrar la conexión
?>
