<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php'; // Conexión de PDO
include '../public/encabezadoNoticias.php';

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

$id = $_POST['id'];
$title = $_POST['title'];
$date = $_POST['date'];
$content = $_POST['content'];

// Manejo de imágenes
$uploadedImages = [];
$uploadDir = '../assets/uploads/';

// Obtener imágenes actuales
$query = "SELECT images FROM news WHERE id = :id";
$stmt = $conexiones->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);
$currentImages = explode(',', $news['images']);

// Subir nuevas imágenes
foreach ($_FILES['images']['name'] as $key => $imageName) {
    if (!empty($imageName)) {
        $imageTmp = $_FILES['images']['tmp_name'][$key];
        $uniqueImageName = time() . '_' . basename($imageName); // Asegurarse de que los nombres de archivo sean únicos
        $imagePath = $uploadDir . $uniqueImageName;

        // Mover el archivo a la carpeta de uploads
        if (move_uploaded_file($imageTmp, $imagePath)) {
            $uploadedImages[] = $uniqueImageName; // Guardar el nombre de la nueva imagen
        }
    }
}

// Si no hay nuevas imágenes cargadas, mantenemos las actuales
if (empty($uploadedImages)) {
    $allImages = $currentImages;
} else {
    // Combinar imágenes actuales con las nuevas
    $allImages = array_merge($currentImages, $uploadedImages);
}

// Filtrar cualquier imagen vacía o eliminada
$allImages = array_filter($allImages);

// Actualizar lista de imágenes en la base de datos
$imagesList = implode(',', $allImages);

// Actualizar la noticia en la base de datos
$sql = "UPDATE news SET title = :title, date = :date, content = :content, images = :images WHERE id = :id";
$stmt = $conexiones->prepare($sql);
$stmt->bindParam(':title', $title, PDO::PARAM_STR);
$stmt->bindParam(':date', $date, PDO::PARAM_STR);
$stmt->bindParam(':content', $content, PDO::PARAM_STR);
$stmt->bindParam(':images', $imagesList, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmt->execute()) {
    echo "<script>window.location.href = '../public/index.php';</script>";
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}
?>
