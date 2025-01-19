<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);



include("../includes/encabezado.php");
include("../sql/DocenteRepository.php");
include("../sql/conexion.php");

$certificados = [];

try {
    if (!$conexiones) {
        throw new Exception("Conexión a la base de datos no establecida.");
    }

    $stmt = $conexiones->prepare("SELECT c.idCertificado, c.FechaSolicitud, e.nombre, e.apellido, e.id_estudiante, c.id_Tecnicatura, t.nombreTec AS nombre_tecnicatura, c.TipoCertificado, es.estado, es.idEstado
                                  FROM estudiantes e
                                  JOIN certificados c ON e.id_estudiante = c.id_estudiante
                                  JOIN tecnicaturas t ON c.id_Tecnicatura = t.id_Tecnicatura
                                  JOIN estados es ON c.idEstado = es.idEstado
                                  ORDER BY c.idCertificado DESC");
    $stmt->execute();
    $certificados = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p>Error al obtener los certificados: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p>Error general: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITMDM-Certificados</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        .action-btn-img {
            width: 50px;
            /* Cambia el tamaño de las imágenes aquí */
            height: 50px;
            cursor: pointer;
            margin-right: 5px;
            /* Espacio entre los botones */
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            /* Espacio entre los botones */
        }

        .estado-caducado {
            color: yellow;
        }
    </style>

</head>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php include("direcMenuNav.php"); ?>
    </div>
    <main>
        <div class="container mt-5">
            <div class="card text-center">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
                    style="border-radius: 8px;">
                    <h4 class="mb-0">Certificados solicitados</h4>
                    <div>
                        <button class="btn btn-primary" onclick="window.location.href='inicioDirec.php'">VOLVER</button>
                    </div>
                </div>

                <?php if (empty($certificados)): ?>
                    <p>No hay certificados para mostrar.</p>
                <?php else: ?>
                    <table id="certificatesTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>N° Certificado</th>
                                <th>Fecha de Solicitud</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Tecnicaura</th>
                                <th>Certificado</th>
                                <th>Estado</th>
                                <th>Acción</th>
                                <th>Descargas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($certificados as $certificado): ?>
                                <tr>
                                    <td><?= htmlspecialchars($certificado['idCertificado']); ?></td>
                                    <td><?= date('d/m/Y', strtotime($certificado['FechaSolicitud'])); ?></td>
                                    <td><?= htmlspecialchars($certificado['nombre']); ?></td>
                                    <td><?= htmlspecialchars($certificado['apellido']); ?></td>
                                    <td><?= htmlspecialchars($certificado['nombre_tecnicatura']); ?></td>
                                    <td><?= htmlspecialchars($certificado['TipoCertificado']); ?></td>
                                    <td><?= htmlspecialchars($certificado['estado']); ?></td>
                                    <td>
                                        <?php if ($certificado['idEstado'] == 1): ?>
                                            <img src="../assets/img/overlays/aprobar.png" alt="Aprobar" title="Aprobar certificado"
                                                class="action-btn-img"
                                                onclick="actualizarEstadoCertificado(<?= $certificado['idCertificado']; ?>, 'aprobar')">
                                        <?php elseif ($certificado['idEstado'] == 2): ?>
                                            <div class="action-buttons">
                                                <img src="../assets/img/overlays/rechazar.png" alt="Rechazar"
                                                    title="Rechazar certificado" class="action-btn-img"
                                                    onclick="actualizarEstadoCertificado(<?= $certificado['idCertificado']; ?>, 'rechazar')">
                                                <img src="../assets/img/overlays/caducar.png" alt="Caducar"
                                                    title="Caducar certificado" class="action-btn-img"
                                                    onclick="actualizarEstadoCertificado(<?= $certificado['idCertificado']; ?>, 'caducar')">
                                            </div>
                                        <?php elseif ($certificado['idEstado'] == 3): ?>
                                            <span class="estado-caducado">Caducado</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button class="btn btn-primary"
                                            onclick="verCertificado('<?= $certificado['TipoCertificado']; ?>', <?= $certificado['id_estudiante']; ?>, <?= $certificado['id_Tecnicatura']; ?>)">Ver
                                            Certificado</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include("../includes/pie.php"); ?>

    <script>
        $(document).ready(function () {
            $('#certificatesTable').DataTable({
                "paging": true,
                "searching": true,
                "info": false,
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "zeroRecords": "No se encontraron resultados",
                    "infoEmpty": "No hay entradas disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total entradas)"
                }
            });
        });
        function verCertificado(tipoCertificado, id_estudiante, id_Tecnicatura) {
    let url = '';
    switch (tipoCertificado.toLowerCase()) {
        case 'alumno regular':
            url = `certificados/ContsAlumRegular.php?id_estudiante=${id_estudiante}&id_Tecnicatura=${id_Tecnicatura}`;
            break;
        case 'analítico parcial': 
            url = `certificados/Cert_Espacios_Acreditados.php?id_estudiante=${id_estudiante}&id_Tecnicatura=${id_Tecnicatura}`;
            break;
        case 'porcentaje de materias':
            url = `certificados/PorcentajeMaterias.php?id_estudiante=${id_estudiante}&id_Tecnicatura=${id_Tecnicatura}`;
            break;
        default:
            alert('No es una opción válida.');
            return;
    }
    window.open(url, '_blank');
}


        function actualizarEstadoCertificado(idCertificado, accion) {
            $.ajax({
                url: 'updateCertificado.php',
                type: 'POST',
                data: {
                    idCertificado: idCertificado,
                    accion: accion
                },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function () {
                    alert('Error al actualizar el estado del certificado');
                }
            });
        }
    </script>
</body>

</html>