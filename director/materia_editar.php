<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);

include("../includes/encabezado.php");
include("../sql/conexion.php");

$id_Tecnicatura = $_GET['id'];
    // Consulta para obtener el nombre de la tecnicatura
    $sql = "SELECT nombreTec FROM tecnicaturas WHERE id_Tecnicatura = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $id_Tecnicatura);
    $stmt->execute();
    $stmt->bind_result($nombreTec);
    $stmt->fetch();
    $stmt->close();



// Verificar si se ha enviado el ID del registro
if (isset($_GET['id'])) {
  $id = $_GET['id'];


  // Verificar si se han enviado los datos del formulario para actualizar el registro
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $materia = $_POST['materia'];
      $anioCursada = $_POST['anioCursada'];
      $horas = $_POST['horas'];
      $idTec = $_POST['idTec'];
      $estado = intval($_POST['estado']);


      // Preparar y ejecutar la consulta de actualización
      $stmt = $conexion->prepare("UPDATE materias SET Materia = ?, AnioCursada = ?, Horas = ?, idTec = ?, Estado = ? WHERE id_Materia = ?");
      $stmt->bind_param("ssiisi", $materia, $anioCursada, $horas, $idTec, $estado, $id);

      if ($stmt->execute()) {
          echo "<script>alert('Registro actualizado exitosamente'); window.location.href = 'ver_materias.php?id=$idTec';</script>";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  } else {
      // Recuperar los datos del registro seleccionado
      $stmt = $conexion->prepare("SELECT Materia, AnioCursada, Horas, Estado, idTec FROM materias WHERE id_Materia = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt->bind_result($materia, $anioCursada, $horas, $estado, $idTec);
      $stmt->fetch();
      $stmt->close();
  }
} else {
  echo "ID de registro no especificado.";
  exit;
}




$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar materia</title>
  <script>
      function showAlert(message) {
          alert(message);
      }
  </script>
</head>
<body class="hidden-sn mdb-skin">
<main>
  <div class="container card text-center my-3 px-0">
    <form action="" method="post">
      <div class="card-body">
        <div class="form-header bgRosa w-max-content">
          <h3 class="font-weight-200 text-white"><i class="fas fa-user"></i> Editar Materia</h3>
        </div>
        <div class="row align-items-center">
          <div class="col-md-8 col-sm-8">
            <div class="md-form md-outline">
              <input id="idMateria" name="idMateria" type="text" class="form-control" value="<?php echo $nombreTec; ?>" readonly required>
              <label for="idMateria" class="active">Tecnicatura:</label>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
            <div class="md-form md-outline">
              <input id="idTec" name="idTec" type="text" class="form-control" value="<?php echo $idTec; ?>" readonly required>
              <label for="idTec" class="active">ID Tecnicatura:</label>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
            <div class="md-form md-outline">
              <input id="materia" name="materia" type="text" class="form-control" value="<?php echo $materia; ?>" required autofocus>
              <label for="materia" class="active">Materia:</label>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
            <label for="anioCursada" class="active">Año de Cursada:</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="anioCursada" id="anioPrimero" value="Primero" <?php echo ($anioCursada == 'Primero') ? 'checked' : ''; ?> required>
              <label class="form-check-label" for="anioPrimero">Primero</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="anioCursada" id="anioSegundo" value="Segundo" <?php echo ($anioCursada == 'Segundo') ? 'checked' : ''; ?> required>
              <label class="form-check-label" for="anioSegundo">Segundo</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="anioCursada" id="anioTercero" value="Tercero" <?php echo ($anioCursada == 'Tercero') ? 'checked' : ''; ?> required>
              <label class="form-check-label" for="anioTercero">Tercero</label>
            </div>
          </div>  
          <div class="col-md-8 col-sm-8">
            </div>
          <div class="col-md-8 col-sm-8">
            <div class="md-form md-outline">
              <input id="horas" name="horas" type="number" class="form-control" value="<?php echo $horas; ?>" required>
              <label for="horas" class="active">Horas Semanales:</label>
            </div>
          </div>
          <div class="col-md-8 col-sm-8">
          <label for="estado" class="active">Estado:</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="estadoActivo" value="1" <?php echo ($estado == 1) ? 'checked' : ''; ?> required>
            <label class="form-check-label" for="estadoActivo">Activo</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estado" id="estadoInactivo" value="0" <?php echo ($estado == 0) ? 'checked' : ''; ?> required>
            <label class="form-check-label" for="estadoInactivo">Inactivo</label>
          </div>
        </div>
        </div>
        <button type="submit" name="Guardar" class="btn btn-primary">ACTUALIZAR</button>          
      </div>
    </form>
    <div class="col-md-12 col-sm-0">
    <button class="btn btn-primary" onclick="window.location.href='ver_materias.php?id=<?php echo $idTec; ?>';">VOLVER</button>
  </div>
  </div>
</body>
</html>