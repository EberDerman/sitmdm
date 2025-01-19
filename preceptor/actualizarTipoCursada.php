<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/conexion.php");

if (isset($_POST['id_estudiante']) && isset($_POST['id_Materia']) && isset($_POST['id_Tipocursada']) && $_POST['id_Tipocursada'] !== "" && isset($_POST['nombre']) && isset($_POST['id_Tecnicatura']) && isset($_POST['nombreTec']) && isset($_POST['Ciclo'])) {
    $id_estudiante = $_POST['id_estudiante'];
    $id_Materia = $_POST['id_Materia'];
    $id_Tipocursada = $_POST['id_Tipocursada'];
    $nombre = $_POST['nombre'];
    $id_Tecnicatura = $_POST['id_Tecnicatura'];
    $nombreTec = $_POST['nombreTec'];
    $ciclo = $_POST['Ciclo'];

    try {
        // Comprobamos si ya existe un registro para este estudiante y materia
        $query = $conexiones->prepare("SELECT COUNT(*) FROM estudiante_materia WHERE id_estudiante = :id_estudiante AND id_Materia = :id_Materia");
        $query->execute(['id_estudiante' => $id_estudiante, 'id_Materia' => $id_Materia]);
        $exists = $query->fetchColumn();

        if ($exists) {
            // Si existe, actualizamos el estado
            $update = $conexiones->prepare("UPDATE estudiante_materia SET id_Tipocursada = :id_Tipocursada WHERE id_estudiante = :id_estudiante AND id_Materia = :id_Materia");
            $update->execute(['id_Tipocursada' => $id_Tipocursada, 'id_estudiante' => $id_estudiante, 'id_Materia' => $id_Materia]);
        } else {
            // Si no existe, insertamos un nuevo registro
            $insert = $conexiones->prepare("INSERT INTO estudiante_materia (id_estudiante, id_Materia, id_Tipocursada) VALUES (:id_estudiante, :id_Materia, :id_Tipocursada)");
            $insert->execute(['id_estudiante' => $id_estudiante, 'id_Materia' => $id_Materia, 'id_Tipocursada' => $id_Tipocursada]);
        }

        // Devolver una respuesta adecuada
        echo "Tipo de cursada actualizado correctamente";

    } catch (PDOException $e) {
        echo "Error al actualizar el tipo de cursada: " . $e->getMessage();
    }
} else {
    echo "Faltan datos para actualizar el tipo de cursada.";
}
?>
