<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);

include("../sql/PersonaRepository.php");

if (isset($_POST['id_Persona']) && isset($_POST['idUsuario'])) {
    $id_Persona = $_POST['id_Persona'];
    $idUsuario = $_POST['idUsuario'];

    $personaRepository = new PersonaRepository();
    $dni = $personaRepository->getDniByIdPersona($id_Persona);
    $newPassword = $personaRepository->resetPassword($idUsuario, $dni);

    if ($newPassword['success']) {
        echo "Se ha reiniciado la contraseña correctamente.";
    } else {
        echo "Error al reiniciar la contraseña. dni: ". $dni . "pass:" . $newPassword['success'];
    }

} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}