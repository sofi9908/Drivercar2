<?php
session_start();
include("../programas/conexion.php");

//if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  //  header("Location: inicioSesion.php");
    //exit();
//}
 include("../programas/obtener_datos_admin.php"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Administrador</title>
<link rel="stylesheet" href="../css/admin.css">
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
            <li onclick="mostrar('usuarios', this)">👥 Usuarios</li>
            <li onclick="mostrar('estudiantes', this)">🎓 Estudiantes</li>
            <li onclick="mostrar('costos', this)">💰 Costos</li>
            <li onclick="mostrar('autos', this)">🚗 Autos</li>
            <li onclick="mostrar('horarios', this)">📅 Horarios</li>
            <li onclick="mostrar('mensajes', this)">✉️ Mensajes</li>
        </ul>
        <a href="../programas/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="header">
            <div class="header-perfil">
                <div class="avatar">
                    <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
                </div>
                <div>
                    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
                    <p>Panel de Administración</p>
                </div>
            </div>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard" class="section">
            <div class="section-tag">● RESUMEN</div>
            <h3 class="section-titulo">Panel de <span class="highlight">Administración</span></h3>

            <div class="dashboard-grid">
                <div class="dash-card">
                    <div class="dash-card-icon">👥</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Total usuarios</span>
                        <span class="dash-value"><?php echo $totalUsuarios; ?></span>
                        <span class="dash-sub">Registrados en el sistema</span>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon">🎓</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Estudiantes</span>
                        <span class="dash-value"><?php echo $totalEstudiantes; ?></span>
                        <span class="dash-sub">En el sistema</span>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon">📅</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Clases hoy</span>
                        <span class="dash-value"><?php echo $resClasesHoy['total']; ?></span>
                        <span class="dash-sub">Programadas para hoy</span>
                    </div>
                </div>
                <div class="dash-card">
                    <div class="dash-card-icon">✉️</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Mensajes</span>
                        <span class="dash-value"><?php echo $totalMensajes; ?></span>
                        <span class="dash-sub">Recibidos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- USUARIOS -->
        <div id="usuarios" class="section oculto">
            <div class="section-tag">● GESTIÓN</div>
            <h3 class="section-titulo">Gestión de <span class="highlight">Usuarios</span></h3>

            <div class="form-card">
                <h3>Crear nuevo usuario</h3>
                <form action="../programas/guardarUsuario.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" placeholder="Nombre completo" required>
                        </div>
                        <div class="form-group">
                            <label>Correo</label>
                            <input type="email" name="email" placeholder="correo@ejemplo.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" name="password" placeholder="••••••••" required>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select name="rol">
                                <option value="1">Admin</option>
                                <option value="2">Estudiante</option>
                                <option value="3">Profesor</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-principal">Crear usuario</button>
                </form>
            </div>

            <!-- Buscar por documento -->
            <div class="form-card" style="margin-top: 20px;">
                <h3>Buscar usuario por documento</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label>Número de documento</label>
                        <input type="text" id="buscarDoc" placeholder="Ej: 1023164940">
                    </div>
                    <div class="form-group" style="justify-content: flex-end; padding-top: 24px;">
                        <button type="button" class="btn-principal" onclick="buscarUsuario()">Buscar</button>
                    </div>
                </div>
                <div id="resultadoBusqueda"></div>
            </div>

            <h3 class="section-titulo" style="font-size: 20px; margin: 30px 0 16px;">Lista de <span class="highlight">usuarios</span></h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                mysqli_data_seek($resUsuarios, 0);
                while($fila = mysqli_fetch_assoc($resUsuarios)) { ?>
                    <tr>
                        <td><?php echo $fila['id_usuario']; ?></td>
                        <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
                        <td><?php echo $fila['correo']; ?></td>
                        <td>
                            <?php
                            $roles = [1 => 'Admin', 2 => 'Estudiante', 3 => 'Profesor'];
                            echo $roles[$fila['id_rol']] ?? $fila['id_rol'];
                            ?>
                        </td>
                        <td>
                            <?php if($fila['estado'] == 'activo'): ?>
                                <span class="badge badge-completada">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-cancelada">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($fila['estado'] == 'activo'): ?>
                                <a class="btn-accion btn-red" href="../programas/cambiar_estado.php?id=<?php echo $fila['id_usuario']; ?>&estado=inactivo">Desactivar</a>
                            <?php else: ?>
                                <a class="btn-accion btn-green" href="../programas/cambiar_estado.php?id=<?php echo $fila['id_usuario']; ?>&estado=activo">Activar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- ESTUDIANTES -->
        <div id="estudiantes" class="section oculto">
            <div class="section-tag">● GESTIÓN</div>
            <h3 class="section-titulo">Gestión de <span class="highlight">Estudiantes</span></h3>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Licencia</th>
                        <th>Profesor asignado</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                mysqli_data_seek($resEstudiantes, 0);
                while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
                    <tr>
                        <td><?php echo $est['nombre'] . " " . $est['apellido']; ?></td>
                        <td><?php echo $est['numero_documento']; ?></td>
                        <td><?php echo $est['tipo_licencia'] ?? '-'; ?></td>
                        <td>
                            <form method="POST" action="../programas/asignar_profesor.php" style="display:flex; gap:8px; align-items:center;">
                                <input type="hidden" name="id_estudiante" value="<?php echo $est['id_estudiante']; ?>">
                                <select name="id_profesor" style="background:#12151f; color:#fff; border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:6px 10px; font-size:13px;">
                                    <option value="">Sin asignar</option>
                                    <?php
                                    mysqli_data_seek($resProfesores, 0);
                                    while($prof = mysqli_fetch_assoc($resProfesores)) { ?>
                                        <option value="<?php echo $prof['id_profesor']; ?>"
                                            <?php if($est['id_profesor'] == $prof['id_profesor']) echo 'selected'; ?>>
                                            <?php echo $prof['nombre'] . " " . $prof['apellido']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <button type="submit" class="btn-accion btn-green">Asignar</button>
                            </form>
                        </td>
                        <td>
                            <?php if($est['estado'] == 'activo'): ?>
                                <span class="badge badge-completada">Activo</span>
                            <?php else: ?>
                                <span class="badge badge-cancelada">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn-accion btn-blue" href="../programas/ver_estudiante.php?id=<?php echo $est['id_estudiante']; ?>">Ver detalle</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- COSTOS -->
        <div id="costos" class="section oculto">
            <div class="section-tag">● PAGOS</div>
            <h3 class="section-titulo">Gestión de <span class="highlight">Costos</span></h3>

            <table>
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Valor</th>
                        <th>Cuotas</th>
                        <th>Fecha Pago</th>
                        <th>Tipo Pase</th>
                        <th>Método Pago</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($costo = mysqli_fetch_assoc($resCostos)) { ?>
                    <tr>
                        <td><?php echo $costo['nombre'] . " " . $costo['apellido']; ?></td>
                        <td>$<?php echo number_format($costo['valor']); ?></td>
                        <td><?php echo $costo['cuotas'] ?? '-'; ?></td>
                        <td><?php echo $costo['fecha_pago']; ?></td>
                        <td><?php echo $costo['tipo_pase'] ?? '-'; ?></td>
                        <td><?php echo $costo['metodo_pago']; ?></td>
                        <td>
                            <a class="btn-accion btn-blue" href="../programas/editar_costo.php?id=<?php echo $costo['id_costo']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- AUTOS -->
        <div id="autos" class="section oculto">
            <div class="section-tag">● VEHÍCULOS</div>
            <h3 class="section-titulo">Gestión de <span class="highlight">Autos</span></h3>

            <table>
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Licencia</th>
                        <th>Tecnomecánica</th>
                        <th>Profesor</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($auto = mysqli_fetch_assoc($resAutos)) {
                    $venc = $auto['tecnomecanica_vencimiento'];
                    $hoy = date('Y-m-d');
                    $badgeAuto = $venc < $hoy ? 'badge-cancelada' : 'badge-completada';
                    $textoAuto = $venc < $hoy ? 'Vencida' : 'Vigente';
                ?>
                    <tr>
                        <td><?php echo $auto['placa']; ?></td>
                        <td><?php echo $auto['modelo']; ?></td>
                        <td><?php echo $auto['tipo_vehiculo']; ?></td>
                        <td><?php echo $auto['tipo_licencia']; ?></td>
                        <td>
                            <?php echo $auto['tecnomecanica_vencimiento']; ?>
                            <span class="badge <?php echo $badgeAuto; ?>"><?php echo $textoAuto; ?></span>
                        </td>
                        <td><?php echo $auto['profesor_nombre'] . " " . $auto['profesor_apellido']; ?></td>
                        <td>
                            <a class="btn-accion btn-blue" href="../programas/editar_auto.php?id=<?php echo $auto['id_auto']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- HORARIOS -->
        <div id="horarios" class="section oculto">
            <div class="section-tag">● DISPONIBILIDAD</div>
            <h3 class="section-titulo">Horarios de <span class="highlight">Profesores</span></h3>

            <div class="form-card">
                <h3>Asignar horario a profesor</h3>
                <form method="POST" action="../programas/guardar_horario.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Profesor</label>
                            <select name="id_profesor" required>
                                <option value="">Seleccione...</option>
                                <?php
                                mysqli_data_seek($resProfesores, 0);
                                while($prof = mysqli_fetch_assoc($resProfesores)) { ?>
                                    <option value="<?php echo $prof['id_profesor']; ?>">
                                        <?php echo $prof['nombre'] . " " . $prof['apellido']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Día</label>
                            <select name="id_dia" required>
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                                <option value="6">Sábado</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bloque horario</label>
                            <select name="id_bloque" required>
                                <option value="1">06:00 - 08:00</option>
                                <option value="2">08:00 - 10:00</option>
                                <option value="3">10:00 - 12:00</option>
                                <option value="4">12:00 - 14:00</option>
                                <option value="5">14:00 - 16:00</option>
                                <option value="6">16:00 - 18:00</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-principal">Asignar horario</button>
                </form>
            </div>

            <h3 class="section-titulo" style="font-size: 20px; margin: 30px 0 16px;">Horarios <span class="highlight">asignados</span></h3>
            <table>
    <thead>
        <tr>
            <th>Profesor</th>
            <th>Día</th>
            <th>Horario</th>
            <th>Estudiante</th>
            <th>Fecha clase</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php while($hor = mysqli_fetch_assoc($resHorarios)) {
        $estado = $hor['estado'] ?? null;
        $badgeClass = 'badge-pendiente';
        if($estado == 'Completada') $badgeClass = 'badge-completada';
        if($estado == 'Cancelada') $badgeClass = 'badge-cancelada';
    ?>
        <tr>
            <td><?php echo $hor['prof_nombre'] . " " . $hor['prof_apellido']; ?></td>
            <td><?php echo $hor['nombre_dia']; ?></td>
            <td><?php echo $hor['hora_inicio'] . " - " . $hor['hora_fin']; ?></td>
            <td>
                <?php if($hor['est_nombre']): ?>
                    <?php echo $hor['est_nombre'] . " " . $hor['est_apellido']; ?>
                <?php else: ?>
                    <span style="color:#4a5068;">Sin estudiante</span>
                <?php endif; ?>
            </td>
            <td><?php echo $hor['fecha'] ?? '-'; ?></td>
            <td>
                <?php if($estado): ?>
                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $estado; ?></span>
                <?php else: ?>
                    <span style="color:#4a5068;">Sin clase</span>
                <?php endif; ?>
            </td>
            <td>
                <a class="btn-accion btn-red" href="../programas/eliminar_horario.php?id=<?php echo $hor['id_disponibilidad']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
        </div>

        <!-- MENSAJES -->
        <div id="mensajes" class="section oculto">
            <div class="section-tag">● CONTACTO</div>
            <h3 class="section-titulo">Mensajes <span class="highlight">recibidos</span></h3>

            <?php if(mysqli_num_rows($resMensajes) == 0): ?>
                <p class="empty-msg">No hay mensajes aún.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                mysqli_data_seek($resMensajes, 0);
                while($msg = mysqli_fetch_assoc($resMensajes)) { ?>
                    <tr>
                        <td><?php echo $msg['nombre']; ?></td>
                        <td><?php echo $msg['correo']; ?></td>
                        <td><?php echo $msg['mensaje']; ?></td>
                        <td><?php echo $msg['fecha']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
function mostrar(seccion, elemento) {
    document.querySelectorAll('.section').forEach(sec => sec.classList.add('oculto'));
    document.getElementById(seccion).classList.remove('oculto');
    document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
    if(elemento && elemento.tagName === 'LI') elemento.classList.add('active');
}

function buscarUsuario() {
    const doc = document.getElementById('buscarDoc').value.trim();
    if(!doc) { alert('Ingresa un número de documento'); return; }

    fetch('../programas/buscar_usuario.php?doc=' + doc)
    .then(res => res.json())
    .then(data => {
        const div = document.getElementById('resultadoBusqueda');
        if(data.error) {
            div.innerHTML = '<p class="empty-msg">❌ ' + data.error + '</p>';
        } else {
            div.innerHTML = `
                <div class="card" style="margin-top:16px;">
                    <p><strong>Nombre:</strong> ${data.nombre} ${data.apellido}</p>
                    <p><strong>Correo:</strong> ${data.correo}</p>
                    <p><strong>Documento:</strong> ${data.numero_documento}</p>
                    <p><strong>Rol:</strong> ${data.rol}</p>
                    <p><strong>Estado:</strong> ${data.estado}</p>
                    <p><strong>Licencia:</strong> ${data.tipo_licencia ?? '-'}</p>
                </div>`;
        }
    });
}
</script>

</body>
</html>