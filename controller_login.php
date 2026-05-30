<?php
require_once('usuario.php');
require_once('crud_usuario.php');
require_once('conexion.php');
require_once('include/db.php');
require_once('include/config.php');



$usuario = $_REQUEST["usuario"];
//echo "Usuario:".$usuario."<br>";
$clave = $_REQUEST["clave"];
//echo "Clave:".$clave."<br>";
$tipo = $_REQUEST["tipo"];
//echo "Tipo:".$tipo."<br>";


//inicio de sesion
session_start();
$usuario = new Usuario();
$crud = new CrudUsuario();
//verifica si la variable registrarse está definida
//se da que está definicda cuando el usuario se loguea, ya que la envía en la petición
if (isset($_REQUEST["accion"])) {
	if ($_REQUEST["accion"] == "CERRARCESION") {

		//***REGISTRA AUDITORIA */
		$data	=	array(
			'usuario' => $_SESSION['usuario']->getUsuario(),
			'modulo' => "INGRESO AL SISTEMA",
			't_operacion' => "CERRAR SESION",
			'descripcion' => $_SESSION['usuario']->getNombre(),
		);
		$insert	=	$db->insert('auditoria', $data);

		if ($insert) {
			echo ('<br>Auditoria registrada<br>');
		} else {
			echo '<br>Error no pudo insertarse la auditoria<br>';
		}
		//********** */

		session_destroy();

		header('location:ingreso_usuarios.php');
	}
}
if (isset($_POST['registrarse'])) {
	$usuario->setNombre($_POST['usuario']);
	$usuario->setClave($_POST['pas']);
	if ($crud->buscarUsuario($_POST['usuario'])) {
		$crud->insertar($usuario);
		header('Location:index.php');
	} else {
		header('Location: error.php?mensaje=El nombre de usuario ya existe');
	}
} elseif (isset($_POST['entrar'])) { //verifica si la variable entrar está definida

	//echo "<br>---> Usuario:".$_POST['usuario']." pass:".$_POST['pas']." Tipo:".$tipo;		
	$usuario = $crud->obtenerUsuario($_POST['usuario'], $_POST['clave'], $tipo);
	// si el id del objeto retornado no es null, quiere decir que encontro un registro en la base

	if (!isset(($usuario))) {
		echo "<br>Gestión academica del ISTMS";
		echo "<br>1. ERROR, credenciales no validas<br>";
		echo "<a href='index.php'>Regresar</a>";
		return;
	}

	if ($usuario->getId() != NULL) {
		$_SESSION['usuario'] = $usuario; //si el usuario se encuentra, crea la sesión de usuario			
		if ($usuario->getTipo() == 'DOCENTE') {

			/***REGISTRA AUDITORIA */
			$data	=	array(
				'usuario' => $_REQUEST["usuario"],
				'modulo' => "INGRESO AL SISTEMA",
				't_operacion' => "INICIAR SESION",
				'descripcion' => $_SESSION['usuario']->getNombre(),
			);

			$insert	=	$db->insert('auditoria', $data);

			if ($insert) {
				echo ('<br>Auditoria registrada<br>');
			} else {
				echo '<br>Error no pudo insertarse la auditoria<br>';
			}
			//********** */

			header('Location:index.php?id_docente=' . $usuario->getId()); //envia a la página que simula la cuenta

		} else {
			echo "Error, no hay usuario definido";
			return;
		}
	} else {
		echo "<br>Gestión academica del ISTMS";
		echo "<br>2. ERROR, credenciales no validas<br>";
		echo "<a href='index.php'>Regresar</a>";
		return;
	}
} elseif (isset($_REQUEST['salir'])) { // cuando presiona el botòn salir
	header('Location: index.php');
	unset($_SESSION['usuario']); //destruye la sesión
}
echo "alla va";
