<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id_profesor = $_POST['id_profesor'];
$id_dia = $_POST['id_dia'];
$id_bloque = $_POST['id_bloque'];

// Verificar si ya existe ese horario
$verificar = mysqli_query($conexion, "SELECT * FROM disponibilidad_profesores 
    WHERE idProfesor='$id_profesor' AND id_dia='$id_dia' AND id_bloque='$id_bloque'");

if(mysqli_num_rows($verificar) > 0) {
    echo "<script>alert('Este horario ya está asignado a ese profesor'); window.history.back();</script>";
    exit();
}

$sql = "INSERT INTO disponibilidad_profesores (idProfesor, id_dia, id_bloque) 
        VALUES ('$id_profesor', '$id_dia', '$id_bloque')";

if(mysqli_query($conexion, $sql)) {
    echo "<script>alert('Horario asignado correctamente'); window.location='../html/admin.php';</script>";
} else {
    echo "<script>alert('Error: " . mysqli_error($conexion) . "'); window.history.back();</script>";
}
?>