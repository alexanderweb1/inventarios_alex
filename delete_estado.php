<?php
   require_once('cusuario.php');
    require_once("db.php");
    $id_estado=$_REQUEST["id_estado"];
    echo "<br>id_estado:$id_estado"; 

     $sql = "DELETE FROM  estado WHERE id_estado=:id_estado;";
     $pdo_statement = $pdo_conn->prepare( $sql );
     $result = $pdo_statement->execute( array( ':id_estado'=>$id_estado) );
    if (!empty($result) ){
	   echo "Registro eliminado correctamente";
       header('location:add_estado.php');
	   exit;
	}
?>