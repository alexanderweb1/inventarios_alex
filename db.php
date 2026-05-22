<?php
	$database_username = 'root';
	$database_password = '';
	$pdo_conn = new PDO( 'mysql:host=localhost;dbname=inventario_mariano_samaniego', $database_username, $database_password );
	$conexion = new mysqli("localhost",$database_username,$database_password,"inventario_mariano_samaniego");
	
?>