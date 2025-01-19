<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../includes/encabezado.php");
include("../sql/conexion.php");
include("../sql/TecnicaturaRepository.php");
include("precepMenuNav.php");
$tecnicaturaRepository = new TecnicaturaRepository();
$tecnicaturasPreinscripcion = $tecnicaturaRepository->getTecnicaturasInscripcion();
?>

<title>Gestion de preinscriptos</title>
</head>

<body class="hidden-sn mdb-skin">
  <main>

    <div class="container card text-center my-3 px-0">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4"
        style="border-radius: 8px;">
        <h4 class="mb-0">Preinscripciones a nuevas tecnicaturas</h4>
        <div>
          <button class="btn btn-primary" onclick="window.location.href='inicioPrecep.php'">VOLVER</button>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered table-hover table-striped display AllDataTables" cellspacing="0"
            width="100%">
            <thead>
              <tr>
                <td>Nombre</td>
                <td>Ciclo</td>
                <td>Acciones</td>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($tecnicaturasPreinscripcion as $row) {
                $id_Tecnicatura = $row['id_Tecnicatura'];
                ?>
                <tr>
                  <td><?php echo $nombreTec = $row['nombreTec']; ?></td>
                  <td><?php echo $Ciclo = $row['Ciclo']; ?></td>
                  <td>
                    <a style='color: #55acee'
                      href='precepPreinscripcionesVer.php?id_Tecnicatura=<?= $id_Tecnicatura ?>&nombreTec=<?= $nombreTec ?>&Ciclo=<?= $Ciclo ?>'
                      title='Ver Estudiantes'>
                      <i class='fas fa-plus fa-lg'></i>
                    </a>
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