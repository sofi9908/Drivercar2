<?php
session_start();
include("conexion.php");


// Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Error: no hay sesión iniciada");
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener id_profesor
$sql = "SELECT id_profesor FROM profesores WHERE id_usuario = '$id_usuario'";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$fila = mysqli_fetch_assoc($result);

if ($fila) {
    $_SESSION['id_profesor'] = $fila['id_profesor'];
} else {
    die("No se encontró el profesor");
}

$id_profesor = $_SESSION['id_profesor'];



// Obtener estudiantes
$sqlEstudiantes = "
SELECT e.id_estudiante, u.nombre, u.apellido
FROM estudiantes e
JOIN usuarios u ON e.id_usuario = u.id_usuario
WHERE e.id_profesor = '$id_profesor'
";
$resEstudiantes = mysqli_query($conexion, $sqlEstudiantes);

//obtener clases_programadas
$sqlClases_programadas = "
SELECT 
u.nombre AS Estudiante,
u.apellido AS Apellido,

up.nombre AS Profesor,
up.apellido AS ApellidoProfesor,

a.placa AS Auto,

c.id_dia AS Dia,
c.id_bloque AS Bloque,
c.fecha AS Fecha,
c.estado AS Estado

FROM clases_programadas c

JOIN estudiantes e ON c.idEstudiante = e.id_estudiante
JOIN usuarios u ON e.id_usuario = u.id_usuario

JOIN profesores p ON c.idProfesor = p.id_profesor
JOIN usuarios up ON p.id_usuario = up.id_usuario

JOIN autos a ON c.id_auto = a.id_auto

WHERE c.idProfesor = $id_profesor
";
$resClases_programadas = mysqli_query($conexion, $sqlClases_programadas);
// Obtener cursos (aún sin filtro)
$sqlCursos = "
SELECT modalidad, tipo_licencia, idEstudiante 
FROM cursos
";
$resCursos = mysqli_query($conexion, $sqlCursos);

// Obtener autos
$sqlAutos = "
SELECT placa, tecnomecanica_vencimiento, tipo_vehiculo, modelo, tipo_licencia
FROM autos 
WHERE idProfesor = '$id_profesor'
";
$resAutos = mysqli_query($conexion, $sqlAutos);

//obtener notas
$sqlNotas = "
SELECT 
    u.nombre, 
    u.apellido, 
    n.modalidad, 
    n.observacion
FROM notas n
INNER JOIN estudiantes e ON n.idEstudiante = e.id_estudiante
INNER JOIN usuarios u ON e.id_usuario = u.id_usuario
WHERE n.idProfesor = '$id_profesor'
";

$resNotas = mysqli_query($conexion, $sqlNotas);

//perfil
$sql = "
SELECT 
    u.nombre,
    u.apellido,
    u.correo,
    p.licencia_categoria,
    p.vencimiento_licencia,
    p.experiencia_anios,
    p.certificado_idoneidad
FROM profesores p
INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
WHERE p.id_usuario = '$id_usuario'
";

$resPerfil = mysqli_query($conexion, $sql);
$perfil = mysqli_fetch_assoc($resPerfil);
?>