<?php
$host = "localhost";
$usuario = "root";        
$contrasena = "";         
$base_datos = "drivercar2"; 
$conexion = mysqli_connect($host, $usuario, $contrasena, $base_datos);

if (!$conexion) {
    die(json_encode(["exito" => false, "error" => "Error de conexión"]));
}

$nombre  = mysqli_real_escape_string($conexion, $_POST['nombre']);
$correo  = mysqli_real_escape_string($conexion, $_POST['correo']);
$mensaje = mysqli_real_escape_string($conexion, $_POST['mensaje']);

if (empty($nombre) || empty($correo) || empty($mensaje)) {
    echo json_encode(["exito" => false, "error" => "Todos los campos son obligatorios"]);
    exit;
}

$sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES ('$nombre', '$correo', '$mensaje')";

if (mysqli_query($conexion, $sql)) {
    echo json_encode(["exito" => true]);
} else {
    echo json_encode(["exito" => false, "error" => "Error al guardar"]);
}

mysqli_close($conexion);
?>