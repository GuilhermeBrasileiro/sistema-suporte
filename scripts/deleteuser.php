<?php
include('../index.php');
include('../MySql.php');
$id = $_GET['id'];
$sql = \MySql::conectar()->prepare('DELETE FROM users WHERE id = (?)');
$sql->execute(array($id));
header("location: ../admin/usuarios");
die();
?>