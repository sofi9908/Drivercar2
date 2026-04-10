<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");

$id_usuario = $_SESSION['id_usuario'];

// datos
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$tipo = $_POST['tipo_licencia_actual'];
$categoria = $_POST['categoria_licencia'];
$vencimiento = $_POST['vencimiento_licencia'];
$contacto = $_POST['contacto_emergencia_nombre'];
$telefono = $_POST['contacto_emergencia_telefono'];
$parentesco = $_POST['contacto_emergencia_parentesco'];

//actualizar usuarios
$sqlUsuario = "
UPDATE usuarios 
SET nombre='$nombre', correo='$correo'
WHERE id_usuario='$id_usuario'
";

// actualizar estudiante
$sqlEstudiante = "
UPDATE estudiantes 
SET 
tipo_licencia_actual='$tipo',
categoria_licencia='$categoria',
vencimiento_licencia='$vencimiento',
contacto_emergencia_nombre='$contacto',
contacto_emergencia_telefono='$telefono',
contacto_emergencia_parentesco='$parentesco'
WHERE id_usuario='$id_usuario'
";

if(mysqli_query($conexion, $sqlUsuario) && mysqli_query($conexion, $sqlEstudiante)){
    header("Location: ../html/estudiante.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>