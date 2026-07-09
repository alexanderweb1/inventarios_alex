<?php
require_once('cusuario.php');
$id_ubicacion = $_REQUEST["id_ubicacion"];
echo "<br>id_ubicacion:$id_ubicacion";

$sql = "DELETE FROM  ubicacion WHERE id_ubicacion=:id_ubicacion;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_ubicacion' => $id_ubicacion));
if (!empty($result)) {
    echo "Registro eliminado correctamente";

    //****** registro auditoria */
    $data    =    array(
        'usuario' => $_SESSION['usuario']->getUsuario(),
        'modulo' => "MODULO UBICACION",
        't_operacion' => "ELIMINAR",
        'descripcion' => $_SESSION['usuario']->getNombre() . " DATO PARA ELIMINAR: id_ubicacion= $id_ubicacion",
    );
    $insert    =    $db->insert('auditoria', $data);
    if ($insert) {
        echo ('<br>Auditoria registrada<br>');
    } else {
        echo '<br>Error no pudo actualizar la auditoria<br>';
        return;
    }
    //**** */
    header('location:registrar_ubicacion_add.php');
    exit;
}
