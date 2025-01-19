<?php

include("../includes/sesion.php");
$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/PersonaRepository.php");



if (isset($_POST['id_Persona']) && isset($_POST['idUsuario'])) {
    $id_Persona = $_POST['id_Persona'];
    $idUsuario = $_POST['idUsuario'];

    $personaRepository = new PersonaRepository();
    $personaHabilitada = $personaRepository->logicEnablePersona($id_Persona);
    $usuarioHabilitado = $personaRepository->logicEnableUsuario($idUsuario);

    if ($personaHabilitada['success'] && $usuarioHabilitado['success']) {
        echo "Se ha reactivado al usuario correctamente.";
    } else {
        echo "Error al quitar un usuario.";
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}