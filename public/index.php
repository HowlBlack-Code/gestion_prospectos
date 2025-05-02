<?php
include __DIR__ . '/../includes/db.php';

$mensaje = '';
$alerta = '';

// Mensajes de acción
if (isset($_GET['mensaje'])) {
    switch ($_GET['mensaje']) {
        case 'agregado':
            $mensaje = "Prospecto agregado correctamente.";
            $alerta = 'success';
            break;
        case 'editado':
            $mensaje = "Prospecto actualizado correctamente.";
            $alerta = 'primary';
            break;
        case 'eliminado':
            $mensaje = "Prospecto eliminado correctamente.";
            $alerta = 'danger';
            break;
    }
}

// Consulta de prospectos
$sql = "SELECT * FROM prospectos ORDER BY fecha_contacto DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$prospectos = [];
while ($row = $result->fetch_assoc()) {
    $prospectos[] = $row;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Prospectos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1 class="mb-4">Prospectos Contactados</h1>

    <?php if ($mensaje): ?>
      <div class="alert alert-<?= $alerta ?> alert-dismissible fade show" role="alert">
        <?= $mensaje ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <a href="agregar.php" class="btn btn-success mb-3">Agregar nuevo prospecto</a>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Producto</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($prospectos)): ?>
            <tr><td colspan="8" class="text-center">No hay prospectos cargados.</td></tr>
          <?php else: ?>
            <?php foreach ($prospectos as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['telefono']) ?></td>
                <td><?= htmlspecialchars($p['email']) ?></td>
                <td><?= htmlspecialchars($p['producto_interes']) ?></td>
                <td><?= htmlspecialchars($p['estado_contacto']) ?></td>
                <td><?= htmlspecialchars($p['fecha_contacto']) ?></td>
                <td class="text-center">
                  <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                  <a href="eliminar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este prospecto?')">Eliminar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
