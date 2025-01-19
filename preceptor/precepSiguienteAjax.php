<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/MateriasRepository.php");

$anio = isset($_GET['anio']) ? intval($_GET['anio']) : 2024;

$materiasRepository = new MateriasRepository();
$materiasNoAsignadas = $materiasRepository->getMateriasNoAsignadas($anio);  // Filtra por el año recibido

$materias = [];

foreach ($materiasNoAsignadas as $row) {
    $AnioCursada = $row['AnioCursada'];
    switch ($AnioCursada) {
        case 'Primero':
            $anio = 0;
            break;
        case 'Segundo':
            $anio = 1;
            break;
        case 'Tercero':
            $anio = 2;
            break;
        case 'Cuarto':
            $anio = 3;
            break;
        case 'Quinto':
            $anio = 4;
            break;
        default:
            $anio = 0;
            break;
    }
    
    $materias[] = [
        'nombreTec' => $row['nombreTec'],
        'Ciclo' => $row['Ciclo'],
        'Materia' => $row['Materia'],
        'AnioCursada' => $AnioCursada,
        'AnioCursadaCiclo' => $row['Ciclo'] + $anio
    ];
}

echo json_encode($materias);
