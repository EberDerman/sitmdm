<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Modificar Estudiantes Planillas</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <style>
        /* CSS para la página */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            color: #555;
            margin-bottom: 15px;
        }

        .form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 16px;
            color: #333;
            display: flex;
            align-items: center;
        }

        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .submit-button {
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            align-self: center;
            margin-top: 20px;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body class="hidden-sn mdb-skin" style="margin-top: 150px;">
    <?php include("precepMenuNav.php"); ?>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <div class="form-header bg-primary text-white text-center p-33 rounded-1">
                        <h3 class="font-weight-200"><i class="fas fa-user"></i> Modificar Planillas de Estudiantes <span
                                id="fechaTitulo"></span></h3>
                    </div>
                    <a class="btn btn-primary" href='precepPreinscripcionesVer.php?id_estudiante=<?= $_GET["id_estudiante"] ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= $_GET["nombreTec"] ?>&Ciclo=<?= $_GET["Ciclo"] ?>'>Volver</a>
                </div>

                <h3 class="subtitle">Estudiante: </h3>
                <input type="hidden" name="id_estudiante" value="<?php echo htmlspecialchars($id_estudiante); ?>">

                <form id="formulario" method="post" action="precepEntregaPlanillaGuardar.php?id_estudiante=<?php echo htmlspecialchars($_GET['id_estudiante']); ?>&id_Tecnicatura=<?php echo htmlspecialchars($_GET['id_Tecnicatura']); ?>">

                    <!-- Campos de planilla -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_dni" name="entrega_dni">
                            <label class="form-check-label" for="entrega_dni">DNI</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_partida" name="entrega_partida">
                            <label class="form-check-label" for="entrega_partida">Partida de nacimiento</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_fotos" name="entrega_fotos">
                            <label class="form-check-label" for="entrega_fotos">Fotos carnet (2)</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_titulo" name="entrega_titulo">
                            <label class="form-check-label" for="entrega_titulo">Fotocopia título nivel secundario</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_certificado" name="entrega_certificado">
                            <label class="form-check-label" for="entrega_certificado">Certificado médico de salud</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_inscripcion" name="entrega_inscripcion">
                            <label class="form-check-label" for="entrega_inscripcion">Planilla de inscripción</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="entrega_carpeta" name="entrega_carpeta">
                            <label class="form-check-label" for="entrega_carpeta">Carpeta y etiqueta</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                </form>

            </div>
        </div>
    </div>

    <?php include("../includes/pie.php"); ?>
</body>

</html>