<?php
require_once('usuario.php');
session_start();
require_once("db.php");
include_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Asignar mantenimiento</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <?php
  require_once('cabecera.php');
  ?>
  <main class="main">
    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto">
          <h1 data-aos="fade-up">Asignar <span>mantenimiento</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">a un artículo<br></p>
          <div class="card shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">
            <form id="form_mantenimiento" name="form1" method="post" action="asignar_mantenimiento_acc.php" class="text-start d-flex flex-column gap-4">

              <div class="form-group">
                <label for="id_articulo" class="form-label font-weight-bold">Artículo:</label>
                <select name="id_articulo" id="id_articulo" class="form-select" required>
                  <option value="" selected disabled>Elija un Artículo</option>
                  <?php
                  $art_query = $pdo_conn->query("SELECT id_articulo, nombre FROM articulo");
                  while ($art = $art_query->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='{$art->id_articulo}'>{$art->nombre}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="fecha_mantenimiento" class="form-label">Fecha del Mantenimiento:</label>
                <input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="descripcion_mantenimiento" class="form-label">Descripción:</label>
                <textarea name="descripcion_mantenimiento" id="descripcion_mantenimiento" class="form-control" rows="3" cols="50" placeholder="¿Qué se le hizo al equipo?" required style="resize: none"></textarea>
              </div>

              <div class="form-group">
                <label for="estado_ingresa" class="form-label">Estado al ingresar:</label>
                <input type="text" name="estado_ingresa" id="estado_ingresa" class="form-control" placeholder="Ej: Rayado, No enciende..." required>
              </div>

              <button name="agregar" id="agregar" class="btn btn-success shadow-sm align-self-center" type="submit">
                <i class="bi bi-plus-circle me-2"></i> Asignar
              </button>

            </form>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->
    <!-- Services Section -->
    <section id="services" class="services section light-background">
      <div class="container">
        <table class="table table-bordered table-striped table-hover">
          <thead class="table-light">
            <tr class="text-center">
              <th colspan="6">Lista de Mantenimientos</th>
            </tr>
            <tr>
              <th>ID</th>
              <th>Artículo</th>
              <th>Fecha Mantenimiento</th>
              <th>Descripción</th>
              <th>Estado Ingreso</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Join entre mantenimiento y articulo para ver el nombre del equipo
            $sql = "SELECT m.*, a.nombre AS nombre_articulo 
                      FROM mantenimiento m 
                      INNER JOIN articulo a ON m.id_articulo = a.id_articulo 
                      ORDER BY m.id_mantenimiento";

            $res = $pdo_conn->query($sql);
            while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            ?>
              <tr>
                <td><?php echo $row->id_mantenimiento; ?></td>
                <td><?php echo $row->nombre_articulo; ?></td>
                <td><?php echo $row->fecha_mantenimiento; ?></td>
                <td><?php echo $row->descripcion_mantenimiento; ?></td>
                <td><?php echo $row->estado_ingresa; ?></td>
                <td class="text-center">
                  <a href="asignar_mantenimiento_editar.php?id_mantenimiento=<?php echo $row->id_mantenimiento; ?>"
                    class="btn btn-sm btn-info text-white"
                    title="Editar">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="asignar_mantenimiento_borrar.php?id_mantenimiento=<?php echo $row->id_mantenimiento; ?>"
                    class="btn btn-sm btn-danger"
                    title="Eliminar"
                    onClick="return confirm('¿Eliminar registro de mantenimiento?');">
                    <i class="bi bi-trash"></i>
                  </a>

                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </section><!-- /Services Section -->


  </main>
  <?php
  require_once('pie.php');
  ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>