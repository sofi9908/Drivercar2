<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id_estudiante = $_POST['id_estudiante'];
$id_profesor = $_POST['id_profesor'];

$sql = "UPDATE estudiantes SET id_profesor = '$id_profesor' WHERE id_estudiante = '$id_estudiante'";

if(mysqli_query($conexion, $sql)) {
    echo "<script>alert('Profesor asignado correctamente'); window.location='../html/admin.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conexion) . "'); window.history.back();</script>";
}
?>