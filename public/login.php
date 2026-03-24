<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

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
$nombre_usuario = trim($_POST['login_nombre_usuario']);
$contraseña     = $_POST['login_contraseña'];

// Validaciones
if (empty($nombre_usuario) || empty($contraseña)) {
    die("Error: rellena todos los campos.");
}

// Usuario en la base de datos
$stmt = $conn->prepare("SELECT id, nombre_usuario, contraseña FROM usuarios WHERE nombre_usuario = ?");
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("<div class='alert alert-danger'>Error: usuario no encontrado.</div>");
}

$usuario = $resultado->fetch_assoc();

// Contraseña desencr
if (password_verify($contraseña, $usuario['contraseña'])) {
    $_SESSION['id_usuario']      = $usuario['id'];
    $_SESSION['nombre_usuario']  = $usuario['nombre_usuario'];
    header("Location: index.php");
    exit;

} else {
    echo "<div class='alert alert-danger'>Error: contraseña incorrecta.</div>";
}

$stmt->close();
$conn->close();
?>