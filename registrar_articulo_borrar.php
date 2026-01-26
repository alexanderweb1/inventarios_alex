<?php
require_once "conexion.php";

$pdo = Db::conectar();

$id_articulo = $_REQUEST['id'] ?? null;

if (!$id_articulo) {
    die("ID de artículo no válido");
}

/* Obtener foto */
$stmt = $pdo->prepare("SELECT foto FROM articulo WHERE id_articulo = :id");
$stmt->execute([':id' => $id_articulo]);
$art = $stmt->fetch(PDO::FETCH_OBJ);

try {
    /* Eliminar artículo */
    $stmt = $pdo->prepare("DELETE FROM articulo WHERE id_articulo = :id");
    $stmt->execute([':id' => $id_articulo]);

    /* Eliminar imagen SOLO si se borró el artículo */
    if ($art && !empty($art->foto)) {
        $ruta = "uploads/" . $art->foto;
        if (file_exists($ruta)) {
            unlink($ruta);
        }
    }

    header("Location: registrar_articulo_add.php?msg=eliminado");
    exit;
} catch (PDOException $e) {

    // Error de clave foránea
    if ($e->errorInfo[1] == 1451) {
        header("Location: registrar_articulo_add.php?msg=usado");
    } else {
        header("Location: registrar_articulo_add.php?msg=error");
    }
    exit;
}
