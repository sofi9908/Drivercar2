<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
        <h2>DriverCar</h2>

        <ul>
            <li onclick="mostrar('estudiantes')">Estudiantes</li>
            <li onclick="mostrar('clases_programadas')">Clases Programadas</li>
            <li onclick="mostrar('cursos')">Cursos</li>
            <li onclick="mostrar('autos')">Autos</li>
            <li onclick="mostrar('notas')">Notas</li>
            <li onclick="mostrar('perfil')">Mi Perfil</li>
        </ul>

        <a href="../programas/logout.php" class="logout">Cerrar sesión</a>
    </div>

    <!-- CONTENIDO -->
    <div class="content">

        <div class="header">
            <h2>Panel Profesor</h2>
        </div>

        <!-- ESTUDIANTES -->
        <div id="estudiantes" class="section">
            <h3>Lista de Estudiantes</h3>

            <select>
                <?php while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
                  <option value="<?php echo $est['id_estudiante']; ?>">
                    <?php echo $est['nombre']; ?>
                    <?php echo $est['apellido']; ?>
                </option>
            <?php } ?>
            </select>

            <ul>
                <?php 
                mysqli_data_seek($resEstudiantes, 0); // reiniciar
                while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
                    <li><?php echo $est['nombre']; ?></li>
                    <li><?php echo $est['apellido']; ?></li>
                <?php } ?>
            </ul>
        </div>
        <!--clases_programadas-->
        <div id="clases_programadas" class="section oculto">
    <h3>Mis clases programadas</h3>
    <table border="1">
        <tr>
            <th>Estudiante</th>
            <th>Profesor</th>
            <th>Auto</th>
            <th>Dia</th>
            <th>Bloque</th>
            <th>Fecha</th>
            <th>Estado</th>
        </tr>
        <?php
$dias = [
    1 => "Lunes",
    2 => "Martes",
    3 => "Miércoles",
    4 => "Jueves",
    5 => "Viernes",
    6 => "Sábado"
];

$bloques = [
    1 => "06:00:00 - 08:00:00",
    2 => "08:00:00 - 10:00:00",
    3 => "10:00:00 - 12:00:00",
    4 => "12:00:00 - 14:00:00",
    5 => "14:00:00 - 16:00:00",
    6 => "16:00:00 - 18:00:00"
];
?>
   
        <?php while($clases_programadas = mysqli_fetch_assoc($resClases_programadas)) { ?>
        <tr>
            <td><?php echo $clases_programadas['Estudiante'] . " " . $clases_programadas['Apellido']; ?></td>
            <td><?php echo $clases_programadas['Profesor'] . " " . $clases_programadas['ApellidoProfesor']; ?></td>
            <td><?php echo $clases_programadas['Auto']; ?></td>
            <td><?php echo $dias[$clases_programadas['Dia']]; ?></td>
            <td><?php echo $bloques[$clases_programadas['Bloque']]; ?></td>
            <td><?php echo $clases_programadas['Fecha']; ?></td>
            <td><?php echo $clases_programadas['Estado']; ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>

        <!-- CURSOS -->
        <div id="cursos" class="section oculto">
            <h3>Cursos</h3>

            <?php while($curso = mysqli_fetch_assoc($resCursos)) { ?>
                <div class="card">
                    <p><strong>Modalidad:</strong> <?php echo $curso['modalidad']; ?></p>
                    <p><strong>Licencia:</strong> <?php echo $curso['tipo_licencia']; ?></p>
                    <p><strong>Estudiante:</strong> <?php echo $curso['nombre'] . " " . $curso['apellido']; ?></p>
                </div>
            <?php } ?>
        </div>
        <div id="autos" class="section oculto">
    <h3>Mis Autos</h3>

    <table border="1">
        <tr>
            <th>Placa</th>
            <th>Tecnomecanica vencimiento</th>
            <th>Tipo</th>
            <th>Modelo</th>
            <th>Tipo licencia</th>
        </tr>

        <?php while($auto = mysqli_fetch_assoc($resAutos)) { ?>
        <tr>
            <td><?php echo $auto['placa']; ?></td>
            <td><?php echo $auto['tecnomecanica_vencimiento']; ?></td>
            <td><?php echo $auto['tipo_vehiculo']; ?></td>
            <td><?php echo $auto['modelo']; ?></td>
            <td><?php echo $auto['tipo_licencia']; ?></td>
        </tr>
        <?php } ?>
    </table>
    </div>
    <div id="notas" class="section oculto">
    <h3>Notas</h3>
    

    <table border="1">
       <tr>
        <th>Estudiante</th>
        <th>Modalidad</th>
        <th>Observación</th>
    </tr>

    <?php if(mysqli_num_rows($resNotas) == 0){ ?>
        <tr><td colspan="3">No hay notas registradas</td></tr>
    <?php } ?>

    <?php while($nota = mysqli_fetch_assoc($resNotas)) { ?>
    <tr>
        <td><?php echo $nota['nombre'] . " " . $nota['apellido']; ?></td>
        <td><?php echo $nota['modalidad']; ?></td>
        <td><?php echo $nota['observacion']; ?></td>
    </tr>
    <?php } ?>
    </table>
    <h4>Agregar nueva nota</h4>
    <form method="POST" action="../programas/guardar_nota.php">

    <label>Estudiante:</label>
    <select name="id_estudiante" required>
        <?php 
        mysqli_data_seek($resEstudiantes, 0);
        while($est = mysqli_fetch_assoc($resEstudiantes)) { ?>
            <option value="<?php echo $est['id_estudiante']; ?>">
                <?php echo $est['nombre'] . " " . $est['apellido']; ?>
            </option>
        <?php } ?>
    </select>

    <label>Modalidad:</label>
    <select name="modalidad">
        <option value="Teorico">Teórico</option>
        <option value="Practico">Práctico</option>
    </select>

    <label>Observación:</label>
    <textarea name="observacion"></textarea>

    <button type="submit">Guardar</button>

</form>
</div>


<div id="perfil" class="section oculto">
    <h3>Mi Perfil</h3>

    <div class="card">
        <p><strong>Nombre:</strong> <?php echo $perfil['nombre'] . " " . $perfil['apellido']; ?></p>
        <p><strong>Correo:</strong> <?php echo $perfil['correo']; ?></p>
        <p><strong>Categoría Licencia:</strong> <?php echo $perfil['licencia_categoria']; ?></p>
        <p><strong>Vencimiento Licencia:</strong> <?php echo $perfil['vencimiento_licencia']; ?></p>
        <p><strong>Experiencia:</strong> <?php echo $perfil['experiencia_anios']; ?> años</p>
        <p><strong>Certificado:</strong> <?php echo $perfil['certificado_idoneidad']; ?></p>
        <button onclick="mostrar('editarPerfil')">Editar perfil</button>
    </div>
    </div>
<div id="editarPerfil" class="section oculto">
    <h3>Editar Perfil</h3>

    <form method="POST" action="../programas/actualizar_perfil.php">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $perfil['nombre']; ?>" required>

        <label>Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $perfil['apellido']; ?>" required>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo $perfil['correo']; ?>" required>

        <label>Categoría Licencia:</label>
        <input type="text" name="licencia_categoria" value="<?php echo $perfil['licencia_categoria']; ?>">

        <label>Vencimiento Licencia:</label>
        <input type="date" name="vencimiento_licencia" value="<?php echo $perfil['vencimiento_licencia']; ?>">

        <label>Experiencia (años):</label>
        <input type="number" name="experiencia_anios" value="<?php echo $perfil['experiencia_anios']; ?>">

        <label>Certificado:</label>
        <input type="text" name="certificado_idoneidad" value="<?php echo $perfil['certificado_idoneidad']; ?>">

        <button type="submit">Guardar cambios</button>
    </form>
</div>
</div>

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
