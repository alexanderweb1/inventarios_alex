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
  <title>Sistema de inventarios - Registrar docente </title>
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


  <?php if (isset($_GET['res'])): ?>
    <!-- Alertas flotantes con margen superior para no quedar debajo del navbar -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 80px;">
      <?php if ($_GET['res'] == 'guardado'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="min-width: 300px;">
          <i class="bi bi-check-circle-fill me-2"></i>
          <strong>¡Éxito!</strong> El docente ha sido registrado correctamente.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif ($_GET['res'] == 'editado'): ?>
        <div class="alert alert-info alert-dismissible fade show shadow-lg" role="alert" style="min-width: 300px;">
          <i class="bi bi-pencil-square me-2"></i>
          <strong>¡Actualizado!</strong> Los datos del docente han sido modificados.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif ($_GET['res'] == 'eliminado'): ?>
        <div class="alert alert-warning alert-dismissible fade show shadow-lg" role="alert" style="min-width: 300px;">
          <i class="bi bi-trash-fill me-2"></i>
          <strong>¡Eliminado!</strong> El docente ha sido eliminado correctamente.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif ($_GET['res'] == 'error_restriccion'): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="min-width: 300px;">
          <i class="bi bi-exclamation-triangle-fill me-2"></i>
          <strong>Error</strong> No se puede eliminar el docente porque tiene registros relacionados.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php elseif ($_GET['res'] == 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="min-width: 300px;">
          <i class="bi bi-x-circle-fill me-2"></i>
          <strong>Error</strong> No se pudo completar la operación.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Auto-ocultar alertas después de 4 segundos
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
          setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
          }, 4000); // 4 segundos
        });

        // Limpiar el parámetro 'res' del URL inmediatamente
        if (window.location.search.includes('res=')) {
          const url = window.location.origin + window.location.pathname;
          window.history.replaceState({}, document.title, url);
        }
      });
    </script>
  <?php endif; ?>

  <main class="main">

    <main class="main">

      <!-- Hero Section -->
      <section id="hero" class="hero section">
        <div class="hero-bg">
          <img src="assets/img/hero-bg-light.webp" alt="">
        </div>
        <div class="container text-center">
          <div class="d-flex flex-column justify-content-center align-items-center">
            <h1 data-aos="fade-up">Registrar <span>Docente</span></h1>
            <p data-aos="fade-up" data-aos-delay="100">Ingrese los datos del docente<br></p>
            <div class="card shadow p-4" data-aos="fade-up" data-aos-delay="200">

              <form id="form1" name="form1" method="post" action="registrar_docente_acc.php" enctype="multipart/form-data">

                <!-- FILA 1 -->
                <div class="row mb-4">
                  <div class="col-md-4">
                    <label for="cedula" class="form-label fw-bold">Cédula</label>
                    <input type="number" required name="cedula" id="cedula" class="form-control" placeholder="1712345678">
                  </div>

                  <div class="col-md-4">
                    <label for="apellidos" class="form-label fw-bold">Apellidos</label>
                    <input type="text" required name="apellidos" id="apellidos" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label for="nombre" class="form-label fw-bold">Nombres</label>
                    <input type="text" required name="nombre" id="nombre" class="form-control">
                  </div>
                </div>

                <!-- FILA 2 -->
                <div class="row mb-4">
                  <div class="col-md-3">
                    <label for="correo" class="form-label fw-bold">Correo</label>
                    <input type="email" required name="correo" id="correo" class="form-control">
                  </div>

                  <div class="col-md-3">
                    <label for="telefono" class="form-label fw-bold">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                  </div>

                  <div class="col-md-3">
                    <label for="tel_casa" class="form-label fw-bold">Teléfono Casa</label>
                    <input type="text" name="tel_casa" id="tel_casa" class="form-control">
                  </div>

                  <div class="col-md-3">
                    <label for="direccion" class="form-label fw-bold">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control">
                  </div>
                </div>

                <!-- FILA 3 -->
                <div class="row mb-4 bg-light p-3 rounded mx-0 border">
                  <div class="col-md-4">
                    <label for="hoja_vida" class="form-label fw-bold">Hoja de Vida (PDF)</label>
                    <input type="file" name="hoja_vida" id="hoja_vida" class="form-control" accept=".pdf">
                  </div>
                  <div class="col-md-4">
                    <label for="usuario" class="form-label fw-bold text-primary">Usuario</label>
                    <input type="text" required name="usuario" id="usuario" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label for="clave" class="form-label fw-bold text-primary">Clave</label>
                    <input type="password" required name="clave" id="clave" class="form-control">
                  </div>
                </div>

                <!-- FILA 4 -->
                <div class="row mb-4 g-3">

                  <!-- ESTADO -->
                  <div class="col-md-4">
                    <label for="estado" class="form-label fw-bold">Estado</label>
                    <select name="estado" id="estado" class="form-select">
                      <option value="ACTIVO" selected>ACTIVO</option>
                      <option value="INACTIVO">INACTIVO</option>
                    </select>
                  </div>

                  <!-- TOKEN -->
                  <div class="col-md-8">
                    <label for="token" class="form-label fw-bold">Token</label>
                    <input type="text" name="token" id="token" class="form-control" maxlength="2">
                  </div>

                </div>

                <div class="row mb-4 g-4">

                  <!-- STATUS -->
                  <div class="col-md-4">
                    <label for="status" class="form-label fw-bold">Status</label>
                    <input type="text" name="status" id="status" class="form-control" maxlength="2">
                  </div>

                  <!-- NÚMERO DE DÍAS -->
                  <div class="col-md-4">
                    <label for="numDias" class="form-label fw-bold">Número de Días</label>
                    <input type="text" name="numDias" id="numDias" class="form-control" value="15">
                  </div>

                  <!-- COORDINADOR -->
                  <div class="col-md-4">
                    <label for="coordinador" class="form-label fw-bold">¿Es Coordinador?</label>
                    <select name="coordinador" id="coordinador" class="form-select">
                      <option value="NO" selected>NO</option>
                      <option value="SI">SÍ</option>
                    </select>
                  </div>

                </div>


                <!-- TOKEN -->
                <input type="hidden" name="token" value="">


                <!-- BOTONES -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                  <!-- <button type="reset" class="btn btn-secondary px-4">Limpiar</button> -->
                  <button type="submit" class="btn btn-success px-5 shadow">
                    <i class="bi bi-cloud-arrow-up-fill me-2"></i> Registrar Docente
                  </button>
                </div>

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
                <th colspan="13">Lista de Docentes</th>
              </tr>
              <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Tel. Casa</th>
                <th>Dirección</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Coordinador</th>
                <th>Hoja de Vida</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $doc = $pdo_conn->query("SELECT * FROM docente ORDER BY id_docente");
              $docentes = $doc->fetchAll(PDO::FETCH_OBJ);
              foreach ($docentes as $d) {
              ?>
                <tr>
                  <td><?php echo $d->id_docente; ?></td>
                  <td><?php echo $d->cedula; ?></td>
                  <td><?php echo $d->apellidos; ?></td>
                  <td><?php echo $d->nombre; ?></td>
                  <td><?php echo $d->correo; ?></td>
                  <td><?php echo $d->telefono; ?></td>
                  <td><?php echo $d->tel_casa; ?></td>
                  <td><?php echo $d->direccion; ?></td>
                  <td><?php echo $d->usuario; ?></td>
                  <td>
                    <span class="badge <?php echo ($d->estado == 'ACTIVO') ? 'bg-success' : 'bg-secondary'; ?>">
                      <?php echo $d->estado; ?>
                    </span>
                  </td>
                  <td class="text-center">
                    <?php if ($d->coordinador == 'SI') { ?>
                      <i class="bi bi-check-circle-fill text-success" title="Es coordinador"></i>
                    <?php } else { ?>
                      <i class="bi bi-x-circle text-muted" title="No es coordinador"></i>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <?php if (!empty($d->hoja_vida)) { ?>
                      <a href="<?php echo $d->hoja_vida; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Ver hoja de vida">
                        <i class="bi bi-file-pdf"></i>
                      </a>
                    <?php } else { ?>
                      <span class="text-muted">N/A</span>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <a href="registrar_docente_editar.php?id_docente=<?php echo $d->id_docente; ?>"
                      title="Editar"
                      class="btn btn-sm btn-info text-white">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="registrar_docente_borrar.php?id_docente=<?php echo $d->id_docente; ?>"
                      title="Eliminar"
                      class="btn btn-sm btn-danger text-white"
                      onClick="return confirm('¿Desea eliminar este docente?');">
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
      <!-- /Services Section -->



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