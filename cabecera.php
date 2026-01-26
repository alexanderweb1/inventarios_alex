<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="index.html" class="logo d-flex align-items-center me-auto">
      <img src="assets/img/logo1.png" alt="">
      <h1 class="sitename">ISTMS</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="index.php" class="active">Inicio</a></li>
        <!-- marcas -->
        <li class="dropdown"><a href="#"><span>Ficheros</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="add_marca.php">Marca</a></li>
            <li><a href="add_estado.php">Estado</a></li>
            <li><a href="add_modelo.php">Modelo</a></li>
            <li><a href="add_ubica.php">Ubicación</a></li>
            <li><a href="asignar_mantenimiento_add.php">Mantenimiento</a></li>
            <li class="dropdown"><a href="#"><span>Artículos</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="#">Tipo de artículo</a></li>
                <li><a href="registrar_articulo_add.php">Administrar Articulo</a></li>
              </ul>
            </li>
          </ul>
        </li>

        <!-- inventarios -->
        <li class="dropdown"><a href="#"><span>inventario</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="add_marca.php">inventario</a></li>
            <li><a href="asignar_inventario_add.php">Asignar inventario</a></li>
          </ul>
        </li>

        <li><a href="index.html#contact">Contacto</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    <div class="d-flex align-items-center gap-2">
      <a class="btn-getstarted" href="index.html#about">
        <?php echo $_SESSION['usuario']->getNombre();
        ?>
      </a>
      <a onclick=" return confirm('Seguro que quiere cerrar sesión ?')" href="controller_login.php?accion=CERRARCESION" class="btn btn-danger rounded-pill">Cerrar Sesión</a>
    </div>
  </div>
</header>