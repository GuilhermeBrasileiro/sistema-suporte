<?php
include('../index.php');
include('../MySql.php');
$id = $_GET['id'];
$sql = \MySql::conectar()->prepare('DELETE FROM notes WHERE id = (?)');
$sql->execute(array($id));
header("location: ../admin");
die();
?>