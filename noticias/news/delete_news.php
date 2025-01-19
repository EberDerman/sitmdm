<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php'; // Ya tenemos la conexión aquí, no es necesario duplicarla

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

// Verifica si se ha proporcionado un ID para la noticia
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $news_id = intval($_GET['id']);

    // Obtén la lista de imágenes asociadas a la noticia usando la conexión centralizada
    $stmt = $conexion->prepare("SELECT images FROM news WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $news = $result->fetch_assoc();

    if ($news) {
        // Elimina la noticia de la base de datos
        $stmt = $conexion->prepare("DELETE FROM news WHERE id = ?");
        $stmt->bind_param("i", $news_id);
        $stmt->execute();

        // Obtén la lista de imágenes
        $images = explode(',', $news['images']);
        foreach ($images as $image) {
            $imagePath = "../assets/uploads/" . $image;
            // Verifica si el archivo existe y elimínalo
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Redirige al usuario con un mensaje de éxito
        header("Location: ../public/index.php?message=noticia_eliminada");
        exit();
    } else {
        echo "No se encontró la noticia.";
    }
} else {
    echo "ID de noticia no proporcionado.";
}
?>
