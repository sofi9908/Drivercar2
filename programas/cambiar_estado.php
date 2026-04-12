<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id = $_GET['id'];
$estado = $_GET['estado'];

$sql = "UPDATE usuarios SET estado='$estado' WHERE id_usuario='$id'";
mysqli_query($conexion, $sql);

header("Location: ../html/admin.php");
exit();
?>