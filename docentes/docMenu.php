<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>sitmdm</title>
    <style>
        .custom-img {
            width: 100%; /* Ocupa todo el ancho de la tarjeta */
            height: auto; /* Mantiene la proporción de la imagen */
        }
        .card-title {
            font-size: 1rem; /* Reduce el tamaño del texto del título */
        }
        .card-text {
            font-size: 0.875rem; /* Reduce el tamaño del texto del cuerpo */
        }
        .card {
            width: 20rem; /* Ajusta el ancho de la tarjeta */
            border-radius: 15px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra opcional */
        }
        .btn {
            border-radius: 25px; /* Botones redondeados */
        }
        .welcome-card {
            border-radius: 15px; /* Bordes redondeados para la tarjeta de bienvenida */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra opcional */
            background-color: #f9f9f9; /* Fondo claro */
            width: 100%; /* Tarjeta alargada, ocupa el ancho completo del contenedor */
            max-width: 800px; /* Máximo ancho de la tarjeta para controlarla */
            margin: 0 auto; /* Centra la tarjeta */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Sección de Bienvenida y Botones dentro de una tarjeta alargada -->
        <div class="card p-4 text-center mb-4 welcome-card">
            <div>
                <h3>Bienvenido <?php echo $_SESSION['usuario']; ?></h3>
            </div>
            <div class="my-4">
                
                <a href="MisCursos.php"><button class="btn btn-primary mx-2">Mis cursos</button></a>
                <a href="Datos_PersonalesDoc.php"><button class="btn btn-primary mx-2">Datos personales</button></a>
            </div>
        </div>
       
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
