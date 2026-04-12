<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id = $_GET['id'];
$sql = "DELETE FROM disponibilidad_profesores WHERE id_disponibilidad = '$id'";

if(mysqli_query($conexion, $sql)) {
    echo "<script>alert('Horario eliminado'); window.location='../html/admin.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conexion) . "'); window.history.back();</script>";
}
?>