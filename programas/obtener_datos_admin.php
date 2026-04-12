<?php
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}
// ── USUARIOS ──
$sqlUsuarios = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
$resUsuarios = mysqli_query($conexion, $sqlUsuarios);

// ── ESTUDIANTES ──
$sqlEstudiantes = "
SELECT e.id_estudiante, e.id_profesor, u.nombre, u.apellido, u.correo, 
       u.numero_documento, u.estado, u.tipo_licencia,
       e.tipo_licencia_actual, e.categoria_licencia, e.vencimiento_licencia
FROM estudiantes e
INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
ORDER BY u.nombre";
$resEstudiantes = mysqli_query($conexion, $sqlEstudiantes);

// ── PROFESORES ──
$sqlProfesores = "
SELECT p.id_profesor, u.nombre, u.apellido
FROM profesores p
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
ORDER BY u.nombre";
$resProfesores = mysqli_query($conexion, $sqlProfesores);

// ── COSTOS ──
$sqlCostos = "
SELECT c.id_costo, c.valor, c.cuotas, c.fecha_pago, c.tipo_pase, c.metodo_pago,
       u.nombre, u.apellido
FROM costos c
INNER JOIN estudiantes e ON c.idEstudiante = e.id_estudiante
INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
ORDER BY c.fecha_pago DESC";
$resCostos = mysqli_query($conexion, $sqlCostos);

// ── AUTOS ──
$sqlAutos = "
SELECT a.id_auto, a.placa, a.tecnomecanica_vencimiento, a.tipo_vehiculo, 
       a.modelo, a.tipo_licencia, u.nombre AS profesor_nombre, u.apellido AS profesor_apellido
FROM autos a
INNER JOIN profesores p ON a.idProfesor = p.id_profesor
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
ORDER BY a.placa";
$resAutos = mysqli_query($conexion, $sqlAutos);

// ── HORARIOS ──
$sqlHorarios = "
SELECT 
    dp.id_disponibilidad,
    u.nombre AS prof_nombre, 
    u.apellido AS prof_apellido,
    d.nombre_dia, 
    b.hora_inicio, 
    b.hora_fin,
    ue.nombre AS est_nombre,
    ue.apellido AS est_apellido,
    c.fecha,
    c.estado
FROM disponibilidad_profesores dp
INNER JOIN profesores p ON dp.idProfesor = p.id_profesor
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
INNER JOIN dias_semana d ON dp.id_dia = d.id_dia
INNER JOIN bloques_horarios b ON dp.id_bloque = b.id_bloque
LEFT JOIN clases_programadas c ON c.idProfesor = p.id_profesor 
    AND c.id_dia = dp.id_dia 
    AND c.id_bloque = dp.id_bloque
LEFT JOIN estudiantes e ON c.idEstudiante = e.id_estudiante
LEFT JOIN usuarios ue ON e.id_usuario = ue.id_usuario
ORDER BY u.nombre, dp.id_dia, dp.id_bloque";
$resHorarios = mysqli_query($conexion, $sqlHorarios);

// ── MENSAJES ──
$sqlMensajes = "SELECT * FROM mensajes ORDER BY fecha DESC";
$resMensajes = mysqli_query($conexion, $sqlMensajes);

// ── STATS DASHBOARD ──
$totalUsuarios = mysqli_num_rows($resUsuarios);
$totalEstudiantes = mysqli_num_rows($resEstudiantes);
$resClasesHoy = mysqli_fetch_assoc(mysqli_query($conexion, 
    "SELECT COUNT(*) as total FROM clases_programadas WHERE fecha = CURDATE()"));
$totalMensajes = mysqli_num_rows($resMensajes);

// Reset cursors
mysqli_data_seek($resUsuarios, 0);
mysqli_data_seek($resEstudiantes, 0);
mysqli_data_seek($resMensajes, 0);
?>