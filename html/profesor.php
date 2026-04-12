<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include("../programas/obtener_datos_profesor.php");

// Validar sesión
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 3) {
    header("Location: inicioSesion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Profesor</title>
<link rel="stylesheet" href="../css/profe.css">
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
            <li onclick="mostrar('estudiantes', this)">👥 Estudiantes</li>
            <li onclick="mostrar('clases_programadas', this)">📅 Clases</li>
            <li onclick="mostrar('cursos', this)">🎓 Cursos</li>
            <li onclick="mostrar('autos', this)">🚗 Autos</li>
            <li onclick="mostrar('notas', this)">📝 Notas</li>
            <li onclick="mostrar('perfil', this)">👤 Mi Perfil</li>
        </ul>
        <a href="../programas/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="header">
            <div class="header-perfil">
                <div class="avatar">
                    <?php echo strtoupper(substr($perfil['nombre'], 0, 1)); ?>
                </div>
                <div>
                    <h2>Bienvenido, <?php echo $perfil['nombre']; ?></h2>
                    <p><?php echo $perfil['correo']; ?></p>
                </div>
            </div>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard" class="section">
            <div class="section-tag">● RESUMEN</div>
            <h3 class="section-titulo">Tu panel de <span class="highlight">profesor</span></h3>

            <div class="dashboard-grid">

                <?php
                mysqli_data_seek($resEstudiantes, 0);
                $totalEst = mysqli_num_rows($resEstudiantes);
                mysqli_data_seek($resEstudiantes, 0);
                ?>
                <div class="dash-card">
                    <div class="dash-card-icon">👥</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Estudiantes</span>
                        <span class="dash-value"><?php echo $totalEst; ?></span>
                        <span class="dash-sub">Asignados a ti</span>
                    </div>
                </div>

                <?php
                mysqli_data_seek($resClases_programadas, 0);
                $totalClases = mysqli_num_rows($resClases_programadas);
                mysqli_data_seek($resClases_programadas, 0);
                ?>
                <div class="dash-card">
                    <div class="dash-card-icon">📅</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Clases programadas</span>
                        <span class="dash-value"><?php echo $totalClases; ?></span>
                        <span class="dash-sub">En total</span>
                    </div>
                </div>

                <?php
                mysqli_data_seek($resAutos, 0);
                $totalAutos = mysqli_num_rows($resAutos);
                mysqli_data_seek($resAutos, 0);
                ?>
                <div class="dash-card">
                    <div class="dash-card-icon">🚗</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Vehículos</span>
                        <span class="dash-value"><?php echo $totalAutos; ?></span>
                        <span class="dash-sub">Asignados a ti</span>
                    </div>
                </div>

                <?php
                mysqli_data_seek($resNotas, 0);
                $totalNotas = mysqli_num_rows($resNotas);
                mysqli_data_seek($resNotas, 0);
                ?>
                <div class="dash-card">
                    <div class="dash-card-icon">📝</div>
                    <div class="dash-card-info">
                        <span class="dash-label">Notas registradas</span>
                        <span class="dash-value"><?php echo $totalNotas; ?></span>
                        <span class="dash-sub">En total</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- ESTUDIANTES -->
        <div id="estudiantes" class="section oculto">
            <div class="section-tag">● MIS ESTUDIANTES</div>
            <h3 class="section-titulo">Lista de <span class="highlight">Estudiantes</span></h3>

            <div class="cards-grid">
                <?php
                mysqli_data_seek($resEstudiantes, 0);
                while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
                    <div class="card">
                        <div class="card-avatar">
                            <?php echo strtoupper(substr($est['nombre'], 0, 1)); ?>
                        </div>
                        <h3><?php echo $est['nombre'] . " " . $est['apellido']; ?></h3>
                        <span class="badge badge-completada">Estudiante activo</span>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- CLASES PROGRAMADAS -->
        <div id="clases_programadas" class="section oculto">
            <div class="section-tag">● PROGRAMACIÓN</div>
            <h3 class="section-titulo">Mis <span class="highlight">Clases</span></h3>

            <?php
            $dias = [1=>"Lunes",2=>"Martes",3=>"Miércoles",4=>"Jueves",5=>"Viernes",6=>"Sábado"];
            $bloques = [1=>"06:00 - 08:00",2=>"08:00 - 10:00",3=>"10:00 - 12:00",4=>"12:00 - 14:00",5=>"14:00 - 16:00",6=>"16:00 - 18:00"];
            mysqli_data_seek($resClases_programadas, 0);
            while($clase = mysqli_fetch_assoc($resClases_programadas)) { ?>
                <div class="card">
                    <div class="card-top">
                        <div>
                            <p><strong>Estudiante:</strong> <?php echo $clase['Estudiante'] . " " . $clase['Apellido']; ?></p>
                            <p><strong>Auto:</strong> <?php echo $clase['Auto']; ?></p>
                            <p><strong>Día:</strong> <?php echo $dias[$clase['Dia']]; ?></p>
                            <p><strong>Horario:</strong> <?php echo $bloques[$clase['Bloque']]; ?></p>
                            <p><strong>Fecha:</strong> <?php echo $clase['Fecha']; ?></p>
                        </div>
                        <div>
                            <?php
                            $estado = $clase['Estado'];
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

        <!-- CURSOS -->
        <div id="cursos" class="section oculto">
            <div class="section-tag">● FORMACIÓN</div>
            <h3 class="section-titulo">Mis <span class="highlight">Cursos</span></h3>

            <div class="cards-grid">
                <?php
                mysqli_data_seek($resCursos, 0);
                while($curso = mysqli_fetch_assoc($resCursos)) { ?>
                    <div class="card">
                        <div class="card-icon">🎓</div>
                        <h3><?php echo $curso['nombre'] . " " . $curso['apellido']; ?></h3>
                        <p><strong>Modalidad:</strong> <?php echo $curso['modalidad']; ?></p>
                        <p><strong>Licencia:</strong> <?php echo $curso['tipo_licencia']; ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- AUTOS -->
        <div id="autos" class="section oculto">
            <div class="section-tag">● VEHÍCULOS</div>
            <h3 class="section-titulo">Mis <span class="highlight">Autos</span></h3>

            <div class="cards-grid">
                <?php
                mysqli_data_seek($resAutos, 0);
                while($auto = mysqli_fetch_assoc($resAutos)) { ?>
                    <div class="card">
                        <div class="card-icon">🚗</div>
                        <h3><?php echo $auto['placa']; ?></h3>
                        <p><strong>Modelo:</strong> <?php echo $auto['modelo']; ?></p>
                        <p><strong>Tipo:</strong> <?php echo $auto['tipo_vehiculo']; ?></p>
                        <p><strong>Licencia:</strong> <?php echo $auto['tipo_licencia']; ?></p>
                        <p><strong>Tecnomecánica:</strong> <?php echo $auto['tecnomecanica_vencimiento']; ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- NOTAS -->
        <div id="notas" class="section oculto">
            <div class="section-tag">● EVALUACIONES</div>
            <h3 class="section-titulo">Mis <span class="highlight">Notas</span></h3>

            <?php if(mysqli_num_rows($resNotas) == 0){ ?>
                <p class="empty-msg">No hay notas registradas</p>
            <?php } ?>

            <?php
            mysqli_data_seek($resNotas, 0);
            while($nota = mysqli_fetch_assoc($resNotas)) { ?>
                <div class="card">
                    <p><strong>Estudiante:</strong> <?php echo $nota['nombre'] . " " . $nota['apellido']; ?></p>
                    <p><strong>Modalidad:</strong> <?php echo $nota['modalidad']; ?></p>
                    <p><strong>Observación:</strong> <?php echo $nota['observacion']; ?></p>
                </div>
            <?php } ?>

            <div class="form-card">
                <h3>Agregar nueva nota</h3>
                <form method="POST" action="../programas/guardar_nota.php">

                    <div class="form-group">
                        <label>Estudiante</label>
                        <select name="id_estudiante" required>
                            <?php
                            mysqli_data_seek($resEstudiantes, 0);
                            while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
                                <option value="<?php echo $est['id_estudiante']; ?>">
                                    <?php echo $est['nombre'] . " " . $est['apellido']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Modalidad</label>
                        <select name="modalidad">
                            <option value="Teorico">Teórico</option>
                            <option value="Practico">Práctico</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Observación</label>
                        <textarea name="observacion" placeholder="Escribe la observación..."></textarea>
                    </div>

                    <button type="submit" class="btn-principal">Guardar nota</button>
                </form>
            </div>
        </div>

        <!-- PERFIL -->
        <div id="perfil" class="section oculto">
            <div class="section-tag">● INFORMACIÓN</div>
            <h3 class="section-titulo">Mi <span class="highlight">Perfil</span></h3>
            <div class="card">
                <p><strong>Nombre:</strong> <?php echo $perfil['nombre'] . " " . $perfil['apellido']; ?></p>
                <p><strong>Correo:</strong> <?php echo $perfil['correo']; ?></p>
                <p><strong>Categoría Licencia:</strong> <?php echo $perfil['licencia_categoria']; ?></p>
                <p><strong>Vencimiento:</strong> <?php echo $perfil['vencimiento_licencia']; ?></p>
                <p><strong>Experiencia:</strong> <?php echo $perfil['experiencia_anios']; ?> años</p>
                <p><strong>Certificado:</strong> <?php echo $perfil['certificado_idoneidad']; ?></p>
                <button type="button" onclick="mostrar('editarPerfil', this)">Editar perfil</button>
            </div>
        </div>

        <!-- EDITAR PERFIL -->
        <div id="editarPerfil" class="section oculto">
            <div class="section-tag">● EDITAR</div>
            <h3 class="section-titulo">Editar <span class="highlight">Perfil</span></h3>
            <form method="POST" action="../programas/actualizar_perfil.php">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="<?php echo $perfil['nombre']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" name="apellido" value="<?php echo $perfil['apellido']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="correo" value="<?php echo $perfil['correo']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Categoría Licencia</label>
                    <input type="text" name="licencia_categoria" value="<?php echo $perfil['licencia_categoria']; ?>">
                </div>
                <div class="form-group">
                    <label>Vencimiento Licencia</label>
                    <input type="date" name="vencimiento_licencia" value="<?php echo $perfil['vencimiento_licencia']; ?>">
                </div>
                <div class="form-group">
                    <label>Experiencia (años)</label>
                    <input type="number" name="experiencia_anios" value="<?php echo $perfil['experiencia_anios']; ?>">
                </div>
                <div class="form-group">
                    <label>Certificado</label>
                    <input type="text" name="certificado_idoneidad" value="<?php echo $perfil['certificado_idoneidad']; ?>">
                </div>
                <button type="submit" class="btn-principal">Guardar cambios</button>
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