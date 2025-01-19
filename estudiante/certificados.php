<?php
include("../includes/sesion.php");


$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante


include("../includes/encabezado.php");
include("../sql/conexion.php"); 

$id_usuario = getIdUsuario();
$id_tecnicatura = getIdTecnicatura();

$sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
$stmt_estudiante = $conexion->prepare($sql_estudiante);
$stmt_estudiante->bind_param("i", $id_usuario);
$stmt_estudiante->execute();
$stmt_estudiante->bind_result($id_estudiante);
$stmt_estudiante->fetch();
$stmt_estudiante->close();

try {
    $stmt = $conexiones->prepare("SELECT c.FechaSolicitud, c.TipoCertificado, e.estado, c.idEstado
                                  FROM certificados c 
                                  JOIN estados e ON c.idEstado = e.idEstado 
                                  WHERE c.id_estudiante = :id_estudiante 
                                  AND c.id_tecnicatura = :id_tecnicatura");
    $stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
    $stmt->bindParam(':id_tecnicatura', $id_tecnicatura, PDO::PARAM_INT);
    $stmt->execute();
    $certificados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener los certificados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sitmdm/css/bootstrap.css">
    <title>Certificados</title>
    <style>
        .header-container {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background-color: #f8f9fa;
            padding: 100px 10px 10px;
            box-sizing: border-box;
        }

        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 20px;
        }

        .caducado {
            background-color: #fffae5; /* Fondo amarillo suave para certificados caducados */
        }

        .aprobado {
            background-color: #e5ffea; /* Fondo verde suave para certificados aprobados */
            color: green; /* Texto en verde */
            font-weight: bold;
        }
    </style>
</head>

<body class="hidden-sn mdb-skin">
    <div class="container-fluid">
        <?php include("menuEstudiante.php"); ?>
    </div>

    <div class="header-container">
        <div class="container">
            <h1 class="text-center mb-4 text-dark">Certificados</h1>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary w-100" onclick="addCertificate('Alumno Regular')">Alumno Regular</button>
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary w-100" onclick="addCertificate('Porcentaje de Materias')">Porcentaje de Materias</button>
                </div>
                <div class="col-md-4 mb-2">
                    <button class="btn btn-primary w-100" onclick="addCertificate('Analítico Parcial')">Analítico Parcial</button>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Fecha de solicitud</th>
                            <th>Certificado</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="certTableBody">
                        <?php 
                        $certificadosAprobados = [];
                        $certificadosPendientes = [];
                        $certificadosCaducados = [];

                        foreach ($certificados as $certificado) {
                            if ($certificado['estado'] == 'aprobado') {
                                $certificadosAprobados[] = $certificado;
                            } elseif ($certificado['estado'] == 'caducado') {
                                $certificadosCaducados[] = $certificado;
                            } else {
                                $certificadosPendientes[] = $certificado;
                            }
                        }

                        // Mostrar certificados aprobados
                        foreach ($certificadosAprobados as $certificado): ?>
                            <tr class="aprobado">
                                <td><?= date('d/m/Y', strtotime($certificado['FechaSolicitud'])); ?></td>
                                <td><?= htmlspecialchars($certificado['TipoCertificado']); ?></td>
                                <td>Aprobado</td>
                            </tr>
                        <?php endforeach; ?>

                 
                        <?php foreach ($certificadosPendientes as $certificado): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($certificado['FechaSolicitud'])); ?></td>
                                <td><?= htmlspecialchars($certificado['TipoCertificado']); ?></td>
                                <td>Pendiente</td>
                            </tr>
                        <?php endforeach; ?>

                        <?php foreach ($certificadosCaducados as $certificado): ?>
                            <tr class="caducado">
                                <td><?= date('d/m/Y', strtotime($certificado['FechaSolicitud'])); ?></td>
                                <td><?= htmlspecialchars($certificado['TipoCertificado']); ?></td>
                                <td>Caducado</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include("../includes/pie.php"); ?>

    <script>
        const requestedCertificates = new Set();

        document.addEventListener('DOMContentLoaded', () => {
            const certificados = <?php echo json_encode($certificados); ?>;
            certificados.forEach(cert => {
                if (cert['idEstado'] !== 3) { // Solo evitar solicitudes si el estado no es caducado
                    requestedCertificates.add(cert['TipoCertificado']);
                }
            });
        });

        function addCertificate(certName) {
            if (requestedCertificates.has(certName)) {
                alert(`Ya has solicitado un certificado de tipo "${certName}".`);
                return;
            }

            const tableBody = document.getElementById('certTableBody');
            const currentDate = new Date().toLocaleDateString('es-ES');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${currentDate}</td>
                <td>${certName}</td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="realizarPedido(this, '${certName}')">Realizar pedido</button>
                    <button class="btn btn-danger btn-sm" onclick="cancelarPedido(this)">Cancelar</button>
                </td>
            `;
            tableBody.appendChild(newRow);

            requestedCertificates.add(certName); // Marca el certificado como solicitado
        }

        function realizarPedido(button, certName) {
            const row = button.closest('tr');

            fetch('solicitar_certificado.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'tipoCertificado': certName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert('Error al solicitar el certificado: ' + data.message);
                    requestedCertificates.delete(certName);
                } else {
                    row.cells[2].innerHTML = 'Pendiente';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                requestedCertificates.delete(certName);
            });
        }

        function cancelarPedido(button) {
            const row = button.closest('tr');
            const certName = row.cells[1].textContent;

            row.remove();
            requestedCertificates.delete(certName);
        }
    </script>

</body>
</html>
