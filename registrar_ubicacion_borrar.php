<?php
    require_once("db.php");
    $id_ubicacion=$_REQUEST["id_ubicacion"];
    echo "<br>id_ubicacion:$id_ubicacion"; 

     $sql = "DELETE FROM  ubicacion WHERE id_ubicacion=:id_ubicacion;";
     $pdo_statement = $pdo_conn->prepare( $sql );
     $result = $pdo_statement->execute( array( ':id_ubicacion'=>$id_ubicacion) );
    if (!empty($result) ){
	   echo "Registro eliminado correctamente";
       header('location:registrar_ubicacion_add.php');
	   exit;
	}
?>