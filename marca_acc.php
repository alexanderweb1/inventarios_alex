<?php
require_once('cusuario.php');
require_once("usuario.php");
require_once("db.php");
require_once("config.php");

$id_marca = $_REQUEST["id_marca"];
echo "id_marca=$id_marca<br>";
$accion = $_REQUEST["accion"];
echo "accion=$accion<br>";
$nombre = $_REQUEST["nombre"];
echo "nombre=$nombre<br>";
$descripcion = $_REQUEST["descripcion"];
echo "descripcion=$descripcion<br>";

if ($accion == "EDITAR") {
    $sql = "UPDATE marca SET nombre=:nombre,descripcion=:descripcion where id_marca=:id_marca;";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':nombre' => $nombre, ':descripcion' => $descripcion, ':id_marca' => $id_marca));
    if (!empty($result)) {
        echo "Registro actualizado correctamente";

        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO MARCA",
            't_operacion' => "EDITAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Actualizados: Nombre= $nombre descripcion= $descripcion",
        );
        $insert    =    $db->insert('auditoria', $data);
        if ($insert) {
            echo ('<br>Auditoria registrada<br>');
        } else {
            echo '<br>Error no pudo actualizar la auditoria<br>';
            return;
        }
        //**** */


        header('location:add_marca.php');
        exit;
    }
} else {
    $sql = "INSERT INTO marca ( nombre, descripcion) VALUES ( :nombre, :descripcion);";
    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(':nombre' => $nombre, ':descripcion' => $descripcion));

    if (!empty($result)) {
        echo "Registro almacenado correctamente";

        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO MARCA",
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

        header('location:add_marca.php');
        exit;
    }
}
