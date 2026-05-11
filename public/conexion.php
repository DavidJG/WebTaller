<?php

//===================================//
//      conexion a BD estandar       //
//===================================//

$host = "localhost";
$user = "webuser";
$pass = "Alexito23@";
$db   = "garajedb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>