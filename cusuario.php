<?php
require_once('usuario.php');

session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ingreso_usuarios.php');
}

if ($_SESSION['usuario']->getTipo() <> 'DOCENTE') {
    echo "<br>No tines permiso para acceder";
    echo "<br>Contacta con el administrador";
    header('Location: controller_login.php?accion=CERRARCESION');
    return;
}
require_once("db.php");
include_once('config.php');
