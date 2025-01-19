<?php
$id_director = getIdUsuario();
checkAccess([$id_director, 3]);

$query = "SELECT idEstado FROM preinscripciones WHERE idPreinscripcion = 1";
$result = $conexion->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $botonTexto = ($row['idEstado'] == 2) ? "Deshabilitar Preinscripción" : "Habilitar Preinscripción";
} else {
    $botonTexto = "Habilitar/deshabilitar Preinscripción";
}
