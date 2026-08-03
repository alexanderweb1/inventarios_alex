<?php
require_once('cusuario.php');

$id_articulo = $_REQUEST["id_articulo"];
echo "<br>id_articulo:$id_articulo";

$sql = "DELETE FROM  articulo WHERE id_articulo=:id_articulo;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_articulo' => $id_articulo));
if (!empty($result)) {
    //****** registro auditoria */
    $data    =    array(
        'usuario' => $_SESSION['usuario']->getUsuario(),
        'modulo' => "MODULO ARTICULO",
        't_operacion' => "ELIMINAR",
        'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Eliminados: id_articulo= $id_articulo",
    );
    $insert    =    $db->insert('auditoria', $data);
    if ($insert) {
        echo ('<br>Auditoria registrada<br>');
    } else {
        echo '<br>Error no pudo insertarse la auditoria<br>';
        return;
    }
    //**** */

    echo "Registro eliminado correctamente";
    header('location:articulo.php');
    exit;
}
