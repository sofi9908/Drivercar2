<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$tipo_documento = $_POST['tipo_documento'];
$numero_documento = $_POST['numero_documento'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$id_rol = $_POST['id_rol'];
$tipo_licencia = $_POST['tipo_licencia'];

// Encriptar contraseña 
$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Verificar si el correo ya existe
$verificar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo'");

if (mysqli_num_rows($verificar) > 0) {
    echo "<script>alert('Este correo ya está registrado'); window.history.back();</script>";
    exit();
}

// Insertar datos
$sql = "INSERT INTO usuarios 
(nombre, apellido, tipo_documento, numero_documento, fecha_nacimiento, telefono, direccion, ciudad, correo,contrasena, id_rol, tipo_licencia)
VALUES 
('$nombre','$apellido','$tipo_documento','$numero_documento','$fecha_nacimiento','$telefono','$direccion','$ciudad','$correo','$contrasena_hash','$id_rol', '$tipo_licencia')";

if(mysqli_query($conexion, $sql)){

$id_usuario = mysqli_insert_id($conexion);

if($id_rol == 2){ // estudiante
        $sqlEstudiante = "INSERT INTO estudiantes (id_usuario) VALUES ('$id_usuario')";
        mysqli_query($conexion, $sqlEstudiante);
    }

    if($id_rol == 3){ // profesor
        $sqlProfesor = "INSERT INTO profesores (id_usuario) VALUES ('$id_usuario')";
        mysqli_query($conexion, $sqlProfesor);
    }
    echo "<script>alert('Registro exitoso'); window.location='../html/inicioSesion.php';</script>";
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>