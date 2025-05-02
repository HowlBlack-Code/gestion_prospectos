<?php
include __DIR__ . '/../includes/db.php';

$errores = [];
$exito = "";

// Si se envió el formulario
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

    // Si no hay errores, insertar en la base
    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO prospectos (nombre, telefono, email, producto_interes, estado_contacto, fecha_contacto) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $telefono, $email, $producto, $estado, $fecha);

        if ($stmt->execute()) {
            header("Location: index.php?mensaje=agregado");
            exit;
        } else {
            $errores[] = "Error al guardar en la base de datos: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Prospecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1>Agregar nuevo prospecto</h1>

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
        <input type="text" name="nombre" class="form-control" value="<?= $_POST['nombre'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= $_POST['telefono'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?= $_POST['email'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Producto de interés</label>
        <input type="text" name="producto_interes" class="form-control" value="<?= $_POST['producto_interes'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label">Estado de contacto</label>
        <select name="estado_contacto" class="form-select">
          <option value="">-- Seleccionar --</option>
          <option value="pendiente" <?= ($_POST['estado_contacto'] ?? '') === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
          <option value="comprado" <?= ($_POST['estado_contacto'] ?? '') === 'comprado' ? 'selected' : '' ?>>Comprado</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Fecha de contacto</label>
        <input type="date" name="fecha_contacto" class="form-control" value="<?= $_POST['fecha_contacto'] ?? '' ?>">
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
