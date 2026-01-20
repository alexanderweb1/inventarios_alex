<?php
require_once('usuario.php');
session_start();
require_once("db.php");
include_once('config.php');

// 1. Verificamos si el ID realmente llegó por la URL
if (isset($_REQUEST["id_mantenimiento"]) && !empty($_REQUEST["id_mantenimiento"])) {
  $id_mantenimiento = $_REQUEST["id_mantenimiento"];

  // 2. Usamos una consulta preparada para evitar el error de sintaxis y por seguridad
  $sentencia = $pdo_conn->prepare("SELECT * FROM mantenimiento WHERE id_mantenimiento = :id");
  $sentencia->execute([':id' => $id_mantenimiento]);
  $mantenimiento = $sentencia->fetch(PDO::FETCH_OBJ);

  // 3. Si el ID no existe en la base de datos
  if (!$mantenimiento) {
    die("Error: El registro de mantenimiento no existe.");
  }
} else {
  // Si intentas entrar directo al archivo sin pasar un ID
  die("Error: No se ha especificado un ID de mantenimiento para editar.");
}
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
          <h1 data-aos="fade-up">Editar <span>mantenimiento</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">de un artículo<br></p>
          <div class="card shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">

            <form id="form_mantenimiento" name="form1" method="post" action="asignar_mantenimiento_acc.php" class="text-start d-flex flex-column gap-4">

              <input type="hidden" name="id_mantenimiento" value="<?php echo $mantenimiento->id_mantenimiento; ?>">

              <div class="form-group">
                <label for="id_articulo" class="form-label font-weight-bold">Artículo:</label>
                <select name="id_articulo" id="id_articulo" class="form-select" required>
                  <option value="" disabled>Elija un Artículo</option>
                  <?php
                  $art_query = $pdo_conn->query("SELECT id_articulo, nombre FROM articulo");
                  while ($art = $art_query->fetch(PDO::FETCH_OBJ)) {
                    // Ahora la comparación funciona porque $mantenimiento es un objeto
                    $selected = ($art->id_articulo == $mantenimiento->id_articulo) ? "selected" : "";
                    echo "<option value='{$art->id_articulo}' $selected>{$art->nombre}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="fecha_mantenimiento" class="form-label">Fecha del Mantenimiento:</label>
                <input type="date" name="fecha_mantenimiento" id="fecha_mantenimiento" class="form-control"
                  value="<?php echo $mantenimiento->fecha_mantenimiento; ?>" required>
                <input type=hidden name="id_mantenimiento" id="id_mantenimiento" value="<?php echo $mantenimiento->id_mantenimiento; ?>">
                <input type=hidden name="accion" id="accion" value="EDITAR">
              </div>

              <div class="form-group">
                <label for="descripcion_mantenimiento" class="form-label">Descripción:</label>
                <textarea name="descripcion_mantenimiento" id="descripcion_mantenimiento" class="form-control"
                  rows="3" cols="50" required style="resize: none"><?php echo $mantenimiento->descripcion_mantenimiento; ?></textarea>
              </div>

              <div class="form-group">
                <label for="estado_ingresa" class="form-label">Estado al ingresar:</label>
                <input type="text" name="estado_ingresa" id="estado_ingresa" class="form-control"
                  value="<?php echo $mantenimiento->estado_ingresa; ?>" required>
              </div>

              <button name="actualizar" id="actualizar" class="btn btn-info shadow-sm align-self-center" type="submit">
                <i class="bi bi-pencil-square me-2"></i> Actualizar
              </button>

            </form>
          </div>
        </div>
      </div>
    </section>

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