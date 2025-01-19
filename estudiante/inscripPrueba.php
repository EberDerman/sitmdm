<?php
include("../includes/sesion.php");
$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante
include("encabezado.php");
include("../sql/conexion.php");
include("menuEstudiante.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Inscripción a Exámenes</title>
  <style>
    .centrarCol {
      text-align: center;
    }

    .hidden {
      display: none;
    }

    .not-regular {
      color: red;
    }
  </style>
</head>

<body class="hidden-sn mdb-skin">
  <main>
    <div class="container-fluid"></div>
    <div class="container card text-center my-3 px-0">
      <h4 class="card-header primary-color-dark white-text">INSCRIPCIÓN A EXÁMENES</h4>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>Materias</td>
                <td class="centrarCol">Fechas</td>
              </tr>
            </thead>
            <tbody class="materias">
              <!-- Las filas se insertarán aquí -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php
      $id_usuario = getIdUsuario();
      $id_tecnicatura = getIdTecnicatura(); // Obtiene la tecnicatura seleccionada

      // Obtener el id del estudiante
      $sql_estudiante = "SELECT id_estudiante FROM estudiantes WHERE idUsuario = ?";
      $stmt_estudiante = $conexion->prepare($sql_estudiante);
      $stmt_estudiante->bind_param("i", $id_usuario);
      $stmt_estudiante->execute();
      $stmt_estudiante->bind_result($id_estudiante);
      $stmt_estudiante->fetch();
      $stmt_estudiante->close();

      // Consulta principal con filtro por tecnicatura
      $sql = "SELECT 
                    m.id_Materia, 
                    m.Materia, 
                    m.AnioCursada, 
                    tm.nota_primer_cuatrimestre, 
                    tm.nota_segundo_cuatrimestre, 
                    fm.fecha1, 
                    fm.fecha2,
                    (a.horas_asistidas) AS horas_asistidas, 
                    (t.horas_dadas) AS horas_dadas,
                    ie.fecha_tipo AS fechaInscripcion, 
                    ie.fecha_inscripcion
              FROM estudiante_materia tm
              JOIN materias m ON tm.id_Materia = m.id_Materia
              JOIN estudiante_tecnicatura et ON et.id_estudiante = tm.id_estudiante
              LEFT JOIN fechas_materias fm ON fm.id_Materia = m.id_Materia AND fm.id_Tecnicatura =et.id_Tecnicatura
              LEFT JOIN asistencia a ON a.id_estudiante = tm.id_estudiante AND a.id_Materia = tm.id_Materia
              LEFT JOIN temario t ON t.id_Materia = m.id_Materia
              LEFT JOIN inscripciones_examenes ie ON ie.id_estudiante = tm.id_estudiante AND ie.materia = m.Materia
              WHERE tm.id_estudiante = ? AND et.id_Tecnicatura = ? AND m.IdTec = ?
              GROUP BY m.id_Materia, m.Materia, m.AnioCursada, 
                    tm.nota_primer_cuatrimestre, tm.nota_segundo_cuatrimestre, 
                    fm.fecha1, fm.fecha2";


      $stmt = $conexion->prepare($sql);
      $stmt->bind_param("iii", $id_estudiante, $id_tecnicatura, $id_tecnicatura);
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

      echo "const materias = " . json_encode($datos) . ";";
      ?>

      function calcularPromedio(notas) {
        if (notas.length === 0) return 0;
        let suma = notas.reduce((a, b) => a + b, 0);
        return suma / notas.length;
      }

      function calcularPorcentajeAsistencia(horas_dadas, horas_asistidas) {
        if (horas_dadas === 0) return 0; // Prevenir división por cero
        return (horas_asistidas * 100) / horas_dadas;
      }

      function regularidad(promedio, porcentajeAsistencia) {
        // Determina si la materia es regular basado en el promedio y el porcentaje de asistencia
        return promedio >= 4 && porcentajeAsistencia >= 75;
      }

      function generarHTML(materias) {
        if (materias.length === 0) {
          return `<tr><td colspan="2" class="text-center">No hay materias disponibles para la tecnicatura seleccionada.</td></tr>`;
        }

        return materias.map(materiaData => {
          const notaPrimerCuatrimestre = parseFloat(materiaData.nota_primer_cuatrimestre);
          const notaSegundoCuatrimestre = parseFloat(materiaData.nota_segundo_cuatrimestre);
          const notas = [notaPrimerCuatrimestre, notaSegundoCuatrimestre];
          const promedio = calcularPromedio(notas);
          const horasAsistidas = parseFloat(materiaData.horas_asistidas);
          const horasDadas = parseFloat(materiaData.horas_dadas);
          const porcentajeAsistencia = calcularPorcentajeAsistencia(horasDadas, horasAsistidas);

          const fecha1 = materiaData.fecha1 ? new Date(materiaData.fecha1).toLocaleDateString('es-ES') : null;
          const fecha2 = materiaData.fecha2 ? new Date(materiaData.fecha2).toLocaleDateString('es-ES') : null;
          const fechaInscripcion = materiaData.fechaInscripcion ? new Date(materiaData.fecha_inscripcion).toLocaleDateString('es-ES') : null;

          const esRegular = regularidad(promedio, porcentajeAsistencia);

          if (esRegular) {
            if (fechaInscripcion) {
              return `
                <tr>
                  <td class="campoMateria">${materiaData.Materia}</td>
                  <td class="d-flex justify-content-center align-items-center">
                    <p class="successMessage me-2">Inscripto el ${fechaInscripcion}</p>
                    <button class="btn btn-secondary pdfButton" onclick="location.href='InscrCompletaExam.php'">PDF</button>
                  </td>
                </tr>`;
            } else {
              return `
                <tr>
                  <td class="campoMateria">${materiaData.Materia}</td>
                  <td class="d-flex justify-content-center align-items-center">
                    <button type="button" onclick="inscripcion('fecha1', this);" class="btn btn-primary confirmButtonA me-2" ${!fecha1 ? 'disabled' : ''}>
                      ${fecha1 ? fecha1 : 'Fecha no cargada'}
                    </button>
                    <button type="button" onclick="inscripcion('fecha2', this);" class="btn btn-primary confirmButtonB me-2" ${!fecha2 ? 'disabled' : ''}>
                      ${fecha2 ? fecha2 : 'Fecha no cargada'}
                    </button>
                    <p class="successMessage me-2 hidden">Inscripto el ${new Date().toLocaleDateString('es-ES')}</p>
                    <button class="btn btn-secondary pdfButton hidden" onclick="location.href='InscrCompletaExam.php'">PDF</button>
                  </td>
                </tr>`;
            }
          } else {
            return `
              <tr>
                <td class="campoMateria not-regular">${materiaData.Materia} (No Regular)</td>
                <td class="centrarCol">Materia no regular</td>
              </tr>`;
          }
        }).join('');
      }

      const tbody = document.querySelector('.materias');
      tbody.innerHTML = generarHTML(materias);

    });

    function inscripcion(tipo, clickedButton) {
      const row = clickedButton.closest('tr');
      const materia = row.querySelector('.campoMateria').innerText;

      fetch('guardar_inscripcion.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `materia=${encodeURIComponent(materia)}&tipo=${encodeURIComponent(tipo)}`
        })
        .then(response => response.text())
        .then(data => {
          row.querySelector('.confirmButtonA').classList.add('hidden');
          row.querySelector('.confirmButtonB').classList.add('hidden');
          row.querySelector('.successMessage').classList.remove('hidden');
          row.querySelector('.pdfButton').classList.remove('hidden');
        });
    }
  </script>
  <?php include('../includes/pie.php') ?>
</body>

</html>