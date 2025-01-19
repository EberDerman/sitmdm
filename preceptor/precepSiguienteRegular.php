<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/EstudiantesRepository.php"); // Incluir el repositorio

// Verifica si se ha recibido el año por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el año desde la solicitud POST
    $anioSeleccionado = isset($_POST['anio']) ? $_POST['anio'] : null;

    if ($anioSeleccionado) {
        // Crear una instancia de EstudiantesRepository
        $estudiantesRepository = new EstudiantesRepository();

        // Llamar al método para asignar la regularidad
        $resultado = $estudiantesRepository->estudiantesMateriasToRegular($anioSeleccionado);

        // Responder en formato JSON
        if ($resultado > 0) {
            echo json_encode(["success" => true, "message" => "Regularidad asignada correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "No se encontraron materias para asignar regularidad."]);
        }
        
    } else {
        // Si no se recibe el año, enviar un error
        echo json_encode(["success" => false, "message" => "Año no especificado."]);
    }
}
