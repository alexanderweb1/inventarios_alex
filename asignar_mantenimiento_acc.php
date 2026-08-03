<?php
require_once('cusuario.php');

/* =========================
   DATOS DEL FORMULARIO
   ========================= */
$id_articulo = $_POST["id_articulo"];
$fecha_mantenimiento = $_POST["fecha_mantenimiento"];
$descripcion_mantenimiento = $_POST["descripcion_mantenimiento"];
$estado_ingresa = $_POST["estado_ingresa"];

/* =========================
   DEFINIMOS LA ACCIÓN
   ========================= */
if (isset($_POST["actualizar"])) {
    $action = "EDITAR";
} else {
    $action = "INSERTAR";
}

/* =========================
   EDITAR REGISTRO
   ========================= */
if ($action == "EDITAR") {

    // FALTABA ESTO
    $id_mantenimiento = $_POST["id_mantenimiento"];

    $sql = "UPDATE mantenimiento 
            SET id_articulo = :id_articulo,
                fecha_mantenimiento = :fecha_mantenimiento,
                descripcion_mantenimiento = :descripcion_mantenimiento,
                estado_ingresa = :estado_ingresa
            WHERE id_mantenimiento = :id_mantenimiento";

    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(
        ':id_articulo' => $id_articulo,
        ':fecha_mantenimiento' => $fecha_mantenimiento,
        ':descripcion_mantenimiento' => $descripcion_mantenimiento,
        ':estado_ingresa' => $estado_ingresa,
        ':id_mantenimiento' => $id_mantenimiento
    ));

    if ($result) {
        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MANTENIMIENTO EQUIPO",
            't_operacion' => "EDITAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Actualizados: Id artículo: $id_articulo, Fecha mantenimiento= $fecha_mantenimiento, estado en el que ingresa: $estado_ingresa, descripción= $descripcion_mantenimiento ",
        );
        $insert    =    $db->insert('auditoria', $data);
        if ($insert) {
            echo ('<br>Auditoria registrada<br>');
        } else {
            echo '<br>Error no pudo insertarse la auditoria<br>';
            return;
        }
        //**** */
        header('Location: asignar_mantenimiento_add.php?res=editado');
        exit;
    }
} else {

    /* =========================
       INSERTAR REGISTRO
       ========================= */
    $sql = "INSERT INTO mantenimiento 
            (id_articulo, fecha_mantenimiento, descripcion_mantenimiento, estado_ingresa) 
            VALUES 
            (:id_articulo, :fecha_mantenimiento, :descripcion_mantenimiento, :estado_ingresa)";

    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(
        ':id_articulo' => $id_articulo,
        ':fecha_mantenimiento' => $fecha_mantenimiento,
        ':descripcion_mantenimiento' => $descripcion_mantenimiento,
        ':estado_ingresa' => $estado_ingresa
    ));

    if ($result) {
        //****** registro auditoria */
        $data    =    array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MANTENIMIENTO EQUIPO",
            't_operacion' => "INSERTAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Insertados: Id artículo: $id_articulo, Fecha mantenimiento= $fecha_mantenimiento, estado en el que ingresa: $estado_ingresa, descripción= $descripcion_mantenimiento ",
        );
        $insert    =    $db->insert('auditoria', $data);
        if ($insert) {
            echo ('<br>Auditoria registrada<br>');
        } else {
            echo '<br>Error no pudo insertarse la auditoria<br>';
            return;
        }
        //**** */
        header('Location: asignar_mantenimiento_add.php?res=guardado');
        exit;
    }
}
