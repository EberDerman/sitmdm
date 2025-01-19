<?php

include("../../sql/PersonaRepository.php");
include("../utils/constantes.php");


$personaRepository = new PersonaRepository();


function sanitize_input($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}


function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $apellido = isset($_POST['apellido']) ? sanitize_input($_POST['apellido']) : '';
    $nombre = isset($_POST['nombre']) ? sanitize_input($_POST['nombre']) : '';
    $codRol = isset($_POST['rol']) ? constantes::obtenerCodigo(sanitize_input($_POST['rol'])) : '';
    $telefono_1 = isset($_POST['celular']) ? sanitize_input($_POST['celular']) : '';
    $telefono_2 = isset($_POST['telefono']) ? sanitize_input($_POST['telefono']) : '';
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? sanitize_input($_POST['fecha_nacimiento']) : '';
    $dni = isset($_POST['dni']) ? sanitize_input($_POST['dni']) : '';
    $cuil = isset($_POST['cuil']) ? sanitize_input($_POST['cuil']) : '';
    $estado_civil = isset($_POST['estado_civil']) ? sanitize_input($_POST['estado_civil']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $nacionalidad = isset($_POST['nacionalidad']) ? sanitize_input($_POST['nacionalidad']) : '';
    $domicilio = isset($_POST['domicilio']) ? sanitize_input($_POST['domicilio']) : '';
    $pais = isset($_POST['pais']) ? sanitize_input($_POST['pais']) : '';
    $titulo = isset($_POST['titulo']) ? sanitize_input($_POST['titulo']) : '';
    $usuario = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $contrasenia = isset($_POST['contrasenia']) ? sanitize_input($_POST['contrasenia']) : '';


    if (!validate_email($email)) {
        $errors[] = 'Invalid email format.';
    }


    if ($fecha_nacimiento) {
        $fecha_nacimiento = date('Y-m-d', strtotime($fecha_nacimiento));
        if ($fecha_nacimiento == false) {
            $errors[] = 'Invalid date format.';
        }
    }


    if (empty($contrasenia)) {
        $errors[] = 'Password cannot be empty.';
    }


    if (empty($errors)) {
        try {

            // $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT); FUNCION PARA ENCRIPTAR (SIN USO ACTUAL)


            $idUsuarioInsertado = $personaRepository->saveUsuario($usuario, $contrasenia, $codRol);
            $idPersonaInsertada = $personaRepository->savePersona(
                $idUsuarioInsertado,
                $apellido,
                $nombre,
                $codRol,
                $telefono_1,
                $telefono_2,
                $fecha_nacimiento,
                $dni,
                $cuil,
                $estado_civil,
                $email,
                $nacionalidad,
                $domicilio,
                $pais,
                $titulo
            );
        } catch (Exception $e) {

            error_log('Error inserting user/person: ' . $e->getMessage());
            $errors[] = 'An error occurred while processing your request.';
        }


        if (empty($errors) && $idPersonaInsertada > 0) {
            header("Location: ../direcFormPersonaConfirm.php?ok=true&nombre=$nombre&apellido=$apellido");
            exit;
        } else {
            $errors[] = 'Failed to insert the person into the database.';
        }
    }


    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
?>
