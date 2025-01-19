<?php
include ('../../includes/sesion.php');
include '../../sql/conexion.php';
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

?>


<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/css/shepherd.css">
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@8.1.0/dist/js/shepherd.min.js"></script>
</head>

<body>
    <?php

    include '../public/noticiasNav.php';
    ?>

    <div class="container my-4" style="padding-top: 80px;">
        <h1 class="mb-4">Agregar Noticia</h1>
        <form action="upload_news.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Contenido</label>
                <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Imágenes (hasta 5)</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Noticia</button>
        </form>
    </div>

   

    <script>
        // Establecer la fecha actual en el campo de fecha
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        });
    </script>

   


<?php include '../public/footerNoticias.php'?>

</body>

</html>