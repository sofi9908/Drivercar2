<?php
session_start();
include("../programas/conexion.php");

$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
// VALIDACIÓN DE SESIÓN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: inicioSesion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Administrador</title>
<link rel="stylesheet" href="../css/admin.css">
</head>

<body>

<div class="container">

    <h2>Bienvenido <?php echo $_SESSION['nombre']; ?></h2>

    <div class="card">
        <h3>Crear Usuario</h3>

        <form id="formUsuario" action="../programas/guardarUsuario.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>

            <select name="rol">
                <option value="1">admin</option>
                <option value="2">Estudiante</option>
                <option value="3">Profesor</option>
            </select>

            <button type="submit">Crear</button>
        </form>

        <p id="mensaje"></p>
    </div>

    <div class="card">
        <h3>Lista de usuarios</h3>

        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>

            <?php while($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $fila['id_usuario']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['id_rol']; ?></td>
                <td class="<?php echo $fila['estado']; ?>">
                    <?php echo $fila['estado']; ?>
                </td>

                <td>
                    <?php if($fila['estado'] == 'activo'){ ?>
                        <a class="btn red" href="../programas/cambiar_estado.php?id=<?php echo $fila['id_usuario']; ?>&estado=inactivo">
                            Desactivar
                        </a>
                    <?php } else { ?>
                        <a class="btn green" href="../programas/cambiar_estado.php?id=<?php echo $fila['id_usuario']; ?>&estado=activo">
                            Activar
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>
    <?php
$sql_mensajes = "SELECT * FROM mensajes ORDER BY fecha DESC";
$resultado_mensajes = mysqli_query($conexion, $sql_mensajes);
?>

<div class="card">
    <h3>Mensajes recibidos</h3>

    <?php if(mysqli_num_rows($resultado_mensajes) == 0){ ?>
        <p>No hay mensajes aún.</p>
    <?php } else { ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Mensaje</th>
            <th>Fecha</th>
        </tr>

        <?php while($msg = mysqli_fetch_assoc($resultado_mensajes)){ ?>
        <tr>
            <td><?php echo $msg['id']; ?></td>
            <td><?php echo $msg['nombre']; ?></td>
            <td><?php echo $msg['correo']; ?></td>
            <td><?php echo $msg['mensaje']; ?></td>
            <td><?php echo $msg['fecha']; ?></td>
        </tr>
        <?php } ?>

    </table>
    <?php } ?>
</div>
    <a href="../programas/logout.php" class="logout">Cerrar sesión</a>

</div>
</body>
</html>

