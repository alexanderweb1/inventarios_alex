<?php
    require_once("db.php");
    $id_estado=$_REQUEST["id_estado"];
    echo "id_estado=$id_estado<br>";
    $accion=$_REQUEST["accion"];
    echo "accion=$accion<br>";
    $estado=$_REQUEST["estado"];
    echo "estado=$estado<br>";
    $descripcion=$_REQUEST["descripcion"];
    echo "descripcion=$descripcion<br>";

    if($accion=="EDITAR"){
        $sql = "UPDATE estado SET estado=:estado,descripcion=:descripcion where id_estado=:id_estado;";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':estado'=>$estado,':descripcion'=>$descripcion, ':id_estado'=>$id_estado  ) );
        if (!empty($result) ){
        echo "Registro actualizado correctamente";
        header('location:add_estado.php');
        exit;
        }
    }else{
        $sql = "INSERT INTO estado (estado,descripcion) VALUES ( :estado,:descripcion);";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':estado'=>$estado,':descripcion'=>$descripcion ) );
        if (!empty($result) ){
        echo "Registro almacenado correctamente";
        header('location:add_estado.php');
        exit;
        }
    }
?>