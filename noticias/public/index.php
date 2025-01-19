<?php
include '../../includes/sesion.php';
include '../../sql/conexion.php';
include './encabezadoNoticias.php';

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

// Consulta PDO para obtener las noticias
try {
    $stmt = $conexiones->prepare("SELECT * FROM news ORDER BY date DESC");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener las noticias: " . $e->getMessage();
    exit();
}

?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/css/shepherd.css">
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/js/shepherd.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
include './noticiasNav.php';
?>

<main style="padding-top: 90px;">

    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container text-center">
            <h1>Crear Noticias</h1>
        </div>
    </header>

    <!-- Sección de noticias -->
    <div class="container my-5">
        <div class="row">
            
            <?php foreach ($result as $news): ?>
                <div class="col-md-4 mb-4 cardTour">
                    <div class="card h-100" style="background-color: var(--color-primary); border: solid 2px white;">
                        <?php
                        $images = explode(',', $news['images']);
                        if (!empty($images[0])): ?>
                            <div id="carousel<?php echo $news['id']; ?>" class="carousel slide">
                                <div class="carousel-inner">
                                    <?php foreach ($images as $index => $image): ?>
                                        <?php if (!empty($image)): ?>
                                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                                <img src="../assets/uploads/<?php echo htmlspecialchars($image); ?>" class="d-block w-100" alt="Imagen noticia" style="max-height: 50vh;">
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title"><?php echo htmlspecialchars($news['title']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo date('d/m/Y', strtotime($news['date'])); ?></h6>
                            </div>

                            <!-- Contenedor para el contenido de la noticia -->
                            <p class="card-text" id="content-<?php echo $news['id']; ?>">
                                <?php echo nl2br(htmlspecialchars(substr($news['content'], 0, 200))) . '...'; ?>
                            </p>
                            <a href="javascript:void(0);" id="btn-readmore-<?php echo $news['id']; ?>" class="btn btn-primary leerMas" onclick="showFullText(<?php echo $news['id']; ?>)">Leer más</a>
                            <a href="javascript:void(0);" id="btn-close-<?php echo $news['id']; ?>" class="btn btn-danger" style="display:none;" onclick="showSummary(<?php echo $news['id']; ?>)">Cerrar</a>
                            <a href="../news/update_news.php?id=<?php echo $news['id']; ?>" class="btn btn-warning editar">Editar</a>
                            <a href="../news/delete_news.php?id=<?php echo $news['id']; ?>" class="btn btn-danger borrar" onclick="return confirm('¿Estás seguro de que quieres eliminar esta noticia?');">Borrar</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Cerrar conexión -->
    <?php
    // No es necesario cerrar la conexión PDO, ya que PDO se cierra automáticamente cuando se destruye el objeto.
    ?>

</main>

<?php
include './footerNoticias.php';
?>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para mostrar y ocultar texto completo de la noticia -->
<script>
    function showFullText(id) {
        const contentElement = document.getElementById(`content-${id}`);
        const btnReadMore = document.getElementById(`btn-readmore-${id}`);
        const btnClose = document.getElementById(`btn-close-${id}`);

        fetchFullText(id)
            .then(fullContent => {
                contentElement.innerHTML = fullContent; // Mostrar el contenido completo
                btnReadMore.style.display = 'none'; // Ocultar el botón "Leer más"
                btnClose.style.display = 'inline-block'; // Mostrar el botón "Cerrar"
            })
            .catch(error => {
                console.error('Error al cargar el texto completo:', error);
            });
    }

    function showSummary(id) {
        const contentElement = document.getElementById(`content-${id}`);
        const btnReadMore = document.getElementById(`btn-readmore-${id}`);
        const btnClose = document.getElementById(`btn-close-${id}`);

        fetchSummaryText(id)
            .then(summaryContent => {
                contentElement.innerHTML = summaryContent; // Mostrar solo el resumen
                btnReadMore.style.display = 'inline-block'; // Mostrar el botón "Leer más"
                btnClose.style.display = 'none'; // Ocultar el botón "Cerrar"
            })
            .catch(error => {
                console.error('Error al cargar el resumen:', error);
            });
    }

    function fetchFullText(id) {
        return new Promise((resolve, reject) => {
            switch (id) {
                <?php
                foreach ($result as $news) {
                    $fullContent = json_encode(nl2br(htmlspecialchars($news['content'])));
                    echo "case {$news['id']}:
                                resolve($fullContent);
                                break;\n";
                }
                ?>
                default:
                    reject('Noticia no encontrada');
            }
        });
    }

    function fetchSummaryText(id) {
        return new Promise((resolve, reject) => {
            switch (id) {
                <?php
                foreach ($result as $news) {
                    $summaryContent = json_encode(nl2br(htmlspecialchars(substr($news['content'], 0, 200))) . '...');
                    echo "case {$news['id']}:
                                resolve($summaryContent);
                                break;\n";
                }
                ?>
                default:
                    reject('Noticia no encontrada');
            }
        });
    }
</script>

<!-- Bootstrap JS Bundle (que incluye Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
