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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consumo_w'])) {
    $consumo_w = floatval($_POST['consumo_w']);
    $horas     = floatval($_POST['horas']);
    $tipo_idx  = intval($_POST['tipo_bateria']);

    if ($consumo_w <= 0 || $horas <= 0) {
        $error = "Introduce valores válidos mayores que 0.";
    } else {
        $bateria = $baterias[$tipo_idx];
        $energia_necesaria_wh = $consumo_w * $horas * 1.2;
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