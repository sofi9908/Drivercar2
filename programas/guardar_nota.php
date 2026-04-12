<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 3) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener id_profesor
$sqlProf = "SELECT id_profesor FROM profesores WHERE id_usuario = '$id_usuario'";
$resProf = mysqli_query($conexion, $sqlProf);
$prof = mysqli_fetch_assoc($resProf);
$id_profesor = $prof['id_profesor'];

// Obtener datos del formulario
$id_estudiante = $_POST['id_estudiante'];
$modalidad = mysqli_real_escape_string($conexion, $_POST['modalidad']);
$observacion = mysqli_real_escape_string($conexion, $_POST['observacion']);

if(empty($observacion)) {
    echo "<script>alert('La observación no puede estar vacía'); window.history.back();</script>";
    exit();
}

// Insertar nota
$sql = "INSERT INTO notas (idProfesor, idEstudiante, modalidad, observacion)
        VALUES ('$id_profesor', '$id_estudiante', '$modalidad', '$observacion')";

if(mysqli_query($conexion, $sql)) {
    echo "<script>alert('Nota guardada correctamente'); window.location='../html/profesor.php';</script>";
} else {
    echo "<script>alert('Error al guardar: " . mysqli_error($conexion) . "'); window.history.back();</script>";
}
?>