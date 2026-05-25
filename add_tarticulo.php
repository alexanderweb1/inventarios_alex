<?php
require_once('include/usuario.php');
require_once('include/cusuario.php');

if (isset($_REQUEST['submit']) and $_REQUEST['submit'] != "") {
  extract($_REQUEST);

  if ($accion == "EDITAR") {
    $data  =  array(
      'tipo_articulo' => $tipo_articulo,
    );
    $update  =  $db->update('tipo_articulo', $data, array('id_tipo_articulo' => $id_tipo_articulo));
    if ($insert) {
      header('location:add_tarticulo.php?msg=edi');
      exit;
    } else {
      header('location:add_tarticulo.php?msg=nedi');
      exit;
    }
    return;
  } else {
    $data  =  array(
      'tipo_articulo' => trim($tipo_articulo),
    );
    $insert  =  $db->insert('tipo_articulo', $data);

    if ($insert) {
      header('location:add_tarticulo.php?msg=ras');
      exit;
    } else {
      header('location:add_tarticulo.php?msg=rna');
      exit;
    }
  }
}
//PARA ACCION CLICN EN EL ENLACE
if (isset($_REQUEST['accion']) and $_REQUEST['accion'] != "") {
  extract($_REQUEST);
  echo "<br>accion:" . $accion;
  if ($accion == "ELIMINAR") {
    $data  =  array(
      'id_tipo_articulo' => trim($id_tipo_articulo),
    );
    $delete  =  $db->delete('tipo_articulo', $data);
    if ($delete) {
      header('location:add_tarticulo.php?msg=del');
      exit;
    } else {
      header('location:add_tarticulo.php?msg=undel');
      exit;
    }
  }
  if ($accion == "EDITAR") {
    $row_edit  =  $db->getAllRecords('tipo_articulo', '*', ' AND id_tipo_articulo="' . $_REQUEST['id_tipo_articulo'] . '"');
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
  <title>Sistema de inventarios - Administrar tipos de artículo </title>
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

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <?php
          require_once('cabecera.php');

          if (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "del") {
            echo  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Regitro eliminado correctamente</div>';
          } elseif (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "edi") {

            echo  '<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Registro actualizado correctamente!</div>';
          } elseif (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "ras") {

            echo  '<div class="alert alert-success"><i class="fa fa-thumbs-up"></i> Registro almacenado correctamente!</div>';
          } elseif (isset($_REQUEST['msg']) and $_REQUEST['msg'] == "rna") {

            echo  '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Record not added <strong>Please try again!</strong></div>';
          }
          ?>
          <h1 data-aos="fade-up">Administrar <span>Tipo de Artículo</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ingrese los datos del tipo de artículo<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <form id="form1" name="form1" method="post">
              <div class="form-group">
                <label for="usuario" class="sr-only">Tipo de artículo:</label>
                <input type="hidden" name="id_tipo_articulo" id="id_tipo_articulo"
                  <?php
                  if ($accion == "EDITAR") {
                    echo "value='" . $_REQUEST['id_tipo_articulo'] . "'";
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
                <input required name="tipo_articulo" id="tipo_articulo" class="form-control" placeholder="Ingrese el tipo de artículo"
                  <?php
                  if ($accion == "EDITAR") {
                    echo "value='" . $row_edit[0]['tipo_articulo'] . "'";
                  } else {
                    echo "value=''";
                  }
                  ?>>
              </div>
              <div class="form-group mb-4">
              </div>

              <input name="submit" id="submit" class="btn btn-block login-btn mb-4" type="submit" value="Agregar">

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
              <th colspan=4>Lista de tipos de artículo</th>
            </tr>
            <tr>
              <th>Id.</th>
              <th>Tipo de artículo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $row_tipo_articulo  =  $db->getAllRecords('tipo_articulo', '*', ' ');
            foreach ($row_tipo_articulo as $ta) {
            ?>
              <tr>
                <td><?php echo $ta['id_tipo_articulo']; ?></td>
                <td><?php echo $ta['tipo_articulo']; ?></td>
                <td>
                  <a href="add_tarticulo.php?accion=EDITAR&id_tipo_articulo=<?php echo $ta['id_tipo_articulo']; ?>" class="text-primary"><i class="bi bi-pencil-square"></i>Editar</a>
                  <a href="add_tarticulo.php?accion=ELIMINAR&id_tipo_articulo=<?php echo $ta['id_tipo_articulo']; ?>" class="text-danger" onClick="return confirm('Desea eliminar?');"><i class="bi bi-trash3-fill"></i>Borrar</a>
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