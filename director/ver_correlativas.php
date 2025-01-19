<?php

include("../includes/sesion.php");

$id_director = getIdUsuario();
checkAccess([$id_director, 3]);
include("../includes/encabezado.php");
include("../sql/conexion.php");
include("direcMenuNav.php");

// Obtener el id_Materia del parámetro de la URL
$id_Materia = $_GET['id'];

// Consulta para obtener los detalles de la materia actual
$sql = "SELECT Materia, IdTec FROM materias WHERE id_Materia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_Materia);
$stmt->execute();
$stmt->bind_result($Materia, $IdTec);
$stmt->fetch();
$stmt->close();

// Consulta para obtener todas las materias para el dropdown, excluyendo la materia actual
$sqlMaterias = "SELECT id_Materia, Materia FROM materias WHERE IdTec = ? AND id_Materia != ?";
$stmtMaterias = $conexion->prepare($sqlMaterias);
$stmtMaterias->bind_param('ii', $IdTec, $id_Materia); // Excluir la materia actual
$stmtMaterias->execute();
$resultMaterias = $stmtMaterias->get_result();

// Consulta para obtener las correlativas
$sqlCorrelativas = "SELECT c.idCorrelativas, m1.Materia AS MateriaBase, m2.Materia AS Correlativa 
                    FROM correlativas c 
                    JOIN materias m1 ON c.idMateria = m1.id_Materia 
                    JOIN materias m2 ON c.idCorrelativas = m2.id_Materia 
                    WHERE c.idTec = ?";
$stmtCorrelativas = $conexion->prepare($sqlCorrelativas);
$stmtCorrelativas->bind_param('i', $IdTec);
$stmtCorrelativas->execute();
$resultCorrelativas = $stmtCorrelativas->get_result();

// Procesar formulario al enviar (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Guardar'])) {
  // Capturar el idMateria y las correlativas seleccionadas
  $idMateria = $_POST['idMateria'];
  $correlativas = $_POST['correlativas']; // Esto es un array

  // Validar que se haya seleccionado al menos una correlativa
  if (!empty($correlativas)) {
      foreach ($correlativas as $correlativa) {
          // Verificar si ya existe la correlativa en la base de datos
          $sqlCheck = "SELECT COUNT(*) FROM correlativas WHERE idMateria = ? AND idCorrelativas = ?";
          $stmtCheck = $conexion->prepare($sqlCheck);
          $stmtCheck->bind_param('ii', $idMateria, $correlativa);
          $stmtCheck->execute();
          $stmtCheck->bind_result($count);
          $stmtCheck->fetch();
          $stmtCheck->close();

          // Si no existe, insertar la correlativa
          if ($count == 0) {
              $sqlInsert = "INSERT INTO correlativas (idMateria, idCorrelativas, idTec) VALUES (?, ?, ?)";
              $stmtInsert = $conexion->prepare($sqlInsert);
              $stmtInsert->bind_param('iii', $idMateria, $correlativa, $IdTec);
              $stmtInsert->execute();
              $stmtInsert->close();
          } else {
              echo "<script>alert('La correlativa ya está registrada.');</script>";
          }
      }
      echo "<script>alert('Correlativas guardadas correctamente.');</script>";
      // Redirigir a la misma página para actualizar la lista de correlativas
      echo "<script>window.location.href = window.location.href;</script>";
  } else {
      echo "<script>alert('Debe seleccionar al menos una correlativa.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Correlativas</title>
    <script>
        function showAlert(message) {
            alert(message);
        }

        function eliminarCorrelativa(idCorrelativa) {
            if (confirm('¿Estás seguro de eliminar esta correlativa?')) {
                $.ajax({
                    url: 'eliminar_correlativa.php',
                    method: 'POST',
                    data: { idCorrelativa: idCorrelativa },
                    success: function(response) {
                        showAlert('Correlativa eliminada correctamente.');
                        window.location.reload();
                    },
                    error: function() {
                        showAlert('Error al eliminar la correlativa.');
                    }
                });
            }
        }
    </script>
</head>
<body class="hidden-sn mdb-skin">
  <main>
    <div class="container card text-center my-3 px-0">
      <form method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-header bgRosa w-max-content">
            <h3 class="font-weight-200 text-white"><i class="fas fa-book-open"></i> Ingresar Correlativas</h3>
          </div>
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="idMateria" name="idMateria" type="text" class="form-control" value="<?php echo $id_Materia; ?>" readonly>
                <label for="idMateria" class="active">ID Materia</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="Materia" name="Materia" type="text" class="form-control" value="<?php echo $Materia; ?>" disabled>
                <label for="Materia" class="active">Materia</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="IdTec" name="IdTec" type="text" class="form-control" value="<?php echo $IdTec; ?>" readonly>
                <label for="IdTec" class="active">ID Tecnicatura</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div id="selectContainer" class="md-form md-outline">
                <select name="correlativas[]" class="materias-select mdb-select colorful-select dropdown-primary md-form" required multiple>
                  <option value="" disabled selected>Seleccionar Correlativa</option>
                  <?php
                  // Mostrar solo materias que no sean la actual
                  while ($row = $resultMaterias->fetch_assoc()) {
                      echo '<option value="' . $row['id_Materia'] . '">' . $row['Materia'] . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
      <div class="col-md-12 col-sm-0">
        <button class="btn btn-primary" onclick="window.location.href='ver_materias.php?id=<?php echo $IdTec; ?>';">VOLVER</button>
      </div>
    </div>

    <div class="container card text-center my-3 px-0">
      <h4 class="card-header primary-color-dark white-text">Correlativas</h4>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>ID Correlativa</th>
                <th>Materia</th>
                <th>Correlativa</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = $resultCorrelativas->fetch_assoc()) {
                  $id_Correlativa = $row['idCorrelativas'];
                  ?>
                  <tr>
                    <td><?php echo $row['idCorrelativas']; ?></td>
                    <td><?php echo $row['MateriaBase']; ?></td>
                    <td><?php echo $row['Correlativa']; ?></td>
                    <td>
                      <a style='color: #ff4500' href='javascript:void(0);' onclick='eliminarCorrelativa(<?php echo $id_Correlativa; ?>)'><i class='far fa-trash-alt fa-lg' title='Eliminar'></i></a>
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
</body>
</html>
