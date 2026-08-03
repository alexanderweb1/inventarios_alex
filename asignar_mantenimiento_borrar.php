<?php
require_once('cusuario.php');

$id_mantenimiento = $_REQUEST["id_mantenimiento"];
echo "<br>id_mantenimiento:$id_mantenimiento";

$sql = "DELETE FROM  mantenimiento WHERE id_mantenimiento=:id_mantenimiento;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_mantenimiento' => $id_mantenimiento));
if (!empty($result)) {
    //****** registro auditoria */
    $data    =    array(
        'usuario' => $_SESSION['usuario']->getUsuario(),
        'modulo' => "MANTENIMIENTO EQUIPO",
        't_operacion' => "ELIMINAR",
        'descripcion' => $_SESSION['usuario']->getNombre() . " Registro Eliminado: Id mantenimiento: $id_mantenimiento",
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
    header('location:asignar_mantenimiento_add.php');
    exit;
}
