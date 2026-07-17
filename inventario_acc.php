<?php
require_once('cusuario.php');
require_once("usuario.php");
require_once("db.php");
require_once("config.php");


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

        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO INVENTARIO",
            't_operacion' => "EDITAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Actualizados: id_inventario= $id_inventario, Nombre= $nombre, descripcion= $descripcion",
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
} else {
    $sql = "INSERT INTO inventario ( nombre, descripcion) VALUES ( :nombre, :descripcion);";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':nombre' => $nombre, ':descripcion' => $descripcion));
    if (!empty($result)) {
        echo "Registro almacenado correctamente";
        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO INVENTARIO",
            't_operacion' => "INSERTAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Insertados: Nombre= $nombre descripcion= $descripcion",
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
}
