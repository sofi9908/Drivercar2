<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - DriverCar</title>
    <link rel="stylesheet" href="../css/inicioSesion.css">
</head>
<body>

    <div class="container-wrap">

        <button class="btn-volver" onclick="window.location.href='../index.html'">⬅ Volver</button>

        <div class="login-card">

            <div class="login-logo">
                <img src="../imagenes/fondo.jpg" alt="Drivercar Logo">
            </div>

            <h2>Iniciar <span class="highlight">Sesión</span></h2>
            <p class="subtitulo">Bienvenido de nuevo, ingresa tus datos</p>

            <?php if(isset($_GET['error'])): ?>
            <p class="error-msg">
                <?php
                    if($_GET['error'] == 'contrasena') echo '❌ Contraseña incorrecta.';
                    if($_GET['error'] == 'usuario') echo '❌ El correo no está registrado.';
                    if($_GET['error'] == 'inactivo') echo '❌ Usuario inactivo. Contacta al administrador.';
                ?>
            </p>
            <?php endif; ?>

            <form action="../programas/login.php" method="POST">

                <div class="form-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" placeholder="tu@correo.com" required>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn-ingresar">Ingresar</button>

                <?php if(isset($_GET['error'])): ?>
<p class="error-msg">
    <?php
        if($_GET['error'] == 'contraseña') echo '❌ Contraseña incorrecta.';
        if($_GET['error'] == 'usuario') echo '❌ El correo no está registrado.';
    ?>
</p>
<?php endif; ?>

                <a href="../programas/recuperar.php" class="link-recuperar">¿Olvidaste tu contraseña?</a>

            </form>

        </div>

    </div>

</body>
</html>