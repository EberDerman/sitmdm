<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);




include("../includes/encabezado.php");
include("../sql/conexion.php");

?>

<title>SITMDM-Inicio</title>
</head>

<body class="hidden-sn mdb-skin">

  <!-- Main layout -->
  <main>

    <div class="container-fluid">
  <?php include("direcMenuNav.php"); ?>
</div>

<!-- Incluir finales.php en un iframe -->
<iframe src="finales/finales.php" style="width:100%; border:none; height:100vh;"></iframe>

  </main>
  <!-- Main layout -->

  <?php
  include("../includes/pie.php");
  ?>
  <!-- Footer -->


</body>

</html>