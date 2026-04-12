<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../html/inicioSesion.php");
    exit();
}

$id = $_GET['id'] ?? null;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_costo'];
    $valor = $_POST['valor'];
    $cuotas = $_POST['cuotas'];
    $fecha_pago = $_POST['fecha_pago'];
    $tipo_pase = $_POST['tipo_pase'];
    $metodo_pago = $_POST['metodo_pago'];

    $sql = "UPDATE costos SET valor='$valor', cuotas='$cuotas', fecha_pago='$fecha_pago',
            tipo_pase='$tipo_pase', metodo_pago='$metodo_pago' WHERE id_costo='$id'";

    if(mysqli_query($conexion, $sql)) {
        echo "<script>alert('Costo actualizado correctamente'); window.location='../html/admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conexion) . "'); window.history.back();</script>";
    }
    exit();
}

$res = mysqli_query($conexion, "SELECT * FROM costos WHERE id_costo='$id'");
$costo = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Costo</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<div class="layout">
    <div class="content" style="margin-left:0; padding: 40px;">
        <div class="section-tag">● EDITAR</div>
        <h3 class="section-titulo">Editar <span class="highlight">Costo</span></h3>
        <div class="form-card">
            <form method="POST">
                <input type="hidden" name="id_costo" value="<?php echo $costo['id_costo']; ?>">
                <div class="form-group">
                    <label>Valor</label>
                    <input type="number" name="valor" value="<?php echo $costo['valor']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Cuotas</label>
                    <input type="text" name="cuotas" value="<?php echo $costo['cuotas']; ?>">
                </div>
                <div class="form-group">
                    <label>Fecha de pago</label>
                    <input type="date" name="fecha_pago" value="<?php echo $costo['fecha_pago']; ?>">
                </div>
                <div class="form-group">
                    <label>Tipo pase</label>
                    <input type="text" name="tipo_pase" value="<?php echo $costo['tipo_pase']; ?>">
                </div>
                <div class="form-group">
                    <label>Método de pago</label>
                    <select name="metodo_pago">
                        <?php foreach(['Efectivo','Tarjeta crédito','Tarjeta débito','Nequi','Daviplata','Transferencia'] as $m): ?>
                            <option value="<?php echo $m; ?>" <?php if($costo['metodo_pago']==$m) echo 'selected'; ?>>
                                <?php echo $m; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-principal">Guardar cambios</button>
                <a href="../html/admin.php" class="btn-accion btn-red" style="margin-left:10px;">Cancelar</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>