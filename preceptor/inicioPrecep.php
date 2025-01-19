<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);
include("../includes/encabezado.php");
include("../sql/conexion.php");

?>

<title>SITMDM-Inicio</title>
</head>

<body class="hidden-sn mdb-skin">

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
      <?php
      include("precepMenuNav.php");
    
      ?>
    </div>
    <?php

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