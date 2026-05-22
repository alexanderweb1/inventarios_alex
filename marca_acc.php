<?php
    require_once("db.php");
    $id_marca=$_REQUEST["id_marca"];
    echo "id_marca=$id_marca<br>";
    $accion=$_REQUEST["accion"];
    echo "accion=$accion<br>";
    $nombre=$_REQUEST["nombre"];
    echo "nombre=$nombre<br>";
    $descripcion=$_REQUEST["descripcion"];
    echo "descripcion=$descripcion<br>";

    if($accion=="EDITAR"){
        $sql = "UPDATE marca SET nombre=:nombre,descripcion=:descripcion where id_marca=:id_marca;";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':nombre'=>$nombre, ':descripcion'=>$descripcion,':id_marca'=>$id_marca  ) );
        if (!empty($result) ){
        echo "Registro actualizado correctamente";
        header('location:add_marca.php');
        exit;
        }
    }else{
        $sql = "INSERT INTO marca ( nombre, descripcion) VALUES ( :nombre, :descripcion);";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':nombre'=>$nombre, ':descripcion'=>$descripcion ) );
        if (!empty($result) ){
        echo "Registro almacenado correctamente";
        header('location:add_marca.php');
        exit;
        }
    }
?>