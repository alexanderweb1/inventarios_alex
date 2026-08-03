<?php
require_once('usuario.php');
session_start();
require_once("db.php");
include_once('config.php');

// Obtener el ID del artículo a editar
if (!isset($_GET['id'])) {
  header("Location: registrar_articulo_add.php");
  exit;
}

$id_articulo = $_GET['id'];

// Obtener datos del artículo
$stmt = $pdo_conn->prepare("SELECT * FROM articulo WHERE id_articulo = ?");
$stmt->execute([$id_articulo]);
$articulo = $stmt->fetch(PDO::FETCH_OBJ);

if (!$articulo) {
  header("Location: registrar_articulo_add.php?error=not_found");
  exit;
}

// Consultas para llenar los SELECTs
$ubicaciones = $pdo_conn->query("SELECT id_ubicacion, nombre FROM ubicacion")->fetchAll(PDO::FETCH_OBJ);
$inventarios = $pdo_conn->query("SELECT id_inventario, nombre FROM inventario")->fetchAll(PDO::FETCH_OBJ);
$marcas = $pdo_conn->query("SELECT id_marca, nombre FROM marca")->fetchAll(PDO::FETCH_OBJ);
$tipos = $pdo_conn->query("SELECT id_tipo_articulo, tipo_articulo FROM tipo_articulo")->fetchAll(PDO::FETCH_OBJ);
$estados = $pdo_conn->query("SELECT id_estado, estado FROM estado")->fetchAll(PDO::FETCH_OBJ);
$modelos = $pdo_conn->query("SELECT id_modelo, modelo FROM modelo")->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Editar artículo</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- fontawesome icons -->
  <script src="https://kit.fontawesome.com/58e95fbc3e.js" crossorigin="anonymous"></script>

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
</head>

<body class="index-page">

  <?php require_once('cabecera.php'); ?>

  <main class="main">
    <section id="hero" class="hero section">
      <div class="hero-bg"><img src="assets/img/hero-bg-light.webp" alt=""></div>
      <div class="container">
        <div class="text-center mb-4">
          <h1 data-aos="fade-up">Editar <span>Artículo</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Modifique los datos del artículo</p>
        </div>

        <div class="card shadow-lg p-4" data-aos="fade-up" data-aos-delay="200">
          <form action="registrar_articulo_acc.php" method="post" enctype="multipart/form-data" class="row g-3">
            <input type="hidden" name="accion" value="EDITAR">
            <input type="hidden" name="id_articulo" value="<?php echo $articulo->id_articulo; ?>">
            <input type="hidden" name="foto_actual" value="<?php echo $articulo->foto; ?>">

            <div class="col-md-4">
              <label class="form-label fw-bold">Ubicación Física</label>
              <select name="id_ubicacion" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($ubicaciones as $u): ?>
                  <option value="<?php echo $u->id_ubicacion; ?>" <?php echo ($u->id_ubicacion == $articulo->id_ubicacion) ? 'selected' : ''; ?>>
                    <?php echo $u->nombre; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">ID Inventario</label>
              <select name="id_inventario" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($inventarios as $i): ?>
                  <option value="<?php echo $i->id_inventario; ?>" <?php echo ($i->id_inventario == $articulo->id_inventario) ? 'selected' : ''; ?>>
                    <?php echo $i->nombre; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Nombre del Artículo</label>
              <input type="text" name="nombre" class="form-control" required value="<?php echo htmlspecialchars($articulo->nombre); ?>">
            </div>

            <div class="col-12">
              <label class="form-label fw-bold">Descripción del Artículo</label>
              <textarea name="descripcion" class="form-control" rows="2"><?php echo htmlspecialchars($articulo->descripcion); ?></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Marca</label>
              <select name="id_marca" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($marcas as $m): ?>
                  <option value="<?php echo $m->id_marca; ?>" <?php echo ($m->id_marca == $articulo->id_marca) ? 'selected' : ''; ?>>
                    <?php echo $m->nombre; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Tipo de Artículo</label>
              <select name="id_tipo_articulo" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($tipos as $t): ?>
                  <option value="<?php echo $t->id_tipo_articulo; ?>" <?php echo ($t->id_tipo_articulo == $articulo->id_tipo_articulo) ? 'selected' : ''; ?>>
                    <?php echo $t->tipo_articulo; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Nro. Inventario ISTMS</label>
              <input type="text" name="n_inventario_istms" class="form-control" required value="<?php echo htmlspecialchars($articulo->n_inventario_istms); ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Foto del Activo</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
              <?php if ($articulo->foto): ?>
                <small class="text-muted">Foto actual: <?php echo $articulo->foto; ?></small><br>
                <img src="uploads/<?php echo $articulo->foto; ?>" width="100" class="mt-2 rounded">
              <?php endif; ?>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Valor Inicial ($)</label>
              <input type="number" step="0.01" name="v_eco_inicial" class="form-control" value="<?php echo $articulo->v_eco_inicial; ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Fecha Adquisición</label>
              <input type="date" name="f_adquisicion" class="form-control" value="<?php echo $articulo->f_adquisicion; ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Estado Actual</label>
              <select name="id_estado" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($estados as $e): ?>
                  <option value="<?php echo $e->id_estado; ?>" <?php echo ($e->id_estado == $articulo->id_estado) ? 'selected' : ''; ?>>
                    <?php echo $e->estado; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Nro. de Serie</label>
              <input type="text" name="n_serie" class="form-control" value="<?php echo htmlspecialchars($articulo->n_serie); ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Modelo</label>
              <select name="id_modelo" class="form-select">
                <option value="">Seleccione...</option>
                <?php foreach ($modelos as $mo): ?>
                  <option value="<?php echo $mo->id_modelo; ?>" <?php echo ($mo->id_modelo == $articulo->id_modelo) ? 'selected' : ''; ?>>
                    <?php echo $mo->modelo; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">¿Baja?</label>
              <select name="baja" class="form-select">
                <option value="0" <?php echo ($articulo->baja == 0) ? 'selected' : ''; ?>>No</option>
                <option value="1" <?php echo ($articulo->baja == 1) ? 'selected' : ''; ?>>Sí</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-bold">Descripción de Baja</label>
              <input type="text" name="descripcion_baja" class="form-control" value="<?php echo htmlspecialchars($articulo->descripcion_baja); ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Fecha de Baja</label>
              <input type="date" name="fecha_baja" class="form-control" value="<?php echo $articulo->fecha_baja; ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Fecha Registro</label>
              <input type="datetime-local" name="fecha" class="form-control" value="<?php echo date('Y-m-d\TH:i', strtotime($articulo->fecha)); ?>">
            </div>

            <div class="col-12 text-center mt-4">
              <a href="registrar_articulo_add.php" class="btn btn-secondary btn-lg px-5 me-2">
                <i class="bi bi-x-circle"></i> Cancelar
              </a>
              <button type="submit" class="btn btn-primary btn-lg px-5">
                <i class="bi bi-check-circle"></i> Guardar Cambios
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>

  <?php require_once('pie.php'); ?>

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