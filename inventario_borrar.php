<?php
require_once("db.php");
$id_inventario = $_REQUEST["id_inventario"];
echo "<br>id_inventario:$id_inventario";

$sql = "DELETE FROM  inventario WHERE id_inventario=:id_inventario;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_inventario' => $id_inventario));
if (!empty($result)) {
    echo "Registro eliminado correctamente";
    header('location:inventario_add.php');
    exit;
}
