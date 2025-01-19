<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include('session_check.php');
?>

<title>SITMDM-Inicio</title>
</head>

<body class="hidden-sn mdb-skin">
    <main>
        <div class="container-fluid">
            <?php
            include("docMenuNav.php");
            ?>
        </div>
        <div class="container mt-5">
            <div class="card p-4">
                <h3 class="text-center">Mis Cursos</h3>
                <ul class="text-center">
                    <?php
                    if (isset($_SESSION['materias_del_docente']) && !empty($_SESSION['materias_del_docente'])) {
                        $total_materias = count($_SESSION['materias_del_docente']);
                        foreach ($_SESSION['materias_del_docente'] as $index => $id_Materia) {
                            // Preparar la consulta para obtener el nombre de la materia según el id_Materia
                            $stmt = $conexiones->prepare("SELECT Materia FROM materias WHERE id_Materia = :id_Materia");
                            $stmt->execute(['id_Materia' => $id_Materia]);
                            $materia = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($materia) {
                                // Imprimir el círculo y el nombre de la materia
                                echo "• " . htmlspecialchars($materia['Materia']);
                                // Añadimos una coma después de cada materia excepto la última
                                if ($index < $total_materias - 1) {
                                    echo " ";
                                }
                            } else {
                                echo "Materia no encontrada para id $id_Materia";
                            }
                        }
                    } else {
                        echo "No tienes materias asignadas.";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <?php
                foreach ($materias_del_docente as $id_Materia) {
                    // Consulta para obtener los datos de la tabla 'materias' según 'id_Materia'
                    $consulta_materia = "SELECT Materia, AnioCursada, IdTec FROM materias WHERE id_Materia = :id_Materia";
                    $stmt_materia = $conexiones->prepare($consulta_materia);
                    $stmt_materia->bindParam(':id_Materia', $id_Materia, PDO::PARAM_INT);
                    $stmt_materia->execute();

                    if ($stmt_materia->rowCount() > 0) {
                        $materia = $stmt_materia->fetch(PDO::FETCH_ASSOC);

                        // Obtenemos el 'IdTec' de la materia para buscar en la tabla 'tecnicaturas'
                        $id_Tecnicatura = $materia['IdTec'];

                        // Consulta para obtener los datos de la tabla 'tecnicaturas' según 'id_Tecnicatura'
                        $consulta_tecnicatura = "SELECT nombreTec FROM tecnicaturas WHERE id_Tecnicatura = :id_Tecnicatura";
                        $stmt_tecnicatura = $conexiones->prepare($consulta_tecnicatura);
                        $stmt_tecnicatura->bindParam(':id_Tecnicatura', $id_Tecnicatura, PDO::PARAM_INT);
                        $stmt_tecnicatura->execute();

                        if ($stmt_tecnicatura->rowCount() > 0) {
                            $tecnicatura = $stmt_tecnicatura->fetch(PDO::FETCH_ASSOC);

                            // Generamos la tarjeta con los datos obtenidos
                            echo '
                    <!-- Tarjeta de materia -->
                    <div class="card m-2" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($tecnicatura['nombreTec']) . '</h5>
                            <h6 class="card-title">' . htmlspecialchars($materia['AnioCursada']) . '</h6>
                            <p class="card-text">' . htmlspecialchars($materia['Materia']) . '</p>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <a href="Temario_cargar.php?id_Materia=' . $id_Materia . '" class="btn btn-primary" title="Temario"><i class="fas fa-book"></i></a>
                                <a href="index_asistencia.php?id_Materia=' . $id_Materia . '" class="btn btn-primary" title="Asistencia"><i class="fas fa-user-check"></i></a>
                                <a href="index_notas.php?id_Materia=' . $id_Materia . '" class="btn btn-primary" title="Notas"><i class="fas fa-clipboard-list"></i></a>
                            </div>
                        </div>
                    </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <!-- Main layout -->
    <?php
    include("../includes/pie.php");
    ?>
    <!-- Footer -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>

</html>