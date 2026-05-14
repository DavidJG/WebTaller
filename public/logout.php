<section id="usuario-logeado">
    <?php
    session_start();
    session_destroy();
    header("Location: index.php");
    exit;
    ?>
</section>