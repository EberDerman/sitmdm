<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);

include("../sql/PersonaRepository.php");

if (isset($_POST['id_Persona']) && isset($_POST['idUsuario'])) {
    $id_Persona = $_POST['id_Persona'];
    $idUsuario = $_POST['idUsuario'];

    $personaRepository = new PersonaRepository();
    $personaDesactivada = $personaRepository->logicDeletePersona($id_Persona);
    $usuarioDesactivado = $personaRepository->logicDeleteUsuario($idUsuario);

    if ($personaDesactivada['success'] && $usuarioDesactivado['success']) {
        echo "Se ha desactivado al preceptor correctamente.";
    } else {
        echo "Error al quitar un preceptor.";
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}