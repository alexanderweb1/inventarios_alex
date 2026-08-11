<?php
require_once('cusuario.php');
require_once('usuario.php');
require_once("db.php");
include_once('config.php');
$id_ubicacion = $_REQUEST["id_ubicacion"];

$ubi = $pdo_conn->query("SELECT * FROM ubicacion WHERE id_ubicacion=$id_ubicacion; ");
$ubicacion = $ubi->fetchAll(PDO::FETCH_OBJ);
foreach ($ubicacion as $ubi) {
  $id_ubicacion = $ubi->id_ubicacion;
  $nombre = $ubi->nombre;
  $descripcion = $ubi->descripcion;
  $fecha = date("Y-m-d", strtotime($ubi->fecha));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Editar ubicacion </title>
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
          <h1 data-aos="fade-up">Editar <span>ubicacion</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ingrese los datos nuevos de la ubicacion<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <form id="form1" name="form1" method="post" action="registrar_ubicacion_acc.php">
              <div class="form-group">
                <label for="usuario" class="sr-only">Nombre de ubicacion:</label>
                <input required name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" placeholder="Ingrese el nombre de la marca">
                <input type=hidden name="id_ubicacion" id="id_ubicacion" value="<?php echo $id_ubicacion; ?>">
                <input type=hidden name="accion" id="accion" value="EDITAR">
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Descripción de la ubicación:</label><br>
                <textarea required id="descripcion" name="descripcion" rows="4" cols="50" placeholder="Ingrese la descripción de la marca"><?php echo $descripcion; ?></textarea>
              </div>

              <div class="form-group">
                <label for="fecha" class="form-label">Fecha de la ubicación:</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>" class="form-control" required>
              </div>

              <input name="agregar" id="agregar" class="btn btn-block login-btn mb-4" type="submit" value="Actualizar">

            </form>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->
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