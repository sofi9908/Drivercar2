<?php
session_start();
include("../programas/conexion.php");

$sql = "SELECT * FROM usuarios";
$resultado = mysqli_query($conexion, $sql);
// VALIDACIÓN DE SESIÓN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: inicioSesion.html");
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

    <button class="logout" onclick="cerrarSesion()">Cerrar sesión</button>

</div>
</body>
</html>

