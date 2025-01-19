<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/EstudiantesRepository.php");
include("../sql/PersonaRepository.php");

if (isset($_POST['id_estudiante']) && isset($_POST['idUsuario'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $idUsuario = $_POST['idUsuario'];

    $estudianteRepository = new EstudiantesRepository();
    $personaRepository = new PersonaRepository();
    $estudianteDesactivado = $estudianteRepository->logicDeleteEstudiante($id_estudiante);
    $usuarioDesactivado = $personaRepository->logicDeleteUsuario($idUsuario);

    if ($estudianteDesactivado['success'] && $usuarioDesactivado['success']) {
        echo "Se ha desactivado al estudiante correctamente.";
    } else {
        echo "Error al quitar un estudiante.";
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}