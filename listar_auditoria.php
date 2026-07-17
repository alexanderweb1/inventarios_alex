<?php
require_once('cusuario.php');
require_once("usuario.php");
require_once("db.php");
require_once("config.php");
$where = "";

if (isset($_REQUEST['usuario']) and $_REQUEST['usuario'] != "") {
  $usuario = $_REQUEST['usuario'] ?? '';
  $where .= " usuario = '" . $usuario . "'";
  //echo "<br>Usuario:$usuario<br>";
} else {
  $where .= " 1=1";
}

if (isset($_REQUEST['t_operacion']) and $_REQUEST['t_operacion'] != "") {
  $t_operacion = $_REQUEST['t_operacion'] ?? '';
  $where .= " AND t_operacion = '" . $t_operacion . "'";
  //echo "<br>Tipo de Operación:$t_operacion<br>";
}

if (isset($_REQUEST['fecha_inicio']) and $_REQUEST['fecha_inicio'] != "") {
  $fecha_inicio = $_REQUEST['fecha_inicio'] ?? '';
  $where .= " AND fecha >= '" . $fecha_inicio . "'";
  //echo "<br>Fecha de inicio:$fecha_inicio<br>";
}

if (isset($_REQUEST['fecha_fin']) and $_REQUEST['fecha_fin'] != "") {
  $fecha_fin = $_REQUEST['fecha_fin'] ?? '';
  $where .= " AND fecha <= '" . $fecha_fin . "'";
  //echo "<br>Fecha de fin:$fecha_fin<br>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Lista de eventos auditoría</title>
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
          <h1 data-aos="fade-up">Listar<span> Eventos </span></h1>
          <p data-aos="fade-up" data-aos-delay="100">de Auditoría<br></p>
          <div class="card shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">
            <form id="form_mantenimiento" name="form1" method="GET" class="text-start d-flex flex-column gap-4">

              <div class="form-group">
                <label for="id_articulo" class="form-label font-weight-bold">Usuario:</label>
                <select name="usuario" id="usuario" class="form-select">
                  <option value="" selected disabled>Elija un Usuario</option>
                  <?php
                  $art_query = $pdo_conn->query("SELECT DISTINCT usuario FROM auditoria");
                  while ($art = $art_query->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='{$art->usuario}'>{$art->usuario}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="id_articulo" class="form-label font-weight-bold">Tipo de Operación:</label>
                <select name="t_operacion" id="t_operacion" class="form-select">
                  <option value="" selected disabled>Elija un tipo de Operación</option>
                  <?php
                  $art_query = $pdo_conn->query("SELECT DISTINCT t_operacion FROM auditoria");
                  while ($art = $art_query->fetch(PDO::FETCH_OBJ)) {
                    echo "<option value='{$art->t_operacion}'>{$art->t_operacion}</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
              </div>


              <div class="form-group">
                <label for="fecha_fin" class="form-label">Fecha de fin:</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
              </div>

              <button name="agregar" id="agregar" class="btn btn-success shadow-sm align-self-center" type="submit">
                <i class="bi bi-plus-circle me-2"></i> Enviar
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
              <th colspan="5">Lista de Eventos de Auditoría</th>
            </tr>
            <tr>
              <th>Id. auditoria</th>
              <th>Usuario</th>
              <th>Tipo de Operación</th>
              <th>Descripción</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody>
            <?php

            //echo "<br>" . $where . "<br>";
            $sql = "SELECT * ";
            $sql .= " FROM auditoria ";
            if ($where != "") {
              $sql .= " WHERE $where ";
            }
            $sql .= " ORDER BY id_auditoria DESC LIMIT 500;";
            echo "<br>" . $sql . "<br>";

            $res = $pdo_conn->query($sql);
            while ($row = $res->fetch(PDO::FETCH_OBJ)) {
            ?>
              <tr>
                <td><?php echo $row->id_auditoria; ?></td>
                <td><?php echo $row->usuario; ?></td>
                <td><?php echo $row->t_operacion; ?></td>
                <td><?php echo $row->descripcion; ?></td>
                <td><?php echo $row->fecha; ?></td>

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