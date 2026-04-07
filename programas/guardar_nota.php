<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include("conexion.php");


$id_usuario = $_SESSION['id_usuario'];


$sqlProf = "SELECT id_profesor FROM profesores WHERE id_usuario = '$id_usuario'";
$resProf = mysqli_query($conexion, $sqlProf);
$prof = mysqli_fetch_assoc($resProf);

$id_profesor = $prof['id_profesor'];

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

if(!$resNotas){
    die("Error: " . mysqli_error($conexion));
}
?>