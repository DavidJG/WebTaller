<?php
// ======= DATOS DE BATERÍAS (hardcoded) =======
$baterias = [
    ["nombre" => "Batería 100Ah 12V", "capacidad_wh" => 1200, "precio" => 180],
    ["nombre" => "Batería 200Ah 12V", "capacidad_wh" => 2400, "precio" => 320],
    ["nombre" => "Batería 100Ah 24V", "capacidad_wh" => 2400, "precio" => 350],
    ["nombre" => "Batería 200Ah 24V", "capacidad_wh" => 4800, "precio" => 620],
];

$resultado = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $consumo_w  = floatval($_POST['consumo_w']);   // Vatios
    $horas      = floatval($_POST['horas']);         // Horas de autonomía
    $tipo_idx   = intval($_POST['tipo_bateria']);    // Índice de batería elegida

    if ($consumo_w <= 0 || $horas <= 0) {
        $error = "Introduce valores válidos mayores que 0.";
    } else {
        $bateria = $baterias[$tipo_idx];

        // Energía necesaria (con margen del 20% para no agotar la batería)
        $energia_necesaria_wh = $consumo_w * $horas * 1.2;

        // Número de baterías (redondeado hacia arriba)
        $num_baterias = ceil($energia_necesaria_wh / $bateria['capacidad_wh']);

        $precio_total = $num_baterias * $bateria['precio'];

        $resultado = [
            "energia_necesaria" => round($energia_necesaria_wh),
            "bateria"           => $bateria['nombre'],
            "num_baterias"      => $num_baterias,
            "precio_total"      => $precio_total,
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora SAI</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
<main>

    <h2 id="titseccion">Calculadora SAI</h2>

    <section id="calculadora">

        <form method="post" action="sai.php">

            <label for="consumo_w">Consumo del dispositivo (W):</label>
            <input type="number" id="consumo_w" name="consumo_w" min="1"
                value="<?= isset($_POST['consumo_w']) ? htmlspecialchars($_POST['consumo_w']) : '' ?>" required>

            <label for="horas">Horas de autonomía deseadas:</label>
            <input type="number" id="horas" name="horas" min="1" step="0.5"
                value="<?= isset($_POST['horas']) ? htmlspecialchars($_POST['horas']) : '' ?>" required>

            <label for="tipo_bateria">Tipo de batería:</label>
            <select id="tipo_bateria" name="tipo_bateria">
                <?php foreach ($baterias as $i => $b): ?>
                    <option value="<?= $i ?>" <?= (isset($_POST['tipo_bateria']) && $_POST['tipo_bateria'] == $i) ? 'selected' : '' ?>>
                        <?= $b['nombre'] ?> — <?= $b['capacidad_wh'] ?>Wh — <?= $b['precio'] ?>€
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
                <p>Energía necesaria (con margen 20%): <strong><?= $resultado['energia_necesaria'] ?> Wh</strong></p>
                <p>Batería seleccionada: <strong><?= $resultado['bateria'] ?></strong></p>
                <p>Baterías necesarias: <strong><?= $resultado['num_baterias'] ?></strong></p>
                <p class="precio-total">Precio estimado: <strong><?= number_format($resultado['precio_total'], 0, ',', '.') ?>€</strong></p>
            </section>
        <?php endif; ?>

    </section>

</main>
</body>
</html>