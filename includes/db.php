<?php
// Configuración de la conexión a la base de datos
$host = "localhost"; 
$usuario = "root";  
$contrasena = "";    
$base_datos = "gestion_prospectos";  
// Establecer la conexión
$conn = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Establecer el juego de caracteres a UTF-8 para evitar problemas con caracteres especiales
$conn->set_charset("utf8");
?>
