<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);



include("../includes/encabezado.php");
include("../sql/PersonaRepository.php");

$personaRepository = new PersonaRepository();
$existePersonaDni = $personaRepository->getPersonaByDni($_POST['dni']);
$existePersonaEmail = $personaRepository->getPersonaByEmail($_POST['email']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITMDM-Guardar persona</title>
    <style>
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 1.1rem;
        }

        .alert-warning span {
            font-weight: bold;
        }

        .btn-back {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }

        .container-fluid {
            padding: 15px;
        }

        .form-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .card-header {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("direcMenuNav.php"); ?>
    </div>

    <main>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-body">
                    <?php if (!$existePersonaDni && !$existePersonaEmail) { ?>
                        <div class="form-header text-center">
                            <h3 class="font-weight-200" style="margin: 0;"><i class="fas fa-user"></i> Se creará el
                                siguiente registro:</h3>
                        </div>
                        <form id="formulario" method="post" action="formulario_persona/formulario_guardar_datosDB.php">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8">
                                    <div class="border mb-3 p-3">
                                        <?php
                                        $fields = [
                                            'email' => 'Usuario / email',
                                            'contrasenia' => 'Contraseña',
                                            'rol' => 'Rol',
                                            'apellido' => 'Apellido',
                                            'nombre' => 'Nombre',
                                            'celular' => 'Celular',
                                            'telefono' => 'Telefono',
                                            'fecha_nacimiento' => 'Fecha de nacimiento',
                                            'dni' => 'DNI',
                                            'cuil' => 'CUIT/CUIL',
                                            'estado_civil' => 'Estado Civil',
                                            'domicilio' => 'Domicilio / Localidad',
                                            'nacionalidad' => 'Nacionalidad',
                                            'pais' => 'Extranjeros, especificar país',
                                            'titulo' => 'Título'
                                        ];
                                        foreach ($fields as $key => $label) {
                                            $value = $_POST[$key] ?? '';
                                            if ($key === 'contrasenia') {
                                                // Asignar el DNI como valor de la contraseña
                                                $value = $_POST['dni'] ?? '';
                                                echo "<div class='mb-3'>
                                                        <label for='$key'>$label:</label>
                                                        <input type='password' class='form-control' id='$key' name='$key' value='$value' readonly>
                                                        <button type='button' id='togglePasswordButton' onclick='togglePassword()'>Ver contraseña</button>
                                                      </div>";
                                            } else {
                                                echo "<div class='mb-3'>
                                                        <label for='$key'>$label:</label>
                                                        <input type='text' class='form-control' id='$key' name='$key' value='$value' readonly>
                                                      </div>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">CONFIRMAR</button>
                        </form>
                        <button class="btn btn-primary" onclick="history.back()">VOLVER</button>
                    <?php } else { ?>
                        <div class="alert-warning">
                            <span>Usuario con
                                <?php echo $existePersonaEmail ? "email " : ""; ?>
                                <?php echo $existePersonaDni ? "dni " : ""; ?>
                                existente
                            </span>
                        </div>
                        <div class="text-center">
                            <button class="btn-back" onclick="history.back()">VOLVER</button>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('contrasenia');
            const toggleButton = document.getElementById('togglePasswordButton');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.innerText = 'Ocultar contraseña';
            } else {
                passwordField.type = 'password';
                toggleButton.innerText = 'Ver contraseña';
            }
        }
    </script>
</body>

</html>