<?php


$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante



?>



<style>
    /* Evita que se corten estos elementos entre páginas */
    .hoja-completa,
    h1,
    h2,
    .titulo {
        page-break-inside: avoid;
    }

    .no-imprimir {
        display: '';
    }
</style>

<div id="contenidoPDF"> <!-- Contenedor principal para el PDF editado-->
    <div class="container">
        <span class="badge badge-primary" id="tituloTec" style="font-size: 120%; padding: .5em .75em; margin-top: 20px; display: block;"></span>

        <div class="d-flex justify-content-between align-items-center" style="margin-top: 20px; margin-bottom: 20px;">
            <strong>
                <h4>TRAYECTORIA</h4>
            </strong>
            <div>
                <button id="btnPDF" type="button" class="btn btn-primary no-imprimir">PDF</button>
                <button id="btnExpandir" type="button" class="btn btn-secondary no-imprimir">VER</button>
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
            <h6>Año De Cursada: <span id="year"></span></h6>

            <script>
                document.getElementById("year").textContent = new Date().getFullYear();
            </script>

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos obtenidos de PHP
        <?php


        $id_usuario = getIdUsuario();
        $id_tecnicatura = getIdTecnicatura();

        $sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
        $stmt_estudiante = $conexion->prepare($sql_estudiante);
        $stmt_estudiante->bind_param("i", $id_usuario);
        $stmt_estudiante->execute();
        $stmt_estudiante->bind_result($id_estudiante);
        $stmt_estudiante->fetch();
        $stmt_estudiante->close();



        $sql_tecnicatura = "SELECT t.nombreTec 
        FROM tecnicaturas t 
                WHERE id_Tecnicatura = ?";
        $stmt_tecnicatura = $conexion->prepare($sql_tecnicatura);
        $stmt_tecnicatura->bind_param("i", $id_tecnicatura);
        $stmt_tecnicatura->execute();
        $stmt_tecnicatura->bind_result($nombreTec);
        $stmt_tecnicatura->fetch();
        $stmt_tecnicatura->close();
        $sql_materias = "SELECT 
        m.AnioCursada, 
        m.id_Materia, 
        m.Materia, 
        ti.tipocursada,
        tm.nota_primer_cuatrimestre, 
        tm.nota_segundo_cuatrimestre, 
        a.horas_asistidas,   
        t.horas_dadas        
    FROM estudiante_materia tm
    JOIN tipocursada ti on ti.id_Tipocursada = tm.id_Tipocursada
    LEFT JOIN materias m ON tm.id_Materia = m.id_Materia
    LEFT JOIN fechas_materias fm ON fm.id_Materia = m.id_Materia AND fm.id_Tecnicatura = ?
    LEFT JOIN estudiante_tecnicatura et ON et.id_estudiante = tm.id_estudiante
    LEFT JOIN asistencia a ON a.id_estudiante = tm.id_estudiante AND a.id_Materia = tm.id_Materia  -- Relación con la tabla asistencia
    LEFT JOIN temario t ON t.id_Materia = tm.id_Materia    -- Relación con la tabla temario
    WHERE tm.id_estudiante = ? 
    ORDER BY m.AnioCursada ASC";

        $stmt = $conexion->prepare($sql_materias);
        $stmt->bind_param("ii", $id_estudiante, $id_tecnicatura);
        $stmt->execute();
        $resultado_materias = $stmt->get_result();

        $datos = array();

        if ($resultado_materias->num_rows > 0) {
            while ($row = $resultado_materias->fetch_assoc()) {
                $datos[$row['id_Materia']] = $row;
                $datos[$row['id_Materia']]['finales'] = array();
            }
        }

        $stmt->close();

        $sql_finales = "SELECT 
            f.id_materia, 
            f.fecha, 
            f.nota 
            FROM finales f
            WHERE f.id_estudiante = ? AND f.id_tecnicatura = ?";

        $stmt_finales = $conexion->prepare($sql_finales);
        $stmt_finales->bind_param("ii", $id_estudiante, $id_tecnicatura);
        $stmt_finales->execute();
        $resultado_finales = $stmt_finales->get_result();

        if ($resultado_finales->num_rows > 0) {
            while ($row_finales = $resultado_finales->fetch_assoc()) {
                $datos[$row_finales['id_materia']]['finales'][] = array(
                    "fecha" => $row_finales['fecha'],
                    "nota" => $row_finales['nota']
                );
            }
        }


        $stmt_finales->close();
        $conexion->close();

        echo "const materias = " . json_encode($datos) . ";";
        echo "const nombreTec = " . json_encode($nombreTec) . ";";
        ?>


        document.getElementById('btnExpandir').addEventListener('click', function() {
            const todasLasCards = document.querySelectorAll('.accordion .collapse');
            const estaExpandido = todasLasCards[0].classList.contains('show'); // Verificamos si al menos una card está expandida

            if (estaExpandido) {
                // Si alguna está expandida, colapsamos todas
                todasLasCards.forEach(collapse => {
                    collapse.classList.remove('show');
                });
            } else {
                // Si ninguna está expandida, expandimos todas
                todasLasCards.forEach(collapse => {
                    collapse.classList.add('show');
                });
            }
        });

        document.getElementById('btnPDF').addEventListener('click', function() {

            // Expandir todas las secciones de acordeón
            document.querySelectorAll('.accordion .collapse').forEach(collapse => {
                collapse.classList.add('show');
            });

            // Ocultar los botones con la clase 'no-imprimir'
            document.querySelectorAll('.no-imprimir').forEach(element => {
                element.style.display = 'none';
            });

            const contenido = document.getElementById('contenidoPDF');
            html2pdf()
                .set({
                    margin: 10, // Ajusta el margen si es necesario
                    filename: 'reporte.pdf',
                    html2canvas: {
                        scale: 2,
                        useCORS: true
                    },
                    jsPDF: {
                        format: 'a4',
                        orientation: 'portrait'
                    },
                    pagebreak: {
                        mode: ['avoid-all', 'css', 'legacy']
                    }
                })
                .from(contenido)
                .save()
                .then(() => {
                    // Restaurar la visibilidad de los botones después de generar el PDF
                    document.querySelectorAll('.no-imprimir').forEach(element => {
                        element.style.display = '';
                    });
                });
        });

        console.log('Datos de materias:', materias);

        const tituloTec = document.getElementById('tituloTec');
        tituloTec.innerHTML = nombreTec;

        function calcularPromedio(notas) {
            if (notas.length === 0) return 0;
            let suma = notas.reduce((a, b) => a + b, 0);
            return suma / notas.length;
        }

        function calcularPorcentajeAsistencia(horasDadas, horasAsistidas) {
            if (horasDadas > 0) {
                return ((horasAsistidas / horasDadas) * 100).toFixed(2);
            }
            return "0.00";
        }

        function regularidad(promedio, porcentajeAsistencia) {
            return promedio >= 4 && porcentajeAsistencia >= 60;
        }

       
        function generarHTML(materias) {
            return Object.values(materias).map((materiaData) => {
                const notaPrimerCuatrimestre = parseFloat(materiaData.nota_primer_cuatrimestre) || 0;
                const notaSegundoCuatrimestre = parseFloat(materiaData.nota_segundo_cuatrimestre) || 0;

                const notas = [notaPrimerCuatrimestre, notaSegundoCuatrimestre];
                const promedio = calcularPromedio(notas);
                const porcentajeAsistencia = calcularPorcentajeAsistencia(materiaData.horas_dadas, materiaData.horas_asistidas); // Corregido
               const esRegular = materiaData.tipocursada;



                const cardId = materiaData.Materia.replace(/\s+/g, '') + Math.random().toString(36).substring(7);

                const finales = materiaData.finales || [];
                let filasFinales = '';
                finales.forEach((final, index) => {
                    filasFinales += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${final.fecha}</td>
                    <td class="text-center">${final.nota}</td>
                </tr>
            `;
                });

                return `
            <div class="card mb-3">
                <div class="card-header" id="heading${cardId}">
                    <h5 class="mb-0">
                        <button class="btn btn-link toggle-card" type="button" data-toggle="collapse" data-target="#collapse${cardId}" aria-expanded="false" aria-controls="collapse${cardId}">
                        <strong>${materiaData.Materia}</strong> - Año: ${materiaData.AnioCursada}
                        </button>
                    </h5>
                </div>
                <div id="collapse${cardId}" class="collapse" aria-labelledby="heading${cardId}">
                    <div class="card-body">
                        <p><strong>Condición:</strong> ${esRegular}</p>
                        <hr>
                        <p><strong>Nota Primer Cuatrimestre:</strong> ${notaPrimerCuatrimestre}</p>
                        <p><strong>Nota Segundo Cuatrimestre:</strong> ${notaSegundoCuatrimestre}</p>
                        <hr>
                        <p><strong>Porcentaje de asistencia:</strong> ${porcentajeAsistencia}%</p> <!-- Corregido -->
                        <hr>
                        <p><strong>Nota Examen Final:</strong></p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">N°</th>
                                    <th scope="col" class="text-center">Fecha</th>
                                    <th scope="col" class="text-center">Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${filasFinales}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;
            }).join('');
        }



        function actualizarProgreso(materias) {
            let totalMaterias = 0;
            let materiasAprobadas = 0;

            Object.values(materias).forEach(materia => {
                totalMaterias++;
                const notasFinales = materia.finales.map(final => parseFloat(final.nota)).filter(nota => !isNaN(nota));
                if (notasFinales.length > 0) {
                    const ultimaNotaFinal = notasFinales[notasFinales.length - 1];
                    if (ultimaNotaFinal >= 4) { // Considera 4 como aprobada
                        materiasAprobadas++;
                    }
                }
            });

            if (totalMaterias > 0) {
                const progresoPorcentaje = (materiasAprobadas / totalMaterias) * 100;
                document.getElementById('barraProgreso').style.width = progresoPorcentaje + '%';
                document.getElementById('progresoTexto').innerText = `${progresoPorcentaje.toFixed(2)}%`;
            } else {
                document.getElementById('progresoTexto').innerText = '0%';
            }
        }


        function actualizarPromedioGeneral(materias) {
            let sumaPromedios = 0;
            let totalMaterias = 0;

            Object.values(materias).forEach(materia => {
                const notasFinales = materia.finales.map(final => parseFloat(final.nota)).filter(nota => !isNaN(nota));
                if (notasFinales.length > 0) {
                    const ultimaNotaFinal = notasFinales[notasFinales.length - 1]; // Última nota final
                    sumaPromedios += ultimaNotaFinal;
                    totalMaterias++;
                }
            });

            const promedioGeneral = (sumaPromedios / totalMaterias).toFixed(2);
            document.getElementById('barraPromedio').style.width = promedioGeneral * 10 + '%'; // 0-10 promedio, se multiplica por 10 para un rango de 0-100
            document.getElementById('promedioGeneral').innerText = promedioGeneral;
        }

        document.getElementById('accordionMaterias').innerHTML = generarHTML(materias);
        actualizarProgreso(materias);
        actualizarPromedioGeneral(materias);
    });
</script>