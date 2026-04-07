<?php include("../programas/obtener_datos_estudiante.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Estudiante</title>
<link rel="stylesheet" href="../css/estu.css">
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>DriverCar</h2>

        <ul>
            <li onclick="mostrar('curso')">Curso</li>
            <li onclick="mostrar('notas')">Notas</li>
            <li onclick="mostrar('clases')">Clases</li>
            <li onclick="mostrar('costos')">Costos</li>
            <li onclick="mostrar('perfil')">Mi Perfil</li>
        </ul>

        <a href="../programas/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="header">
            <h2>Bienvenido <?php echo $user['nombre']; ?></h2>
            <p><?php echo $user['correo']; ?></p>
        </div>

        <!-- CURSO -->
        <div id="curso" class="section">
            <h3>Curso</h3>
            <?php while($curso = mysqli_fetch_assoc($resCurso)) { ?>
                <div class="card">
                    <p><strong>Modalidad:</strong> <?php echo $curso['modalidad']; ?></p>
                    <p><strong>Licencia:</strong> <?php echo $curso['tipo_licencia']; ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- NOTAS -->
        <div id="notas" class="section oculto">
    <h3>Mis Notas</h3>

    <?php if(mysqli_num_rows($resNotas) == 0){ ?>
        <p>No tienes notas registradas</p>
    <?php } ?>

    <?php while($nota = mysqli_fetch_assoc($resNotas)) { ?>
        <div class="card">
            <p><strong>Modalidad:</strong> <?php echo $nota['modalidad']; ?></p>
            <p><strong>Observación:</strong> <?php echo $nota['observacion']; ?></p>
            <p><strong>Profesor:</strong> 
                <?php echo $nota['profesor_nombre'] . " " . $nota['profesor_apellido']; ?>
            </p>
        </div>
    <?php } ?>
</div>

        <!-- CLASES -->
        <div id="clases" class="section oculto">
    <h3>Mis Clases</h3>

    <?php if(mysqli_num_rows($resClases) == 0){ ?>
        <p>No tienes clases programadas</p>
    <?php } ?>

    <?php while($clase = mysqli_fetch_assoc($resClases)) { ?>
        <div class="card">
            <p><strong>Día:</strong> <?php echo $clase['nombre_dia']; ?></p>
            <p><strong>Hora:</strong> <?php echo $clase['hora_inicio']; ?> - <?php echo $clase['hora_fin']; ?></p>
            <p><strong>Fecha:</strong> <?php echo $clase['fecha']; ?></p>
            <p><strong>Profesor:</strong> <?php echo $clase['profesor_nombre'] . " " . $clase['profesor_apellido']; ?></p>
            <p><strong>Auto:</strong> <?php echo $clase['placa']; ?></p>
            <p><strong>Estado:</strong> <?php echo $clase['estado']; ?></p>
        </div>
    <?php } ?>
</div>

    <div id="costos" class="section oculto">
    <h3>Mis Costos</h3>

    <table>
        <thead>
        <tr>
            <th>Valor</th>
            <th>Cuotas</th>
            <th>Fecha de Pago</th>
            <th>Tipo Pase</th>
            <th>Método Pago</th>
        </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($resCostos) == 0){ ?>
            <tr><td colspan="5">No tienes costos registrados</td></tr>
        <?php } ?>

        <?php while($costo = mysqli_fetch_assoc($resCostos)) { ?>
        <tr>
            <td>$<?php echo number_format($costo['valor']); ?></td>
            <td><?php echo $costo['cuotas']; ?></td>
            <td><?php echo $costo['fecha_pago']; ?></td>
            <td><?php echo $costo['tipo_pase']; ?></td>
            <td><?php echo $costo['metodo_pago']; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<div id="perfil" class="section oculto">
    <h3>Mi Perfil</h3>

    <div class="card">
        <p><strong>Nombre:</strong> <?php echo $perfil['nombre']; ?></p>
        <p><strong>Correo:</strong> <?php echo $perfil['correo']; ?></p>
        <p><strong>Tipo Licencia:</strong> <?php echo $perfil['tipo_licencia_actual']; ?></p>
        <p><strong>Categoría:</strong> <?php echo $perfil['categoria_licencia']; ?></p>
        <p><strong>Vencimiento:</strong> <?php echo $perfil['vencimiento_licencia']; ?></p>

        <p><strong>Contacto Emergencia:</strong> <?php echo $perfil['contacto_emergencia_nombre']; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $perfil['contacto_emergencia_telefono']; ?></p>
        <p><strong>Parentesco:</strong> <?php echo $perfil['contacto_emergencia_parentesco']; ?></p>

        <button type="button" onclick="mostrar('editarPerfil')">
            Editar perfil
        </button>
    </div>
</div>
<div id="editarPerfil" class="section oculto">
    <h3>Editar Perfil</h3>

    <form method="POST" action="../programas/actualizar_perfil_estudiante.php">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $perfil['nombre']; ?>" required>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo $perfil['correo']; ?>" required>

        <label>Tipo Licencia:</label>
        <input type="text" name="tipo_licencia_actual" value="<?php echo $perfil['tipo_licencia_actual']; ?>">

        <label>Categoría:</label>
        <input type="text" name="categoria_licencia" value="<?php echo $perfil['categoria_licencia']; ?>">

        <label>Vencimiento:</label>
        <input type="date" name="vencimiento_licencia" value="<?php echo $perfil['vencimiento_licencia']; ?>">

        <label>Contacto Emergencia:</label>
        <input type="text" name="contacto_emergencia_nombre" value="<?php echo $perfil['contacto_emergencia_nombre']; ?>">

        <label>Teléfono:</label>
        <input type="text" name="contacto_emergencia_telefono" value="<?php echo $perfil['contacto_emergencia_telefono']; ?>">

        <label>Parentesco:</label>
        <input type="text" name="contacto_emergencia_parentesco" value="<?php echo $perfil['contacto_emergencia_parentesco']; ?>">

        <button type="submit">Guardar cambios</button>
    </form>
</div>
</div>

</div>

<script>
function mostrar(seccion) {
    document.querySelectorAll('.section').forEach(sec => {
        sec.classList.add('oculto');
    });
    document.getElementById(seccion).classList.remove('oculto');
}
</script>

</body>
</html>