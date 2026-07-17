<?php
require_once('cusuario.php');
require_once("usuario.php");
require_once("db.php");
require_once("config.php");

$id_inventario = $_REQUEST["id_inventario"];
echo "<br>id_inventario:$id_inventario";

$sql = "DELETE FROM  inventario WHERE id_inventario=:id_inventario;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_inventario' => $id_inventario));
if (!empty($result)) {
    echo "Registro eliminado correctamente";
    //****** registro auditoria */
    $data    =    array(
        'usuario' => $_SESSION['usuario']->getUsuario(),
        'modulo' => "MODULO INVENTARIO",
        't_operacion' => "ELIMINAR",
        'descripcion' => $_SESSION['usuario']->getNombre() . " Datos registro Eliminados: id_inventario= $id_inventario",
    );
    $insert    =    $db->insert('auditoria', $data);
    if ($insert) {
        echo ('<br>Auditoria registrada<br>');
    } else {
        echo '<br>Error no pudo insertarse la auditoria<br>';
        return;
    }
    //**** */

    header('location:inventario_add.php');
    exit;
}
