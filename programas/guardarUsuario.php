<?php
header('Content-Type: application/json');

// SIMULACIÓN (luego puedes guardar en BD)
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = $_POST['password'];
$rol = $_POST['rol'];

if ($nombre && $email && $password) {
    echo json_encode(["success" => "Usuario creado correctamente"]);
} else {
    echo json_encode(["error" => "Faltan datos"]);
}