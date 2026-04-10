<?php
session_start();
include("conexion.php");

// Validar datos
if (!isset($_POST["email"]) || !isset($_POST["password"])) {
    die("Datos incompletos");
}

$correo = mysqli_real_escape_string($conexion,$_POST["email"]);
$password = $_POST["password"];

#$correo = mysqli_real_escape_string($conexion, $correo);
#$password = mysqli_real_escape_string($conexion, $password);

$consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    die("Error en la consulta");
}

$filas = mysqli_fetch_assoc($resultado);

if ($filas) {

    // Verificar si el usuario está activo
    if ($filas["estado"] != 'activo') {
        echo "Usuario inactivo. Contacte al administrador.";
        exit();
    }

    if (password_verify($password, $filas["contrasena"])) {

        $_SESSION["rol"] = $filas["id_rol"];
        $_SESSION["nombre"] = $filas["nombre"];
        $_SESSION['id_usuario'] = $filas['id_usuario'];

        if ($filas["id_rol"] == 1) {
            header("Location:../html/admin.php");
            exit();
        } 
        else if ($filas["id_rol"] == 2) {
            header("Location:../html/estudiante.php");
            exit();
        } 
        else if ($filas["id_rol"] == 3) {
            header("Location:../html/profesor.php");
            exit();
        }

    } else {
        echo "Contraseña incorrecta";
    }

} else {
    echo "Usuario no existe";
}

mysqli_close($conexion);
?>