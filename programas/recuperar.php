<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/recuperar.css">
    <title>Recuperar contraseña - DriverCar</title>
</head>
<body>

<div class="container-wrap">

    <div class="recuperar-card">

        <div class="login-logo">
            <img src="../imagenes/fondo.jpg" alt="Drivercar Logo">
            <span>drivercar</span>
        </div>

        <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <?php
                $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
                $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND estado='activo'";
                $res = mysqli_query($conexion, $sql);
            ?>

            <?php if(mysqli_num_rows($res) > 0): ?>

                <h2>Nueva <span class="highlight">contraseña</span></h2>
                <p class="subtitulo">Ingresa tu nueva contraseña</p>

                <form method="POST" action="actualizar_contrasena.php">
                    <input type="hidden" name="correo" value="<?php echo $correo; ?>">

                    <div class="form-group">
                        <label>Nueva contraseña</label>
                        <input type="password" name="nueva" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-principal">Actualizar contraseña</button>
                    <a href="../html/inicioSesion.php" class="link-volver">Volver al login</a>
                </form>

            <?php else: ?>

                <h2>Recuperar <span class="highlight">contraseña</span></h2>
                <p class="error-msg">❌ Correo no encontrado o usuario inactivo.</p>

                <form method="POST">
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="correo" placeholder="tu@correo.com" required>
                    </div>
                    <button type="submit" class="btn-principal">Buscar</button>
                    <a href="../html/inicioSesion.php" class="link-volver">Volver al login</a>
                </form>

            <?php endif; ?>

        <?php else: ?>

            <h2>Recuperar <span class="highlight">contraseña</span></h2>
            <p class="subtitulo">Ingresa tu correo para continuar</p>

            <form method="POST">
                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="correo" placeholder="tu@correo.com" required>
                </div>
                <button type="submit" class="btn-principal">Buscar</button>
                <a href="../html/inicioSesion.php" class="link-volver">Volver al login</a>
            </form>

        <?php endif; ?>

    </div>

</div>

</body>
</html>