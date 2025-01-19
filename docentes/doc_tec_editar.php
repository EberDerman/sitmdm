<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");

// Crear conexión
$conn = new mysqli($servername, $username, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si se han enviado los datos del formulario para actualizar el registro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST['nombre'];
        $resolucion = $_POST['resolucion'];
        $ciclo = $_POST['ciclo'];
        $estado = $_POST['estado']; // Captura el valor del estado

        // Preparar y ejecutar la consulta de actualización
        $stmt = $conn->prepare("UPDATE tecnicaturas SET nombreTec = ?, Resolucion = ?, Ciclo = ?, EstadoTec = ? WHERE id_Tecnicatura = ?");
        $stmt->bind_param("sssii", $nombre, $resolucion, $ciclo, $estado, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Registro actualizado exitosamente'); window.location.href = 'Doc_tecniNuevas.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Recuperar los datos del registro seleccionado
        $stmt = $conn->prepare("SELECT nombreTec, Resolucion, Ciclo, EstadoTec FROM tecnicaturas WHERE id_Tecnicatura = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nombre, $resolucion, $ciclo, $estado);
        $stmt->fetch();
        $stmt->close();
    }
} else {
    echo "ID de registro no especificado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tecnicatura</title>
</head>
<body class="hidden-sn mdb-skin">
  <main>
    <div class="container card text-center my-3 px-0">
      <form action="" method="post">
        <div class="card-body">
          <div class="form-header bgRosa w-max-content">
            <h3 class="font-weight-200 text-white"><i class="fas fa-user"></i> Editar Tecnicatura</h3>
          </div>
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
              <input id="id" name="id" type="text" class="form-control" value="<?php echo $id; ?>" disabled required autofocus>
                <label for="id" class="active">ID</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="nombre" name="nombre" type="text" class="form-control" value="<?php echo $nombre; ?>" required autofocus>
                <label for="nombre" class="active">Nombre:</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="resolucion" name="resolucion" type="text" class="form-control" value="<?php echo $resolucion; ?>" required autofocus>
                <label for="resolucion" class="active">Resolución:</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="ciclo" name="ciclo" type="text" class="form-control" value="<?php echo $ciclo; ?>" required autofocus>
                <label for="ciclo" class="active">Ciclo:</label>
              </div>
            </div>
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <label class="active">Estado:</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estado" id="estado0" value="0" <?php if ($estado == 0) echo 'checked'; ?>>
                  <label class="form-check-label" for="estado0">inactivo</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="estado" id="estado1" value="1" <?php if ($estado == 1) echo 'checked'; ?>>
                  <label class="form-check-label" for="estado1">activo</label>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="Guardar" class="btn btn-primary">ACTUALIZAR</button>          
        </div>
      </form>
      <div class="col-md-12 col-sm-0">
        <button class="btn btn-primary" onclick="window.location.href='Doc_tecniNuevas.php';">VOLVER</button>
      </div>
    </div>
</body>
</html>
