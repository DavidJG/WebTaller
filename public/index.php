<?php
session_start();
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

<!--  
    <nav>
        <ul>
            <li>ent 1</li>
            <li>ent 2</li>
            <li>ent 3</li>
            <li>ent 4</li>
        </ul>
    </nav>
-->

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

    
    
    <h2 id="titseccion">Destacados</h2>
    <section id="destacados">
        <article>
            <img src="assets/img/c0pictures/angle.png" alt="Coche">
            <section id="text">
                <p id="modelo">Citroen C0</p>
                <p id="autonomia">200 Km autonomia</p>
                <p id="precio">6000€</p>
                <button type="button" id="boton">Ver más</button>
            </section>
        </article>
        <article>
            <img src="assets/img/c0pictures/1.png" alt="Coche">
            <section id="text">
                <p id="modelo">Citroen C0</p>
                <p id="autonomia">200 Km autonomia</p>
                <p id="precio">6000€</p>
                <button type="button" id="boton">Ver más</button>
            </section>
        </article>
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