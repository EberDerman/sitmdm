<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php'; // Incluir la conexión PDO
include '../public/encabezadoNoticias.php';

// Obtener el valor de rol almacenado en la sesión
$roll = $_SESSION['codRol'] ?? null; // Si no existe, $roll será null
$id_preceptor = getIdUsuarioSeguridad(); // Asumiendo que esta función devuelve el id del preceptor

// Verificar si el rol es 3 o 4
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

$id = $_GET['id'] ?? null; // Asegurarse de que el id esté presente

// Verificar si el id es válido
if ($id) {
    try {
        // Preparar la consulta con PDO
        $stmt = $conexiones->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $news = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si se encontró la noticia
        if (!$news) {
            echo "Noticia no encontrada.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al obtener la noticia: " . $e->getMessage();
        exit();
    }
}
?>
<?php include '../includes/navbar.php'; ?>

<body>
    <div class="container my-4">
        <h1 class="mb-4"><?php echo htmlspecialchars($news['title']); ?></h1>
        <div id="carousel<?php echo $news['id']; ?>" class="carousel slide">
            <div class="carousel-inner">
                <?php
                $images = explode(',', $news['images']);
                foreach ($images as $index => $image):
                    if (!empty($image)): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="../assets/uploads/<?php echo htmlspecialchars($image); ?>" class="d-block w-25" alt="Imagen noticia">
                        </div>
                <?php endif;
                endforeach;
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $news['id']; ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $news['id']; ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <p class="mt-4"><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
        <a href="update_news.php?id=<?php echo $news['id']; ?>" class="btn btn-warning" onclick="return confirm('¿Estás seguro de que quieres actualizar esta noticia?');">Editar</a>
        <a href="delete_news.php?id=<?php echo $news['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar esta noticia?');">Borrar</a>
    </div>
    <?php include "../includes/footer.php" ?>
</body>

</html>
