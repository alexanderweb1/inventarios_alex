<?php
require_once("db.php"); // usa $pdo_conn

// ========== GENERAR INVENTARIO (AJAX) ==========
if (isset($_POST['accion']) && $_POST['accion'] === 'generar_inventario') {
    header('Content-Type: application/json');

    try {
        $id_tipo = $_POST['id_tipo_articulo'];

        // Obtener prefijo del tipo
        $stmt = $pdo_conn->prepare("SELECT tipo_articulo FROM tipo_articulo WHERE id_tipo_articulo = ?");
        $stmt->execute([$id_tipo]);
        $tipo = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$tipo) {
            echo json_encode(['error' => 'Tipo de artículo no encontrado']);
            exit;
        }

        $prefijo = strtoupper(substr($tipo->tipo_articulo, 0, 3));

        // Obtener último número de inventario con ese prefijo
        $anio = date('Y');
        $stmt = $pdo_conn->prepare("SELECT n_inventario_istms FROM articulo WHERE n_inventario_istms LIKE ? ORDER BY id_articulo DESC LIMIT 1");
        $stmt->execute(["{$prefijo}-{$anio}-%"]);
        $ultimo = $stmt->fetch(PDO::FETCH_OBJ);

        if ($ultimo) {
            // Extraer número y sumar 1
            $partes = explode('-', $ultimo->n_inventario_istms);
            $numero = intval($partes[2]) + 1;
        } else {
            $numero = 1;
        }

        $nuevo_inventario = sprintf("%s-%s-%04d", $prefijo, $anio, $numero);

        echo json_encode(['inventario' => $nuevo_inventario]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// ========== VALIDAR ACCIÓN ==========
if (!isset($_POST['accion'])) {
    die("Acción no definida");
}

$accion = $_POST['accion'];

// ========== AGREGAR ARTÍCULO ==========
if ($accion === 'AGREGAR') {

    // 1. Gestión de la Foto
    $foto_nombre = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto_nombre = time() . "_" . $_FILES['foto']['name'];
        if (!is_dir("uploads/")) {
            mkdir("uploads/", 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_nombre);
    }

    // 2. Limpieza de datos (fechas y nulos)
    $f_adq   = !empty($_POST['f_adquisicion']) ? $_POST['f_adquisicion'] : null;
    $f_baja  = !empty($_POST['fecha_baja'])    ? $_POST['fecha_baja']    : null;
    $id_mod  = !empty($_POST['id_modelo'])     ? $_POST['id_modelo']     : null;
    $f_reg   = !empty($_POST['fecha'])          ? $_POST['fecha']          : date('Y-m-d H:i:s');

    // 3. SQL con los nombres exactos de tu formulario
    $sql = "INSERT INTO articulo (
        id_ubicacion, id_inventario, nombre, descripcion, id_marca, 
        n_inventario_istms, id_tipo_articulo, foto, v_eco_inicial, 
        f_adquisicion, id_estado, n_serie, id_modelo, baja, 
        descripcion_baja, fecha_baja, fecha
    ) VALUES (
        :id_u, :id_i, :nom, :descr, :id_mar, 
        :n_inv, :id_tip, :foto, :valor, 
        :f_adq, :id_est, :serie, :id_mod, :baja, 
        :d_baja, :f_baja, :f_reg
    )";

    try {
        $stmt = $pdo_conn->prepare($sql);
        $stmt->execute([
            ':id_u'   => $_POST['id_ubicacion'],
            ':id_i'   => $_POST['id_inventario'],
            ':nom'    => $_POST['nombre'],
            ':descr'  => $_POST['descripcion'],
            ':id_mar' => $_POST['id_marca'],
            ':n_inv'  => $_POST['n_inventario_istms'],
            ':id_tip' => $_POST['id_tipo_articulo'],
            ':foto'   => $foto_nombre,
            ':valor'  => $_POST['v_eco_inicial'],
            ':f_adq'  => $f_adq,
            ':id_est' => $_POST['id_estado'],
            ':serie'  => $_POST['n_serie'],
            ':id_mod' => $id_mod,
            ':baja'   => $_POST['baja'],
            ':d_baja' => $_POST['descripcion_baja'],
            ':f_baja' => $f_baja,
            ':f_reg'  => $f_reg
        ]);

        header("Location: registrar_articulo_add.php?res=success");
    } catch (PDOException $e) {
        echo "Error al insertar: " . $e->getMessage();
    }
    exit;
}

// ========== MODIFICAR ARTÍCULO ==========
if ($accion === 'EDITAR') {

    $id_articulo = $_POST['id_articulo'];

    // Gestión de la foto
    $foto_nombre = $_POST['foto_actual']; // Mantener la foto actual por defecto

    if (!empty($_FILES['foto']['name'])) {
        // Si hay nueva foto, eliminar la anterior
        if (!empty($_POST['foto_actual']) && file_exists("uploads/" . $_POST['foto_actual'])) {
            unlink("uploads/" . $_POST['foto_actual']);
        }

        $foto_nombre = time() . "_" . $_FILES['foto']['name'];
        if (!is_dir("uploads/")) {
            mkdir("uploads/", 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto_nombre);
    }

    // Limpieza de datos
    $f_adq   = !empty($_POST['f_adquisicion']) ? $_POST['f_adquisicion'] : null;
    $f_baja  = !empty($_POST['fecha_baja'])    ? $_POST['fecha_baja']    : null;
    $id_mod  = !empty($_POST['id_modelo'])     ? $_POST['id_modelo']     : null;
    $f_reg   = !empty($_POST['fecha'])          ? $_POST['fecha']          : date('Y-m-d H:i:s');

    $sql = "UPDATE articulo SET
        id_ubicacion = :id_u,
        id_inventario = :id_i,
        nombre = :nom,
        descripcion = :descr,
        id_marca = :id_mar,
        n_inventario_istms = :n_inv,
        id_tipo_articulo = :id_tip,
        foto = :foto,
        v_eco_inicial = :valor,
        f_adquisicion = :f_adq,
        id_estado = :id_est,
        n_serie = :serie,
        id_modelo = :id_mod,
        baja = :baja,
        descripcion_baja = :d_baja,
        fecha_baja = :f_baja,
        fecha = :f_reg
    WHERE id_articulo = :id_art";

    try {
        $stmt = $pdo_conn->prepare($sql);
        $stmt->execute([
            ':id_u'    => $_POST['id_ubicacion'],
            ':id_i'    => $_POST['id_inventario'],
            ':nom'     => $_POST['nombre'],
            ':descr'   => $_POST['descripcion'],
            ':id_mar'  => $_POST['id_marca'],
            ':n_inv'   => $_POST['n_inventario_istms'],
            ':id_tip'  => $_POST['id_tipo_articulo'],
            ':foto'    => $foto_nombre,
            ':valor'   => $_POST['v_eco_inicial'],
            ':f_adq'   => $f_adq,
            ':id_est'  => $_POST['id_estado'],
            ':serie'   => $_POST['n_serie'],
            ':id_mod'  => $id_mod,
            ':baja'    => $_POST['baja'],
            ':d_baja'  => $_POST['descripcion_baja'],
            ':f_baja'  => $f_baja,
            ':f_reg'   => $f_reg,
            ':id_art'  => $id_articulo
        ]);

        header("Location: registrar_articulo_add.php?res=updated");
    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
    }
    exit;
}
