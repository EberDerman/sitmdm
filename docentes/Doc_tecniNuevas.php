<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include("../includes/sesion.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Tecnicatura</title>
    <script>
        function showAlert(message) {
            alert(message);
        }

        function borrarCaps(element) {          
            window.location.href = "doc_tec_eliminar.php?id=" + element.id;           
        }
    </script>
</head>
<body class="hidden-sn mdb-skin">
  <main>
  
      <?php
      include ("docMenuNav.php");
      ?>
   
    <div class="container card text-center my-3 px-0">
      <form method="POST" enctype="multipart/form-data">
        <div class="card-body">
          <div class="form-header bgRosa w-max-content">
            <h3 class="font-weight-200 text-white"><i class="fas fa-user"></i> Ingresar tecnicatura</h3>
          </div>
          <div class="row align-items-center">
            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="nombre" name="nombre" placeholder="" type="text" class="form-control" required autofocus>
                <label for="nombre" class="active">Nombre</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="resolucion" name="resolucion" placeholder="" type="text" class="form-control" required autofocus>
                <label for="nombre" class="active">Resolución</label>
              </div>
            </div>

            <div class="col-md-8 col-sm-8">
              <div class="md-form md-outline">
                <input id="ciclo" name="ciclo" placeholder="" type="text" class="form-control" required autofocus>
                <label for="ciclo" class="active">Ciclo Lectivo</label>
              </div>
            </div>
          </div>
          <button type="submit" name="Guardar" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>

    <?php
    // Consulta para obtener los datos de la tabla tecnicaturas
    $sql = "SELECT id_Tecnicatura, nombreTec, Resolucion, Ciclo, EstadoTec, FechaModificacion FROM tecnicaturas";
    $result = $conexion->query($sql);
    
    if (isset($_POST['Guardar'])) {
      // Variables
      $nombre = $_POST['nombre'];
      $resolucion = $_POST['resolucion'];
      $ciclo = $_POST['ciclo'];

      // Función para guardar en la tabla 'tecnicaturas'
      $sql = "INSERT INTO tecnicaturas (nombreTec, Resolucion, Ciclo) VALUES (?, ?, ?)";
      $stmt = $conexion->prepare($sql);
      $stmt->bind_param('sss', $nombre, $resolucion, $ciclo);

      if ($stmt->execute()) {
          echo "<script>showAlert('Los datos fueron guardados correctamente.'); window.location.href = 'Doc_tecniNuevas.php';</script>";
      } else {
          echo "<script>showAlert('Error al guardar los datos.');</script>";
      }
    }
    ?>

    <div class="container card text-center my-3 px-0">
      <h4 class="card-header primary-color-dark white-text">Búsqueda de Técnicas</h4>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0" width="100%">
            <thead>
              <tr>
                <td>ID</td>
                <td>Nombre</td>
                <td>Resolución</td>
                <td>Ciclo</td>
                <td>Estado</td>
                <td>Fecha de Modificación</td>
                <td>Acciones</td>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = $result->fetch_assoc()) {
                  $id_Tecnicatura = $row['id_Tecnicatura'];
                  ?>
                  <tr>
                    <td><?php echo $row['id_Tecnicatura']; ?></td>
                    <td><?php echo $row['nombreTec']; ?></td>
                    <td><?php echo $row['Resolucion']; ?></td>
                    <td><?php echo $row['Ciclo']; ?></td>
                    <td><?php echo $row['EstadoTec']; ?></td>
                    <td><?php echo $row['FechaModificacion']; ?></td>
                    <td>
                      <a style='color: #55acee' href='doc_tec_editar.php?id=<?php echo $id_Tecnicatura; ?>'><i class='far fa-edit fa-lg' title='Modificar'></i></a>
                      <a style='color: #007bff' href='ver_materias.php?id=<?php echo $id_Tecnicatura; ?>'><i class='fas fa-book fa-lg' title='Ver Materias'></i></a>
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

  <script>
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
  </script>
</body>
</html>
