<?php
require_once('include/usuario.php');
require_once('include/cusuario.php');

$usuario = "123456";
$modulo = "INGRESO";
$t_operacion = "INGRESO";
$descripcion = "tEST DE PRUEBA";

$data    =    array(
    'usuario' => trim($usuario),
    'modulo' => trim($modulo),
    't_operacion' => trim($t_operacion),
    'descripcion' => trim($descripcion),
);
$insert    =    $db->insert('auditoria', $data);

if ($insert) {
    echo ('<br>Auditoria registrada<br>');
    exit;
} else {
    echo '<br>Error no pudo insertarse la auditoria<br>';
    exit;
}
