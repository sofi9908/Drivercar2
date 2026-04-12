<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id = $_GET['id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_auto'];
    $placa = mysqli_real_escape_string($conexion, $_POST['placa']);
    $tecnomecanica = $_POST['tecnomecanica_vencimiento'];
    $tipo_vehiculo = mysqli_real_escape_string($conexion, $_POST['tipo_vehiculo']);
    $modelo = mysqli_real_escape_string($conexion, $_POST['modelo']);
    $tipo_licencia = $_POST['tipo_licencia'];

    $sql = "UPDATE autos SET placa='$placa', tecnomecanica_vencimiento='$tecnomecanica',
            tipo_vehiculo='$tipo_vehiculo', modelo='$modelo', tipo_licencia='$tipo_licencia'
            WHERE id_auto='$id'";

    if(mysqli_query($conexion, $sql)) {
        echo "<script>alert('Auto actualizado correctamente'); window.location='../html/admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
    exit();
}

$res = mysqli_query($conexion, "SELECT * FROM autos WHERE id_auto='$id'");
$auto = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Auto</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="layout">
    <div class="content" style="margin-left:0; padding: 40px;">
        <div class="section-tag">● EDITAR</div>
        <h3 class="section-titulo">Editar <span class="highlight">Auto</span></h3>
        <div class="form-card">
            <form method="POST">
                <input type="hidden" name="id_auto" value="<?php echo $auto['id_auto']; ?>">
                <div class="form-group">
                    <label>Placa</label>
                    <input type="text" name="placa" value="<?php echo $auto['placa']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <input type="text" name="modelo" value="<?php echo $auto['modelo']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Tipo de vehículo</label>
                    <input type="text" name="tipo_vehiculo" value="<?php echo $auto['tipo_vehiculo']; ?>">
                </div>
                <div class="form-group">
                    <label>Tipo de licencia</label>
                    <select name="tipo_licencia">
                        <?php foreach(['A1','A2','B1','B2','C1','C2'] as $lic): ?>
                            <option value="<?php echo $lic; ?>" <?php if($auto['tipo_licencia']==$lic) echo 'selected'; ?>>
                                <?php echo $lic; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Vencimiento tecnomecánica</label>
                    <input type="date" name="tecnomecanica_vencimiento" value="<?php echo $auto['tecnomecanica_vencimiento']; ?>">
                </div>
                <button type="submit" class="btn-principal">Guardar cambios</button>
                <a href="../html/admin.php" class="btn-accion btn-red" style="margin-left:10px;">Cancelar</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>