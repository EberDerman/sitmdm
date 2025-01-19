<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/PersonaRepository.php");
include("../sql/EstudiantesRepository.php");

if (isset($_POST['id_estudiante']) && isset($_POST['idUsuario'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $idUsuario = $_POST['idUsuario'];

    $estudianteRepository = new EstudiantesRepository();
    $personaRepository = new PersonaRepository();
    $estudianteHabilitado = $estudianteRepository->logicEnableEstudiante($id_estudiante);
    $usuarioHabilitado = $personaRepository->logicEnableUsuario($idUsuario);

    if ($estudianteHabilitado['success'] && $usuarioHabilitado['success']) {
        echo "Se ha reactivado al estudiante correctamente.";
    } else {
        echo "Error al quitar un estudiante.";
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}