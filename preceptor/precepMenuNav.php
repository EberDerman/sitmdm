<style>
  body {
    background-color: #f8f9fa;
  }

  .card {
    border-radius: 20px;
  }

  table th,
  table td {
    text-align: center;
    vertical-align: middle;
  }

  button {
    border-radius: 5px;
  }

  .side-nav {
    position: fixed;
    width: 250px;
    height: 100%;
    background: #333;
    color: #fff;
    transition: transform 0.3s ease;
    transform: translateX(-100%);
  }

  .side-nav.open {
    transform: translateX(0);
  }

  .dropdown-menu {
    display: none;
  }

  .dropdown-menu.show {
    display: block;
  }
</style>
</head>

<body>
  <header>
    <!-- Sidebar navigation -->
    <div id="slide-out" class="side-nav">
      <ul class="custom-scrollbar">
        <li>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a href="inicioPrecep.php" class="waves-effect"><i class="fas fa-user"></i>Menu Preceptor</a>
            </li>
            <li>
              <a href="precepEstudiantes.php" class="waves-effect"><i class="far fa-user"></i>Listado de Estudiantes</a>
            </li>
            <li>
              <a href="precepPreinscripciones.php" class="waves-effect"><i
                  class="fas fa-user-plus"></i>Preinscripciones</a>
            </li>
            <li>
              <a href="precepSiguiente.php" class="waves-effect"><i class="fas fa-user-plus"></i>Asignar regularidad</a>
            </li>
            <li>
              <a href="../noticias/public/index.php" class="waves-effect"><i class="fas fa-user-plus"></i>Crear
                Noticias</a>
            </li>
          </ul>
        </li>
      </ul>
      <div class="sidenav-bg mask-strong"></div>
    </div>
    <!-- Sidebar navigation -->

    <!-- Navbar -->
    <nav class="navbar fixed-top navbar-toggleable-md navbar-expand-lg scrolling-navbar double-nav">
      <!-- SideNav slide-out button -->
      <div class="float-left">
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
      </div>
      <!-- Breadcrumb-->
      <div class="breadcrumb-dn mr-auto">
        <div class="mx-3">
          <img src="../assets/img/logo/sitmdm_icono_nav.webp" alt="Logo SITMDM">
        </div>
      </div>
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="inicioPrecep.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="precepEstudiantes.php">Listado de Estudiantes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="precepPreinscripciones.php">Preinscripciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="precepSiguiente.php">Asignar Regularidad</a>
        </li>
      </ul>
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i>
            <?php echo $_SESSION['usuario']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.Navbar -->
  </header>