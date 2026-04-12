<?php
include("conexion.php");
header('Content-Type: application/json');

$doc = mysqli_real_escape_string($conexion, $_GET['doc']);
$roles = [1 => 'Admin', 2 => 'Estudiante', 3 => 'Profesor'];

$sql = "SELECT * FROM usuarios WHERE numero_documento = '$doc'";
$res = mysqli_query($conexion, $sql);

if(mysqli_num_rows($res) == 0) {
    echo json_encode(['error' => 'No se encontró ningún usuario con ese documento']);
    exit();
}

$user = mysqli_fetch_assoc($res);
$user['rol'] = $roles[$user['id_rol']] ?? 'Desconocido';
unset($user['contrasena']);
echo json_encode($user);
?>