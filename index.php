<?php

include "presentacion/layout/header.php";
include "presentacion/layout/menu.php";

$vista = $_GET["vista"] ?? "liquidacion";

$ruta = "presentacion/$vista/index.php";

if (file_exists($ruta)) {
    include $ruta;
} else {
    echo "<div class='container mt-5'>";
    echo "<div class='alert alert-danger'>La vista no existe.</div>";
    echo "</div>";
}

include "presentacion/layout/footer.php";