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

<header>
  <!-- Sidebar navigation -->
  <div id="slide-out" class="side-nav">
    <ul class="custom-scrollbar">
      <li>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a href="inicioDirec.php" class="waves-effect"><i class="fas fa-user"></i>Menu Director</a>
          </li>
          <li>
            <a href="direcDoc.php" class="waves-effect"><i class="far fa-user"></i>Docentes</a>
          </li>
          <li>
            <a href="direcPrecep.php" class="waves-effect"><i class="far fa-user"></i>Preceptores</a>
          </li>
          <li>
            <a href="Doc_tecniNuevas.php" class="waves-effect"><i class="fas fa-book"></i>Tecnicaturas</a>
          </li>
          <li>
            <a href="finales.php" class="waves-effect"><i class="far fa-calendar-alt"></i>Fecha de Finales</a>
          </li>
          <li>
            <a href="certificadoSolici.php" class="waves-effect"><i class="fas fa-book"></i>Certificados</a>
          </li>
          <li>
            <a href="direcFormPersona.php" class="waves-effect"><i class="fas fa-user-plus"></i>Crear
              Docente/Preceptor</a>
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
        <a class="nav-link" href="inicioDirec.php">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="direcDoc.php">Docentes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="direcPrecep.php">Preceptores</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Doc_tecniNuevas.php">Tecnicaturas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="finales.php">Fecha de Finales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="certificadoSolici.php">Certificados</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="direcFormPersona.php">Crear Docente/Preceptor</a>
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