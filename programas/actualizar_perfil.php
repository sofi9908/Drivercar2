<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");

$id_usuario = $_SESSION['id_usuario'];

// datos
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$licencia = $_POST['licencia_categoria'];
$vencimiento = $_POST['vencimiento_licencia'];
$experiencia = $_POST['experiencia_anios'];
$certificado = $_POST['certificado_idoneidad'];

// 🔥 actualizar usuarios
$sqlUsuario = "
UPDATE usuarios 
SET nombre='$nombre', apellido='$apellido', correo='$correo'
WHERE id_usuario='$id_usuario'
";

// 🔥 actualizar profesor
$sqlProfesor = "
UPDATE profesores p
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
SET 
p.licencia_categoria='$licencia',
p.vencimiento_licencia='$vencimiento',
p.experiencia_anios='$experiencia',
p.certificado_idoneidad='$certificado'
WHERE u.id_usuario='$id_usuario'
";

if(mysqli_query($conexion, $sqlUsuario) && mysqli_query($conexion, $sqlProfesor)){
    header("Location: ../html/profesor.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>