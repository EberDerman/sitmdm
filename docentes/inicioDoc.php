<?php
include("../includes/sesion.php");

$id_docente = getIdUsuarioSeguridad();
checkAccess([5], $id_docente);

include("../includes/encabezado.php");
include("../sql/conexion.php");

?>

<title>SITMDM-Inicio</title>
</head>

<body class="hidden-sn mdb-skin">

  <!-- Main layout -->
  <main>
    <?php
    include("docMenuNav.php");
    include("../includes/paginaInicio.php");

    ?>

  </main>
  <!-- Main layout -->

  <?php
  include("../includes/pie.php");
  ?>
  <!-- Footer -->


</body>

</html>