<?php
include("../includes/sesion.php");
include("../includes/encabezado.php");
include("../sql/conexion.php");

$idUsuario = getIdUsuario(); // Recupera el ID del usuario actual

// Consulta para obtener el DNI del estudiante a partir del ID de usuario
$sqlDni = "SELECT dni_numero FROM estudiantes WHERE idUsuario = ?";
$stmt = $conexiones->prepare($sqlDni);
$stmt->execute([$idUsuario]);
$dni = $stmt->fetchColumn(); // Obtiene el DNI del estudiante

// Verifica si se obtuvo el DNI del estudiante
if ($dni === false) {
    // Manejar el error si no se encuentra el estudiante
    echo "<script>
        alert('El usuario o la clave no son válidos');
        window.location.href = '../index.php';
    </script>";
    exit();
}

// Consulta para obtener las tecnicaturas asociadas al estudiante
$sqlTecnicaturas = "
    SELECT t.id_Tecnicatura, t.nombreTec 
    FROM tecnicaturas t 
    INNER JOIN estudiante_tecnicatura et ON t.id_Tecnicatura = et.id_Tecnicatura
    INNER JOIN estudiantes e ON e.id_estudiante = et.id_estudiante
    WHERE e.dni_numero = ?
";
$stmt = $conexiones->prepare($sqlTecnicaturas);
$stmt->execute([$dni]);
$tecnicaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si el estudiante tiene solo una tecnicatura, redirige automáticamente
if (count($tecnicaturas) === 1) {
    $_SESSION['id_tecnicatura'] = $tecnicaturas[0]['id_Tecnicatura'];
    echo "<script>window.location.href = 'inicioEstudiante.php';</script>";
    exit();
}

// Manejo del formulario enviado para seleccionar tecnicatura
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tecnicatura'])) {
    $_SESSION['id_tecnicatura'] = $_POST['tecnicatura'];
    echo "<script>window.location.href = 'inicioEstudiante.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="../assets/css/bootstrap.css">

<body class="hidden-sn mdb-skin">
    <style>
        img {
            max-width: 50%;
            max-height: 50%;
        }

        .container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card {
            min-height: 250px; /* Ajusta este valor según sea necesario */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
           }

        .card h4 {
            margin-bottom: auto; /* Espacio entre el título y el botón */
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px 0;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .icon-text {
            color: white;
            font-weight: bold;
            font-size: 20px;
            font-family: Arial, sans-serif;
        }
        body{background-color: #fff;}
    </style>

    <div class="container-fluid">
        <?php include("menuEstudiante.php"); ?>
    </div>

    <div class="container">
        <h2 class="text-center m-5">Selecciona tu Tecnicatura</h2>
        <div class="row" style="display: flex; justify-content: center;">
            <?php foreach ($tecnicaturas as $tecnicatura): ?>
                <div class="col-md-4">
                    <div class="card">
                        <h4 class="text-center pb-2 pt-2"><?php echo $tecnicatura['nombreTec']; ?></h4>

                        <!-- Círculo con color aleatorio -->
                        <?php
                        // Generar un color hexadecimal aleatorio
                        $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                        ?>
                        <div class="icon-circle mx-auto" style="background-color: <?php echo $randomColor; ?>;">
                            <span class="icon-text">T</span>
                        </div>

                        <form action="" method="POST">
                            <input type="hidden" name="tecnicatura" value="<?php echo $tecnicatura['id_Tecnicatura']; ?>">
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary">Acceder</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include("../includes/pie.php"); ?>
    <script src="../assets/js/inicializacionSidear.js"></script>
    <script src="../assets/js/charts.js"></script>
</body>

</html>
