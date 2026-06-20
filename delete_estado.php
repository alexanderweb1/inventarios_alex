<?php
require_once('cusuario.php');

$id_estado = $_REQUEST["id_estado"];
echo "<br>id_estado:$id_estado";

$sql = "DELETE FROM  estado WHERE id_estado=:id_estado;";
$pdo_statement = $pdo_conn->prepare($sql);
$result = $pdo_statement->execute(array(':id_estado' => $id_estado));
if (!empty($result)) {
   echo "Registro eliminado correctamente";

   //****** registro auditoria */
   $data    =    array(
      'usuario' => $_SESSION['usuario']->getUsuario(),
      'modulo' => "MODULO ESTADO",
      't_operacion' => "ELIMINAR",
      'descripcion' => $_SESSION['usuario']->getNombre() . " DATO PARA ELIMINAR: id_estado= $id_estado",
   );
   $insert    =    $db->insert('auditoria', $data);
   if ($insert) {
      echo ('<br>Auditoria registrada<br>');
   } else {
      echo '<br>Error no pudo actualizar la auditoria<br>';
      return;
   }
   //**** */
   header('location:add_estado.php');
   exit;
}
