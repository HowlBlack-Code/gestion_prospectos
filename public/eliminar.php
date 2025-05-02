<?php
include __DIR__ . '/../includes/db.php';

// Validar que venga un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

// Verificar si el prospecto existe antes de eliminar
$stmt = $conn->prepare("SELECT id FROM prospectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    $stmt->close();
    $conn->close();
    die("Prospecto no encontrado.");
}
$stmt->close();

// Eliminar el prospecto
$stmt = $conn->prepare("DELETE FROM prospectos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: index.php?mensaje=eliminado");
    exit;
} else {
    $stmt->close();
    $conn->close();
    die("Error al eliminar el prospecto: " . $conn->error);
}
?>
