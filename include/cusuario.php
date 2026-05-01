<?php 
require_once('usuario.php');
session_start();
if (!isset($_SESSION['usuario'])) {
	header('Location: ingreso_usuarios.php');
}
		
/*if ($_SESSION['usuario']->getTipo()<>'ADMIN') {					
    echo "<br>No tines permiso para acceder";
    echo "<br>Contacta con el administrador";
    header('Location: controller_login.php?accion=CERRARCESION');
    return;
}*/
        require_once("include/db.php");
        include_once('include/config.php');
?>