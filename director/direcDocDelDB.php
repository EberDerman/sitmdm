<?php

include("../includes/sesion.php");
include("../sql/PersonaRepository.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);

if (isset($_POST['id_Persona']) && isset($_POST['idUsuario'])) {
    $id_Persona = $_POST['id_Persona'];
    $idUsuario = $_POST['idUsuario'];

    $personaRepository = new PersonaRepository();
    $personaDesactivada = $personaRepository->logicDeletePersona($id_Persona);
    $usuarioDesactivado = $personaRepository->logicDeleteUsuario($idUsuario);

    if ($personaDesactivada['success'] && $usuarioDesactivado['success']) {
        echo "Se ha desactivado al docente correctamente.";
    } else {
        echo "Error al quitar un docente.";
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}