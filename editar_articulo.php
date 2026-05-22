<?php
    require_once('usuario.php');
    session_start();
    require_once("db.php");
    include_once('config.php');

    $id_articulo=$_REQUEST["id_articulo"];
    $mar = $pdo->query("SELECT * FROM articulo WHERE id_articulo=$id_articulo; ");	
    $articulo = $mar->fetchAll(PDO::FETCH_OBJ);	
    foreach ($articulo as $art){   
      $id_ubicacion=$art->id_ubicacion;
      $id_inventario=$art->id_inventario;
      $id_marca=$art->id_marca;
      $id_modelo=$art->id_modelo;
      $id_tipo_articulo=$art->id_tipo_articulo;
      $id_estado=$art->id_estado;
      $descripcion=$art->descripcion;
      $nombre=$art->nombre;
      $n_inventario_istms=$art->n_inventario_istms;
      $v_eco_inicial=$art->v_eco_inicial;
      $f_adquisicion=$art->f_adquisicion;
      $fecha_baja=$art->fecha_baja;
      $descripcion_baja=$art->descripcion_baja;
      $n_serie=$art->n_serie;
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistema de inventarios - Administrar artículo</title>
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

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <nav id="navmenu" class="navmenu">
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

<?php 
  if(isset($_REQUEST["error"])){
    $error=$_REQUEST["error"];
    
?>
  <script>
      alert("<?php echo $error?>");
  </script>
<?php
  }
    
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
          <h1 data-aos="fade-up">Administrar <span>artículo</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Igrese los artículos<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
              <form id="form1" name="form1" method="post" action="articulo_acc.php">
                                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione un inventario:</label>
                     <select name="id_inventario" id="id_inventario" class="form-select" aria-label="Default select example">
                      <option value=0 >Elija un inventario</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM inventario; ");	
                        $inventario = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($inventario as $doc){
                          if($id_inventario==$doc->id_inventario){
                              $selected=" selected ";
                          }else{$selected=" ";}
?>                          <option <?php echo $selected;?> value="<?php echo $doc->id_inventario;?>"><?php echo $doc->nombre;?></option>
<?php                   }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione una ubicación:</label>
                     <select name="id_ubicacion" id="id_ubicacion" class="form-select" aria-label="Default select example">
                      <option value=0 selected>Elija una ubicación</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM ubicacion; ");	
                        $ubicacion = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($ubicacion as $ubi){
                          if($id_ubicacion==$ubi->id_ubicacion){
                              $selected=" selected ";
                          }else{$selected=" ";}

?>
                          <option <?php echo $selected;?> value="<?php echo $ubi->id_ubicacion;?>"><?php echo $ubi->nombre;?></option>
<?php                   }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione una marca:</label>
                     <select name="id_marca" id="id_marca" class="form-select" aria-label="Default select example">
                      <option value=0 selected>Elija una marca</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM marca; ");	
                        $marca = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($marca as $mar){
                          if($id_marca==$mar->id_marca){
                              $selected=" selected ";
                          }else{$selected=" ";}
?>
                          <option <?php echo $selected;?> value="<?php echo $mar->id_marca;?>"><?php echo $mar->nombre;?></option>
<?php                   }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione un modelo:</label>
                     <select name="id_modelo" id="id_modelo" class="form-select" aria-label="Default select example">
                      <option value=0 selected>Elija un modelo</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM modelo; ");	
                        $modelo = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($modelo as $mod){
                          if($id_modelo==$mod->id_modelo){
                              $selected=" selected ";
                          }else{$selected=" ";}
?>
                          <option <?php echo $selected;?> value="<?php echo $mod->id_modelo;?>"><?php echo $mod->modelo;?></option>
<?php                   }?>
                    </select>
                  </div>                  
                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione un tipo de artículo:</label>
                     <select name="id_tipo_articulo" id="id_tipo_articulo" class="form-select" aria-label="Default select example">
                      <option value=0 selected>Elija un tipo de artículo</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM tipo_articulo; ");	
                        $tarticulo = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($tarticulo as $tar){ 
                          if($id_tipo_articulo==$tar->id_tipo_articulo){
                              $selected=" selected ";
                          }else{$selected=" ";}
?>
                          <option <?php echo $selected;?> value="<?php echo $tar->id_tipo_articulo;?>"><?php echo $tar->tipo_articulo;?></option>
<?php                   }?>
                    </select>
                  </div>    
                  
                  <div class="form-group">
                    <label for="usuario" class="sr-only">Seleccione el estado del artículo:</label>
                     <select name="id_estado" id="id_estado" class="form-select" aria-label="Default select example">
                      <option value=0 selected>Elija el estado del artículo</option>
<?php 							
                        $mar = $pdo->query("SELECT * FROM estado; ");	
                        $estado = $mar->fetchAll(PDO::FETCH_OBJ);	
                        foreach ($estado as $est){
                          if($id_estado==$est->id_estado){
                              $selected=" selected ";
                          }else{$selected=" ";}
?>
                          <option <?php echo $selected;?> value="<?php echo $est->id_estado;?>"><?php echo $est->estado;?></option>
<?php                   }?>
                    </select>
                  </div>                                 
                  <div class="form-group">
                    <input <?php echo "value=".$nombre;?> type="text" required  name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del articulo">
                    <label for="usuario" class="sr-only">Descripción de la asignaci&oacute;n:</label>
                    <br><textarea required id="descripcion" name="descripcion" rows="3" cols="50" placeholder="Ingrese la descripción de la asignación"><?php echo $descripcion;?></textarea>
                    <input type="text" required <?php echo "value=".$n_inventario_istms;?> name="n_inventario_istms" id="n_inventario_istms" class="form-control" placeholder="Ingrese el número de inventario del articulo">
                    <input type="text" required  <?php echo "value=".$v_eco_inicial;?> name="v_eco_inicial" id="v_eco_inicial" class="form-control" placeholder="Ingrese el valor económico inicial">
                    <label for="usuario" class="sr-only">Fecha de adquisición:</label>
                    <input type="date" required <?php echo "value=".$f_adquisicion;?> name="f_adquisicion" id="f_adquisicion" class="form-control" placeholder="Ingrese la fecha de adquisición">
                    <input required <?php echo "value=".$n_serie;?> name="n_serie" id="n_serie" class="form-control" placeholder="Ingrese el número de serie">
                    <label for="usuario" class="sr-only">Fecha de la baja:</label>
                    <input type="date"  <?php echo "value=".$fecha_baja;?> name="fecha_baja" id="fecha_baja" class="form-control" placeholder="Ingrese la fecha de baja">
                    <label for="usuario" class="sr-only">Descripción de la baja:</label>
                    <br><textarea id="descripcion_baja" name="descripcion_baja" rows="3" cols="50" placeholder="Ingrese la descripción de la baja"><?php echo $descripcion_baja;?></textarea>
                    <input type="hidden"   value="EDITAR" name="accion" id="accion" class="form-control">
                    <input type="hidden"   <?php echo "value=".$id_articulo;?> name="id_articulo" id="id_articulo" class="form-control">
                  
                  </div>
                  <input name="agregar" id="agregar" class="btn btn-block login-btn mb-4" type="submit" value="Asignar">
                  
                </form>          
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->
     <!-- Services Section -->
    


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