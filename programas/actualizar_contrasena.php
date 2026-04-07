<?php
include("conexion.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $correo = $_POST['correo'];
    $nueva = $_POST['nueva'];

    $hash = password_hash($nueva, PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET contrasena='$hash' WHERE correo='$correo'";

    if(mysqli_query($conexion, $sql)){
        header("Location: ../html/inicioSesion.html");
exit();
    } else {
        echo "Error";
    }
} else {
    echo "Acceso no permitido";
}
?>