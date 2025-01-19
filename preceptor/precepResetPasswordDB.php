<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/EstudiantesRepository.php");

if (isset($_POST['id_estudiante']) && isset($_POST['idUsuario'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $idUsuario = $_POST['idUsuario'];

    $estudianteRepository = new EstudiantesRepository();
    $dni = $estudianteRepository->getDniByIdEstudiante($id_estudiante);
    $newPassword = $estudianteRepository->resetPasswordEstudiante($idUsuario, $dni);

    if ($newPassword['success']) {
        echo "Se ha reiniciado la contraseña correctamente.";
    } else {
        echo "Error al reiniciar la contraseña. dni: ". $dni . "pass:" . $newPassword['success'];
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}