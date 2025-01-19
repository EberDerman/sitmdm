<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../sql/conexion.php");


try {

    $sql = "SELECT idEstado FROM preinscripciones LIMIT 1"; 
    $stmt = $conexiones->prepare($sql);
    $stmt->execute();
    $currentEstado = $stmt->fetchColumn();

    //cambia el estado actual
    $newEstado = ($currentEstado == 2) ? 1 : 2;
    $updateSql = "UPDATE preinscripciones SET idEstado = :newEstado";
    $updateStmt = $conexiones->prepare($updateSql);
    $updateStmt->bindParam(':newEstado', $newEstado, PDO::PARAM_INT);
    $updateStmt->execute();

    //volver a incio
    header("Location: Doc_tecniNuevas.php?msg=Estado de preinscripciones actualizado correctamente");
    exit;
} catch (PDOException $e) {
    echo "Error al actualizar preinscripciones: " . $e->getMessage();
}
?>