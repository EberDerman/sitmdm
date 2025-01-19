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

  .navbar {
    background-color: #243A51 !important;
  }

  .side-nav {
    position: fixed;
    width: 250px;
    height: 100%;
    background: #243A51;
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

            <?php
            $codRol = isset($_SESSION['codRol']) ? $_SESSION['codRol'] : null;

            if ($codRol == 3) { ?>
              <li>
                <a href="../../director/inicioDirec.php" class="waves-effect"><i class="fas fa-user"></i>Inicio</a>
              </li>
            <?php
            } elseif ($codRol == 4) { ?>
              <li>
                <a href="../../preceptor/InicioPrecep.php" class="waves-effect"><i class="fas fa-user"></i>Inicio</a>
              </li>
            <?php
            }
            ?>

            <li>
              <a href="../public/index.php" class="waves-effect"><i class="far fa-chart-bar"></i>Vista Noticias</a>
            </li>
            <li>
              <a href="../news/add_news.php" class="waves-effect"><i class="far fa-user"></i>Agregar Noticia</a>
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
        <p>SITMDM</p>
      </div>
      <ul class="nav navbar-nav nav-flex-icons ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i>
            <?php echo $_SESSION['usuario']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.Navbar -->
  </header>



  <script src="../public/js/script.js"></script>