<?php

$controller = $_GET['controller'] ?? '';
$accion = $_GET['accion'] ?? '';
switch ($controller) {

    case 'liquidacion':
         require_once __DIR__ . '/../controllers/liquidacionController.php';
        $controlador = new LiquidacionController();
        break;

    case 'empleado':
        require_once __DIR__ . '/../controllers/empleadoController.php';
        $controlador = new EmpleadoController();
        break;

    case 'cargo':
        require_once __DIR__ . '/../controllers/cargoController.php';

        $controlador = new CargoController();
        break;

    default:
        http_response_code(404);
        exit(json_encode([
            'estado' => false,
            'mensaje' => 'Controlador no encontrado.'
        ]));
}

if (!method_exists($controlador, $accion)) {
    http_response_code(404);
    exit(json_encode([
        'estado' => false,
        'mensaje' => 'Acción no encontrada.'
    ]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controlador->$accion($_POST);
} else {
    $controlador->$accion();
}
