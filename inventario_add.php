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
  <title>Sistema de inventarios - Administrar datos de inventarios</title>
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
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up">Administrar <span>inventarios</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ingrese los datos del inventario<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <form id="form1" name="form1" method="post" action="inventario_acc.php" class="d-flex flex-column gap-3">
              <div class="form-group">
                <label for="usuario" class="sr-only">Nombre de inventario:</label>
                <input required name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del inventario">
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Descripción:</label><br>
                <textarea required id="descripcion" name="descripcion" rows="4" cols="50" class="form-control" placeholder="Ingrese la descripción del inventario"></textarea>
              </div>

              <input name="agregar" id="agregar" class="btn btn-block login-btn mb-4" type="submit" value="Agregar">
            </form>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->
    <!-- Services Section -->
    <section id="services" class="services section light-background">
      <div class="container">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr class="text-center align-middle">
              <th colspan=4>Lista de inventarios</th>
            </tr>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $inv = $pdo_conn->query("SELECT * FROM inventario");
            $inventario = $inv->fetchAll(PDO::FETCH_OBJ);
            foreach ($inventario as $inv) {
            ?>
              <tr>
                <td><?php echo $inv->id_inventario; ?></td>
                <td><?php echo $inv->nombre; ?></td>
                <td><?php echo $inv->descripcion; ?></td>
                <td>
                  <a href="inventario_editar.php?id_inventario=<?php echo $inv->id_inventario; ?>" title="Editar" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></a>
                  <a href="inventario_borrar.php?id_inventario=<?php echo $inv->id_inventario; ?>" title="Eliminar" class="btn btn-sm btn-danger text-white" onClick="return confirm('Desea eliminar el inventario?');"><i class="bi bi-trash"></i></a>
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