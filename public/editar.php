<?php
include __DIR__ . '/../includes/db.php';

$errores = [];
$exito = "";

// Validar ID recibido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

// Procesar si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $producto = trim($_POST['producto_interes']);
    $estado = $_POST['estado_contacto'] ?? '';
    $fecha = $_POST['fecha_contacto'] ?? '';

    // Validaciones
    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    if ($telefono === '') $errores[] = "El teléfono es obligatorio.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email no es válido.";
    if ($producto === '') $errores[] = "El producto de interés es obligatorio.";
    if (!in_array($estado, ['pendiente', 'comprado'])) $errores[] = "El estado debe ser válido.";
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) $errores[] = "La fecha debe tener formato AAAA-MM-DD.";

    // Si no hay errores, actualizar en la base
    if (empty($errores)) {
        $stmt = $conn->prepare("UPDATE prospectos SET nombre=?, telefono=?, email=?, producto_interes=?, estado_contacto=?, fecha_contacto=? WHERE id=?");
        $stmt->bind_param("ssssssi", $nombre, $telefono, $email, $producto, $estado, $fecha, $id);

        if ($stmt->execute()) {
            header("Location: index.php?mensaje=editado");
            exit;
        } else {
            $errores[] = "Error al actualizar: " . $conn->error;
        }

        $stmt->close();
    }
}

// Obtener datos actuales del prospecto
$stmt = $conn->prepare("SELECT * FROM prospectos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$prospecto = $resultado->fetch_assoc();
$stmt->close();

if (!$prospecto) {
    die("Prospecto no encontrado.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Prospecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1>Editar prospecto</h1>

    <?php if (!empty($errores)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errores as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form method="post" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($_POST['nombre'] ?? $prospecto['nombre']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($_POST['telefono'] ?? $prospecto['telefono']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_POST['email'] ?? $prospecto['email']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Producto de interés</label>
        <input type="text" name="producto_interes" class="form-control" value="<?= htmlspecialchars($_POST['producto_interes'] ?? $prospecto['producto_interes']) ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Estado de contacto</label>
        <select name="estado_contacto" class="form-select">
          <option value="">-- Seleccionar --</option>
          <option value="pendiente" <?= (($_POST['estado_contacto'] ?? $prospecto['estado_contacto']) === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
          <option value="comprado" <?= (($_POST['estado_contacto'] ?? $prospecto['estado_contacto']) === 'comprado') ? 'selected' : '' ?>>Comprado</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Fecha de contacto</label>
        <input type="date" name="fecha_contacto" class="form-control" value="<?= $_POST['fecha_contacto'] ?? $prospecto['fecha_contacto'] ?>">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
