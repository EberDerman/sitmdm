<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php'; // Incluir la conexión

//include '../../sql/conexion.php';
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

$id = $_GET['id'];

// Usar PDO para la consulta
$stmt = $conexiones->prepare("SELECT * FROM news WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/css/shepherd.css">
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/js/shepherd.min.js"></script>
</head>

<body>
    <?php
    include '../public/noticiasNav.php';
    ?>

    <div class="container my-4" style="padding-top: 100px;">
        <h1 class="mb-4">Editar Noticia</h1>
        <form action="update_news_action.php" method="post" enctype="multipart/form-data" id="editForm">
            <input type="hidden" name="id" value="<?php echo $news['id']; ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $news['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $news['date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenido</label>
                <textarea class="form-control" id="content" name="content" rows="4" required><?php echo $news['content']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Imágenes (dejar en blanco para mantener las actuales)</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>

                <div id="images-container">
                    <?php
                    $images = explode(',', $news['images']);
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            echo '<div class="image-container mt-2" id="image_' . $image . '">';
                            echo '<img src="../assets/uploads/' . $image . '" alt="Imagen noticia" class="img-thumbnail" style="max-width: 200px;">';
                            echo '<button type="button" class="btn btn-danger btn-sm mt-2 delete-image" data-image="' . $image . '">Eliminar</button>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" id="updateButton">Actualizar Noticia</button>
                <button type="button" class="btn btn-secondary" id="cancelButton">Cancelar</button>
            </div>
        </form>
    </div>

    <script>
        // Eliminar imagen usando event delegation
        document.getElementById('images-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-image')) {
                var imageName = event.target.getAttribute('data-image');
                if (confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
                    // Hacer una petición para eliminar la imagen
                    fetch('delete_image.php?id=<?php echo $news['id']; ?>&image=' + imageName)
                        .then(response => response.text())
                        .then(data => {
                            if (data === 'success') {
                                // Remover la imagen del DOM si se eliminó correctamente
                                document.getElementById('image_' + imageName).remove();
                            } else {
                                alert('No se pudo eliminar la imagen. Inténtalo de nuevo.');
                            }
                        });
                }
            }
        });

        // Confirmación antes de actualizar
        document.getElementById('updateButton').addEventListener('click', function(event) {
            if (!confirm('¿Estás seguro de que quieres actualizar esta noticia?')) {
                event.preventDefault();
            }
        });

        // Redirigir al hacer clic en Cancelar
        document.getElementById('cancelButton').addEventListener('click', function() {
            window.location.href = '../public/index.php';
        });
    </script>
    <?php include '../public/footerNoticias.php' ?>
</body>

</html>
