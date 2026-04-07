<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 2 || !isset($_SESSION['id_usuario'])) {
    header("Location: ../html/inicioSesion.html");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener datos
$sqlUser = "SELECT nombre, correo FROM usuarios WHERE id_usuario = '$id_usuario'";
$resUser = mysqli_query($conexion, $sqlUser);
$user = mysqli_fetch_assoc($resUser);

$sqlCurso = "SELECT modalidad, tipo_licencia FROM cursos WHERE idEstudiante = (
    SELECT id_estudiante FROM estudiantes WHERE id_usuario = '$id_usuario'
)";
$resCurso = mysqli_query($conexion, $sqlCurso);

$sqlNotas = "
SELECT 
    n.modalidad,
    n.observacion,
    u.nombre AS profesor_nombre,
    u.apellido AS profesor_apellido
FROM notas n

INNER JOIN profesores p ON n.idProfesor = p.id_profesor
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario

WHERE n.idEstudiante = (
    SELECT id_estudiante 
    FROM estudiantes 
    WHERE id_usuario = '$id_usuario'
)
";

$resNotas = mysqli_query($conexion, $sqlNotas);

$sqlClases = "
SELECT 
    d.nombre_dia,
    b.hora_inicio,
    b.hora_fin,
    c.fecha,
    c.estado,
    a.placa,
    u.nombre AS profesor_nombre,
    u.apellido AS profesor_apellido
FROM clases_programadas c

INNER JOIN estudiantes e ON c.idEstudiante = e.id_estudiante
INNER JOIN profesores p ON c.idProfesor = p.id_profesor
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario

INNER JOIN autos a ON c.id_auto = a.id_auto
INNER JOIN dias_semana d ON c.id_dia = d.id_dia
INNER JOIN bloques_horarios b ON c.id_bloque = b.id_bloque

WHERE e.id_usuario = '$id_usuario'
";

$resClases = mysqli_query($conexion, $sqlClases);

$sqlCostos = "
SELECT valor, cuotas, fecha_pago, tipo_pase, metodo_pago
FROM costos
WHERE idEstudiante = (
    SELECT id_estudiante FROM estudiantes WHERE id_usuario = '$id_usuario'
)";

$resCostos = mysqli_query($conexion, $sqlCostos);

// 🔥 PERFIL ESTUDIANTE
$sqlPerfil = "
SELECT 
    u.nombre,
    u.correo,
    e.tipo_licencia_actual,
    e.categoria_licencia,
    e.vencimiento_licencia,
    e.contacto_emergencia_nombre,
    e.contacto_emergencia_telefono,
    e.contacto_emergencia_parentesco
FROM estudiantes e
INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
WHERE e.id_usuario = '$id_usuario'
";

$resPerfil = mysqli_query($conexion, $sqlPerfil);
$perfil = mysqli_fetch_assoc($resPerfil);
?>