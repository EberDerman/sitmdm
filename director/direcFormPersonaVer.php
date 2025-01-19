<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);



$id_Persona = $_REQUEST['id_Persona'];
include("../sql/conexion.php");
include("../sql/mostrarPersonas.php");
include("../includes/encabezado.php");


?>
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<title>SITMDM-Mostrar persona</title>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php
        include("direcMenuNav.php");
        ?>
    </div>

    <main>
        <?php
        include("./formulario_persona/formularioVer.php");
        ?>

    </main>

    <?php
    include("../includes/pie.php");
    ?>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="./formulario_persona/formulario.js"></script>

</body>

</html>