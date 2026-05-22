<?php
   require_once('cusuario.php');
   require_once("db.php");
    $id_marca=$_REQUEST["id_marca"];
    echo "<br>id_marca:$id_marca"; 

     $sql = "DELETE FROM  MARCA WHERE id_marca=:id_marca;";
     $pdo_statement = $pdo_conn->prepare( $sql );
     $result = $pdo_statement->execute( array( ':id_marca'=>$id_marca) );
    if (!empty($result) ){
	   echo "Registro eliminado correctamente";
       header('location:add_marca.php');
	   exit;
	}
?>