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
  <title>Sistema de inventarios - Asignar inventario a docente</title>
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

  <!-- alertify -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <?php if (isset($_REQUEST['error'])): ?>
    <script>
      const mensaje = "<?php echo htmlspecialchars($_REQUEST['error']); ?>";
      const esError = mensaje.toLowerCase().includes('error');

      Swal.fire({
        title: esError ? '¡Atención!' : '¡Logrado!',
        text: mensaje,
        icon: esError ? 'error' : 'success',
        timer: 5000,
        showConfirmButton: false,
        timerProgressBar: true
      });

      window.history.replaceState({}, document.title, window.location.pathname);
    </script>
  <?php endif; ?>

  <?php require_once('cabecera.php'); ?>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center mx-auto">
          <h1 data-aos="fade-up">Asignar <span>inventario</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">a docente<br></p>
          <div class="card shadow-sm p-4" data-aos="fade-up" data-aos-delay="200">
            <form id="form1" name="form1" method="post" action="asignar_inventario_acc.php" class="d-flex flex-column gap-3">
              <!-- asignar inventario -->
              <div class="form-group">
                <label for="usuario" class="sr-only">Seleccionar inventario:</label>
                <select name="id_inventario" id="id_inventario" class="form-select" aria-label="defaul selet example" required>
                  <option value="" selected disabled>Elija un inventario</option>
                  <?php
                  $inv = $pdo_conn->query("SELECT * FROM inventario ");
                  $inventario = $inv->fetchAll(PDO::FETCH_OBJ);
                  foreach ($inventario as $inv) {
                  ?>
                    <option value="<?php echo $inv->id_inventario; ?>"><?php echo $inv->nombre; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <!-- asignar docente -->
              <div class="form-group">
                <label for="usuario" class="sr-only">Seleccionar docente:</label>
                <select name="id_docente" id="id_docente" class="form-select" aria-label="defaul selet example" required>
                  <option value="" selected disabled>Elija un docente</option>
                  <?php
                  $doc = $pdo_conn->query("SELECT * FROM docente ");
                  $docente = $doc->fetchAll(PDO::FETCH_OBJ);
                  foreach ($docente as $doc) {
                  ?>
                    <option value="<?php echo $doc->id_docente; ?>"><?php echo $doc->nombre . " " . $doc->apellidos; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="descripcion" class="sr-only">Descripción de la asignación:</label>
                <textarea type="text" name="descripcion" id="descripcion" class="form-control" rows="3" cols="50" placeholder="Ingrese una descripción de la asignación" required></textarea>
              </div>
              <!-- <input name="agregar" id="agregar" class="btn btn-success px-5 shadow-sm" type="submit" value="Asignar"> -->
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
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr class="text-center align-middle">
              <th colspan=4>Lista de asignaciones</th>
            </tr>
            <tr>
              <th>id</th>
              <th>Inventario</th>
              <th>Docente</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $sql = " SELECT docente_inventario.id_docente_inventario,docente.nombre AS 'nombre_docente',docente.apellidos,inventario.nombre";
            $sql .= " FROM docente_inventario, docente,inventario ";
            $sql .= " WHERE";
            $sql .= " docente_inventario.id_docente=docente.id_docente AND ";
            $sql .= " docente_inventario.id_inventario=inventario.id_inventario ";

            $mar = $pdo_conn->query($sql);
            $adocente_inventario = $mar->fetchAll(PDO::FETCH_OBJ);
            foreach ($adocente_inventario as $adi) {
            ?>
              <tr>
                <td><?php echo $adi->id_docente_inventario; ?></td>
                <td><?php echo $adi->nombre; ?></td>
                <td><?php echo $adi->nombre_docente . " " . $adi->apellidos; ?></td>
                <td>

                  <a href="asignar_inventario_borrar.php?id_docente_inventario=<?php echo $adi->id_docente_inventario; ?>" title="Eliminar" class="btn btn-sm btn-danger text-white" onClick="return confirm('Desea eliminar la asignación?');"><i class="bi bi-trash"></i></a>
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