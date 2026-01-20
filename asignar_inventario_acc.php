<?php
require_once("db.php");
$id_inventario = $_REQUEST["id_inventario"];
echo "id_inventario=$id_inventario<br>";
$id_docente = $_REQUEST["id_docente"];
echo "id_docente=$id_docente<br>";
$descripcion = $_REQUEST["descripcion"];
echo "descripcion=$descripcion<br>";

// --- aqui controlamos si ya extiste o no el mismo inventario ---
$stmt_nombre = $pdo_conn->prepare("SELECT nombre FROM docente WHERE id_docente = :id");
$stmt_nombre->execute([':id' => $id_docente]);
$docente_obj = $stmt_nombre->fetch(PDO::FETCH_OBJ);
$nombre_docente = ($docente_obj) ? $docente_obj->nombre : "Docente desconocido";
// --------------------


$sql = " SELECT *";
$sql .= " FROM docente_inventario ";
$sql .= " WHERE docente_inventario.id_docente=$id_docente AND docente_inventario.id_inventario=$id_inventario";
// echo $sql . "<br>";


$doc = $pdo_conn->query($sql);
if ($doc->rowCount() == 0) {

    $sql = "INSERT INTO docente_inventario ( id_inventario, id_docente, descripcion) VALUES (:id_inventario, :id_docente, :descripcion);";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':id_inventario' => $id_inventario, ':id_docente' => $id_docente, ':descripcion' => $descripcion));
    if (!empty($result)) {
        // echo "Registro almacenado correctamente";
        // header('location:asignar_inventario_add.php');
        // exit;

        $msj = urlencode("Inventario asignado correctamente a: " . $nombre_docente);
        header("location:asignar_inventario_add.php?error=$msj");
    }
} else {
    // echo "Error, docente ya tiene el laboratorio asignado";
    // header('location:asignar_inventario_add.php?error=Error el docente ya tiene esa asignacion');

    $msj_err = urlencode("Error: " . $nombre_docente . " ya tiene esa asignación");
    header("location:asignar_inventario_add.php?error=$msj_err");
}
