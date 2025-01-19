<?php

include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);


include("../includes/encabezado.php");
$ok = $_GET['ok'];
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
?>

<title>SITMDM-Usuario creado</title>

<body class="hidden-sn mdb-skin">

    <div class="container-fluid">
        <?php
        include("direcMenuNav.php");
        ?>
    </div>

    <main>
        <div class="container mt-5">
            <div class="container card text-center">
                <div class="card-body">
                    <?php
                    if (isset($_GET['ok']) && $_GET['ok'] == 'true') {
                        ?>
                        <div class="card-header">Docente / Preceptor creado correctamente</div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>Nombre y Apellido: <span><?= $nombre . " " . $apellido ?></span></p>
                                <footer class="blockquote-footer">SITMDM</footer>
                            </blockquote>
                        </div>
                        <?php
                    } else if (isset($_GET['ok']) && $_GET['ok'] == 'false') {
                        ?>
                            <div class="card-header">Error al cargar el usuario</div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <p>X</p>
                                    <footer class="blockquote-footer">SITMDM</footer>
                                </blockquote>
                            </div>
                        <?php
                    } else {
                        ?>
                            <div class="card-header">Error al cargar el usuario</div>
                            <div class="card-body">
                                <blockquote class="blockquote mb-0">
                                    <p>ERROR</p>
                                    <footer class="blockquote-footer">SITMDM</footer>
                                </blockquote>
                            </div>
                        <?php
                    }
                    ?>
                </div>
                <div>
                    <a href="inicioDirec.php" class="btn btn-primary">Ir al inicio</a>
                </div>
            </div>
        </div>

    </main>

    <?php
    include("../includes/pie.php");
    ?>
</body>

</html>
<?php
