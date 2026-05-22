<?php
    require_once("db.php");
    $id_articulo=$_REQUEST["id_articulo"];
    echo "<br>id_articulo:$id_articulo"; 

     $sql = "DELETE FROM  articulo WHERE id_articulo=:id_articulo;";
     $pdo_statement = $pdo_conn->prepare( $sql );
     $result = $pdo_statement->execute( array( ':id_articulo'=>$id_articulo) );
    if (!empty($result) ){
	   echo "Registro eliminado correctamente";
       header('location:articulo.php');
	   exit;
	}
?>