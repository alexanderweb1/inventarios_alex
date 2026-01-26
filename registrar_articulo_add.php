<?php
require_once('usuario.php');
session_start();
require_once("db.php");
include_once('config.php');

// Consultas para llenar los SELECTs
$ubicaciones = $pdo_conn->query("SELECT id_ubicacion, nombre FROM ubicacion")->fetchAll(PDO::FETCH_OBJ);
$inventarios = $pdo_conn->query("SELECT id_inventario, nombre FROM inventario")->fetchAll(PDO::FETCH_OBJ);
$marcas = $pdo_conn->query("SELECT id_marca, nombre FROM marca")->fetchAll(PDO::FETCH_OBJ);
// $tipos = $pdo_conn->query("SELECT id_tipo_articulo FROM tipo_articulo")->fetchAll(PDO::FETCH_OBJ);
// Agregamos la columna 'tipo_articulo' a la consulta
$tipos = $pdo_conn->query("SELECT id_tipo_articulo, tipo_articulo FROM tipo_articulo")->fetchAll(PDO::FETCH_OBJ);
$estados = $pdo_conn->query("SELECT id_estado, estado FROM estado")->fetchAll(PDO::FETCH_OBJ);
$modelos = $pdo_conn->query("SELECT id_modelo, modelo FROM modelo")->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Administrar articulo</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- fontawesome icons -->
  <script src="https://kit.fontawesome.com/58e95fbc3e.js" crossorigin="anonymous"></script>

  <!-- mensaje -->
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <section id="hero" class="hero section">
      <div class="hero-bg"><img src="assets/img/hero-bg-light.webp" alt=""></div>
      <div class="container">
        <div class="text-center mb-4">
          <h1 data-aos="fade-up">Administrar <span>Artículos</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ingrese todos los datos del activo</p>
        </div>

        <div class="card shadow-lg p-4" data-aos="fade-up" data-aos-delay="200">
          <form action="registrar_articulo_acc.php" method="post" enctype="multipart/form-data" class="row g-3">
            <input type="hidden" name="accion" value="AGREGAR">

            <div class="col-md-4">
              <label class="form-label fw-bold">Ubicación Física</label>
              <select name="id_ubicacion" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($ubicaciones as $u) echo "<option value='$u->id_ubicacion'>$u->nombre</option>"; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">ID Inventario</label>
              <select name="id_inventario" id="id_inventario" class="form-select" required onchange="generarCodigo()">
                <option value="">Seleccione...</option>
                <?php foreach ($inventarios as $i) echo "<option value='$i->id_inventario'>$i->nombre</option>"; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Nombre del Artículo</label>
              <input type="text" name="nombre" class="form-control" required placeholder="Ej: Laptop Dell">
            </div>

            <div class="col-12 text-start">
              <label class="form-label fw-bold">Descripción del Artículo</label>
              <textarea name="descripcion" class="form-control" rows="2" placeholder="Detalles técnicos adicionales..."></textarea>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Marca</label>
              <select name="id_marca" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($marcas as $m) echo "<option value='$m->id_marca'>$m->nombre</option>"; ?>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Tipo de Artículo</label>
              <select name="id_tipo_articulo" id="id_tipo_articulo" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($tipos as $t): ?>
                  <option value="<?php echo $t->id_tipo_articulo; ?>">
                    <?php echo $t->tipo_articulo; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>


            <div class="col-md-4">
              <label class="form-label fw-bold">Nro. Inventario ISTMS</label>
              <input type="text" name="n_inventario_istms" id="n_inventario_istms" class="form-control" readonly placeholder="Seleccione tipo primero" style="background-color: #e9ecef;">
            </div>

            <div class="col-md-4">
              <label class="form-label fw-bold">Foto del Activo</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="col-md-4 text-start">
              <label class="form-label fw-bold">Valor Inicial ($)</label>
              <input type="number" step="0.01" name="v_eco_inicial" class="form-control">
            </div>

            <div class="col-md-4 text-start">
              <label class="form-label fw-bold">Fecha Adquisición</label>
              <input type="date" name="f_adquisicion" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Estado Actual</label>
              <select name="id_estado" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($estados as $e) echo "<option value='$e->id_estado'>$e->estado</option>"; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Nro. de Serie</label>
              <input type="text" name="n_serie" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label fw-bold">Modelo</label>
              <select name="id_modelo" class="form-select">
                <option value="">Seleccione...</option>
                <?php foreach ($modelos as $mo) echo "<option value='$mo->id_modelo'>$mo->modelo</option>"; ?>
              </select>
            </div>

            <div class="col-md-3 text-start">
              <label class="form-label fw-bold">¿Baja?</label>
              <select name="baja" class="form-select">
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
            </div>

            <div class="col-md-6 text-start">
              <label class="form-label fw-bold">Descripción de Baja</label>
              <input type="text" name="descripcion_baja" class="form-control" placeholder="Motivo de la baja">
            </div>

            <div class="col-md-3 text-start">
              <label class="form-label fw-bold">Fecha de Baja</label>
              <input type="date" name="fecha_baja" class="form-control">
            </div>

            <div class="col-md-3 text-start">
              <label class="form-label fw-bold">Fecha Registro</label>
              <input type="datetime-local" name="fecha" class="form-control">
            </div>

            <div class="col-12 text-center mt-4">
              <button type="submit" name="agregar" class="btn btn-success btn-lg px-5">
                <i class="bi bi-plus-circle"></i> Registrar Artículo
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <section class="services section light-background">
      <div class="container">
        <div class="table-responsive shadow">
          <table class="table table-hover table-bordered align-middle table-striped">
            <thead class="table-secondary">
              <tr class="text-center">
                <th>ID</th>
                <th>Nr. Inventario</th>
                <th>Nombre</th>
                <th>Marca / Ubicación</th>
                <th>Estado</th>
                <th>Ingreso</th>
                <th width="120">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT a.*, m.nombre AS m_nom, u.nombre AS u_nom, e.estado AS e_nom, mo.modelo AS modelo
                      FROM articulo a
                      JOIN marca m ON a.id_marca = m.id_marca
                      JOIN ubicacion u ON a.id_ubicacion = u.id_ubicacion
                      JOIN estado e ON a.id_estado = e.id_estado
                      LEFT JOIN modelo mo ON a.id_modelo = mo.id_modelo
                      ORDER BY a.id_articulo DESC";
              $articulos = $pdo_conn->query($sql)->fetchAll(PDO::FETCH_OBJ);
              foreach ($articulos as $art) {
              ?>
                <tr>
                  <td class="text-center"><span class="badge text-dark"><?php echo $art->id_articulo; ?></span></td>
                  <td><span class="badge bg-light text-dark border"><?php echo $art->n_inventario_istms; ?></span></td>
                  <td><strong><?php echo $art->nombre; ?></strong></td>
                  <td>
                    <small><?php echo $art->m_nom; ?></small><br>
                    <span class="text-primary small"><i class="bi bi-geo-alt"></i> <?php echo $art->u_nom; ?></span>
                  </td>
                  <td class="text-center">
                    <?php
                    // Definir el color según el estado
                    $clase_estado = 'bg-secondary'; // Color por defecto (gris)

                    if ($art->baja == 1) {
                      $clase_estado = 'bg-danger';
                      $texto_estado = 'BAJA';
                    } else {
                      $texto_estado = $art->e_nom;
                      // Lógica de colores por nombre de estado
                      if (strtoupper($art->e_nom) == 'BUENO' || strtoupper($art->e_nom) == 'NUEVO') {
                        $clase_estado = 'bg-success';
                      } elseif (strtoupper($art->e_nom) == 'MEDIO FUNCIONAL' || strtoupper($art->e_nom) == 'REGULAR') {
                        $clase_estado = 'bg-warning text-dark'; // Naranja (Warning)
                      } elseif (strtoupper($art->e_nom) == 'MALO' || strtoupper($art->e_nom) == 'DAÑADO') {
                        $clase_estado = 'bg-danger';
                      }
                    }
                    ?>
                    <span class="badge <?php echo $clase_estado; ?>">
                      <?php echo $texto_estado; ?>
                    </span>
                  </td>
                  <td class="text-center"><small><?php echo date('d/m/Y', strtotime($art->fecha)); ?></small></td>
                  <td class="text-center">
                    <div class="btn-group d-flex gap-1">
                      <button class="btn btn-sm btn-warning" onclick='verDetalles(<?php echo json_encode($art); ?>)' title="Ver Detalles"><i class="fa fa-eye"></i></button>
                      <a href="registrar_articulo_editar.php?id=<?php echo $art->id_articulo; ?>" class="btn btn-sm btn-info text-white" title="Editar Artículo"><i class="bi bi-pencil-square"></i>
                      </a>
                      <a href="registrar_articulo_borrar.php?id=<?php echo $art->id_articulo; ?>"
                        class="btn btn-sm btn-danger text-white"
                        title="Eliminar Artículo"
                        onclick="return confirm('¿Está seguro de eliminar el artículo: <?php echo htmlspecialchars($art->nombre); ?>?\n\nEsta acción no se puede deshacer.');">
                        <i class="bi bi-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php }
              ?>
            </tbody>
          </table>
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

  <!-- modal -->
  <div class="modal fade" id="modalDetalles" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title text-white"><i class="bi bi-info-circle"></i> Información Detallada del Activo</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-5 text-center mb-3">
              <img id="det_foto" src="assets/img/no-image.png" class="img-fluid rounded shadow" alt="Foto del activo">
            </div>
            <div class="col-md-7">
              <h4 id="det_nombre" class="text-primary mb-0"></h4>
              <p id="det_codigo" class="text-muted fw-bold mb-3"></p>

              <table class="table table-sm table-borderless">

                <tr>
                  <th>Marca:</th>
                  <td id="det_marca"></td>
                </tr>
                <tr>
                  <th>Modelo:</th>
                  <td id="det_modelo"></td>
                </tr>
                <tr>
                  <th>Serie:</th>
                  <td id="det_serie"></td>
                </tr>
                <tr>
                  <th>Ubicación:</th>
                  <td id="det_ubicacion"></td>
                </tr>
                <tr>
                  <th>Estado:</th>
                  <td id="det_estado"></td>
                </tr>
              </table>
            </div>
          </div>
          <hr>
          <div class="row mt-2">
            <div class="col-md-6 border-end">
              <h6 class="fw-bold text-success">Datos Económicos</h6>
              <p><strong>Valor Inicial:</strong> $<span id="det_valor"></span></p>
              <p><strong>Fecha Adquisición:</strong> <span id="det_fecha_adq"></span></p>
            </div>
            <div class="col-md-6 ps-4">
              <h6 class="fw-bold text-danger">Estado de Baja</h6>
              <p><strong>¿Está de baja?:</strong> <span id="det_baja"></span></p>
              <p><strong>Motivo:</strong> <span id="det_motivo_baja"></span></p>
            </div>
          </div>
          <div class="mt-3 bg-light p-3 rounded">
            <strong>Descripción Articúlo:</strong>
            <p id="det_descripcion" class="mb-0"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- ajax -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tipoSelect = document.getElementById('id_tipo_articulo');
      const inventarioInput = document.getElementById('n_inventario_istms');

      if (tipoSelect && inventarioInput) {
        tipoSelect.addEventListener('change', function() {
          const idTipo = this.value;

          if (idTipo) {
            inventarioInput.value = 'Generando...';

            fetch('registrar_articulo_acc.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=generar_inventario&id_tipo_articulo=' + idTipo
              })
              .then(response => response.json())
              .then(data => {
                if (data.inventario) {
                  inventarioInput.value = data.inventario;
                }
              })
              .catch(error => {
                console.error('Error:', error);
                inventarioInput.value = '';
                alert('Error al generar número de inventario');
              });
          } else {
            inventarioInput.value = '';
          }
        });
      }
    });

    function verDetalles(articulo) {
      document.getElementById('det_nombre').innerText = articulo.nombre;
      document.getElementById('det_codigo').innerText = "Código: " + articulo.n_inventario_istms;
      document.getElementById('det_marca').innerText = articulo.m_nom;
      document.getElementById('det_modelo').innerText = articulo.modelo || 'N/A';
      document.getElementById('det_serie').innerText = articulo.n_serie || 'N/A';
      document.getElementById('det_ubicacion').innerText = articulo.u_nom;
      document.getElementById('det_estado').innerText = articulo.e_nom || 'No especificado'; // ✅ Cambia a e_nom
      document.getElementById('det_valor').innerText = articulo.v_eco_inicial || '0.00';
      document.getElementById('det_fecha_adq').innerText = articulo.f_adquisicion || 'No registrada';
      document.getElementById('det_descripcion').innerText = articulo.descripcion || 'Sin descripción adicional.';

      document.getElementById('det_baja').innerText = (articulo.baja == 1) ? "SÍ" : "NO";
      document.getElementById('det_motivo_baja').innerText = articulo.descripcion_baja || 'Ninguno';

      const imgElement = document.getElementById('det_foto');

      if (articulo.foto && articulo.foto.trim() !== "") {
        imgElement.src = "uploads/" + articulo.foto;
      } else {
        imgElement.src = "assets/img/no-image.png";
      }

      const myModal = new bootstrap.Modal(document.getElementById('modalDetalles'));
      myModal.show();
    }
  </script>


  <!-- Mensajes SweetAlert2 -->
  <script>
    <?php if (isset($_GET['msg'])): ?>
      <?php if ($_GET['msg'] == 'eliminado'): ?>
        Swal.fire({
          icon: 'success',
          title: '¡Eliminado!',
          text: 'El artículo ha sido eliminado correctamente.',
          timer: 3000,
          showConfirmButton: false
        });
      <?php elseif ($_GET['msg'] == 'usado'): ?>
        Swal.fire({
          icon: 'error',
          title: '¡No se puede eliminar!',
          html: '<b>Este artículo está relacionado con otros registros</b><br><br>Debe eliminar primero las relaciones existentes (asignaciones, movimientos, etc.) antes de borrar el artículo.',
          confirmButtonText: 'Entendido',
          confirmButtonColor: '#d33',
          width: '600px'
        });
      <?php elseif ($_GET['msg'] == 'error'): ?>
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al intentar eliminar el artículo.',
          confirmButtonColor: '#d33'
        });
      <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($_GET['res'])): ?>
      <?php if ($_GET['res'] == 'success'): ?>
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Artículo registrado correctamente.',
          timer: 2000,
          showConfirmButton: false
        });
      <?php elseif ($_GET['res'] == 'updated'): ?>
        Swal.fire({
          icon: 'success',
          title: '¡Actualizado!',
          text: 'Artículo modificado correctamente.',
          timer: 2000,
          showConfirmButton: false
        });
      <?php endif; ?>
    <?php endif; ?>
  </script>
</body>

</html>