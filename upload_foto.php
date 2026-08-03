<?php
require_once('usuario.php');
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ingreso_usuarios.php');
}

require_once("db.php");
include_once('config.php');
include_once('az.multi.upload.class.php');

$id_articulo = $_REQUEST["id_articulo"];
$rename = rand(1000, 5000) . time();
$upload = new ImageUploadAndResize();
$upload->uploadMultiFiles('files', 'ficheros', $rename, 0755);
$flag = 0;

foreach ($upload->prepareNames as $name) {

    $flag = 1;
    $info = new SplFileInfo($name);
    echo $info;

    // Se corrigieron los paréntesis para que evalúe la extensión correctamente
    $ext = strtolower($info->getExtension());
    if ($ext == "jpeg" || $ext == "jpg" || $ext == "png") {

        if (copy("C:\\xampp\\htdocs\\inventarios\\ficheros\\" . $name, "C:\\xampp\\htdocs\\inventarios\\fotos\\" . $name)) {

            $data = array(
                'id_articulo' => trim($id_articulo),
                'ruta' => trim($name)
            );
            $insert = $db->insert('foto', $data);

            if ($insert) {
                header('location:subir_foto.php?id_articulo=' . $id_articulo . '&msg=ras');
                exit;
            } else {
                header('location:subir_foto.php?id_articulo=' . $id_articulo . '&msg=rna');
                exit;
            }

            unlink("C:\\xampp\\htdocs\\inventarios\\ficheros\\" . $name);

            echo "Se ha movido el fichero correctamente";
        } else {
            echo "Error, no se ha podido copiar el fichero";
            return;
        }
    } else {
        echo "<br>ERROR, La extensión no es adecuada";
    }
}
echo "<br>flag:" . $flag;

if ($flag == 1) {
    header('location:subir_foto.php?id_articulo=' . $id_articulo);
    exit;
}
