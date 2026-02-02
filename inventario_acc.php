<?php
require_once("db.php");
$id_inventario = $_REQUEST["id_inventario"];
echo "id_inventario=$id_inventario<br>";
$accion = $_REQUEST["accion"];
echo "accion=$accion<br>";
$nombre = $_REQUEST["nombre"];
echo "nombre=$nombre<br>";
$descripcion = $_REQUEST["descripcion"];
echo "descripcion=$descripcion<br>";


if ($accion == "EDITAR") {
    $sql = "UPDATE inventario SET nombre=:nombre,descripcion=:descripcion where id_inventario=:id_inventario;";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':nombre' => $nombre, ':descripcion' => $descripcion, ':id_inventario' => $id_inventario));
    if (!empty($result)) {
        echo "Registro actualizado correctamente";
        header('location:inventario_add.php');
        exit;
    }
} else {
    $sql = "INSERT INTO inventario ( nombre, descripcion, fecha) VALUES ( :nombre, :descripcion);";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':nombre' => $nombre, ':descripcion' => $descripcion));
    if (!empty($result)) {
        echo "Registro almacenado correctamente";
        header('location:inventario_add.php');
        exit;
    }
}
