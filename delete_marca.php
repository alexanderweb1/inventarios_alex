<?php
require_once('cusuario.php');

$id_marca = $_REQUEST["id_marca"];
echo "<br>id_marca:$id_marca";

$sql = "DELETE FROM  MARCA WHERE id_marca=:id_marca;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_marca' => $id_marca));
if (!empty($result)) {

   //****** registro auditoria */
   $data    =    array(
      'usuario' => $_SESSION['usuario']->getUsuario(),
      'modulo' => "MODULO MARCA",
      't_operacion' => "ELIMINAR",
      'descripcion' => $_SESSION['usuario']->getNombre() . " DATO PARA ELIMINAR: id_marca= $id_marca",
   );
   $insert    =    $db->insert('auditoria', $data);
   if ($insert) {
      echo ('<br>Auditoria registrada<br>');
   } else {
      echo '<br>Error no pudo actualizar la auditoria<br>';
      return;
   }
   //**** */

   echo "Registro eliminado correctamente";
   header('location:add_marca.php');
   exit;
}
