<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/DocenteRepository.php");

if (isset($_POST['idDoc']) && isset($_POST['id_Materia'])) {
    $idDoc = $_POST['idDoc'];
    $id_Materia = $_POST['id_Materia'];

    $docenteRepository = new DocenteRepository();
    $resultado = $docenteRepository->asignMateria($idDoc, $id_Materia);

    if ($resultado['success']) {
        echo "Materia asignada correctamente.";
    } else {
        echo "Error al asignar la materia.";
    }
} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}