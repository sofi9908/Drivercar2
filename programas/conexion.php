<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "drivercar2";

$conexion = mysqli_connect($host, $user, $password, $dbname);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

?>