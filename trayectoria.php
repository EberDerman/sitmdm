<div id="contenidoPDF"> <!-- Contenedor principal para el PDF -->
    <div class="container">
        <span class="badge badge-primary" style="font-size: 120%; padding: .5em .75em; margin-top: 20px; display: block;">TS. en Desarrollo de Software - 2024</span>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px; margin-bottom: 20px;">
            <strong>
                <h4>TRAYECTORIA</h4>
            </strong>
            <div>
                <button id="btnPDF" type="button" class="btn btn-primary">PDF</button>
                <button id="btnExpandir" type="button" class="btn btn-secondary">VER</button>
            </div>
        </div>

        <hr>

        <div class="div">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Progreso General</h6>
                <h6 id="progresoTexto"></h6> <!-- Texto de progreso actualizado dinámicamente -->
            </div>
            <div class="progress" style="margin-top: 20px; margin-bottom: 20px;">
                <div id="barraProgreso" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div> <!-- Barra de progreso actualizable -->
            </div>
        </div>
    </div>

    <div class="container">
        <strong>
            <h6>Año De Cursada: (2024)</h6>
        </strong>
        <div class="accordion" id="accordionMaterias">
            <!-- Las tarjetas se generarán aquí por JavaScript -->
        </div>
    </div>

    <br>

    <div class="container">
        <hr>
        <div class="div">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Promedio</h6>
                <h6 id="promedioGeneral"></h6> <!-- Texto del promedio general actualizado dinámicamente -->
            </div>
            <div class="progress" style="margin-top: 20px; margin-bottom: 20px;">
                <div id="barraPromedio" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="10" style="width: 0%;"></div> <!-- Barra de promedio general actualizable -->
            </div>
        </div>
    </div>
</div>

<!-- Agregar la librería html2pdf.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- Agregar jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Datos obtenidos de PHP
    <?php

   
    // ID del estudiante para el cual se desea obtener las materias
    $id_estudiante = getIdEstudiante();
    
    // Consulta SQL para obtener id_Tecnicatura
    $sql_tecnicatura = "SELECT id_Tecnicatura FROM estudiantes WHERE id_usuario = ?";
    $stmt_tecnicatura = $conexion->prepare($sql_tecnicatura);
    $stmt_tecnicatura->bind_param("i", $id_estudiante);
    $stmt_tecnicatura->execute();
    $stmt_tecnicatura->bind_result($id_tecnicatura);
    $stmt_tecnicatura->fetch();
    $stmt_tecnicatura->close();

    // Consulta SQL para filtrar por el ID del estudiante y el ID de la tecnicatura
    $sql = "SELECT m.id_Materia, m.Materia, m.AnioCursada, tm.nota_primer_cuatrimestre, tm.nota_segundo_cuatrimestre, tm.asistencia_horas, tm.horas_cursadas
            FROM estudiante_materia tm
            JOIN materias m ON tm.id_Materia = m.id_Materia
            JOIN estudiante_tecnicatura et ON et.id_estudiante = tm.id_estudiante
            WHERE tm.id_estudiante = ? AND et.id_Tecnicatura = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $id_estudiante, $id_tecnicatura);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $datos = array();

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            $datos[] = $row;
        }
    }

    $stmt->close();
    $conexion->close();

    // Convertir los datos a formato JSON para usarlos en JavaScript
    echo "const materias = " . json_encode($datos) . ";";
    ?>

    console.log('Datos de materias:', materias);

        function calcularPromedio(notas) {
            if (notas.length === 0) return 0;
            let suma = notas.reduce((a, b) => a + b, 0);
            return suma / notas.length;
        }

        function calcularPorcentajeAsistencia(horasCursada, horasAsistidas) {
            if (horasCursada === 0) return 0;
            return (horasAsistidas / horasCursada) * 100;
        }

        function regularidad(promedio, porcentajeAsistencia) {
            return promedio >= 4 && porcentajeAsistencia >= 60;
        }

        function generarHTML(materias) {
            return materias.map(materiaData => {
                // Convertir notas de cadenas a números
                const notaPrimerCuatrimestre = parseFloat(materiaData.nota_primer_cuatrimestre);
                const notaSegundoCuatrimestre = parseFloat(materiaData.nota_segundo_cuatrimestre);

                const notas = [notaPrimerCuatrimestre, notaSegundoCuatrimestre];
                const promedio = calcularPromedio(notas);
                const porcentajeAsistencia = calcularPorcentajeAsistencia(materiaData.horas_cursadas, materiaData.asistencia_horas);
                const esRegular = regularidad(promedio, porcentajeAsistencia) ? "Regular" : "Libre";
                const cardId = materiaData.Materia.replace(/\s+/g, '') + Math.random().toString(36).substring(7);

                return `
                <div class="card mb-3">
                    <div class="card-header" id="heading${cardId}">
                        <h5 class="mb-0">
                            <button class="btn btn-link toggle-card" type="button" data-toggle="collapse" data-target="#collapse${cardId}" aria-expanded="false" aria-controls="collapse${cardId}">
                                ${materiaData.Materia}
                            </button>
                        </h5>
                    </div>
                    <div id="collapse${cardId}" class="collapse" aria-labelledby="heading${cardId}">
                        <div class="card-body">
                            <p><strong>Condición:</strong> ${esRegular}</p>
                            <p><strong>Nota de Cursada:</strong> ${notaPrimerCuatrimestre}</p>
                            <p><strong>Nota Final:</strong> ${notaSegundoCuatrimestre}</p>
                            <p><strong>Porcentaje de asistencia:</strong> ${porcentajeAsistencia.toFixed(2)}%</p>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
        }

        function calcularProgreso(materias) {
            const totalMaterias = materias.length;
            if (totalMaterias === 0) return 0;
            const materiasAprobadas = materias.filter(materia => {
                const notaPrimerCuatrimestre = parseFloat(materia.nota_primer_cuatrimestre);
                const notaSegundoCuatrimestre = parseFloat(materia.nota_segundo_cuatrimestre);
                const promedio = calcularPromedio([notaPrimerCuatrimestre, notaSegundoCuatrimestre]);
                return promedio >= 4;
            }).length;
            const progreso = (materiasAprobadas / totalMaterias) * 100;
            return progreso.toFixed(2);
        }

        function calcularPromedioGeneral(materias) {
            const materiasConNotaFinal = materias.filter(materia => parseFloat(materia.nota_segundo_cuatrimestre) > 0);
            const totalNotas = materiasConNotaFinal.length;
            if (totalNotas === 0) return 0;
            const sumaNotas = materiasConNotaFinal.reduce((total, materia) => total + parseFloat(materia.nota_segundo_cuatrimestre), 0);
            return (sumaNotas / totalNotas).toFixed(2);
        }

        const container = document.getElementById('accordionMaterias');
        const progresoTexto = document.getElementById('progresoTexto');
        const promedioGeneral = document.getElementById('promedioGeneral');

        // Generar HTML para las materias y actualizar el contenedor
        container.innerHTML = generarHTML(materias);

        // Calcular y actualizar progreso
        const progreso = calcularProgreso(materias);
        progresoTexto.textContent = `${progreso}%`;

        const barraProgreso = document.getElementById('barraProgreso');
        barraProgreso.style.width = `${progreso}%`;
        barraProgreso.setAttribute('aria-valuenow', progreso);

        // Calcular y actualizar promedio general
        const promedio = calcularPromedioGeneral(materias);
        promedioGeneral.textContent = promedio;

        const barraPromedio = document.getElementById('barraPromedio');
        barraPromedio.style.width = `${(parseFloat(promedio) / 10) * 100}%`; // Convertir promedio sobre 10 a porcentaje
        barraPromedio.setAttribute('aria-valuenow', promedio);

        // Función para alternar entre expandir y contraer todas las cards
        let expanded = false;

        function toggleExpandirTodas() {
            const collapses = document.querySelectorAll('.collapse');
            collapses.forEach(collapse => {
                if (expanded) {
                    $(collapse).collapse('hide');
                } else {
                    $(collapse).collapse('show');
                }
            });
            expanded = !expanded; // Cambiar el estado después de la acción
        }

        // Manejar eventos de botones
        document.getElementById('btnExpandir').addEventListener('click', toggleExpandirTodas);
        document.getElementById('btnPDF').addEventListener('click', () => {
            // Asegurarse de expandir todas las cards antes de generar el PDF
            const collapses = document.querySelectorAll('.collapse');
            collapses.forEach(collapse => $(collapse).collapse('show'));
            setTimeout(() => {
                const contenido = document.getElementById('contenidoPDF');
                html2pdf().from(contenido).save('reporte.pdf');
            }, 500); // Esperar medio segundo para asegurarse de que todas las cards están expandidas
        });
    });
</script>