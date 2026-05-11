<?php
$ticket_mensaje = null;
$ticket_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marca_ticket'])) {
    if (!isset($_SESSION['id_usuario'])) {
        $ticket_error = "Debes iniciar sesión para solicitar un servicio.";
    } else {
        $marca            = trim($_POST['marca_ticket']);
        $modelo           = trim($_POST['modelo_ticket']);
        $autonomia_obj    = intval($_POST['autonomia_objetivo']);

        if (empty($marca) || empty($modelo) || $autonomia_obj <= 0) {
            $ticket_error = "Rellena todos los campos correctamente.";
        } else {
            $stmt = $conn->prepare("INSERT INTO tickets (id_usuario, marca, modelo, autonomia_objetivo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("issi", $_SESSION['id_usuario'], $marca, $modelo, $autonomia_obj);
            if ($stmt->execute()) {
                $ticket_mensaje = "Solicitud enviada correctamente. Nos pondremos en contacto contigo pronto.";
            } else {
                $ticket_error = "Error al enviar la solicitud.";
            }
            $stmt->close();
        }
    }
}
?>