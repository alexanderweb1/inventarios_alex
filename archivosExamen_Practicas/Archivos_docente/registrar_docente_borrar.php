<?php
require_once('cusuario.php');

// Obtener el ID del docente a eliminar
$id_docente = isset($_REQUEST['id_docente']) ? $_REQUEST['id_docente'] : 0;

if ($id_docente > 0) {
    try {
        // Primero obtener la ruta del archivo PDF para eliminarlo
        $stmt = $pdo_conn->prepare("SELECT hoja_vida FROM docente WHERE id_docente = :id_docente");
        $stmt->execute([':id_docente' => $id_docente]);
        $docente = $stmt->fetch(PDO::FETCH_OBJ);

        // Eliminar el registro de la base de datos
        $sql = "DELETE FROM docente WHERE id_docente = :id_docente";
        $pdo_statement = $pdo_conn->prepare($sql);
        $result = $pdo_statement->execute([':id_docente' => $id_docente]);

        if ($result) {
            // Si se eliminó correctamente, también eliminar el archivo PDF si existe
            if ($docente && !empty($docente->hoja_vida) && file_exists($docente->hoja_vida)) {
                unlink($docente->hoja_vida);
            }

            //****** registro auditoria */
            $data    =    array(
                'usuario' => $_SESSION['usuario']->getUsuario(),
                'modulo' => "MODULO DOCENTE",
                't_operacion' => "ELIMINAR",
                'descripcion' => $_SESSION['usuario']->getNombre() . " Datos Eliminados: id_docente= $id_docente",
            );
            $insert    =    $db->insert('auditoria', $data);
            if ($insert) {
                echo ('<br>Auditoria registrada<br>');
            } else {
                echo '<br>Error no pudo registrar la auditoria<br>';
                return;
            }
            //**** */

            header('Location: registrar_docente_add.php?res=eliminado');
            exit;
        } else {
            header('Location: registrar_docente_add.php?res=error');
            exit;
        }
    } catch (PDOException $e) {
        // Si hay error (por ejemplo, restricción de clave foránea)
        header('Location: registrar_docente_add.php?res=error_restriccion');
        exit;
    }
} else {
    header('Location: registrar_docente_add.php?res=error');
    exit;
}
