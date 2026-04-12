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
        <div class="sidebar-logo">
            <img src="../imagenes/fondo.jpg" alt="Drivercar Logo">
            <span>drivercar</span>
        </div>
        <ul>
            <li onclick="mostrar('dashboard', this)" class="active">🏠 Inicio</li>
            <li onclick="mostrar('curso', this)">🎓 Curso</li>
            <li onclick="mostrar('notas', this)">📝 Notas</li>
            <li onclick="mostrar('clases', this)">📅 Clases</li>
            <li onclick="mostrar('costos', this)">💰 Costos</li>
            <li onclick="mostrar('perfil', this)">👤 Mi Perfil</li>
        </ul>
        <a href="../programas/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="header">
            <div class="header-perfil">
                <div class="avatar">
                    <?php echo strtoupper(substr($user['nombre'], 0, 1)); ?>
                </div>
                <div>
                    <h2>Bienvenido, <?php echo $user['nombre']; ?></h2>
                    <p><?php echo $user['correo']; ?></p>
                </div>
            </div>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard" class="section">
            <div class="section-tag">● RESUMEN</div>
            <h3 class="section-titulo">Tu panel de <span class="highlight">estudiante</span></h3>

            <div class="dashboard-grid">
                <div class="dash-card">
                    <div class="dash-card-icon">📅</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Próxima clase</span>
                        <?php if($proxima): ?>
                            <span class="dash-value"><?php echo $proxima['nombre_dia'] . " " . $proxima['fecha']; ?></span>
                            <span class="dash-sub"><?php echo $proxima['hora_inicio'] . " - " . $proxima['hora_fin']; ?></span>
                            <span class="dash-sub">Prof: <?php echo $proxima['prof_nombre'] . " " . $proxima['prof_apellido']; ?></span>
                        <?php else: ?>
                            <span class="dash-value">Sin clases pendientes</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dash-card">
                    <div class="dash-card-icon">🎓</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Curso actual</span>
                        <?php if($cursoDash): ?>
                            <span class="dash-value">Licencia <?php echo $cursoDash['tipo_licencia']; ?></span>
                            <span class="dash-sub"><?php echo $cursoDash['modalidad']; ?></span>
                        <?php else: ?>
                            <span class="dash-value">Sin curso asignado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="dash-card">
                    <div class="dash-card-icon">📝</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Última nota</span>
                        <?php if($ultNota): ?>
                            <span class="dash-value"><?php echo $ultNota['modalidad']; ?></span>
                            <span class="dash-sub"><?php echo substr($ultNota['observacion'], 0, 50) . "..."; ?></span>
                        <?php else: ?>
                            <span class="dash-value">Sin notas aún</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="dash-card">
                    <div class="dash-card-icon">💰</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Total pagado</span>
                        <span class="dash-value">$<?php echo number_format($total['total'] ?? 0); ?></span>
                    </div>
                </div>

            </div>
        </div>

        <!-- CURSO -->
        <div id="curso" class="section oculto">
            <div class="section-tag">● FORMACIÓN</div>
            <h3 class="section-titulo">Mi <span class="highlight">Curso</span></h3>
            <?php
            // reset cursor
            mysqli_data_seek($resCurso, 0);
            while($curso = mysqli_fetch_assoc($resCurso)) { ?>
                <div class="card">
                    <p><strong>Modalidad:</strong> <?php echo $curso['modalidad']; ?></p>
                    <p><strong>Licencia:</strong> <?php echo $curso['tipo_licencia']; ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- NOTAS -->
        <div id="notas" class="section oculto">
            <div class="section-tag">● EVALUACIONES</div>
            <h3 class="section-titulo">Mis <span class="highlight">Notas</span></h3>
            <?php if(mysqli_num_rows($resNotas) == 0){ ?>
                <p class="empty-msg">No tienes notas registradas</p>
            <?php } ?>
            <?php while($nota = mysqli_fetch_assoc($resNotas)) { ?>
                <div class="card">
                    <p><strong>Modalidad:</strong> <?php echo $nota['modalidad']; ?></p>
                    <p><strong>Observación:</strong> <?php echo $nota['observacion']; ?></p>
                    <p><strong>Profesor:</strong> <?php echo $nota['profesor_nombre'] . " " . $nota['profesor_apellido']; ?></p>
                </div>
            <?php } ?>
        </div>

        <!-- CLASES -->
        <div id="clases" class="section oculto">
            <div class="section-tag">● PROGRAMACIÓN</div>
            <h3 class="section-titulo">Mis <span class="highlight">Clases</span></h3>
            <?php if(mysqli_num_rows($resClases) == 0){ ?>
                <p class="empty-msg">No tienes clases programadas</p>
            <?php } ?>
            <?php while($clase = mysqli_fetch_assoc($resClases)) { ?>
                <div class="card">
                    <div class="card-top">
                        <div>
                            <p><strong>Día:</strong> <?php echo $clase['nombre_dia']; ?></p>
                            <p><strong>Hora:</strong> <?php echo $clase['hora_inicio']; ?> - <?php echo $clase['hora_fin']; ?></p>
                            <p><strong>Fecha:</strong> <?php echo $clase['fecha']; ?></p>
                            <p><strong>Profesor:</strong> <?php echo $clase['profesor_nombre'] . " " . $clase['profesor_apellido']; ?></p>
                            <p><strong>Auto:</strong> <?php echo $clase['placa']; ?></p>
                        </div>
                        <div>
                            <?php
                            $estado = $clase['estado'];
                            $badgeClass = 'badge-pendiente';
                            if($estado == 'Completada') $badgeClass = 'badge-completada';
                            if($estado == 'Cancelada') $badgeClass = 'badge-cancelada';
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $estado; ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- COSTOS -->
        <div id="costos" class="section oculto">
            <div class="section-tag">● PAGOS</div>
            <h3 class="section-titulo">Mis <span class="highlight">Costos</span></h3>
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
                        <td><?php echo $costo['cuotas'] ?? '-'; ?></td>
                        <td><?php echo $costo['fecha_pago']; ?></td>
                        <td><?php echo $costo['tipo_pase'] ?? '-'; ?></td>
                        <td><?php echo $costo['metodo_pago']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- PERFIL -->
        <div id="perfil" class="section oculto">
            <div class="section-tag">● INFORMACIÓN PERSONAL</div>
            <h3 class="section-titulo">Mi <span class="highlight">Perfil</span></h3>
            <div class="card">
                <p><strong>Nombre:</strong> <?php echo $perfil['nombre']; ?></p>
                <p><strong>Correo:</strong> <?php echo $perfil['correo']; ?></p>
                <p><strong>Tipo Licencia:</strong> <?php echo $perfil['tipo_licencia_actual']; ?></p>
                <p><strong>Categoría:</strong> <?php echo $perfil['categoria_licencia']; ?></p>
                <p><strong>Vencimiento:</strong> <?php echo $perfil['vencimiento_licencia']; ?></p>
                <p><strong>Contacto Emergencia:</strong> <?php echo $perfil['contacto_emergencia_nombre']; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $perfil['contacto_emergencia_telefono']; ?></p>
                <p><strong>Parentesco:</strong> <?php echo $perfil['contacto_emergencia_parentesco']; ?></p>
                <button type="button" onclick="mostrar('editarPerfil', this)">Editar perfil</button>
            </div>
        </div>

        <!-- EDITAR PERFIL -->
        <div id="editarPerfil" class="section oculto">
            <div class="section-tag">● EDITAR</div>
            <h3 class="section-titulo">Editar <span class="highlight">Perfil</span></h3>
            <form method="POST" action="../programas/actualizar_perfil_estudiante.php">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $perfil['nombre']; ?>" required>
                <label>Correo:</label>
                <input type="email" name="correo" value="<?php echo $perfil['correo']; ?>" required>
                <label>Tipo Licencia:</label>
                <select name="tipo_licencia_actual" required>
                    <option value="A1" <?php if($perfil['tipo_licencia_actual']=='A1') echo 'selected'; ?>>A1</option>
                    <option value="A2" <?php if($perfil['tipo_licencia_actual']=='A2') echo 'selected'; ?>>A2</option>
                    <option value="B1" <?php if($perfil['tipo_licencia_actual']=='B1') echo 'selected'; ?>>B1</option>
                    <option value="B2" <?php if($perfil['tipo_licencia_actual']=='B2') echo 'selected'; ?>>B2</option>
                    <option value="C1" <?php if($perfil['tipo_licencia_actual']=='C1') echo 'selected'; ?>>C1</option>
                    <option value="C2" <?php if($perfil['tipo_licencia_actual']=='C2') echo 'selected'; ?>>C2</option>
                </select>
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
function mostrar(seccion, elemento) {
    document.querySelectorAll('.section').forEach(sec => sec.classList.add('oculto'));
    document.getElementById(seccion).classList.remove('oculto');
    document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
    if(elemento && elemento.tagName === 'LI') {
        elemento.classList.add('active');
    }
}
</script>

</body>
</html>