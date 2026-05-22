<?php
    require_once("db.php");
    include_once('config.php');
    $id_articulo=$_REQUEST["id_articulo"];
    echo "id_articulo=$id_articulo<br>";
    $id_inventario=$_REQUEST["id_inventario"];
    echo "id_inventario=$id_inventario<br>";
    $id_ubicacion=$_REQUEST["id_ubicacion"];
    echo "id_ubicacion=$id_ubicacion<br>";
    $id_marca=$_REQUEST["id_marca"];
    echo "id_marca=$id_marca<br>";
    $id_tipo_articulo=$_REQUEST["id_tipo_articulo"];
    echo "id_modelo=$id_modelo<br>";
    $id_modelo=$_REQUEST["id_modelo"];

    echo "id_tipo_articulo=$id_tipo_articulo<br>";
    $id_estado=$_REQUEST["id_estado"];
    echo "id_estado=$id_estado<br>";
    $descripcion=$_REQUEST["descripcion"];
    echo "descripcion=$descripcion<br>";
    $nombre=$_REQUEST["nombre"];
    echo "nombre=$nombre<br>";
    $n_inventario_istms=$_REQUEST["n_inventario_istms"];
    echo "n_inventario_istms=$n_inventario_istms<br>";
    $v_eco_inicial=$_REQUEST["v_eco_inicial"];
    echo "v_eco_inicial=$v_eco_inicial<br>";
    $f_adquisicion=$_REQUEST["f_adquisicion"];
    echo "f_adquisicion=$f_adquisicion<br>";
    $n_serie=$_REQUEST["n_serie"];
    echo "n_serie=$n_serie<br>";
    $fecha_baja=$_REQUEST["fecha_baja"];
    echo "fecha_baja=$fecha_baja<br>";
    $descripcion_baja=$_REQUEST["descripcion_baja"];
    echo "descripcion_baja=$descripcion_baja<br>";
    $accion=$_REQUEST["accion"];

    		
    if($accion=="EDITAR"){
        $sql = "UPDATE articulo SET id_ubicacion=:id_ubicacion,id_inventario=:id_inventario ,id_marca=:id_marca,id_modelo=:id_modelo,id_tipo_articulo=:id_tipo_articulo ,id_estado=:id_estado ,descripcion=:descripcion ,nombre=:nombre ,n_inventario_istms=:n_inventario_istms ,v_eco_inicial=:v_eco_inicial ,f_adquisicion=:f_adquisicion ,n_serie=:n_serie ,fecha_baja=:fecha_baja ,descripcion_baja=:descripcion_baja where id_articulo=:id_articulo; ";
        echo "<br>".$sql."<br>"; 

        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':id_ubicacion'=>$id_ubicacion,':id_inventario'=>$id_inventario,':id_marca'=>$id_marca,':id_modelo'=>$id_modelo,':id_tipo_articulo'=>$id_tipo_articulo,':id_estado'=>$id_estado,':descripcion'=>$descripcion,':nombre'=>$nombre,':n_inventario_istms'=>$n_inventario_istms,':v_eco_inicial'=>$v_eco_inicial,':f_adquisicion'=>$f_adquisicion,':n_serie'=>$n_serie,':fecha_baja'=>$fecha_baja,':descripcion_baja'=>$descripcion_baja,':id_articulo'=>$id_articulo  ) );
        if (!empty($result) ){
        echo "Registro actualizado correctamente";
        header('location:articulo.php');
        exit;
        }
    }else{

        $sql =  "INSERT INTO articulo (id_ubicacion,id_inventario  ,id_marca,id_modelo,id_tipo_articulo ,id_estado ,descripcion ,nombre ,n_inventario_istms ,v_eco_inicial ,f_adquisicion ,n_serie ,fecha_baja ,descripcion_baja) "; 
        $sql .= " VALUES           (:id_ubicacion,:id_inventario,:id_marca,:id_modelo,:id_tipo_articulo,:id_estado,:descripcion,:nombre,:n_inventario_istms,:v_eco_inicial,:f_adquisicion,:n_serie,:fecha_baja,:descripcion_baja );";
        $pdo_statement = $pdo_conn->prepare( $sql );
        $result = $pdo_statement->execute( array( ':id_ubicacion'=>$id_ubicacion, ':id_inventario'=>$id_inventario,':id_marca'=>$id_marca,':id_modelo'=>$id_modelo,':id_tipo_articulo'=>$id_tipo_articulo,':id_estado'=>$id_estado,':descripcion'=>$descripcion,':nombre'=>$nombre,':n_inventario_istms'=>$n_inventario_istms,':v_eco_inicial'=>$v_eco_inicial,':f_adquisicion'=>$f_adquisicion,':n_serie'=>$n_serie,':fecha_baja'=>$fecha_baja,':descripcion_baja'=>$descripcion_baja ) );
        if (!empty($result) ){
        echo "Registro almacenado correctamente";
        header('location:articulo.php');
        exit;
        }
    }
?>