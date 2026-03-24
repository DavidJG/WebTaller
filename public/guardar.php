<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "webuser";
$pass = "Alexito23@";
$db   = "garajedb";

// Conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recoger datos
$nombre_usuario = trim($_POST['nombre_usuario']);
$contraseña     = $_POST['contraseña'];
$contraseñaconf = $_POST['contraseñaconf'];
$tlf            = trim($_POST['tlf']);

// Validaciones
if (empty($nombre_usuario) || empty($contraseña)) {
    die("Error: nombre de usuario y contraseña son obligatorios.");
}

if ($contraseña !== $contraseñaconf) {
    die("Error: las contraseñas no coinciden.");
}

if (strlen($contraseña) < 6) {
    die("Error: la contraseña debe tener al menos 6 caracteres.");
}

// Cifrar contraseña
$contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

// Insertar
$stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, contraseña, tlf) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nombre_usuario, $contraseña_hash, $tlf);

if ($stmt->execute()) {
    
    $_SESSION['id_usuario'] = $conn->insert_id;
    $_SESSION['nombre_usuario'] = $nombre_usuario;
    session_start();
    header("Location: index.php");
    exit;

} else {
    if ($conn->errno == 1062) {

        echo "<div class='alert alert-danger'>Error: ese nombre de usuario ya está en uso.</div>";

    } else {

        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";

    }
}

$stmt->close();
$conn->close();
?>