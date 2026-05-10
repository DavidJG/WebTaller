<?php
session_start();
require_once 'conexion.php';
require_once 'sai.php';

// Consulta coches destacados
$stmt = $conn->prepare("
    SELECT c.id, c.marca, c.modelo, c.autonomia_km, c.descripcion, c.precio_venta
    FROM destacados d
    JOIN coche c ON d.id_destacados = c.id
");
$stmt->execute();
$destacados = $stmt->get_result();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garaje</title>

    <link rel="stylesheet" href="assets/css/styles.css">

</head>

<body>

<header>

    <section id="titulo">
        <img src="assets/img/c0pictures/c0transparent.png" alt="Logo">
        <h1 class="jacquard-24-regular">Electro taller</h1>
    </section>
</header>

<main>
    <section id="navppal">
        <nav class="desple">
            <input type="checkbox" id="toggle" class="menu-checkbox">
            <label id="open" for="toggle">☰</label>
            <label id="close" for="toggle">↪</label>
                <ul class="nav-menu">
                    <li>Menu 1</li>
                    <li>Menu 2</li>
                    <li>END</li>
                </ul>
        </nav>
    </section>
    

    <section id="fondo">
        <img>
    </section>

    
    
    <h2 id="titseccion1">Destacados</h2>
    <section id="destacados">

        <?php while ($coche = $destacados->fetch_assoc()): ?>
        <article>
            <img src="assets/img/coches/<?= $coche['id'] ?>.png" alt="<?= htmlspecialchars($coche['marca'] . ' ' . $coche['modelo']) ?>">
            <section class="text">
                <p class="modelo"><?= htmlspecialchars($coche['marca'] . ' ' . $coche['modelo']) ?></p>
                <p class="autonomia"><?= $coche['autonomia_km'] ?> Km autonomía</p>
                <p class="descripcion"><?= htmlspecialchars($coche['descripcion']) ?></p>
                <p class="precio"><?= number_format($coche['precio_venta'], 0, ',', '.') ?>€</p>
                <button type="button" class="boton">Ver más</button>
            </section>
        </article>
        <?php endwhile; ?>

    </section>


    <h2 id="titseccion">Nuestros servicios</h2>
    <section id="servicios">

        <article id="CochePreparado">
            <h3>Coches preparados</h3>
        </article>
        <article id="ReemplazoCeldas">
            <h3>Reemplazo de celdas</h3>
        </article>
        <article id="SAIs">
    <h3>Sistemas de alimentación ininterrumpida</h3>

    <section id="calculadora">
        <form method="post" action="index.php">

            <label for="consumo_w">Consumo (W):</label>
            <input type="number" id="consumo_w" name="consumo_w" min="1"
                value="<?= isset($_POST['consumo_w']) ? htmlspecialchars($_POST['consumo_w']) : '' ?>">

            <label for="horas">Horas de autonomía:</label>
            <input type="number" id="horas" name="horas" min="1" step="0.5"
                value="<?= isset($_POST['horas']) ? htmlspecialchars($_POST['horas']) : '' ?>">

            <label for="tipo_bateria">Tipo de batería:</label>
            <select id="tipo_bateria" name="tipo_bateria">
                <?php foreach ($baterias as $i => $b): ?>
                    <option value="<?= $i ?>" <?= (isset($_POST['tipo_bateria']) && $_POST['tipo_bateria'] == $i) ? 'selected' : '' ?>>
                        <?= $b['nombre'] ?> - <?= $b['capacidad_wh'] ?>Wh - <?= $b['precio'] ?>€
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Calcular">

        </form>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php elseif ($resultado): ?>
            <section id="resultado">
                <h3>Resultado</h3>
                <p>Energía necesaria (margen 20%): <strong><?= $resultado['energia_necesaria'] ?> Wh</strong></p>
                <p>Batería: <strong><?= $resultado['bateria'] ?></strong></p>
                <p>Unidades necesarias: <strong><?= $resultado['num_baterias'] ?></strong></p>
                <p class="precio-total">Precio estimado: <strong><?= number_format($resultado['precio_total'], 0, ',', '.') ?>€</strong></p>
            </section>
        <?php endif; ?>

    </section>
</article>

    </section>

<!-- 
    <section id="galeria">
        <article>
            <img src="assets/img/citroen_czero-666x375-1.png" alt="Coche">
            <img src="assets/img/citroen_czero-666x375-1.png" alt="Coche">
        </article>
    </section>
-->

    <footer>
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <!-- Usuario logueado -->
            <p>Bienvenido, <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>!</p>
            <a href="logout.php">Cerrar sesión</a>

        <?php else: ?>
            <!-- Formulario de registro -->
            <form action="guardar.php" method="post">
                <section id="registro">
                    <h3>Crear cuenta</h3>
                    <label for="nombre_usuario">Nombre de usuario:</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" required>
                    <label for="contraseña">Contraseña:</label>
                    <input type="password" id="contraseña" name="contraseña" required>
                    <label for="contraseñaconf">Confirma contraseña:</label>
                    <input type="password" id="contraseñaconf" name="contraseñaconf" required>
                    <label for="tlf">Número de teléfono:</label>
                    <input type="text" id="tlf" name="tlf">
                    <input type="submit" value="Registrarse">
                </section>
            </form>

            <!-- Formulario de login -->
            <form action="login.php" method="post">
                <section id="login">
                    <h3>Iniciar sesión</h3>
                    <label for="login_nombre_usuario">Nombre de usuario:</label>
                    <input type="text" id="login_nombre_usuario" name="login_nombre_usuario" required>
                    <label for="login_contraseña">Contraseña:</label>
                    <input type="password" id="login_contraseña" name="login_contraseña" required>
                    <input type="submit" value="Entrar">
                </section>
            </form>

        <?php endif; ?>
    </footer>
</main>


</body>

</html>