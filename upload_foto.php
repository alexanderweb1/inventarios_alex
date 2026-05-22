<?php
require_once('usuario.php');
session_start();
if (!isset($_SESSION['usuario'])) {
	header('Location: ingreso_usuarios.php');
}

require_once("db.php");
include_once('config.php');
include_once('az.multi.upload.class.php');

$id_articulo=$_REQUEST["id_articulo"];
$rename	=	rand(1000,5000).time();
$upload	=	new ImageUploadAndResize();
$upload->uploadMultiFiles('files', 'ficheros', $rename, 0755);
$flag	=	0;
foreach($upload->prepareNames as $name){

        $flag	=	1;
        $info = new SplFileInfo($name);
        echo $info;

        //move_uploaded_file("/var/www/html/smistms/fciheros/".$name,"/var/www/fciheros/".$name);
        //copy("/var/www/html/smistms/ficheros/".$name,"/var/www/ficheros/".$name
        
        if( strtolower($info->getExtension()=="jpeg")  ){
            if (copy("C:\\xampp\\htdocs\\inventarios\\ficheros\\".$name,"C:\\xampp\\htdocs\\inventarios\\fotos\\".$name))
           // if (copy("/var/www/html/smistms/ficheros/".$name,"/var/www/expedientes/".$name))
            {
                //$_ruta='/var/www/html/smistms/ficheros/'.$name;

                        $data	=	array(
                        'id_articulo' => trim($id_articulo),
                        'ruta' => trim($name)
                        );
                        $insert	=	$db->insert('foto', $data);
                        
                        if ($insert) {
                        header('location:articulo.php?msg=ras');
                        exit;
                        } else {
                        header('location:articulo.php?msg=rna');
                        exit;
                        }



                unlink("C:\\xampp\\htdocs\\inventarios\\ficheros\\".$name);
                unlink($_ruta);

                echo "Se ha movido el fichero correctamente"; 
            }
            else
            {echo "Error, no se ha podido copiar el fichero";return;}
        }
        else
        {echo "<br>ERROR, La extensión no es adecuada";}
}
echo "<br>flag:".$flag;

if($flag	==	1){
	header('location:subir_foto.php');
	exit;
}
?>