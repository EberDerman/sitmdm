<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");



// Verificar si se reciben id_estudiante e id_tecnicatura por GET
if (
  isset($_GET['id_estudiante']) && is_numeric($_GET['id_estudiante']) &&
  isset($_GET['id_Tecnicatura']) && is_numeric($_GET['id_Tecnicatura'])
) {
  $id_estudiante = intval($_GET['id_estudiante']);
  $id_tecnicatura = intval($_GET['id_Tecnicatura']);
} else {
  die("ID de estudiante o tecnicatura no válido o no proporcionado.");
}

?>

<!DOCTYPE html>
<html lang="es">

<body class="hidden-sn mdb-skin">

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
      <?php

      include("precepMenuNav.php");

      ?>
    </div>
    <?php

    include("trayectoria.php");


    ?>
  </main>
  <!-- Main layout -->

  <?php
  include("../includes/pie.php");
  ?>
  <!-- Footer -->

  <!-- SCRIPTS -->


  <!-- Initializations -->

  <script src="../assets/js/inicializacionSidear.js"></script>
  <script src="../assets/js/charts.js"></script>

</body>

</html>