<?php
    require_once("db.php");
    date_default_timezone_set('America/Guayaquil'); 

    $id_ubicacion = $_REQUEST["id_ubicacion"];
    $accion = $_REQUEST["accion"];
    $nombre = $_REQUEST["nombre"];
    $descripcion = $_REQUEST["descripcion"];
    $fecha_del_form = $_REQUEST["fecha"]; // El día elegido en el calendario (AAAA-MM-DD)

    if($accion == "EDITAR"){
        // 1. Primero consultamos qué fecha y hora tiene actualmente en la base de datos
        $consulta = $pdo_conn->prepare("SELECT fecha FROM ubicacion WHERE id_ubicacion = :id");
        $consulta->execute([':id' => $id_ubicacion]);
        $registro_viejo = $consulta->fetch(PDO::FETCH_OBJ);
        
        $fecha_hora_original = $registro_viejo->fecha; // Ej: "2026-01-14 10:30:00"
        $solo_fecha_original = date("Y-m-d", strtotime($fecha_hora_original)); // Ej: "2026-01-14"

        // 2. Comparamos la fecha que viene del formulario con la que ya existía
        if ($fecha_del_form == $solo_fecha_original) {
            // SI SON IGUALES: Usamos la fecha y hora completa que ya estaba
            $fecha_final = $fecha_hora_original;
        } else {
            // SI SON DIFERENTES: Ponemos la nueva fecha con la hora actual
            $fecha_final = $fecha_del_form . " " . date("H:i:s");
        }

        // 3. Ejecutamos el Update con la $fecha_final decidida
        $sql = "UPDATE ubicacion SET nombre=:nombre, descripcion=:descripcion, fecha=:fecha WHERE id_ubicacion=:id_ubicacion;";
        $pdo_statement = $pdo_conn->prepare($sql);
        $result = $pdo_statement->execute(array(
            ':nombre' => $nombre, 
            ':descripcion' => $descripcion,
            ':fecha' => $fecha_final, 
            ':id_ubicacion' => $id_ubicacion
        ));
        
        if ($result){
            header('location:registrar_ubicacion_add.php');
            exit;
        }
    } else {
        // Lógica normal para INSERT (Registro nuevo)
        $fecha_final = $fecha_del_form . " " . date("H:i:s");
        $sql = "INSERT INTO ubicacion (nombre, descripcion, fecha) VALUES (:nombre, :descripcion, :fecha);";
        $pdo_statement = $pdo_conn->prepare($sql);
        $result = $pdo_statement->execute(array(
            ':nombre' => $nombre, 
            ':descripcion' => $descripcion, 
            ':fecha' => $fecha_final
        ));
        
        if ($result){
            header('location:registrar_ubicacion_add.php');
            exit;
        }
    }
?>