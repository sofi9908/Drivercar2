<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$email = mysqli_real_escape_string($conexion, $_POST['email']);
$password = $_POST['password'];
$rol = $_POST['rol'];

if (empty($nombre) || empty($email) || empty($password)) {
    echo "<script>alert('Faltan datos'); window.history.back();</script>";
    exit();
}

// Verificar si el correo ya existe
$verificar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$email'");
if (mysqli_num_rows($verificar) > 0) {
    echo "<script>alert('Este correo ya está registrado'); window.history.back();</script>";
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, apellido, tipo_documento, numero_documento, correo, contrasena, id_rol)
        VALUES ('$nombre', '', 'CC', '0', '$email', '$password_hash', '$rol')";

if (mysqli_query($conexion, $sql)) {
    $id_usuario = mysqli_insert_id($conexion);

    if ($rol == 2) {
        mysqli_query($conexion, "INSERT INTO estudiantes (id_usuario) VALUES ('$id_usuario')");
    }
    if ($rol == 3) {
        mysqli_query($conexion, "INSERT INTO profesores (id_usuario) VALUES ('$id_usuario')");
    }

    echo "<script>alert('Usuario creado correctamente'); window.location='../html/admin.php';</script>";
} else {
    echo "<script>alert('Error al crear usuario: " . mysqli_error($conexion) . "'); window.history.back();</script>";
}
?>