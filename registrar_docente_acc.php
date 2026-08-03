<?php
require_once('cusuario.php');

// Recibir datos del formulario usando REQUEST
$cedula = $_REQUEST["cedula"];
$apellidos = $_REQUEST["apellidos"];
$nombre = $_REQUEST["nombre"];
$correo = $_REQUEST["correo"];
$telefono = isset($_REQUEST["telefono"]) ? $_REQUEST["telefono"] : "";
$tel_casa = isset($_REQUEST["tel_casa"]) ? $_REQUEST["tel_casa"] : "";
$direccion = isset($_REQUEST["direccion"]) ? $_REQUEST["direccion"] : "";
$usuario = $_REQUEST["usuario"];
$estado = $_REQUEST["estado"];
$token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : "";
$status = isset($_REQUEST["status"]) ? $_REQUEST["status"] : "";
$numDias = isset($_REQUEST["numDias"]) ? $_REQUEST["numDias"] : "15";
$coordinador = $_REQUEST["coordinador"];

// Determinar la acción (INSERTAR o EDITAR)
if (isset($_REQUEST["id_docente"]) && !empty($_REQUEST["id_docente"])) {
    $action = "EDITAR";
    $id_docente = $_REQUEST["id_docente"];
} else {
    $action = "INSERTAR";
}

// Procesar archivo PDF de hoja de vida
$hoja_vida = "";

if ($action == "EDITAR") {
    // Mantener la hoja de vida actual por defecto
    $hoja_vida = isset($_REQUEST["hoja_vida_actual"]) ? $_REQUEST["hoja_vida_actual"] : "";
}

// Procesar nuevo archivo PDF si se subió uno
if (isset($_FILES["hoja_vida"]) && $_FILES["hoja_vida"]["error"] == 0) {
    $directorio = "uploads/hojas_vida/";

    // Crear directorio si no existe
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $nombre_archivo = time() . "_" . basename($_FILES["hoja_vida"]["name"]);
    $ruta_completa = $directorio . $nombre_archivo;

    if (move_uploaded_file($_FILES["hoja_vida"]["tmp_name"], $ruta_completa)) {
        // Eliminar archivo anterior si existe (solo en edición)
        if ($action == "EDITAR" && !empty($hoja_vida) && file_exists($hoja_vida)) {
            unlink($hoja_vida);
        }
        $hoja_vida = $ruta_completa;
    }
}

// ==================== EDITAR ====================
if ($action == "EDITAR") {

    $clave = isset($_REQUEST["clave"]) ? $_REQUEST["clave"] : "";

    // Verificar si se ingresó una nueva clave
    if (!empty($clave)) {
        // Actualizar incluyendo la nueva clave
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        $sql = "UPDATE docente 
                SET cedula = :cedula,
                    apellidos = :apellidos,
                    nombre = :nombre,
                    correo = :correo,
                    telefono = :telefono,
                    tel_casa = :tel_casa,
                    direccion = :direccion,
                    hoja_vida = :hoja_vida,
                    usuario = :usuario,
                    clave = :clave,
                    estado = :estado,
                    token = :token,
                    status = :status,
                    numDias = :numDias,
                    coordinador = :coordinador
                WHERE id_docente = :id_docente";

        $pdo_statement = $pdo_conn->prepare($sql);
        $result = $pdo_statement->execute(array(
            ':cedula' => $cedula,
            ':apellidos' => $apellidos,
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':telefono' => $telefono,
            ':tel_casa' => $tel_casa,
            ':direccion' => $direccion,
            ':hoja_vida' => $hoja_vida,
            ':usuario' => $usuario,
            ':clave' => $clave_encriptada,
            ':estado' => $estado,
            ':token' => $token,
            ':status' => $status,
            ':numDias' => $numDias,
            ':coordinador' => $coordinador,
            ':id_docente' => $id_docente
        ));
    } else {
        // Mantener la clave actual
        $sql = "UPDATE docente 
                SET cedula = :cedula,
                    apellidos = :apellidos,
                    nombre = :nombre,
                    correo = :correo,
                    telefono = :telefono,
                    tel_casa = :tel_casa,
                    direccion = :direccion,
                    hoja_vida = :hoja_vida,
                    usuario = :usuario,
                    estado = :estado,
                    token = :token,
                    status = :status,
                    numDias = :numDias,
                    coordinador = :coordinador
                WHERE id_docente = :id_docente";

        $pdo_statement = $pdo_conn->prepare($sql);
        $result = $pdo_statement->execute(array(
            ':cedula' => $cedula,
            ':apellidos' => $apellidos,
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':telefono' => $telefono,
            ':tel_casa' => $tel_casa,
            ':direccion' => $direccion,
            ':hoja_vida' => $hoja_vida,
            ':usuario' => $usuario,
            ':estado' => $estado,
            ':token' => $token,
            ':status' => $status,
            ':numDias' => $numDias,
            ':coordinador' => $coordinador,
            ':id_docente' => $id_docente
        ));
    }

    if ($result) {
        // Registro de auditoría
        $data = array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO DOCENTE",
            't_operacion' => "EDITAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Actualizados: Nombre= $nombre cedula= $cedula correo= $correo telefono= $telefono tel_casa= $tel_casa direccion= $direccion hoja_vida= $hoja_vida usuario= $usuario estado= $estado token= $token status= $status numDias= $numDias coordinador= $coordinador",
        );

        $insert = $db->insert('auditoria', $data);
        if ($insert) {
            echo ('<br>Auditoria Actualizada<br>');
        } else {
            echo '<br>Error no pudo registrar la auditoria<br>';
            return;
        }
        //**** */

        header('Location: registrar_docente_editar.php?res=editado');
        exit;
    } else {
        header('Location: registrar_docente_add.php?id_docente=' . $id_docente . '&res=error');
        exit;
    }

    // ==================== INSERTAR ====================
} else {

    $clave = $_REQUEST["clave"];
    $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

    $sql = "INSERT INTO docente 
            (cedula, apellidos, nombre, correo, telefono, tel_casa, direccion, hoja_vida, usuario, clave, estado, token, status, numDias, coordinador) 
            VALUES 
            (:cedula, :apellidos, :nombre, :correo, :telefono, :tel_casa, :direccion, :hoja_vida, :usuario, :clave, :estado, :token, :status, :numDias, :coordinador)";

    $pdo_statement = $pdo_conn->prepare($sql);
    $result = $pdo_statement->execute(array(
        ':cedula' => $cedula,
        ':apellidos' => $apellidos,
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':telefono' => $telefono,
        ':tel_casa' => $tel_casa,
        ':direccion' => $direccion,
        ':hoja_vida' => $hoja_vida,
        ':usuario' => $usuario,
        ':clave' => $clave_encriptada,
        ':estado' => $estado,
        ':token' => $token,
        ':status' => $status,
        ':numDias' => $numDias,
        ':coordinador' => $coordinador
    ));

    if ($result) {
        // Registro de auditoría
        $data = array(
            'usuario' => $_SESSION['usuario']->getUsuario(),
            'modulo' => "MODULO DOCENTE",
            't_operacion' => "INSERTAR",
            'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Insertados: Nombre= $nombre cedula= $cedula correo= $correo telefono= $telefono tel_casa= $tel_casa direccion= $direccion hoja_vida= $hoja_vida usuario= $usuario estado= $estado token= $token status= $status numDias= $numDias coordinador= $coordinador",
        );

        $insert = $db->insert('auditoria', $data);
        if ($insert) {
            echo ('<br>Auditoria registrada<br>');
        } else {
            echo '<br>Error no pudo registrar la auditoria<br>';
            return;
        }
        //**** */

        header('Location: registrar_docente_add.php?res=guardado');
        exit;
    } else {
        header('Location: registrar_docente_add.php?res=error');
        exit;
    }
}
