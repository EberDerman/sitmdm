<?php
include("../includes/sesion.php");

$id_director = getIdUsuario();
checkAccess([$id_director, 3]);

include("../sql/PersonaRepository.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'] ?? null;
    $apellido = $_POST['apellido'] ?? null;
    $email = $_POST['email'] ?? null;
    $estado_civil = $_POST['estado_civil'] ?? ''; // Si no se recibe 'estado_civil', le asignamos una cadena vacía
    $domicilio = $_POST['domicilio'] ?? null;
    $telefono_1 = $_POST['celular'] ?? null;
    $telefono_2 = $_POST['telefono'] ?? null;
    $titulo = $_POST['titulo'] ?? null;
    $id_Persona = $_POST['id_Persona'] ?? null;

    if (!$id_Persona) {
        echo "<script>alert('No se encontró el ID de la persona.'); window.location.href = 'inicioDirec.php';</script>";
        exit;
    }

    // Verificar que todos los datos obligatorios estén presentes
    if (!$nombre || !$apellido || !$email || !$domicilio || !$telefono_1 || !$estado_civil || !$titulo) {
        echo "<script>alert('Por favor, complete todos los campos obligatorios.'); window.location.href = 'direcDocEditar.php?id_Persona=$id_Persona';</script>";
        exit;
    }

    $personaRepository = new PersonaRepository();
    $persona = $personaRepository->getPersonaById($id_Persona); // Obtener los datos actuales de la persona

    if ($persona) {
        $row = $persona;
        $estado_civil = $estado_civil ?: $row['estado_civil']; // Si no se recibe estado_civil, dejamos el valor actual
        $actualizarPersona = $personaRepository->updatePersona($nombre, $apellido, $email, $estado_civil, $domicilio, $telefono_1, $telefono_2, $titulo, $id_Persona);

        $personaRepository->updateEmail($persona['idUsuario'], $email);

        if ($actualizarPersona['success'] === true) {
            switch ($row['codRol']) {
                case 5:
                    echo "<script>alert('Datos actualizados del docente correctamente.'); window.location.href = 'direcDoc.php';</script>";
                    break;
                case 4:
                    echo "<script>alert('Datos actualizados del preceptor correctamente.'); window.location.href = 'direcPrecep.php';</script>";
                    break;
                default:
                    echo "<script>alert('Datos actualizados correctamente.'); window.location.href = 'inicioDirec.php';</script>";
            }
        } else {
            echo "<script>alert('Error al actualizar los datos.'); window.location.href = 'direcDocEditar.php?id_Persona=$id_Persona';</script>";
        }
    } else {
        echo "<script>alert('Persona no encontrada.'); window.location.href = 'inicioDirec.php';</script>";
    }
} else {
    echo "<script>alert('Acción no permitida.'); window.location.href = 'inicioDirec.php';</script>";
}

?>