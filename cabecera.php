<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="index.html" class="logo d-flex align-items-center me-auto">
      <img src="assets/img/logo.png" alt="">
      <h1 class="sitename">Inventarios ISTMS</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="index.php" class="active">Inicio</a></li>
        <li class="dropdown"><a href="#"><span>Ficheros</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="add_marca.php">Marca</a></li>
            <li><a href="add_estado.php">Estado</a></li>
            <li><a href="add_modelo.php">Modelo</a></li>
            <li><a href="registrar_ubicacion_add.php">Ubicación</a></li>
            <li><a href="registrar_docente_add.php">Docente</a></li>
            <li class="dropdown"><a href="#"><span>Artículo</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
              <ul>
                <li><a href="add_tarticulo.php">Tipo de Equipo</a></li>
                <li><a href="articulo.php">Adminstrar Equipos</a></li>
                <li><a href="asignar_mantenimiento_add.php">Mantenimiento de equipo</a></li>


              </ul>
            </li>
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>Inventario</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="inventario_add.php">Inventario</a></li>
            <li><a href="asignar_inventario_addJQ.php">Asignar inventario</a></li>

          </ul>
        </li>
        <li><a href="index.html#contact">Contacto</a></li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    <div class="d-flex align-items-center gap-2">
      <a class="btn-getstarted" href="index.html#about">
        <?php
        if (!isset($_SESSION['usuario'])) {
        } else {
          echo $_SESSION['usuario']->getNombre();
        }
        ?>
      </a>
      <a class="btn btn-danger rounded-pill m-2" onClick="return confirm('¿ Seguro que quiere cerrar seciòn ?');" href="controller_login.php?accion=CERRARCESION" class="btn btn-danger"><span class="icon-off">Cerrar Sesión</span></a>
    </div>

  </div>
</header>