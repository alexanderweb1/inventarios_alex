<?php
require_once('usuario.php');
session_start();
require_once("db.php");
include_once('config.php');

// Obtener el ID del docente a editar
$id_docente = isset($_GET['id_docente']) ? $_GET['id_docente'] : 0;

// Consultar los datos del docente
$stmt = $pdo_conn->prepare("SELECT * FROM docente WHERE id_docente = ?");
$stmt->execute([$id_docente]);
$docente = $stmt->fetch(PDO::FETCH_OBJ);

// Si no existe el docente, redirigir
if (!$docente) {
    header("Location: agregar_docente_add.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sistema de inventarios - Editar docente </title>
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
                    <h1 data-aos="fade-up">Editar <span>Docente</span></h1>
                    <p data-aos="fade-up" data-aos-delay="100">Modifique los datos del docente<br></p>
                    <div class="card shadow p-4" data-aos="fade-up" data-aos-delay="200">

                        <form id="form1" name="form1" method="post" action="registrar_docente_acc.php" enctype="multipart/form-data">

                            <!-- Campo oculto para el ID -->
                            <input type="hidden" name="id_docente" value="<?php echo $docente->id_docente; ?>">

                            <!-- FILA 1 -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="cedula" class="form-label fw-bold">Cédula</label>
                                    <input type="number" required name="cedula" id="cedula" class="form-control"
                                        value="<?php echo $docente->cedula; ?>" placeholder="1712345678">
                                </div>

                                <div class="col-md-4">
                                    <label for="apellidos" class="form-label fw-bold">Apellidos</label>
                                    <input type="text" required name="apellidos" id="apellidos" class="form-control"
                                        value="<?php echo $docente->apellidos; ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="nombre" class="form-label fw-bold">Nombres</label>
                                    <input type="text" required name="nombre" id="nombre" class="form-control"
                                        value="<?php echo $docente->nombre; ?>">
                                </div>
                            </div>

                            <!-- FILA 2 -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label for="correo" class="form-label fw-bold">Correo</label>
                                    <input type="email" required name="correo" id="correo" class="form-control"
                                        value="<?php echo $docente->correo; ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                        value="<?php echo $docente->telefono; ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="tel_casa" class="form-label fw-bold">Teléfono Casa</label>
                                    <input type="text" name="tel_casa" id="tel_casa" class="form-control"
                                        value="<?php echo $docente->tel_casa; ?>">
                                </div>

                                <div class="col-md-3">
                                    <label for="direccion" class="form-label fw-bold">Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="form-control"
                                        value="<?php echo $docente->direccion; ?>">
                                </div>
                            </div>

                            <!-- FILA 3 -->
                            <div class="row mb-4 bg-light p-3 rounded mx-0 border">
                                <div class="col-md-4">
                                    <label for="hoja_vida" class="form-label fw-bold">Hoja de Vida (PDF)</label>
                                    <input type="file" name="hoja_vida" id="hoja_vida" class="form-control" accept=".pdf">
                                    <?php if (!empty($docente->hoja_vida)) { ?>
                                        <small class="text-muted d-block mt-1">
                                            Archivo actual:
                                            <a href="<?php echo $docente->hoja_vida; ?>" target="_blank">
                                                <i class="bi bi-file-pdf"></i> Ver PDF
                                            </a>
                                        </small>
                                    <?php } ?>
                                    <input type="hidden" name="hoja_vida_actual" value="<?php echo $docente->hoja_vida; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="usuario" class="form-label fw-bold text-primary">Usuario</label>
                                    <input type="text" required name="usuario" id="usuario" class="form-control"
                                        value="<?php echo $docente->usuario; ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="clave" class="form-label fw-bold text-primary">Clave</label>
                                    <input type="password" name="clave" id="clave" class="form-control"
                                        placeholder="">
                                    <small class="text-muted">Solo ingrese nueva clave si desea cambiarla</small>
                                </div>
                            </div>

                            <!-- FILA 4 -->
                            <div class="row mb-4 g-3">

                                <!-- ESTADO -->
                                <div class="col-md-4">
                                    <label for="estado" class="form-label fw-bold">Estado</label>
                                    <select name="estado" id="estado" class="form-select">
                                        <option value="ACTIVO" <?php echo ($docente->estado == 'ACTIVO') ? 'selected' : ''; ?>>ACTIVO</option>
                                        <option value="INACTIVO" <?php echo ($docente->estado == 'INACTIVO') ? 'selected' : ''; ?>>INACTIVO</option>
                                    </select>
                                </div>

                                <!-- TOKEN -->
                                <div class="col-md-4">
                                    <label for="token" class="form-label fw-bold">Token</label>
                                    <input type="text" name="token" id="token" class="form-control" maxlength="2"
                                        value="<?php echo $docente->token; ?>">
                                </div>

                                <!-- STATUS -->
                                <div class="col-md-4">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <input type="text" name="status" id="status" class="form-control" maxlength="2"
                                        value="<?php echo $docente->status; ?>">
                                </div>

                            </div>

                            <div class="row mb-4 g-4">

                                <!-- NÚMERO DE DÍAS -->
                                <div class="col-md-6">
                                    <label for="numDias" class="form-label fw-bold">Número de Días</label>
                                    <input type="text" name="numDias" id="numDias" class="form-control"
                                        value="<?php echo $docente->numDias; ?>">
                                </div>

                                <!-- COORDINADOR -->
                                <div class="col-md-6">
                                    <label for="coordinador" class="form-label fw-bold">¿Es Coordinador?</label>
                                    <select name="coordinador" id="coordinador" class="form-select">
                                        <option value="NO" <?php echo ($docente->coordinador == 'NO') ? 'selected' : ''; ?>>NO</option>
                                        <option value="SI" <?php echo ($docente->coordinador == 'SI') ? 'selected' : ''; ?>>SÍ</option>
                                    </select>
                                </div>

                            </div>

                            <!-- BOTONES -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                <a href="registrar_docente_add.php" class="btn btn-secondary px-4">
                                    <i class="bi bi-arrow-left me-2"></i> Volver
                                </a>
                                <button type="submit" class="btn btn-primary px-5 shadow">
                                    <i class="bi bi-save me-2"></i> Actualizar Docente
                                </button>
                            </div>

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