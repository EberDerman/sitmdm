<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/DocenteRepository.php");

if (isset($_POST['iddocentesmaterias'])) {
    $iddocentesmaterias = $_POST['iddocentesmaterias'];

    $docenteRepository = new DocenteRepository();
    $resultado = $docenteRepository->deleteAssignedMateria($iddocentesmaterias);


    if ($resultado['success']) {
        echo "Materia quitada del docente correctamente.";
    } else {
        echo "Error al quitar la materia.";
    }
} else {
    echo "Error: No se han proporcionado los datos necesarios.";
}