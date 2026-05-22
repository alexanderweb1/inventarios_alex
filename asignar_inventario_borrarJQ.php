<?php
    require_once("db.php");
    $id_docente_inventario=$_REQUEST["id_docente_inventario"];
    echo "<br>id_docente_inventario:$id_docente_inventario"; 

     $sql = "DELETE FROM  docente_inventario WHERE id_docente_inventario=:id_docente_inventario;";
     $pdo_statement = $pdo_conn->prepare( $sql );
     $result = $pdo_statement->execute( array( ':id_docente_inventario'=>$id_docente_inventario) );
    if (!empty($result) ){
	   echo "Registro eliminado correctamente";
       header('location:asignar_inventario_add.php');
	   exit;
	}
?>