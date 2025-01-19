<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCertificado = $_POST['idCertificado'];
    $accion = $_POST['accion'];

    // Definir el estado en función de la acción seleccionada
    if ($accion === 'aprobar') {
        $nuevoEstado = 2; // Estado aprobado
    } elseif ($accion === 'rechazar') {
        $nuevoEstado = 1; // Estado pendiente
    } elseif ($accion === 'caducar') {
        $nuevoEstado = 3; // Estado caducado
    } else {
        echo "Acción no válida.";
        exit;
    }

    try {
        $stmt = $conexiones->prepare("UPDATE certificados SET idEstado = :nuevoEstado WHERE idCertificado = :idCertificado");
        $stmt->bindParam(':nuevoEstado', $nuevoEstado, PDO::PARAM_INT);
        $stmt->bindParam(':idCertificado', $idCertificado, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Estado del certificado actualizado correctamente.";
        } else {
            echo "No se encontró el certificado o no se realizaron cambios.";
        }
    } catch (PDOException $e) {
        echo "Error al actualizar el estado del certificado: " . $e->getMessage();
    }
} else {
    echo "Solicitud no válida.";
}
?>
