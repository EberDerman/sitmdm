<head>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        
        <header class="bg-dark py-3 text-white" style="margin-top: -120px;">
            <div class="container text-center">
                <h1>Últimas Noticias</h1>
            </div>
        </header>
        
        <?php
        // Incluir el archivo de conexión
        include("../sql/conexion.php");

        // Obtener todas las noticias ordenadas por fecha
        $result = $conexion->query("SELECT * FROM news ORDER BY date DESC");
        ?>

        <div class="container my-4">
            <div class="row">
                <?php while ($news = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="2000">
                        <div class="card h-100" style="background-color: var(--color--secunday); border: solid 2px #fff;">
                            <?php
                            $images = explode(',', $news['images']);
                            if (!empty($images[0])): ?>
                                <div class="carousel slide" id="carousel<?php echo $news['id']; ?>">
                                    <div class="carousel-inner">
                                        <?php foreach ($images as $index => $image): ?>
                                            <?php if (!empty($image)): ?>
                                                <div class="carousel-item<?php echo $index === 0 ? ' active' : ''; ?>">
                                                    <img alt="Imagen noticia" class="d-block w-100" src="../noticias/assets/uploads/<?php echo htmlspecialchars($image); ?>" style="max-height: 50vh;">
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carousel<?php echo $news['id']; ?>" type="button">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carousel<?php echo $news['id']; ?>" type="button">
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
                                <p class="card-text" id="content-<?php echo $news['id']; ?>"><?php echo nl2br(htmlspecialchars(substr($news['content'], 0, 150))) . '...'; ?></p>
                                <a class="btn btn-primary" href="javascript:void(0);" id="btn-readmore-<?php echo $news['id']; ?>" onclick="showFullText(<?php echo $news['id']; ?>)">Leer más</a>
                                <a class="btn btn-danger" href="javascript:void(0);" id="btn-close-<?php echo $news['id']; ?>" onclick="showSummary(<?php echo $news['id']; ?>)" style="display: none;">Cerrar</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        
        <?php
        // Cerrar la conexión
        $conexion->close();
        ?>
    </main>
  
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
                // Aquí se puede cambiar para hacer una llamada AJAX si el contenido es muy largo
                switch (id) {
                    <?php
                    // Generar un caso por cada noticia
                    $result->data_seek(0); // Volver al primer resultado
                    while ($news = $result->fetch_assoc()) {
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
                    // Generar un caso por cada noticia con resumen
                    $result->data_seek(0); // Volver al primer resultado
                    while ($news = $result->fetch_assoc()) {
                        $summaryContent = json_encode(nl2br(htmlspecialchars(substr($news['content'], 0, 150))) . '...');
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
