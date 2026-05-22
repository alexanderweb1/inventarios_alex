<?php
    require_once("db.php");
    include_once('config.php');
    $id_inventario=$_REQUEST["id_inventario"];
    echo "id_inventario=$id_inventario<br>";
    $id_docente=$_REQUEST["id_docente"];
    echo "id_docente=$id_docente<br>";
    $descripcion=$_REQUEST["descripcion"];
    echo "descripcion=$descripcion<br>";

    $sql=" SELECT * "; 
    $sql.=" FROM docente_inventario ";
    $sql.=" WHERE docente_inventario.id_docente=$id_docente AND docente_inventario.id_inventario=$id_inventario ";
    //echo "<br>".$sql."<br>";
    $doc = $pdo->query($sql);
    		
    if ($doc->rowCount() == 0) {
        $sql = "INSERT INTO docente_inventario ( id_docente,id_inventario, descripcion) VALUES ( :id_docente,:id_inventario,:descripcion);";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':id_docente'=>$id_docente,':id_inventario'=>$id_inventario, ':descripcion'=>$descripcion ) );
        if (!empty($result) ){
            echo "Registro almacenado correctamente";
            header('location:asignar_inventario_add.php');
            exit;
        }
    }else{
            echo "Error el docente ya tienen el laboratorio asignado";
            header('location:asignar_inventario_add.php?error=Error el docente ya tienen el laboratorio asignado');
            exit;
    }
?>