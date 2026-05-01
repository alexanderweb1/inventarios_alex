<?php
require_once('include/usuario.php');
require_once('include/cusuario.php');
// Código para insertar o editar registro
if (isset($_REQUEST['submit']) and $_REQUEST['submit'] != "") {
  extract($_REQUEST);
  echo "<br>Modelo:" . $modelo;

  if ($accion == "EDITAR") {
    $data = array(
      'modelo' => $modelo,
    );
    $update = $db->update('modelo', $data, array('id_modelo' => $id_modelo));
    if ($insert) {
      header('location:add_modelo.php?msg=edi');
      exit;
    } else {
      header('location:add_modelo.php?msg=nedi');
      exit;
    }
    return;
  } else {
    $data = array(
      'modelo' => trim($modelo),
    );
    $insert = $db->insert('modelo', $data);

    if ($insert) {
      header('location:add_modelo.php?msg=ras');
      exit;
    } else {
      header('location:add_modelo.php?msg=rna');
      exit;
    }
  }
}
//Código para cuando se hace clic en los enlaces editar o eliminar
if (isset($_REQUEST['accion']) and $_REQUEST['accion'] != "") {
  extract($_REQUEST);
  echo "<br>accion:" . $accion;
  if ($accion == "ELIMINAR") {
    $data  = array(
      'id_modelo' => trim($id_modelo),
    );
    $delete = $db->delete('modelo', $data);
    if ($delete) {
      header('location:add_modelo.php?msg=del');
      exit;
    } else {
      header('location:add_modelo.php?msg=undel');
      exit;
    }
  }
  if ($accion == "EDITAR") {
    $row_edit = $db->getAllRecords('modelo', '*', ' AND id_modelo="' . $_REQUEST['id_modelo'] . '"');
  }
} else {
  $accion = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Administrar datos de modelos </title>
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
          <?php
          //Código para los mensajes

          if (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "del") {
            echo  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Regitro eliminado correctamente</div>';
          } elseif (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "ras") {

            echo  '<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Registro almacenado correctamente!</div>';
          } elseif (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "rna") {

            echo  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Record not added <strong>Please try again!</strong></div>';
          }
          ?>

          <h1 data-aos="fade-up">Administrar <span>modelo</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ingrese los datos del modelo<br></p>
          <div class="card shadow p-4" data-aos="fade-up" data-aos-delay="200">
            <form id="form1" name="form1" method="post" class="d-flex flex-column gap-4">
              <div class="form-group">
                <label for="usuario" class="sr-only">Nombre de modelo:</label>
                <!-- //Campos ocultos código de modelo y accion -->
                <input type="hidden" name="id_modelo" id="id_modelo"
                  <?php
                  if ($accion == "EDITAR") {
                    echo "value='" . $_REQUEST['id_modelo'] . "'";
                  } else {
                    echo "value=''";
                  }
                  ?>>
                <input type="hidden" name="accion" id="accion"
                  <?php
                  if ($accion == "EDITAR") {
                    echo "value='EDITAR'";
                  } else {
                    echo "value=''";
                  }
                  ?>>

                <!-- //Campo modelo -->
                <input required name="modelo" id="modelo" class="form-control" placeholder="Ingrese el modelo"
                  <?php
                  if ($accion == "EDITAR") {
                    echo "value='" . $row_edit[0]['modelo'] . "'";
                  } else {
                    echo "value=''";
                  }
                  ?>>
              </div>
              <div class="form-group mb-4">
              </div>
              <!-- <input name="agregar" id="agregar" class="btn btn-block login-btn mb-4" type="submit" value="Agregar"> -->
              <button name="submit" id="submit" class="btn btn-success shadow-sm align-self-center" type="submit" value="Agregar">
                <i class="bi bi-plus-circle me-2"></i> Agregar
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
              <th colspan=4>Lista de modelos</th>
            </tr>
            <tr>
              <th>Nro</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $mar = $pdo_conn->query("SELECT * FROM modelo ");
            $marca = $mar->fetchAll(PDO::FETCH_OBJ);
            foreach ($marca as $m) {
            ?>
              <tr>
                <td><?php echo $m->id_modelo; ?></td>
                <td><?php echo $m->modelo; ?></td>
                <td>
                  <a href="add_modelo.php?accion=EDITAR&id_modelo=<?php echo $m->id_modelo; ?>" title="Editar" class="btn btn-sm btn-info text-white"><i class="bi bi-pencil-square"></i></a>
                  <a href="add_modelo.php?accion=ELIMINAR&id_modelo=<?php echo $m->id_modelo; ?>" title="Eliminar" class="btn btn-sm btn-danger text-white" onClick="return confirm('Desea eliminar el modelo?');"><i class="bi bi-trash"></i></a>
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