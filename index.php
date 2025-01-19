<?php
include("includes/sesion.php");
include("sql/conexion.php");
$usuario = $pass = "";
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>SITMDM</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/mdb.min.css">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="assets/js/popper.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/mdb.min.js"></script>

  <script>
    $('.carousel.carousel-multi-item.v-2 .carousel-item').each(function() {
      var next = $(this).next();
      if (!next.length) {
        next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().appendTo($(this));

      for (var i = 0; i < 4; i++) {
        next = next.next();
        if (!next.length) {
          next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));
      }
    });

    function moveLabel(element) {
      $(element).siblings('label').addClass('active');
    }
  </script>
  <style>
    html,
    body,
    header,
    .view {
      height: 100%;
    }

    .pyproductos {
      padding-top: 90px;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body class="landing-page">
  <header>
    <section class="view">
      <div class="mask rgba-stylish-strong d-flex justify-content-center align-items-center" style="background-image: url(img/principal.jpg); background-repeat: no-repeat; background-size: cover">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">
              <form method='post'>
                <div class="card wow fadeInRight" data-wow-delay="0.3s">
                  <div class="card-body">
                    <div class="text-center">
                      <h3 class="white-text"><i class="fas fa-user white-text"></i> Ingreso Sistema</h3>
                      <hr class="hr-light">
                    </div>
                    <div class="md-form">
                      <i class="fas fa-user prefix white-text"></i>
                      <input type="text" id="form3" autocomplete="off" onclick="moveLabel(this)" onkeyup='moveLabel(this)' class="form-control text-white" name="usuario">
                      <label for="form3" class="text-white">Usuario</label>
                    </div>
                    <div class="md-form">
                      <i class="fas fa-lock prefix white-text"></i>
                      <input type="password" id="form4" autocomplete="off" onclick="moveLabel(this)" onkeyup="moveLabel(this)" class="form-control text-white" name="contrasenia">
                      <label for="form4" class="text-white"><b>Contraseña</b></label>
                      <span toggle="#form4" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; right: 10px; top: 10px; cursor: pointer;"></span>
                    </div>
                    <div class="text-center mt-4">
                      <input type="submit" class="btn btn-light-blue btn-rounded" name="ingresar" value="Ingresar"></Input>
                    </div>
                  </div>
                </div>
              </form>

              <!-- PHP para procesar el ingreso -->
              <?php
              if ((isset($_POST['ingresar'])) and ($_POST['usuario'] != "")) {
                $usuario = $_POST["usuario"];
                $pass = $_POST["contrasenia"];

                $result = mysqli_query($conexion, "SELECT idUsuario,usuario, contrasenia, codRol, Estado
                  FROM usuarios WHERE usuario like '$usuario' and contrasenia like '$pass' ");

                $row_cnt = mysqli_num_rows($result);

                if ($row_cnt == 1) {

                  while ($busqueda = mysqli_fetch_array($result)) {
                    $usuario = $busqueda['usuario'];
                    $clave = $busqueda['contrasenia'];
                    $codRol = $busqueda['codRol'];
                    $idUsuario = $busqueda['idUsuario'];
                    $Estado = $busqueda['Estado'];
                  }

                  mysqli_free_result($result);
                  $_SESSION['usuario'] = $usuario;
                  $_SESSION['clave'] = $clave;
                  $_SESSION['codRol'] = $codRol;
                  $_SESSION['idUsuario'] = $idUsuario;
                  $_SESSION['Estado'] = $Estado;

                  if ($codRol == 1 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='inicioAdmin.php';";
                    echo "</script>";
                  } elseif ($codRol == 2 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='index.php';";
                    echo "</script>";
                  } elseif ($codRol == 3 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='director/inicioDirec.php';";
                    echo "</script>";
                  } elseif ($codRol == 4 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='preceptor/inicioPrecep.php';";
                    echo "</script>";
                  } elseif ($codRol == 5 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='docentes/inicioDoc.php';";
                    echo "</script>";
                  } elseif ($codRol == 6 && $Estado == 1) {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='estudiante/seleccionar_tecnicatura.php';";
                    echo "</script>";
                  } else {
                    echo "<script languaje= 'javascript'>";
                    echo "window.location.href='index.php';";
                    echo "alert ('El usuario o la clave no son validas')";
                    echo "</script>";
                  }
                } else {
                  echo "<script languaje= 'javascript'>";
                  echo "alert ('El usuario o la clave no son validas')";
                  echo "window.location.href='index.php';";
                  echo "</script>";
                }
              }

              mysqli_close($conexion);
              ?>
              <!-- /.Fin del procesamiento de ingreso -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>

  <script>
    $(document).ready(function() {
      $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
    });
  </script>
</body>

</html>