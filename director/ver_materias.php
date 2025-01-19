<?php

include("../includes/sesion.php");

$id_director = getIdUsuario();
checkAccess([$id_director, 3]);


include("../includes/encabezado.php");
include("../sql/conexion.php");
include("direcMenuNav.php");

// Obtener el id_Tecnicatura del parámetro de la URL
$id_Tecnicatura = $_GET['id'];

// Consulta para obtener el nombre de la tecnicatura
$sql = "SELECT nombreTec FROM tecnicaturas WHERE id_Tecnicatura = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_Tecnicatura);
$stmt->execute();
$stmt->bind_result($nombreTec);
$stmt->fetch();
$stmt->close();
// Consulta para obtener el ciclo de la tecnicatura
$sql = "SELECT Ciclo FROM tecnicaturas WHERE id_Tecnicatura = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_Tecnicatura);
$stmt->execute();
$stmt->bind_result($Ciclo);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Materias</title>
    <style>
        .form-check-label {
            color: #000; /* Color negro más oscuro */
        }
    </style>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body class="hidden-sn mdb-skin">
  <main>
    <div class="container card text-center my-3 px-0">
      <form method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-header bgRosa w-max-content">
            <h3 class="font-weight-200 text-white"><i class="fas fa-book"></i> Ingresar Materia</h3>
          </div>
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="idTecnicatura" name="idTecnicatura" type="text" class="form-control" value="<?php echo $Ciclo; ?>" readonly>
                <label for="idTecnicatura" class="active">Ciclo Tecnicatura</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="nombreTecnicatura" name="nombreTecnicatura" type="text" class="form-control" value="<?php echo $nombreTec; ?>" disabled>
                <label for "nombreTecnicatura" class="active">Nombre Tecnicatura</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="materia" name="materia" placeholder="" type="text" class="form-control" required autofocus>
                <label for="materia" class="active">Materia</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <label for="anioCursada" class="active">Seleccionar Año de Cursada</label>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-inline mr-2">
                    <input class="form-check-input" type="radio" name="anioCursada" id="primero" value="Primero" checked>
                    <label class="form-check-label" for="primero">Primero</label>
                  </div>
                  <div class="form-check form-check-inline mr-2">
                    <input class="form-check-input" type="radio" name="anioCursada" id="segundo" value="Segundo">
                    <label class="form-check-label" for="segundo">Segundo</label>
                  </div>
                  <div class="form-check form-check-inline mr-2">
                    <input class="form-check-input" type="radio" name="anioCursada" id="tercero" value="Tercero">
                    <label class="form-check-label" for="tercero">Tercero</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Input para Horas Semanales -->
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="horasSemanales" name="horasSemanales"  type="number" class="form-control" required>
                <label for="horasSemanales" class="active">Horas Semanales</label>
              </div>
            </div>

            
          </div>
          <button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      <div class="col-md-12 col-sm-0">
        <button class="btn btn-primary" onclick="window.location.href='Doc_tecniNuevas.php';">VOLVER</button>
      </div>
    </div>

    <?php
    if (isset($_POST['Guardar'])) {
        // Variables
        $materia = $_POST['materia'];
        $anioCursada = $_POST['anioCursada'];
        $horasSemanales = $_POST['horasSemanales'];
        

        // Función para guardar en la tabla 'materias'
        $sql = "INSERT INTO materias (Materia, AnioCursada, Horas, IdTec) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('ssii', $materia, $anioCursada, $horasSemanales, $id_Tecnicatura);

        if ($stmt->execute()) {
            echo "<script>showAlert('Los datos fueron guardados correctamente.'); window.location.href = 'ver_materias.php?id=$id_Tecnicatura';</script>";
        } else {
            echo "<script>showAlert('Error al guardar los datos.');</script>";
        }
    }

    // Consulta para obtener los datos de la tabla materias
    $sql = "SELECT id_Materia, Materia, AnioCursada, Horas, Estado, FechaMod FROM materias WHERE IdTec = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_Tecnicatura);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <div class="container card text-center my-3 px-0">
      <h4 class="card-header primary-color-dark white-text">Búsqueda de Materias</h4>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>ID</td>
                <td>Materia</td>
                <td>Año de Cursada</td>
                <td>Horas Semanales</td>
                <td>Estado</td>
                <td>Fecha de Modificación</td>
                <td>Acciones</td>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = $result->fetch_assoc()) {
                  $id_Materia = $row['id_Materia'];
                  ?>
                  <tr>
                    <td><?php echo $row['id_Materia']; ?></td>
                    <td><?php echo $row['Materia']; ?></td>
                    <td><?php echo $row['AnioCursada']; ?></td>
                    <td><?php echo $row['Horas']; ?></td>
                    <td><?php echo $row['Estado']; ?></td>
                    <td><?php echo $row['FechaMod']; ?></td>
                    <td>
                      <a style='color: #55acee' href='materia_editar.php?id=<?php echo $id_Materia; ?>'><i class='far fa-edit fa-lg' title='Modificar'></i></a>
                      <a style='color: #007bff' href='ver_correlativas.php?id=<?php echo $id_Materia; ?>' title='Ver Correlativas'><i class='fas fa-link fa-lg'></i></a>
                    </td>
                  </tr>
                  <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <?php include("../includes/pie.php"); ?>

  <!-- <script>
    $(".button-collapse").sideNav();
    var container = document.querySelector('.custom-scrollbar');
    var ps = new PerfectScrollbar(container, {
      wheelSpeed: 2,
      wheelPropagation: true,
      minScrollbarLength: 20
    });

    $('.datepicker').pickadate();

    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script> -->
</body>
</html>