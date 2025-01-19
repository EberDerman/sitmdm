<?php
include("../includes/sesion.php");

$id_estudiante = getIdUsuarioSeguridad(); // Recupera el ID del estudiante
checkAccess([6], $id_estudiante); // Rol: 6, ID debe coincidir con el estudiante

include("../includes/encabezado.php");
include("../sql/conexion.php");
?>
<!DOCTYPE html>
<html lang="es">

<body class="hidden-sn mdb-skin" >

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
      <?php

            include ("menuEstudiante.php");

        ?>
      </div>
      <?php

include ("../includes/paginaInicio.php");

?>
    </main>
    <!-- Main layout -->

    <?php
    include("../includes/pie.php");
    ?>
    <!-- Footer -->

    <!-- SCRIPTS -->

<script src="../assets/js/inicializacionSidear.js"></script>
<script src="../assets/js/charts.js"></script>

    </body>

    </html>
