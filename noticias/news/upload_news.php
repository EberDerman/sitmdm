<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php'; // Se incluye la conexión desde el archivo conexion.php

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

// Datos recibidos del formulario
$title = $_POST['title'] ?? null;
$date = $_POST['date'] ?? null;
$content = $_POST['content'] ?? null;

if (!$title || !$date || !$content) {
    die("Faltan datos obligatorios.");
}

// Manejo de imágenes subidas
$uploadedImages = [];
$uploadDir = '../assets/uploads/';

foreach ($_FILES['images']['name'] as $key => $imageName) {
    $imageTmp = $_FILES['images']['tmp_name'][$key];
    $imagePath = $uploadDir . basename($imageName);
    if (move_uploaded_file($imageTmp, $imagePath)) {
        $uploadedImages[] = $imageName;
    }
}

$imagesList = implode(',', $uploadedImages);

// Insertar los datos en la base de datos
try {
    $stmt = $conexiones->prepare("INSERT INTO news (title, date, content, images) VALUES (:title, :date, :content, :images)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':images', $imagesList, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<script>window.location.href = '../public/index.php';</script>";
        exit();
    } else {
        echo "Error al insertar los datos.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
