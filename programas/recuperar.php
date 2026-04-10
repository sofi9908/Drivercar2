<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/recuperar.css">
<title>Recuperar contraseña</title>
</head>
<body>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $correo = $_POST['correo'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND estado='activo'";
    $res = mysqli_query($conexion, $sql);

    if(mysqli_num_rows($res) > 0){
        ?>
        <form method="POST" action="actualizar_contrasena.php">
            <input type="hidden" name="correo" value="<?php echo $correo; ?>">

            <h3>Actualizar contraseña</h3>

            <label>Nueva contraseña:</label>
            <input type="password" name="nueva" required>

            <button type="submit">Actualizar</button>
        </form>
        <?php
    } else {
        echo "<p style='color:red;'>Correo no encontrado</p>";
    }

} else {
?>

<form method="POST">
    <h3>Recuperar contraseña</h3>

    <label>Correo:</label>
    <input type="email" name="correo" required>

    <button type="submit">Buscar</button>

    <a href="../html/inicioSesion.html" class="volver">Volver al login</a>
</form>

<?php } ?>

</body>
</html>